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
     * Atualiza um produto na API Emauto.
     *
     * @param string $idProdutoParaApi O ID/código do produto (valor do campo chave 'PRODUTO').
     * @param array|null $dadosPayloadCompleto O payload completo com todos os campos para a API.
     * @return array Resultado da operação.
     */
   public function atualizarProduto(string $idProdutoParaApi, ?array $dadosAlteradosPeloUsuario): array
    {
        if (empty($idProdutoParaApi)) {
            return ['status' => false, 'mensagem' => 'Código do produto (ID) é obrigatório para atualização.'];
        }

        // Se $dadosAlteradosPeloUsuario for null ou vazio, ainda podemos prosseguir se a intenção
        // for, por exemplo, revalidar/reenviar os dados originais (embora incomum para um PUT).
        // Por segurança, vamos assumir que se está chamando atualizar, algo mudou ou precisa ser enviado.
        if ($dadosAlteradosPeloUsuario === null) { // Permitir array vazio se a intenção for reenviar tudo
             $dadosAlteradosPeloUsuario = [];
        }


        try {
            // 1. BUSCAR OS DADOS COMPLETOS DO PRODUTO EXISTENTE
            //    Use o seu método que já faz isso.
            $produtoOriginalCompleto = $this->buscarTodos($idProdutoParaApi);

            if ($produtoOriginalCompleto === null) {
                return [
                    'status' => false,
                    'mensagem' => "Produto original com ID '{$idProdutoParaApi}' não encontrado para carregar dados base.",
                    'codigo' => 404
                ];
            }

            // 2. FAZER O MERGE: Dados originais + alterações do usuário
            //    Os valores em $dadosAlteradosPeloUsuario sobrescreverão os de $produtoOriginalCompleto.
            $payloadFinalParaApi = array_merge($produtoOriginalCompleto, $dadosAlteradosPeloUsuario);

            // Garante que o campo 'PRODUTO' (chave principal da API) esteja correto e presente.
            // O merge já deve ter cuidado disso se $produtoOriginalCompleto['PRODUTO'] estiver correto.
            $payloadFinalParaApi['PRODUTO'] = $idProdutoParaApi;


            // Lista de campos obrigatórios e seus tipos esperados pela API Emauto
            $camposRequeridosComTipos = [
                'PRODUTO'           => 'string', 'NOME'              => 'string',
                'DT_COMPRA'         => 'string', 'DT_VENDA'          => 'string',
                'SERVICO'           => 'string', 'ATIVO'             => 'string',
                'USAR_MARGEM_CURVA' => 'string', 'MARGEM_CURVA'      => 'number', // Alterado de 'integer' para 'number' para flexibilidade
                'ETIQUETA'          => 'string', 'COMPRA'            => 'string',
                'QTD_MAXIMA'        => 'number', 'QTD_GARANTIA'      => 'number',
                'TRANCAR'           => 'string', 'WEB'               => 'string',
                'VENDA_COM_OFERTA'  => 'string'
            ];
            
            // Verificar se todos os campos obrigatórios estão presentes no $payloadFinalParaApi (APÓS O MERGE)
            $camposAusentes = [];
            foreach (array_keys($camposRequeridosComTipos) as $campoReq) {
                // A API pode aceitar null para alguns campos obrigatórios, mas geralmente não.
                // Se a API não aceitar NULL para campos obrigatórios, a verificação seria:
                // if (!isset($payloadFinalParaApi[$campoReq])) {
                // Ou, se strings vazias não são permitidas para campos string obrigatórios:
                if (!array_key_exists($campoReq, $payloadFinalParaApi) || 
                    ($payloadFinalParaApi[$campoReq] === null && !in_array($campoReq, ['MARGEM_CURVA', 'QTD_MAXIMA', 'QTD_GARANTIA'])) // Permite null para números se a API aceitar
                   ) {
                    $camposAusentes[] = $campoReq;
                }
            }
            
            if (!empty($camposAusentes)) {
                // Para depuração, mostre o payload que está sendo verificado:
                // error_log("Payload antes da falha de campos ausentes: " . print_r($payloadFinalParaApi, true));
                return [
                    'status' => false,
                    'mensagem' => 'Campos obrigatórios ausentes ou nulos indevidamente no payload final para a API.',
                    'campos_ausentes' => $camposAusentes,
                    'payload_verificado' => $payloadFinalParaApi // Para depuração
                ];
            }
            
            // Sanitizar e ajustar tipos dos dados FINAIS para envio.
            $dadosSanitizadosParaApi = [];
            foreach ($payloadFinalParaApi as $campo => $valor) {
                // Se um campo não é esperado pela API, ele pode ser ignorado ou causar erro.
                // Idealmente, filtraríamos para enviar apenas campos conhecidos pela API.
                // Por ora, vamos processar todos os campos presentes em $payloadFinalParaApi.

                $tipoEsperado = 'string'; // Default
                if (isset($camposRequeridosComTipos[$campo])) {
                    $tipoEsperado = $camposRequeridosComTipos[$campo];
                } elseif (is_numeric($valor) && !is_string($valor)) {
                    $tipoEsperado = 'number';
                }
                // Adicione aqui o tratamento para outros campos opcionais que sua API aceita,
                // como DESCRICAO, CODIGOBARRA, QTD_MAX_ARMAZENAGEM, LOCAL, LOCAL2, LOCAL3
                // e defina seus $tipoEsperado.
                // Ex: if ($campo === 'DESCRICAO') $tipoEsperado = 'string';
                //     if ($campo === 'QTD_MAX_ARMAZENAGEM') $tipoEsperado = 'number';


                if ($valor === null) {
                    // Permitir null se o campo não for um dos que verificamos acima como estritamente não nulo
                    // ou se o $tipoEsperado permitir (ex: alguns campos numéricos opcionais).
                    if (in_array($campoReq, ['MARGEM_CURVA', 'QTD_MAXIMA', 'QTD_GARANTIA']) || !isset($camposRequeridosComTipos[$campo])) {
                        $dadosSanitizadosParaApi[$campo] = null;
                    } else {
                         // Se for um campo obrigatório string que não pode ser null:
                        $dadosSanitizadosParaApi[$campo] = ''; // Ou tratar como erro se string vazia não for permitida.
                    }
                    continue;
                }

                switch ($tipoEsperado) {
                    case 'string':
                        $dadosSanitizadosParaApi[$campo] = Sanitizantes::filtro((string)$valor);
                        if (in_array($campo, ['SERVICO', 'ATIVO', 'USAR_MARGEM_CURVA', 'ETIQUETA', 'COMPRA', 'TRANCAR', 'WEB', 'VENDA_COM_OFERTA'])) {
                            $valSN = strtoupper(substr(trim($dadosSanitizadosParaApi[$campo]), 0, 1));
                            if (in_array($valSN, ['S', 'V', '1', 'Y', 'T'])) $dadosSanitizadosParaApi[$campo] = 'S';
                            elseif (in_array($valSN, ['N', 'F', '0'])) $dadosSanitizadosParaApi[$campo] = 'N';
                            else $dadosSanitizadosParaApi[$campo] = (isset($produtoOriginalCompleto[$campo]) ? $produtoOriginalCompleto[$campo] : 'N'); // Default para original ou 'N'
                        }
                        if ($campo === 'PRODUTO' && strlen($dadosSanitizadosParaApi[$campo]) > 15) $dadosSanitizadosParaApi[$campo] = substr($dadosSanitizadosParaApi[$campo], 0, 15);
                        if ($campo === 'NOME' && strlen($dadosSanitizadosParaApi[$campo]) > 50) $dadosSanitizadosParaApi[$campo] = substr($dadosSanitizadosParaApi[$campo], 0, 50);
                        // Para DT_COMPRA e DT_VENDA, garanta o formato esperado pela API (ex: ISO8601)
                        // if ($campo === 'DT_COMPRA' || $campo === 'DT_VENDA') {
                        //     try {
                        //         $date = new \DateTime($valor);
                        //         $dadosSanitizadosParaApi[$campo] = $date->format('Y-m-d\TH:i:s'); // Exemplo, ajuste o formato
                        //     } catch (\Exception $e) {
                        //         // Tratar data inválida, talvez usar o valor original ou retornar erro
                        //         $dadosSanitizadosParaApi[$campo] = $produtoOriginalCompleto[$campo] ?? null;
                        //     }
                        // }
                        break;
                    case 'number': // Para integer ou float
                        if (is_numeric($valor)) {
                            // Se o campo específico deve ser int (ex: QTD_MAXIMA, QTD_GARANTIA)
                            if (in_array($campo, ['MARGEM_CURVA', 'QTD_MAXIMA', 'QTD_GARANTIA', 'QTD_MAX_ARMAZENAGEM'])) { // Adicionado QTD_MAX_ARMAZENAGEM
                                $dadosSanitizadosParaApi[$campo] = (int)$valor;
                            } else { // Assume float para outros 'number'
                                $dadosSanitizadosParaApi[$campo] = (float)str_replace(',', '.', (string)$valor);
                            }
                        } else {
                             // Se não for numérico, mas é esperado como número. Usar valor original ou um default.
                            $dadosSanitizadosParaApi[$campo] = isset($produtoOriginalCompleto[$campo]) && is_numeric($produtoOriginalCompleto[$campo]) ? $produtoOriginalCompleto[$campo] : 0;
                            if ($valor === null && in_array($campo, ['MARGEM_CURVA', 'QTD_MAXIMA', 'QTD_GARANTIA'])) {
                                $dadosSanitizadosParaApi[$campo] = null; // Permite null se a API aceitar
                            }
                        }
                        break;
                    default: // Para outros campos não listados (ex: DESCRICAO, CODIGOBARRA, LOCAL etc.)
                        // Assume que são strings se não especificado
                         $dadosSanitizadosParaApi[$campo] = Sanitizantes::filtro((string)$valor);
                        break;
                }
            }
            // GARANTIR que os campos do seu modal (que não são obrigatórios pela API, mas você edita)
            // estejam no payload final, devidamente sanitizados, mesmo que não estejam em $camposRequeridosComTipos.
            // O loop foreach ($payloadFinalParaApi as $campo => $valor) já deve cuidar disso
            // se você adicionar os tipos deles na lógica do switch ou antes.

            // Exemplo para QTD_MAX_ARMAZENAGEM (se não foi tratado acima e é do seu modal):
            if (isset($payloadFinalParaApi['QTD_MAX_ARMAZENAGEM']) && !isset($dadosSanitizadosParaApi['QTD_MAX_ARMAZENAGEM'])) {
                 if(is_numeric($payloadFinalParaApi['QTD_MAX_ARMAZENAGEM'])){
                    $dadosSanitizadosParaApi['QTD_MAX_ARMAZENAGEM'] = (int)$payloadFinalParaApi['QTD_MAX_ARMAZENAGEM'];
                 } else {
                    $dadosSanitizadosParaApi['QTD_MAX_ARMAZENAGEM'] = isset($produtoOriginalCompleto['QTD_MAX_ARMAZENAGEM']) && is_numeric($produtoOriginalCompleto['QTD_MAX_ARMAZENAGEM']) ? (int)$produtoOriginalCompleto['QTD_MAX_ARMAZENAGEM'] : 0;
                 }
            }
            // Faça o mesmo para DESCRICAO, CODIGOBARRA, LOCAL, LOCAL2, LOCAL3 se necessário

            // var_dump("Payload Final para API:", $dadosSanitizadosParaApi); // Para depuração ANTES de enviar

            $dadosJson = json_encode($dadosSanitizadosParaApi);
            // Restante do código para enviar para API e tratar resposta...
            // (código da resposta anterior)

            if (json_last_error() !== JSON_ERROR_NONE) {
                Erros::salva("ProdutosErroJSONEncode", ['id' => $idProdutoParaApi, 'data' => $dadosSanitizadosParaApi, 'error' => json_last_error_msg()]);
                return ['status' => false, 'mensagem' => 'Erro interno ao preparar dados para a API (JSON).', 'detalhes' => json_last_error_msg()];
            }

            $endpointUrlBase = defined('apiProdutos') ? apiProdutos : 'Produtos';
            $endpoint = $endpointUrlBase . "('" . urlencode($idProdutoParaApi) . "')";

            $this->apiServiceEmauto->set($endpoint, 'PUT', $dadosJson, false, true);

            $statusCode = $this->apiServiceEmauto->getStatus();
            $conteudo = $this->apiServiceEmauto->getConteudo();

            if ($statusCode >= 200 && $statusCode <= 204) {
                return [
                    'status' => true,
                    'mensagem' => 'Produto atualizado com sucesso via Emauto.',
                    'codigo' => $statusCode,
                    'resposta_api' => ($statusCode == 204 ? null : json_decode($conteudo, true))
                ];
            } else {
                $detalhesErroApi = $conteudo;
                if (($jsonDec = json_decode($conteudo, true)) && json_last_error() === JSON_ERROR_NONE) {
                    $detalhesErroApi = $jsonDec;
                }
                Erros::salva("ProdutosErroAPIUpdate", [
                    'id' => $idProdutoParaApi, 'endpoint' => $endpoint, 'payload_sent' => $dadosJson,
                    'status' => $statusCode, 'response' => $detalhesErroApi
                ]);
                return [
                    'status' => false, 'mensagem' => 'Erro ao atualizar produto na API Emauto.',
                    'detalhes' => $detalhesErroApi, 'codigo' => $statusCode, 'payload_enviado' => $dadosSanitizadosParaApi // Para depuração
                ];
            }

        } catch (\Throwable $th) {
            Erros::salva("ProdutosExceptionUpdate", [
                'id' => $idProdutoParaApi, 'data_alterada_usuario' => $dadosAlteradosPeloUsuario,
                'error' => $th->getMessage(), 'trace' => $th->getTraceAsString()
            ]);
            return [
                'status' => false, 'mensagem' => 'Exceção interna ao tentar atualizar produto.',
                'detalhes' => $th->getMessage()
            ];
        }
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



