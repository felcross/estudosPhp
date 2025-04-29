<?php

namespace api;

use api\ApiServiceEmauto;
use utils\Temp;
use utils\Erros;
use api\RequestChavesEmauto;



class TokensControl
{
    /**
     * @var Temp $temp
     * Objeto responsável por gerenciar dados temporários relacionados à classe.
     * 
     * @var ApiServiceEmauto $apiServiceEmauto
     * Serviço responsável por interagir com a API da Emauto.
     * 
     * @var RequestChavesEmauto $requestTokenEmauto
     * Responsável por solicitar chaves de autenticação da API Emauto. 
     * Pode ser utilizado para obter tokens de acesso temporários.
     */
    private Temp $temp;
    private ApiServiceEmauto $apiServiceEmauto;
    private RequestChavesEmauto $requestTokenEmauto;


    /**
     * Construtor da classe que inicializa os serviços da API e os tokens de autenticação.
     * 
     * Este método é responsável por inicializar as propriedades necessárias para comunicação com as APIs da Tecno e Emauto, 
     * bem como realizar a verificação de conectividade com esses serviços utilizando os métodos `pingOutro()` e `pingEmauto()`.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->temp = $this->temp();
        $this->apiServiceEmauto = $this->apiServiceEmauto();
        $this->requestTokenEmauto = $this->requestTokenEmauto();
        $this->initSessoes();
        $this->pingEmauto();
    }

    private function pingEmauto()
    {
        $this->apiServiceEmauto->set(apiTabelaX, 'GET', '?%24top=1');
        $status = $this->apiServiceEmauto->getStatus();
        if ($status >= 300) {
            $this->requestTokenEmauto->logar();
            Erros::salva('APIEmauto - Chaves', $this->apiServiceEmauto->getConteudo());
        }
    }


    private function initSessoes()
    {

        $emauto = $this->temp->recuperaJSON(chaveAcessoEMAUTO);

        if(isset($_SESSION['chaveEMAUTO']) ) {
            return;
        }


        if (isset($emauto[0]['chave'])) {
            $_SESSION['chaveEMAUTO'] = $emauto[0]['chave'];
        }
    }




    private function apiServiceEmauto(): ApiServiceEmauto
    {
        return new ApiServiceEmauto;
    }

    private function requestTokenEmauto(): RequestChavesEmauto
    {
        return new RequestChavesEmauto;
    }


    private function temp(): Temp
    {
        return new Temp;
    }
}
