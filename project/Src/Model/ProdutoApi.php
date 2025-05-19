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

        public function atualizarProduto(string $produtoId, array $dadosAtualizacao): array
    {
        // Validar se o ID do produto foi informado
        if (empty($produtoId)) {
            return [
                'status' => false,
                'mensagem' => 'Código do produto (ID) é obrigatório para atualização.'
            ];
        }

        // Validar se há dados para atualizar
        if (empty($dadosAtualizacao)) {
            return [
                'status' => false,
                'mensagem' => 'Nenhum dado fornecido para atualização.'
            ];
        }

        try {
            // Os $dadosAtualizacao agora vêm diretamente do controller
            // com os campos que o usuário pode modificar no modal.
            // A API Emauto deve lidar com a mesclagem ou atualização parcial.

            $dadosParaEnviar = [];
            // Sanitizar os dados recebidos para garantir segurança
            foreach ($dadosAtualizacao as $campo => $valor) {
                // Apenas sanitiza strings. Números e booleanos podem precisar de validação/conversão específica
                // que pode ser feita no controller ou aqui, se necessário.
                if (is_string($valor)) {
                    $dadosParaEnviar[$campo] = Sanitizantes::filtro($valor);
                } else {
                    $dadosParaEnviar[$campo] = $valor; // Mantém números, booleanos, etc.
                }
            }

            // Garantir que QTD_MAX_ARMAZENAGEM seja um inteiro se estiver presente
            if (isset($dadosParaEnviar['QTD_MAX_ARMAZENAGEM'])) {
                $dadosParaEnviar['QTD_MAX_ARMAZENAGEM'] = (int)$dadosParaEnviar['QTD_MAX_ARMAZENAGEM'];
            }

            // Preparar os dados para o PUT
            // A API Emauto espera um objeto JSON, não um array de objetos.
            $dadosJson = json_encode($dadosParaEnviar);

            // Construir o endpoint para o produto específico
            // A URL da API Emauto para PUT em um produto específico pode ser diferente
            // Verifique se é realmente (id) ou algo como /produtos/id
            $endpoint = "(" . urlencode($produtoId) . ")"; // Mantendo sua formatação original

            // Fazer a requisição à API Emauto
            // Certifique-se que apiProdutos está definido corretamente
            $this->apiServiceEmauto->set(
                apiProdutos . $endpoint, // Ex: 'http://api.emauto.com/produtos/(ID_DO_PRODUTO)'
                'PUT',
                $dadosJson,
                false, // useLineCounts: false
            //   'application/json' // contentType: 'application/json' É IMPORTANTE para PUT/POST com JSON
            );

            // Obter o resultado
            $statusCode = $this->apiServiceEmauto->getStatus();
            $conteudo = $this->apiServiceEmauto->getConteudo();

            // Verificar se a requisição foi bem-sucedida (geralmente 200 OK, 201 Created, 204 No Content para PUT/DELETE)
            if ($statusCode >= 200 && $statusCode <= 204) { // Ajustado para incluir 204
                return [
                    'status' => true,
                    'mensagem' => 'Produto atualizado com sucesso via Emauto.',
                    'codigo' => $statusCode,
                    'resposta_api' => $conteudo // Opcional: retornar a resposta da API
                ];
            } else {
                // Tentar decodificar o conteúdo se for JSON, para melhor log/mensagem de erro
                $detalhesErroApi = $conteudo;
                $jsonDecodificado = json_decode($conteudo, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($jsonDecodificado)) {
                    $detalhesErroApi = $jsonDecodificado;
                }

                Erros::salva("ProdutosErro - Falha ao atualizar produto no EMAUTO", [
                    'produtoId' => $produtoId,
                    'dadosEnviados' => $dadosParaEnviar,
                    'statusCode' => $statusCode,
                    'respostaApi' => $detalhesErroApi
                ]);

                return [
                    'status' => false,
                    'mensagem' => 'Erro ao atualizar produto na API Emauto.',
                    'detalhes' => $detalhesErroApi, // Retorna a resposta da API para depuração
                    'codigo' => $statusCode
                ];
            }
        } catch (\Throwable $th) {
            Erros::salva("ProdutosErro - Exceção ao tentar atualizar produto no EMAUTO", [
                'produtoId' => $produtoId,
                'dadosAtualizacaoBrutos' => $dadosAtualizacao, // Dados antes da sanitização/transformação
                'erro' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);

            return [
                'status' => false,
                'mensagem' => 'Ocorreu uma exceção interna ao tentar atualizar o produto.',
                'detalhes' => $th->getMessage()
            ];
        }
    }



























































/**
 * Atualiza os dados de um produto no sistema EMAUTO
 * 
 * @param string $produto Código único do produto a ser atualizado
 * @param array $dadosAtualizacao Array contendo os campos a serem atualizados
 * @return array Resultado da operação com status e mensagem
 */
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
//             useLineCounts: false,
//            // contentType: 'application/json'
//         );
        
//         // Obter o resultado
//         $statusCode = $this->apiServiceEmauto->getStatus();
//         $conteudo = $this->apiServiceEmauto->getConteudo();
        
//         // Verificar se a requisição foi bem-sucedida
//          //  Erros::salva("TESTE",$conteudo );
        

//         if ($statusCode < 200 || $statusCode > 204) {


//             return [
//                 'status' => false,
//                 'mensagem' => 'Erro ao atualizar produto',
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
// }


}
