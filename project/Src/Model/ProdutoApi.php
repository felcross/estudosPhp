<?php



namespace model;
use api\ApiServiceEmauto;
use utils\Temp;
use api\TokensControl;
use Core\View;
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
    public function buscarProdutos(string $produto , string $ref, string $ref2 , string $codBarra , bool $buscaParcial, ?int $limite, int $pagina): array
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


        $exec = function (string $filtro, int $paginaAtual): array {
            // Fazer a requisição à API
            $this->apiServiceEmauto->set(
                apiProdutos,
                'GET',
                $filtro . "&%24skip={$paginaAtual}",
                false
            );

            // Erros::salva('TESTE',$this->apiServiceEmauto->getUrl() );
            // Obter o resultado
            return [
                'status' => $this->apiServiceEmauto->getStatus(),
                'data' => $this->apiServiceEmauto->getConteudo()['value'] ?? []
            ];

        };

       


        try {

            $resultado = $exec($filtro, $pagina );




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

    public function buscarTodos(string $termo, bool $buscaParcial , ?int $limite  , int $pagina): array
    {
        return $this->buscarProdutos($termo, $termo, $termo, $termo, $buscaParcial, $limite , $pagina);
    }


    public function atualizarProduto(string $codigoProduto, array $dadosAtualizacao): array
    {



        // Validação básica
        if (empty($codigoProduto)) {
            return [
                'status' => false,
                'mensagem' => 'Código do produto é obrigatório'
            ];
        }

        if (empty($dadosAtualizacao)) {
            return [
                'status' => false,
                'mensagem' => 'Dados para atualização são obrigatórios'
            ];
        }

        try {
            // Sanitizar dados de entrada
            $dadosLimpos = [];
            foreach ($dadosAtualizacao as $campo => $valor) {
                if (is_string($valor)) {
                    $dadosLimpos[$campo] = Sanitizantes::filtro($valor);
                } else {
                    $dadosLimpos[$campo] = $valor;
                }
            }

            // Converter para JSON
            $dadosJson = json_encode($dadosLimpos);
            if ($dadosJson === false) {
                return [
                    'status' => false,
                    'mensagem' => 'Erro ao processar dados: ' . json_last_error_msg(),
                    'codigo' => 400
                ];
            }

            // Fazer requisição PUT
            $endpoint = "(" . urlencode($codigoProduto) . ")";

            // Debug do JSON gerado - descomente se necessário
            Erros::salva("DEBUG_JSON", ['dados' => $dadosAtualizacao, 'json' => $dadosJson]);




            $this->apiServiceEmauto->set(
                apiProdutos . $endpoint,
                'PATCH',
                $dadosJson,
                useJsonEncode: false
            );

            $statusCode = $this->apiServiceEmauto->getStatus();
            $conteudo = $this->apiServiceEmauto->getConteudo();
            $url = $this->apiServiceEmauto->getUrl();


            // Para debug - descomente se necessário
            Erros::salva("RESPOSTA_API", ['status' => $statusCode, 'conteudo' => $conteudo, 'Url' => $url]);

            // Verificar resposta
            if ($statusCode >= 200 && $statusCode <= 204) {
                return [
                    'status' => true,
                    'mensagem' => 'Produto atualizado com sucesso',
                    'codigo' => $statusCode
                ];
            }

            return [
                'status' => false,
                'mensagem' => 'Erro ao atualizar produto',
                'detalhes' => $conteudo,
                'codigo' => $statusCode
            ];

        } catch (\Throwable $e) {
            Erros::salva("ProdutosErro - Atualização", [
                'produto' => $codigoProduto,
                'dados' => $dadosAtualizacao,
                'erro' => error_get_last()
            ]);

            return [
                'status' => false,
                'mensagem' => 'Erro interno ao atualizar produto',
                'detalhes' => $e->getMessage()
            ];
        }
    }

































    // public function atualizarProduto(string $produto, array $dadosAtualizacao): array
// {
//     // Validar se o produto foi informado
//     if (empty($produto)) {
//         return [
//             'status' => false,
//             'mensagem' => 'Código do produto é obrigatório'
//         ];
//     }

    //     try {


    //         // Definir todos os campos obrigatórios com seus valores atuais ou vazios
//         $camposObrigatorios = [
//             'PRODUTO' => $produto['PRODUTO'] ?? '',
//             'NOME' => $produto['NOME'] ?? '',
//             'DT_COMPRA' => $produto['DT_COMPRA'] ?? null,
//             'DT_VENDA' => $produto['DT_VENDA'] ?? null,
//             'SERVICO' => $produto['SERVICO'] ?? '',
//             'ATIVO' => $produto['ATIVO'] ?? '',
//             'USAR_MARGEM_CURVA' => $produto['USAR_MARGEM_CURVA'] ?? '',
//             'MARGEM_CURVA' => $produto['MARGEM_CURVA'] ?? 0,
//             'ETIQUETA' => $produto['ETIQUETA'] ?? '',
//             'COMPRA' => $produto['COMPRA'] ?? '',
//             'QTD_MAXIMA' => $produto['QTD_MAXIMA'] ?? 0,
//             'QTD_GARANTIA' => $produto['QTD_GARANTIA'] ?? 0,
//             'TRANCAR' => $produto['TRANCAR'] ?? '',
//             'WEB' => $produto['WEB'] ?? '',
//             'VENDA_COM_OFERTA' => $produto['VENDA_COM_OFERTA'] ?? ''
//         ];

    //         // Mesclar os dados atualizados com os campos obrigatórios
//         $dadosCompletos = array_merge($camposObrigatorios, $dadosAtualizacao);

    //         // Sanitizar os dados para garantir segurança
//         foreach ($dadosCompletos as $campo => $valor) {
//             if (is_string($valor)) {
//                 $dadosCompletos[$campo] = Sanitizantes::filtro($valor);
//             }
//         }

    //         // Preparar os dados para o PUT
//         $dadosJson = json_encode($dadosCompletos);

    //         // Construir o endpoint para o produto específico
//         $endpoint = "(" . urlencode($produto) . ")";

    //         // Fazer a requisição à API
//         $this->apiServiceEmauto->set(
//             apiProdutos . $endpoint,
//             'PUT',
//             $dadosJson,

    //         );

    //         // Obter o resultado
//         $statusCode = $this->apiServiceEmauto->getStatus();
//         $conteudo = $this->apiServiceEmauto->getConteudo();

    //         // Verificar se a requisição foi bem-sucedida
//          //  Erros::salva("TESTE",$conteudo );


    //         if ($statusCode < 200 || $statusCode > 204) {


    //             return [
//                 'status' => false,
//                 'mensagem' => 'Erro ao atualizar produto erro 1',
//                 'detalhes' => $conteudo,
//                 'codigo' => $statusCode
//             ];
//         }

    //         return [
//             'status' => true,
//             'mensagem' => 'Produto atualizado com sucesso',
//             'codigo' => $statusCode
//         ];

    //     } catch (\Throwable $th) {
//         Erros::salva("ProdutosErro - Erro ao atualizar produto no EMAUTO", [
//             'produto' => $produto,
//             'dadosAtualizacao' => $dadosAtualizacao,
//             'erro' => $th->getMessage()
//         ]);

    //         return [
//             'status' => false,
//             'mensagem' => 'Ocorreu um erro ao atualizar o produto',
//             'detalhes' => $th->getMessage()
//         ];
//     }
// }}

}



