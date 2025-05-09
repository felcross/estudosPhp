<?php

// Supondo que estas classes/constantes existam em algum lugar
class Sanitizantes {
    public static function filtro(string $data): string {
        // Implementação de exemplo, substitua pela sua real
        return htmlspecialchars(strip_tags(trim($data)));
    }
}

class Erros {
    public static function salva(string $mensagem, array $contexto): void {
        // Implementação de exemplo para log de erros
        // error_log($mensagem . ': ' . print_r($contexto, true));
        // Em um cenário real, você usaria um logger mais robusto (Monolog, etc.)
        echo "ERRO: " . $mensagem . "<pre>" . print_r($contexto, true) . "</pre>";
    }
}

// Supondo que apiProdutos seja uma constante ou propriedade de classe
if (!defined('apiProdutos')) {
    define('apiProdutos', 'https://seu.api.example.com/produtos'); // Defina o endpoint base da sua API
}


class ProdutoApi
{
    private $apiServiceEmauto; // Você precisará injetar ou instanciar isso
    private $limiteResultados = 10; // Exemplo de limite padrão

    // Construtor de exemplo para injetar a dependência do serviço de API
    public function __construct(/* ApiServiceEmauto */ $apiServiceEmautoInstance)
    {
        $this->apiServiceEmauto = $apiServiceEmautoInstance;
    }

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
        
        try {
            // Fazer a requisição à API
            $this->apiServiceEmauto->set(
                apiProdutos, // Endpoint base
                'GET',
                $filtro, // Query string para GET
                useLineCounts: false
            );
            
            // Obter o resultado
            $resultado = [
                'status' => $this->apiServiceEmauto->getStatus(),
                'data' => $this->apiServiceEmauto->getConteudo()['value'] ?? []
            ];
            
            // Verificar se a requisição foi bem-sucedida
            if ($resultado['status'] < 200 || $resultado['status'] > 299 || empty($resultado['data'])) { // Status 2xx são sucesso
                return [];
            }
            
            $produtos = []; // Inicializa para evitar erro se não houver 'data'
            // Processar os resultados
            if (isset($resultado['data']) && is_array($resultado['data'])) {
                foreach ($resultado['data'] as $item) {
                    $produtos[] = $item;
                }
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
     * Grava (atualiza) as informações de um produto via POST.
     *
     * @param string $idProduto O identificador único do produto a ser atualizado.
     * @param array $dadosProduto Um array associativo com os dados do produto a serem enviados.
     *                            Ex: ['NOME' => 'Novo Nome', 'PRECO' => 19.99]
     * @return array Retorna um array com 'status' (código HTTP) e 'data' (resposta da API) ou 'error'.
     */
    public function gravarProduto(string $idProduto, array $dadosProduto): array
    {
        // 1. Validar se o ID do produto e os dados foram fornecidos
        if (empty($idProduto)) {
            return [
                'status' => 400, // Bad Request
                'error' => 'O ID do produto é obrigatório para gravação.'
            ];
        }
        if (empty($dadosProduto)) {
            return [
                'status' => 400, // Bad Request
                'error' => 'Os dados do produto estão vazios.'
            ];
        }

        // 2. Sanitizar o ID do produto (parâmetro da URL)
        // Não é estritamente necessário se for um UUID ou int, mas bom para consistência se vier de input de usuário.
        $idProdutoSanitizado = Sanitizantes::filtro($idProduto);
        // Para $dadosProduto, a sanitização deve ser mais cuidadosa, campo a campo,
        // ou confiar que os dados já foram validados e sanitizados antes de chegar aqui.
        // Por simplicidade, não farei sanitização profunda do array $dadosProduto aqui.

        // 3. Codificar o ID para uso na URL
        $idProdutoEncoded = urlencode($idProdutoSanitizado);

        // 4. Montar o endpoint específico para o produto
        // Exemplo: apiProdutos base é 'https://api.com/produtos'
        // Endpoint para atualizar será 'https://api.com/produtos/ID_DO_PRODUTO'
        // Verifique como sua API espera o endpoint para atualização.
        // Algumas APIs podem usar PUT em vez de POST para atualizações.
        $endpoint = apiProdutos . '/' . $idProdutoEncoded;

        // 5. Preparar o payload (corpo da requisição)
        // A API provavelmente espera JSON.
        $payload = json_encode($dadosProduto);
        if ($payload === false) {
            Erros::salva("ProdutosErro - Erro ao codificar dados do produto para JSON", [
                'idProduto' => $idProduto,
                'dadosProduto' => $dadosProduto, // Cuidado ao logar dados sensíveis
                'erro' => json_last_error_msg()
            ]);
            return [
                'status' => 500, // Internal Server Error
                'error' => 'Falha ao preparar os dados para envio: ' . json_last_error_msg()
            ];
        }

        try {
            // 6. Fazer a requisição à API
            // O terceiro argumento ($payload) é o corpo da requisição para POST.
            // Se sua apiServiceEmauto->set precisar de headers explícitos (como Content-Type: application/json),
            // você precisará de um jeito de passá-los.
            // Muitos HTTP clients configuram Content-Type automaticamente se você passa uma string JSON e usa POST.
            $this->apiServiceEmauto->set(
                $endpoint,
                'POST', // Ou 'PUT' se sua API usar PUT para atualizações
                $payload
                // Se o método 'set' aceitar opções de cabeçalho:
                // , options: ['headers' => ['Content-Type' => 'application/json']]
            );

            // 7. Obter o resultado
            $status = $this->apiServiceEmauto->getStatus();
            $conteudoResposta = $this->apiServiceEmauto->getConteudo();

            // 8. Verificar se a requisição foi bem-sucedida (geralmente status 200, 201 ou 204 para POST/PUT)
            if ($status >= 200 && $status <= 299) {
                return [
                    'status' => $status,
                    'data' => $conteudoResposta // A API pode retornar o objeto atualizado ou apenas uma confirmação
                ];
            } else {
                Erros::salva("ProdutosErro - API retornou erro ao gravar produto", [
                    'idProduto' => $idProduto,
                    'endpoint' => $endpoint,
                    'status' => $status,
                    'respostaApi' => $conteudoResposta
                ]);
                return [
                    'status' => $status,
                    'error' => 'API retornou um erro.',
                    'details' => $conteudoResposta
                ];
            }

        } catch (\Throwable $th) {
            Erros::salva("ProdutosErro - Erro crítico ao gravar produto no EMAUTO", [
                'idProduto' => $idProduto,
                'dadosProdutoEnviados' => $payload, // JSON string
                'endpoint' => $endpoint,
                'erro' => $th->getMessage()
            ]);
            return [
                'status' => 500, // Internal Server Error
                'error' => 'Erro interno ao tentar gravar o produto.',
                'exception_message' => $th->getMessage()
            ];
        }
    }
}

// Exemplo de uso (requer uma instância mock/real de ApiServiceEmauto):
// class MockApiServiceEmauto {
//     private $lastStatus;
//     private $lastConteudo;
//     public function set($endpoint, $method, $payloadOrQuery = null, $options = []) {
//         echo "ApiServiceEmauto->set() chamado com:\n";
//         echo "Endpoint: $endpoint\n";
//         echo "Method: $method\n";
//         echo "Payload/Query: " . print_r($payloadOrQuery, true) . "\n";
//         // Simular uma resposta de sucesso da API
//         if ($method === 'POST') {
//             $this->lastStatus = 200; // OK
//             $this->lastConteudo = ['message' => 'Produto atualizado com sucesso', 'id' => basename($endpoint), 'data' => json_decode($payloadOrQuery, true)];
//         } else if ($method === 'GET') {
//             $this->lastStatus = 200;
//             $this->lastConteudo = ['value' => [
//                 ['PRODUTO' => 'Produto Teste', 'REFERENCIA' => 'REF123']
//             ]];
//         }
//     }
//     public function getStatus() { return $this->lastStatus; }
//     public function getConteudo() { return $this->lastConteudo; }
// }

// $apiServiceMock = new MockApiServiceEmauto();
// $produtoApiClient = new ProdutoApi($apiServiceMock);

// // Testando gravarProduto
// $idDoProdutoParaAtualizar = "PROD456";
// $dadosParaAtualizar = [
//     "PRODUTO" => "Nome Atualizado do Produto",
//     "PRECOVENDA" => 129.90,
//     "ESTOQUEATUAL" => 50
// ];

// $resultadoGravacao = $produtoApiClient->gravarProduto($idDoProdutoParaAtualizar, $dadosParaAtualizar);
// echo "\nResultado da Gravação:\n";
// print_r($resultadoGravacao);

// echo "\n\n";

// // Testando buscarProdutos (para manter o contexto da classe)
// $resultadoBusca = $produtoApiClient->buscarProdutos(produto: 'Teste');
// echo "\nResultado da Busca:\n";
// print_r($resultadoBusca);

?>