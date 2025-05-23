<?php

namespace src\controller;


use Core\View;
use model\ProdutoApi2;
use utils\Erros;
use utils\Sanitizantes;
use Exception;

// Controller

class Product2
{
    private $produtoApi;

    public function __construct()
    {
        $this->produtoApi = new ProdutoApi2;

    }

    public function processarAtualizacaoAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) {
            //header('Content-Type: application/json');

           // dd($_POST);

            // O ID do produto vem do input hidden #modalIdProduto com name="id_produto"
            $produtoId = $_POST['produto_id'] ?? null;

            // Campos do formulário do modal. As chaves de $_POST correspondem
            // aos 'name' dos inputs no modal e às chaves do formData no JS.
            $codigoBarra = $_POST['codigobarra'] ?? null;
            $qtdMaxArmazenagem = $_POST['qtd_max_armazenagem'] ?? null;
            $local = $_POST['local'] ?? null;
            $local2 = $_POST['local2'] ?? null;
            $local3 = $_POST['local3'] ?? null;

 

            if (!$produtoId) {
                echo json_encode(['success' => false, 'message' => 'ID do produto não fornecido para atualização.']);
                exit;
            }

            $dadosParaAtualizar = [];

            if ($codigoBarra !== null) {
                $dadosParaAtualizar['CODIGOBARRA'] = $codigoBarra;
            }
            if ($qtdMaxArmazenagem !== null) {
                $dadosParaAtualizar['QTD_MAX_ARMAZENAGEM'] = (int) $qtdMaxArmazenagem; // Cast para int
            }
            if ($local !== null) {
                $dadosParaAtualizar['LOCAL'] = $local;
            }
            if ($local2 !== null) {
                $dadosParaAtualizar['LOCAL2'] = $local2;
            }
            if ($local3 !== null) {
                $dadosParaAtualizar['LOCAL3'] = $local3;
            }


            if (empty($dadosParaAtualizar)) {
                echo json_encode(['success' => false, 'message' => 'Nenhum dado válido para atualização foi fornecido.']);
                exit;
            }

            // Aqui, $produtoId é o valor de $produto['PRODUTO'] que foi enviado
            $resultado = $this->produtoApi->atualizarProduto($produtoId, $dadosParaAtualizar);

              var_dump($resultado);

            if (isset($resultado['status']) && $resultado['status']) { // Verifique se 'status' existe antes de acessá-lo
                echo json_encode(['success' => true, 'message' => $resultado['mensagem'] ?? 'Produto atualizado com sucesso!', 'data' => $resultado]);
            } else {
                http_response_code(400); // Ou 500, dependendo da natureza do erro
                echo json_encode([
                    'success' => false,
                    'message' => $resultado['mensagem'] ?? 'Falha ao atualizar o produto.',
                    'details' => $resultado['detalhes'] ?? null,
                    'api_status_code' => $resultado['codigo'] ?? null
                ]);
            }
            exit;
        }
    }

   public function buscar()
    {
    $this->processarAtualizacaoAjax();

        $termo = isset($_GET['termo']) ? filter_input(INPUT_GET, 'termo', FILTER_SANITIZE_SPECIAL_CHARS) : ''; // Sanitizar
        $produtos = [];

        if (!empty($termo)) {
            $produtos = $this->produtoApi->buscarTodos($termo, true, 25);

            //dd($produtos);
        }


        View::render('page/teste.html.php', [
            'produtos' => $produtos,
            'termo' => $termo,
        ], 'Product');
    }

    function processarTodosOsProdutos() 
{

      $termo = isset($_GET['termo']) ? filter_input(INPUT_GET, 'termo', FILTER_SANITIZE_SPECIAL_CHARS) : ''; // Sanitizar

    $pagina = 1;
    $limitePorPagina = 100; // Buscar de 100 em 100, por exemplo

    echo "Iniciando processamento para: " . $termo . "\n";

    do {
        echo "Buscando página: " . $pagina . "\n";
        
        try {
            // Chama a função que usa $top e $skip
            $produtosDaPagina =  $this->produtoApi->buscarTodos($termo, true, $limitePorPagina, $pagina);

            // Se não veio nada, ou deu erro (função retorna []), paramos o loop
            if (empty($produtosDaPagina)) {
                echo "Nenhum produto encontrado na página " . $pagina . ". Finalizando.\n";
                break; 
            }

            echo "Encontrados " . count($produtosDaPagina) . " produtos. Processando...\n";

            // Processa cada item da página atual
            foreach ($produtosDaPagina as $item) {
                // Faça o que você precisa com cada $item
                // Ex: $this->layoutEstoque($item);
                // Ex: $this->layoutPrecoUnitario($item);
                echo " - Processando produto: " . ($item['PRODUTO'] ?? 'N/A') . "\n";
            }

            // Prepara para buscar a próxima página
            $pagina++;

        } catch (\Throwable $th) {
            Erros::salva("ProcessamentoErro - Erro ao buscar página $pagina", ['erro' => $th->getMessage()]);
            echo "Erro ao buscar página $pagina. Parando.\n";
            break; // Para o loop em caso de erro grave
        }

    // Continua enquanto a última busca retornou o número máximo de itens
    // (Isso sugere que PODE haver mais páginas)
    } while (count($produtosDaPagina) === $limitePorPagina); 

    echo "Processamento concluído.\n";
}

// Como usar:
// $api = new ProdutoAPI(...); // Crie sua instância
// processarTodosOsProdutos("TERMO_BUSCA", $api);
}





$productController = new Product2();
//$productController->buscar();
$productController->processarTodosOsProdutos();



















































// class ProdutoController {
//     private $produtoApi;

//     public function __construct() {
//         $this->produtoApi = new ProdutoApi();
//     }


//      // Fix your controller code:

//      public function  atualizar() 
//      { // Handle AJAX request first

//        // dd('entrouuuuu');

//     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) {


//         // Process the AJAX update request
//         $produtoId = $_POST['produto_id'] ?? null;
//         $codigo = $_POST['codigo_produto'] ?? null;
//         $descricao = $_POST['descricao'] ?? null;
//         $referencia = $_POST['referencia'] ?? null;
//         $referencia2 = $_POST['referencia2'] ?? null;
//         $codigoBarra = $_POST['codigobarra'] ?? null;
//         $preco = $_POST['preco'] ?? null;

//         if ($produtoId) {

//             $resultado = $this->produtoApi->atualizarProduto($produtoId, [
//                 'codigo' => $codigo,
//                 'descricao' => $descricao,
//                 'referencia' => $referencia,
//                 'referencia2' => $referencia2,
//                 'codigobarra' => $codigoBarra,
//                 'preco' => $preco

//             ]);

//              dd($resultado);

//             // Return JSON response and exit to prevent rendering the HTML
//             header('Content-Type: application/json');
//             echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso PROD']);
//             exit; // Important! This prevents the rest of the page from loading
//         } else {
//             // Return error response
//             header('Content-Type: application/json');
//             echo json_encode(['success' => false, 'message' => 'ID do produto não fornecido']);
//             exit;
//         }
//     } }

// public function buscar()
// {
//        $this->atualizar();


//     // Normal page load flow continues here
//     $termo = $_GET['termo'] ?? '';
//     $produtos = [];

//     if (!empty($termo)) {
//         $produtos = $this->produtoApi->buscarTodos($termo, true, limite: 15);
//     }

//     View::render('page/search2.html.php', [
//         'produtos' => $produtos,
//         'termo' => $termo,
//     ],js:'product');
// }







// }


// $productController = new ProdutoController;
// $productController->buscar();



















































// class ProdutoController {
//     private $produtoApi;

//     public function __construct() {
//         $this->produtoApi = new ProdutoApi();
//     }

//     public function buscar() {
//         $termo = $_POST['termo'] ?? '';
//       //  $buscaParcial = isset($_POST['parcial']) ? (bool)$_POST['parcial'] : true;

//         $produtos = [];
//         if (!empty($termo)) {
//             $produtos = $this->produtoApi->buscarTodos($termo, true, limite:15);
//         }

//         View::render('page/search2.html.php', [
//             'produtos' => $produtos,
//             'termo' => $termo,
//          //   'buscaParcial' => $buscaParcial
//         ]);
//     }}





// $productController = new ProdutoController;
// $productController->buscar();



























