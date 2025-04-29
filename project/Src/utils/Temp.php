<?php

namespace utils;

use utils\JsonManual;

class Temp
{

    /**
     * Salva o conteúdo em um arquivo JSON. Se o arquivo já existir,
     * o conteúdo existente será mesclado com o novo conteúdo.
     *
     * @param string $nomeParaSalvar O nome do arquivo (sem extensão) para salvar o conteúdo JSON.
     * @param mixed $conteudo O conteúdo a ser salvo, que pode ser de qualquer tipo (array, objeto, etc.).
     * @param bool $incrementa - Informa se deve adicionar ao conteúdo já salvo ou esvaziar e gerar um novo
     *
     * @return void
     */
    public function salvaJSON(string $nomeParaSalvar, mixed $conteudo, bool $incrementa = true, $sobrescreve = false): void
    {
        $caminhoBase =  NomeSistema . "temp/" . $nomeParaSalvar . ".json";

        if ($incrementa == true) {

            if (file_exists($caminhoBase)) {
                $conteudoExistente = json_decode(file_get_contents($caminhoBase), true);
                if (!is_array($conteudoExistente)) {
                    $conteudoExistente = [];
                }
            } else {
                $conteudoExistente = [];
            }

            if (!is_array($conteudo)) {
                $conteudo = [$conteudo];
            }
        }

        if ($sobrescreve == true) {
            $conteudoExistente = $conteudo;
        } else {
            $conteudoExistente[] = $conteudo;
        }


        $conteudoFormatado = json_encode($conteudoExistente, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        file_put_contents($caminhoBase, $conteudoFormatado);
    }




    /**
     * Função que salva arquivos json codificado manualmente
     * @access public
     * @param string $nomeParaSalvar
     * @param string $conteudo
     * @return void
     */
    public function salvaJSONManual(string $nomeParaSalvar, string $conteudo): void
    {
        if ($conteudo) {
            file_put_contents(NomeSistema . "temp/" . $nomeParaSalvar . ".json", $conteudo);
        }
    }


    /**
     * Função que recupera os arquivos json decodificados manualmente
     * @access public
     * @param string $nomeParaBuscar
     * @return mixed
     */
    public function recuperaJSONManualDecode(string $nomeParaBuscar): mixed
    {
        $caminho =  NomeSistema . "temp/" . $nomeParaBuscar . ".json";
        if (file_exists($caminho)) {
            return JsonManual::decode(file_get_contents($caminho));
        } else {
            return null;
        }
    }


    /**
     * Função que recupera os arquivos json codificado manualmente
     * @access public
     * @param string $nomeParaBuscar
     * @return mixed
     */
    public function recuperaJSONManualEncode(string $nomeParaBuscar): mixed
    {
        $caminho =  NomeSistema . "temp/" . $nomeParaBuscar . ".json";
        if (file_exists($caminho)) {
            return file_get_contents($caminho);
        } else {
            return null;
        }
    }



    /**
     * Função que recupera os arquivos json 
     * @access public
     * @param string $nomeParaBuscar
     * @return mixed
     */
    public function recuperaJSON(string $nomeParaBuscar): mixed
    {
        $caminho =  NomeSistema . "temp/" . $nomeParaBuscar . ".json";
        if (file_exists($caminho)) {
            return json_decode(file_get_contents($caminho), true);
        } else {
            return null;
        }
    }


    /**
     * Função que deleta arquivos temporários
     * @access public
     * @param string $nomeArquivo
     * @param string $extensaoArquivo
     * @return void
     */
    public function deleteArqTemp(string $nomeArquivo, string $extensaoArquivo): void
    {
        $caminho =  NomeSistema . "temp/" . $nomeArquivo . "." . $extensaoArquivo;
        if (file_exists($caminho)) {
            unlink($caminho);
        }
    }

    /**
     * Função que salva data da última atualização de produtos
     * @access public
     * @param string $constante
     * @return void
     */


    public function setDataUltUpdateProdutos(string $constante): void
    {

        date_default_timezone_set('America/Sao_Paulo');

        $url = constant($constante);
        $data = date("Y-m-d") . "T" . date('H') . "%3A" . date('i');
        $conteudo = [
            'atualizacao' => $data
        ];

        $this->salvaJSON($url, $conteudo, false, false);
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
