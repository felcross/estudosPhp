<?php



namespace model;
use api\ApiServiceEmauto;
use utils\Temp;
use api\TokensControl;
use Core\View;
use utils\Erros;
use utils\DadosINI;
use utils\Sanitizantes;





class ProdutoApi2 extends TokensControl {
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
     * Limite padrão de resultados
     * @var int
     */
    private int $limiteResultados = 50;
    
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



    public function buscarProdutosPaginado(string $produto = '', string $ref = '', string $ref2 = '', string $codBarra = '', bool $buscaParcial = true, ?int $limite = null, int $pagina = 0): array
{
    $exec = function (string $filtro, int $paginaAtual): array {
        $this->apiServiceEmauto->set(
            apiProdutos,
            'GET',
            $filtro . "&pPagina={$paginaAtual}",
            useLineCounts: false
        );
        return [
            'status' => $this->apiServiceEmauto->getStatus(),
            'data' => $this->apiServiceEmauto->getConteudo()['value'] ?? []
        ];
    };

    // Verifica se pelo menos um parâmetro de busca foi fornecido
    if (empty($produto) && empty($ref) && empty($ref2) && empty($codBarra)) {
        return [];
    }
    
    // Sanitizar todos os parâmetros de busca
    $produto = Sanitizantes::filtro($produto);
    $ref = Sanitizantes::filtro($ref);
    $ref2 = Sanitizantes::filtro($ref2);
    $codBarra = Sanitizantes::filtro($codBarra);
    
    // Codificar os parâmetros para URL
    $produtoEncoded = urlencode($produto);
    $refEncoded = urlencode($ref);
    $ref2Encoded = urlencode($ref2);
    $codBarraEncoded = urlencode($codBarra);
    
    // Definir o operador de comparação com base no tipo de busca
    $operador = $buscaParcial ? "contains" : "eq";
    
    // Construir condições de filtro dinamicamente apenas para parâmetros não vazios
    $condicoes = [];
    
    if (!empty($produto)) {
        $condicoes[] = "{$operador}(PRODUTO,%20'{$produtoEncoded}')";
    }
    
    if (!empty($ref)) {
        $condicoes[] = "{$operador}(REFERENCIA,%20'{$refEncoded}')";
    }
    
    if (!empty($ref2)) {
        $condicoes[] = "{$operador}(REFERENCIA2,%20'{$ref2Encoded}')";
    }
    
    if (!empty($codBarra)) {
        $condicoes[] = "{$operador}(CODIGOBARRA,%20'{$codBarraEncoded}')";
    }
    
    // Juntar condições com operador OR
    $filtroCondicoes = implode('%20or%20', $condicoes);
    
    // Aplicar limite de resultados (usando o valor passado ou o padrão da classe)
    $limiteAtual = $limite ?? $this->limiteResultados;
    
    // Montar a query completa
    $filtro = "%24filter=({$filtroCondicoes})&%24top={$limiteAtual}";

    try {
        $resultado = $exec($filtro, $pagina);
        
        if ($resultado['status'] < 200 || $resultado['status'] > 250 || empty($resultado['data'])) {
            return [];
        }
        
        // Processar os resultados
        $produtos = [];
        foreach ($resultado['data'] as $item) {
            $produtos[] = $item;
        }
        
        return $produtos;
        
    } catch (\Throwable $th) {
        Erros::salva("ProdutosErro - Erro ao buscar produtos no EMAUTO", [
            'parametros' => [
                'produto' => $produto,
                'ref' => $ref,
                'ref2' => $ref2,
                'codBarra' => $codBarra,
                'pagina' => $pagina
            ],
            'filtro' => $filtro,
            'buscaParcial' => $buscaParcial,
            'erro' => $th->getMessage()
        ]);
        return [];
    }
}




public function buscarTodosProdutosPaginado(string $termo , bool $buscaParcial = true): array
{
    $todosProdutos = [];
    $pagina = 0;
    
    do {
        try {
            $resultado = $this->buscarProdutosPaginado($termo, $termo, $termo, $termo, $buscaParcial, null, $pagina);
            
            if (empty($resultado)) {
                break;
            }
            
            foreach ($resultado as $item) {
                $todosProdutos[] = $item;
            }
            
        } catch (\Throwable $th) {
            Erros::salva("ProdutosErro - Erro ao tentar buscar produtos paginados", error_get_last());
            break;
        }
        
        $pagina++;
    } while (!empty($resultado));
    
    return $todosProdutos;
}

}