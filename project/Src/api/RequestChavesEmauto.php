<?php

namespace api;


use api\ApiServiceEmauto;
use utils\DadosINI;
use utils\Crypto;
use utils\Erros;
use utils\Temp;

class RequestChavesEmauto
{

    /**
     * @var DadosINI $dadosINI
     * Instância da classe `DadosINI` que gerencia os dados do arquivo de configuração INI.
     */
    private DadosINI $dadosINI;

    /**
     * @var ApiServiceEmauto $apiService
     * Instância da classe `ApiServiceEmauto` que é usada para interagir com a API Emauto.
     */
    private ApiServiceEmauto $apiService;

    /**
     * @var ?array $dadosUser
     * Dados do usuário. Pode ser um array contendo informações sobre o usuário ou `null` se não estiver disponível.
     */
    private ?array $dadosUser;

    /**
     * @var mixed $resultado
     * Variável para armazenar o resultado de operações, podendo ser de qualquer tipo.
     */
    private mixed $resultado;

    /**
     * @var Temp $temp
     * Objeto responsável por gerenciar dados temporários relacionados à classe.
     */
    private Temp $temp;

    /**
     * Construtor da classe.
     * Inicializa as propriedades da classe com instâncias de `DadosINI` e `ApiServiceEmauto`.
     */
    public function __construct()
    {
        $this->temp = $this->temp();
        $this->dadosINI = $this->dadosINI();
        $this->apiService = $this->apiService();
    }

    /**
     * Realiza o processo de login do usuário.
     * 
     * Este método chama dois métodos: 
     * 1. `recuperaUsuario()` para recuperar as informações do usuário.
     * 2. `processaLogin()` para processar o login com base nas informações recuperadas.
     */
    public function logar(): void
    {
        $this->recuperaUsuario();
        $this->processaLogin();
    }


    /**
     * Processa o login do usuário.
     * 
     * Este método utiliza os dados do usuário, descriptografa as informações de login 
     * (usuário e senha), e faz uma requisição `POST` para a API de login. 
     * Caso o login seja bem-sucedido, a chave de autenticação é armazenada na sessão.
     * Caso ocorra um erro, o erro é salvo no sistema de logs.
     * 
     * @return void
     */
    private function processaLogin(): void
    {

        try {
            $dados = [
                'usuario' => Crypto::descriptografar($this->dadosUser['usuario'] ?? null),
                'senha' => Crypto::descriptografar($this->dadosUser['senha'] ?? null)
            ];

            $this->apiService->set(apiLogin, 'POST', $dados, false);
            $conteudo = $this->apiService->getConteudo();
            $this->resultado = $this->apiService->getStatus();

            if (is_null($conteudo['value'])) {
                Erros::salva("API EMauto - Tentativa de logar", $conteudo);
            }

            $_SESSION['chaveEMAUTO'] = Crypto::criptografar($conteudo['value']);

            $this->temp->salvaJSON(chaveAcessoEMAUTO, [
                'chave' => Crypto::criptografar($conteudo['value'])
            ],false);
        } catch (\Throwable $th) {
            $this->resultado = $th;
            Erros::salva("Login", array("Há um erro ao tentar logar", $th));
        }
    }


    /**
     * Recupera os dados do usuário a partir do arquivo de configuração INI.
     * 
     * Este método utiliza a classe `DadosINI` para recuperar os dados do usuário 
     * armazenados no arquivo de configuração. Se os dados forem encontrados, eles 
     * são atribuídos à propriedade `dadosUser`. Caso contrário, um erro é registrado.
     * 
     * @return void
     */
    private function recuperaUsuario(): void
    {
        $dados = ($this->dadosINI->getUser() ?: null);
        if ($dados) {
            $this->dadosUser = $dados;
        } else {
            Erros::salva("Login", "Não foi possível descriptografar os dados de usuário do EMAUTO. Talvez eles não existam ou estejam desatualizados.");
        }
    }


    /**
     * Verifica o resultado do login.
     * 
     * Este método verifica o valor retornado pelo processo de login (armazenado em 
     * `resultado`). Se o primeiro caractere do resultado for "2", o método retorna 
     * `true`, indicando que o login foi bem-sucedido. Caso contrário, retorna 
     * `false`, indicando que o login falhou.
     * 
     * @return bool Retorna `true` se o login foi bem-sucedido, `false` caso contrário.
     */
    public function resultadoLogin(): bool
    {

        $retorno = mb_strimwidth($this->resultado, 0, 1);
        if (intval($retorno) == 2) {
            return true;
        } else {
            return false;
        }
    }

    private function dadosINI(): DadosINI
    {
        return new DadosINI;
    }

    private function apiService(): ApiServiceEmauto
    {
        return new ApiServiceEmauto;
    }

    private function temp(): Temp
    {
        return new Temp;
    }
}

