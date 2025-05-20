<?php

namespace src\controller;


use Core\View;
use model\ProdutoApi;
use utils\Sanitizantes;
use Exception;

// Controller

class ProdutoController
{
    private $produtoApi;

    public function __construct()
    {
        $this->produtoApi = new ProdutoApi(); 
    }

    public function processarAtualizacaoAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) {
            //header('Content-Type: application/json');

       //   dd($_POST);

            // O ID do produto vem do input hidden #modalIdProduto com name="id_produto"
            $produtoId = $_POST['produto_id'] ?? null;

            // Campos do formulário do modal. As chaves de $_POST correspondem
            // aos 'name' dos inputs no modal e às chaves do formData no JS.
            $descricao = $_POST['descricao'] ?? null;
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

        
     
            if ($descricao !== null) {
                $dadosParaAtualizar['descricao'] = $descricao;
            }
            if ($codigoBarra !== null) {
                $dadosParaAtualizar['codigobarra'] = $codigoBarra;
            }
            if ($qtdMaxArmazenagem !== null) {
                $dadosParaAtualizar['qtd_max_armazenagem'] = (int)$qtdMaxArmazenagem; // Cast para int
            }
            if ($local !== null) {
                $dadosParaAtualizar['local'] = $local;
            }
            if ($local2 !== null) {
                $dadosParaAtualizar['local2'] = $local2;
            }
            if ($local3 !== null) {
                $dadosParaAtualizar['local3'] = $local3;
            }

          //  dd($dadosParaAtualizar);

            if (empty($dadosParaAtualizar)) {
                 echo json_encode(['success' => false, 'message' => 'Nenhum dado válido para atualização foi fornecido.']);
                 exit;
            }

            // Aqui, $produtoId é o valor de $produto['PRODUTO'] que foi enviado
            $resultado = $this->produtoApi->atualizarProduto($produtoId, $dadosParaAtualizar );
           
            var_dump($resultado);
            if (isset($resultado['status']) && $resultado['status']) { // Verifique se 'status' existe antes de acessá-lo
                echo json_encode(['success' => true, 'message' => $resultado['mensagem'] ?? 'Produto atualizado com sucesso!', 'data' => $resultado]);
            } else {
                http_response_code('Falha!!' . 400); // Ou 500, dependendo da natureza do erro
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
            $produtos = $this->produtoApi->buscarTodos($termo, true, 15);
        }

       
        View::render('page/teste.html.php', [ 
            'produtos' => $produtos,
            'termo' => $termo,
        ], 'Product'); 
    }
}



 $productController = new ProdutoController();
 $productController->buscar();



















































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



























