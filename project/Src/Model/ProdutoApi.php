<?php

namespace model;
use api\ApiServiceEmauto;
use utils\Temp;
use api\TokensControl;
use utils\Erros;
use utils\DadosINI;
use utils\Sanitizantes;

class ProdutoApi extends TokensControl
{
    /**
     * Class apiServiceEmauto
     * @var ApiServiceEmauto
     */
    private ApiServiceEmauto $apiServiceEmauto;

    /**
     * Class temp
     * @var Temp
     */
    private Temp $temp;

    /**
     * Class dadosINI
     * @var DadosINI
     */
    private DadosINI $dadosINI;

    /**
     * Construct
     */
    public function __construct()
    {   
        parent::__construct();
        $this->apiServiceEmauto = new ApiServiceEmauto;
        $this->temp = new Temp;
        $this->dadosINI = new DadosINI;
    }
  

/**
 * Busca produtos com base em um termo de busca (suporta correspondência parcial)
 * 
 * @param string $termo Termo de busca para filtrar produtos
 * @param bool $buscaParcial Se true, busca por correspondência parcial (contains), caso contrário, busca exata
 * @return array Array com produtos encontrados ou array vazio se nada for encontrado
 */
public function buscarProdutos(string $termo, bool $buscaParcial = true)
{
    // Sanitizar o termo de busca para evitar injeção
    Sanitizantes::filtro($termo); 
    
    // Codificar o termo de busca para URL
    $termoEncoded = urlencode($termo);
    
    // Definir o operador de comparação com base no tipo de busca
    $operador = $buscaParcial ? "contains" : "eq";

   
    //%24filter=(PRODUTO%20eq%20'35261260'%20or%20REFERENCIA%20eq%20'6L5Z11002AA'%20or%20REFERENCIA2%20eq%20'6L5Z11002AA'%20or%20CODIGOBARRA%20eq%20'A12')
    // Montar o filtro para buscar em múltiplos campos
    $filtro = "%24filter=(PRODUTO%20eq%20'{$termoEncoded}'%20or%20"
    . "REFERENCIA%20eq%20'{$termoEncoded}'%20or%20"
    . "REFERENCIA2%20eq%20'{$termoEncoded}'%20or%20"
    . "CODIGOBARRA%20eq%20'{$termoEncoded}')";

           dd( $filtro);
    
    try {
        // Fazer a requisição à API
        $this->apiServiceEmauto->set(
            apiProdutos,
            'GET',
            $filtro,
            useLineCounts: false
        );
        
        // Obter o resultado
        $resultado = [
            'status' => $this->apiServiceEmauto->getStatus(),
            'data' => $this->apiServiceEmauto->getConteudo()['value'] ?? []
        ];
        
        // Verificar se a requisição foi bem-sucedida
        if ($resultado['status'] < 200 || $resultado['status'] > 250 || empty($resultado['data'])) {
            return [];
        }
        
        $produtos = [];
        // Processar os resultados
        foreach ($resultado['data'] as $item) {
            $produtos[] = $item;
        }
        
        return $produtos;

    } catch (\Throwable $th) {
        Erros::salva("ProdutosErro - Erro ao buscar produtos no EMAUTO", [
            'termo' => $termo,
            'buscaParcial' => $buscaParcial,
            'erro' => $th->getMessage()
        ]);
        return [];
    }
}
    
    public function getProduto()
    {     // "http://166.0.186.208:2002/emsoft/emauto/Produto?%24filter=WEB%20eq%20'S'&%24top={$qtd}"
//%24filter=(PRODUTO%20eq%20'35261260'%20or%20REFERENCIA%20eq%20'6L5Z11002AA'%20or%20REFERENCIA2%20eq%20'6L5Z11002AA'%20or%20CODIGOBARRA%20eq%20'A12')


 
            $this->apiServiceEmauto->set(
                apiProdutos,
                'GET',
                "%24filter=(PRODUTO%20eq%20'35261260'%20or%20REFERENCIA%20eq%20'6L5Z11002AA'%20or%20REFERENCIA2%20eq%20'6L5Z11002AA'%20or%20CODIGOBARRA%20eq%20'A12')",
                useLineCounts: false
            ); 
            
             $resultado = [
                'status' => $this->apiServiceEmauto->getStatus(),
                'data' => $this->apiServiceEmauto->getConteudo()['value'] ?? []
            ];

            try {

                if ($resultado['status'] < 200 || $resultado['status'] > 250 || empty($resultado['data'])) {
                    return $resultado;
                }

               // Adicione os produtos ao array
            foreach ($resultado['data'] as $item) {
               $produtos[] = $item;
            }
            } catch (\Throwable $th) {
                Erros::salva("ProdutosErro Erro ao tentar baixar produtos no EMAUTO", $resultado);
            }

           


        $this->temp->setDataUltUpdateProdutos('dataUllProdutos');

        return $produtos;
    } 




    // public function getProduto($qtd)
    // {     // "http://166.0.186.208:2002/emsoft/emauto/Produto?%24filter=WEB%20eq%20'S'&%24top={$qtd}"


    //     $exec = function (string $data, int $pagina): array {
    //         $this->apiServiceEmauto->set(
    //             apiProdutos,
    //             'GET',
    //             "%24filter=WEB%20eq%20'S'&%24top=5%24skip={$pagina}",
    //             useLineCounts: false
    //         ); 
    //         return [
    //             'status' => $this->apiServiceEmauto->getStatus(),
    //             'data' => $this->apiServiceEmauto->getConteudo()['value'] ?? []
    //         ];
    //     };
    //     $pagina = 0;  
        
    
    //     do {

    //         try {
    //             $resultado = $exec($qtd, $pagina);

    //             if ($resultado['status'] < 200 || $resultado['status'] > 250 || empty($resultado['data'])) {
    //                 break;
    //             }

    //            // Adicione os produtos ao array
    //         foreach ($resultado['data'] as $item) {
    //            $produtos[] = $item;
    //         }
    //         } catch (\Throwable $th) {
    //             Erros::salva("ProdutosErro Erro ao tentar baixar produtos no EMAUTO", $resultado);
    //         }


    //         $pagina = $pagina + 5;
    //     } while (!empty($resultado['data']));

    //     $this->temp->setDataUltUpdateProdutos('dataUllProdutos');

    //     return $produtos;
    // } 
}

    