<?php



namespace model;
use api\ApiServiceEmauto;
use utils\Temp;
use api\TokensControl;
use Core\View;
use utils\Erros;
use utils\DadosINI;
use utils\Sanitizantes;





class ProdutoApi extends TokensControl {
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

    /**
     * Define o limite de resultados para as consultas
     *
     * @param int $limite Número máximo de resultados a serem retornados
     * @return self
     */
    public function setLimiteResultados(int $limite): self
    {
        $this->limiteResultados = max(1, $limite);
        return $this;
    }
    
    /**
     * Busca produtos com base em múltiplos critérios
     *
     * @param string $produto Código ou nome do produto (opcional)
     * @param string $ref Referência principal (opcional)
     * @param string $ref2 Referência secundária (opcional)
     * @param string $codBarra Código de barras (opcional)
     * @param bool $buscaParcial Se true, busca por correspondência parcial (contains), caso contrário, busca exata
     * @param int|null $limite Limite de resultados (null para usar o limite padrão)
     * @return array Array com produtos encontrados ou array vazio se nada for encontrado
     */
    public function buscarProdutos(string $produto = '', string $ref = '', string $ref2 = '', string $codBarra = '', bool $buscaParcial = true, ?int $limite = null): array
    {
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



       // dd($filtro); 
        
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
            
           // Processar os resultados
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
                    'codBarra' => $codBarra
                ],
                'filtro' => $filtro,
                'buscaParcial' => $buscaParcial,
                'erro' => $th->getMessage()
            ]);
            return [];
        }
    }
    
    /**
     * Busca produtos por texto em múltiplos campos
     * 
     * @param string $termo Termo de busca para filtrar produtos em todos os campos
     * @param bool $buscaParcial Se true, busca por correspondência parcial (contains)
     * @param int|null $limite Limite de resultados
     * @return array Array com produtos encontrados
     */
    public function buscarTodos(string $termo, bool $buscaParcial = true, ?int $limite = null): array
    {
        return $this->buscarProdutos($termo, $termo, $termo, $termo, $buscaParcial, $limite);
    }
    
    /**
     * Busca produto por código de barras
     * 
     * @param string $codBarra Código de barras a ser pesquisado
     * @param bool $buscaParcial Se true, busca por correspondência parcial
     * @return array|null Produto encontrado ou null
     */
    public function buscarPorCodigoBarras(string $codBarra, bool $buscaParcial = false): ?array
    {
        $resultado = $this->buscarProdutos('', '', '', $codBarra, $buscaParcial, 1);
        return !empty($resultado) ? $resultado[0] : null;
    }

/**
 * Atualiza os dados de um produto no sistema EMAUTO
 * 
 * @param string $produto Código único do produto a ser atualizado
 * @param array $dadosAtualizacao Array contendo os campos a serem atualizados
 * @return array Resultado da operação com status e mensagem
 */
public function atualizarProduto(string $produto, array $dadosAtualizacao): array
{
    // Validar se o produto foi informado
    if (empty($produto)) {
        return [
            'status' => false,
            'mensagem' => 'Código do produto é obrigatório'
        ];
    }
    
    try {
        // Primeiro, buscar o produto atual para garantir que temos todos os campos obrigatórios
        $produtoAtual = $this->buscarProdutos(produto: $produto, buscaParcial: false);
        
        if (empty($produtoAtual)) {
            return [
                'status' => false,
                'mensagem' => 'Produto não encontrado'
            ];
        }
        
        // Usar o primeiro resultado (deve ser único pois fizemos busca exata)
        $produtoAtual = $produtoAtual[0];
        
        // Definir todos os campos obrigatórios com seus valores atuais ou vazios
        $camposObrigatorios = [
            'PRODUTO' => $produtoAtual['PRODUTO'] ?? '',
            'NOME' => $produtoAtual['NOME'] ?? '',
            'DT_COMPRA' => $produtoAtual['DT_COMPRA'] ?? null,
            'DT_VENDA' => $produtoAtual['DT_VENDA'] ?? null,
            'SERVICO' => $produtoAtual['SERVICO'] ?? '',
            'ATIVO' => $produtoAtual['ATIVO'] ?? '',
            'USAR_MARGEM_CURVA' => $produtoAtual['USAR_MARGEM_CURVA'] ?? '',
            'MARGEM_CURVA' => $produtoAtual['MARGEM_CURVA'] ?? 0,
            'ETIQUETA' => $produtoAtual['ETIQUETA'] ?? '',
            'COMPRA' => $produtoAtual['COMPRA'] ?? '',
            'QTD_MAXIMA' => $produtoAtual['QTD_MAXIMA'] ?? 0,
            'QTD_GARANTIA' => $produtoAtual['QTD_GARANTIA'] ?? 0,
            'TRANCAR' => $produtoAtual['TRANCAR'] ?? '',
            'WEB' => $produtoAtual['WEB'] ?? '',
            'VENDA_COM_OFERTA' => $produtoAtual['VENDA_COM_OFERTA'] ?? ''
        ];
        
        // Mesclar os dados atualizados com os campos obrigatórios
        $dadosCompletos = array_merge($camposObrigatorios, $dadosAtualizacao);
        
        // Sanitizar os dados para garantir segurança
        foreach ($dadosCompletos as $campo => $valor) {
            if (is_string($valor)) {
                $dadosCompletos[$campo] = Sanitizantes::filtro($valor);
            }
        }
        
        // Preparar os dados para o PUT
        $dadosJson = json_encode($dadosCompletos);
        
        // Construir o endpoint para o produto específico
        $endpoint = "(" . urlencode($produto) . ")";
        
        // Fazer a requisição à API
        $this->apiServiceEmauto->set(
            apiProdutos . $endpoint,
            'PUT',
            $dadosJson,
            useLineCounts: false,
           // contentType: 'application/json'
        );
        
        // Obter o resultado
        $statusCode = $this->apiServiceEmauto->getStatus();
        $conteudo = $this->apiServiceEmauto->getConteudo();
        
        // Verificar se a requisição foi bem-sucedida
        if ($statusCode < 200 || $statusCode > 204) {
            return [
                'status' => false,
                'mensagem' => 'Erro ao atualizar produto',
                'detalhes' => $conteudo,
                'codigo' => $statusCode
            ];
        }
        
        return [
            'status' => true,
            'mensagem' => 'Produto atualizado com sucesso',
            'codigo' => $statusCode
        ];
        
    } catch (\Throwable $th) {
        Erros::salva("ProdutosErro - Erro ao atualizar produto no EMAUTO", [
            'produto' => $produto,
            'dadosAtualizacao' => $dadosAtualizacao,
            'erro' => $th->getMessage()
        ]);
        
        return [
            'status' => false,
            'mensagem' => 'Ocorreu um erro ao atualizar o produto',
            'detalhes' => $th->getMessage()
        ];
    }
}


}
