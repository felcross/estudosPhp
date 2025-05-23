<?php

namespace api;

use utils\Crypto;
use utils\Erros;
use utils\Sanitizantes;

class ApiServiceEmauto
{

    private array $header;
    private string $url;
    private $conteudo;
    private string|int $status;
    private bool $useLineCounts;



    /**
     * Função que inicializa a Conexão, recebe os parâmetros necessários e distribui entre os métodos
     * @access public
     * @param string $endpoint
     * @param string $tipoRequisicao
     * @param string|array $dados
     * @param bool $useLineCounts - Função que informa quantidade de registros obtidos na requisição
     * @return void
     */

    public function set(string $endpoint, string $tipoRequisicao, string|array $dados, bool $useLineCounts = true, bool $useJsonEncode = true): void
    {

        $this->defineHeader();
        $this->useLineCounts = $useLineCounts;
        $this->definirUrl($endpoint, $tipoRequisicao, $dados);
        $this->request($tipoRequisicao, $dados, $useJsonEncode);
    }

    /**
     * Função que define o cabeçalho a ser passado via HTTP
     * @access private
     * @return void
     */


    private function defineHeader(): void
    {
        $this->header = [
            "Authorization: Bearer " . Crypto::descriptografar($_SESSION['chaveEMAUTO'] ?? ''),
            'Content-Type: application/json'
        ];
    }


    /**
     * Função que define qual a url deve ser utilizado como base de requisição
     * @access private
     * @param string $endpoint
     * @param string $tipo
     * @param string|array|object $extras
     * @return void
     */

    private function definirUrl(string $endpoint, string $tipo, string|array|object $extras = '')
    {
        $line = '';
        if ($this->useLineCounts == true) {
            $line = '&$inlinecount=allpages';
        }

        $ip = apiEmauto;

        switch ($tipo) {
            case "GET":
                $this->url = Sanitizantes::filtroUrl($ip) . $endpoint . "?" . $extras . $line;
                break;
            case "DELETE":
                $this->url = Sanitizantes::filtroUrl($ip) . $endpoint . "($extras)";
                break;
            case "POST":
                $this->url = Sanitizantes::filtroUrl($ip) . $endpoint;
                break;
            case "PUT":
                $this->url = Sanitizantes::filtroUrl($ip) . $endpoint;
                break;
            case "PATCH":
                $this->url = Sanitizantes::filtroUrl($ip) . $endpoint;
                break;
        }
    }


    /**
     * Função que fará a requisição - A COMUNICAÇÃO
     * @access private
     * @param string $tipo
     * @param string|array|object $extras
     * @return void
     */


    private function request(string $tipo, string|array|object $extras, bool $useJsonEncode): void
    {

        try {

            $env = curl_init();
            curl_setopt($env, CURLOPT_URL, $this->valideUrl($this->url));
            curl_setopt($env, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($env, CURLOPT_CUSTOMREQUEST, $tipo);
            curl_setopt($env, CURLOPT_HTTPHEADER, $this->header);
            curl_setopt($env, CURLOPT_SSL_VERIFYPEER, false);

            if (in_array($tipo, ["POST", "PUT", "PATCH"])) {

                $data = $useJsonEncode ? json_encode($extras) : $extras;
                curl_setopt($env, CURLOPT_POSTFIELDS, $data);
            }

            $result_json = curl_exec($env);

            $this->status = curl_getinfo($env, CURLINFO_HTTP_CODE);
            if ($result_json === false) {
                Erros::salva("APIEmauto - Erro na requisição", curl_error($env));
            }
            curl_close($env);
            $this->conteudo = json_decode($result_json, true);
        } catch (\Throwable $th) {
            $this->status = 404;
            Erros::salva("APIEmauto - Erro na requisição", $th);
        }
    }



    /**
     * Função que valida a url verificando se existem parâmetros enviados via GET, se não existir ele remove o '?' do final da url
     * @access public
     * @return mixed
     */

    private function valideUrl(string $url): string
    {
        if (substr($url, -1) === '?') {
            return substr($url, 0, -1);
        }
        return $url;
    }


    /**
     * Função que Obtêm o conteúdo retornado
     * @access public
     * @return mixed
     */

    public function getConteudo(): mixed
    {
        return $this->conteudo;
    }


    /**
     * Função que Obtêm o código HTTP retornado
     * @access public
     * @return mixed
     */


    public function getStatus(): mixed
    {
        return $this->status;
    }

    /**
     * Função que Obtêm a url utilizada como base no Request
     * @access public
     * @return mixed
     */


    public function getUrl(): mixed
    {
        return $this->url;
    }

    /**
     * DebugFunction
     * @access public
     * @return null|array
     */
    public function __debugInfo(): ?array
    {
        return ["DanosINI"];
    }
}
