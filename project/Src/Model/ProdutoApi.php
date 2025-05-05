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
public function buscarProdutos(string $produto, string $ref, string $ref2, string $codBarra, bool $buscaParcial = true)
{
    // Sanitizar o termo de busca para evitar injeção
    Sanitizantes::filtro($produto); 
    Sanitizantes::filtro($ref);  
    Sanitizantes::filtro($ref2);  
    Sanitizantes::filtro($codBarra); 
    
    
    // Codificar o termo de busca para URL
    $termoEncoded = urlencode($produto);

    // Codificar o termo de busca para URL
    $termoEncoded2 = urlencode($ref);

    // Codificar o termo de busca para URL
    $termoEncoded3 = urlencode($ref2);

     // Codificar o termo de busca para URL
     $termoEncoded4 = urlencode($codBarra);
    
    // Definir o operador de comparação com base no tipo de busca
    $operador = $buscaParcial ? "contains" : "eq";



    $filtro = "%24filter=(contains(PRODUTO,%20'{$termoEncoded}')%20or%20"
            . "contains(REFERENCIA,%20'{$termoEncoded2}')%20or%20"
            . "contains(REFERENCIA2,%20'{$termoEncoded3}')%20or%20"
            . "contains(CODIGOBARRA,%20'{$termoEncoded4}'))&%24top=5";




       //    dd( $filtro);
    
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
            'termo' => [
                'produto' => $produto,
                'ref' => $ref,
                'ref2' => $ref2,
                'codBarra' => $codBarra
            ],
            'filtro' => $filtro,
            'buscaParcial' => $buscaParcial,
            'erro' => $th->getMessage()
        ]);
        return [];
    }
}
}

    