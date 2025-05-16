<?php

namespace src\controller;


use Core\View;
use model\ProdutoApi;


// Controller

class ProdutoController {
    private $produtoApi;
    
    public function __construct() {
        $this->produtoApi = new ProdutoApi();
    }
    
     
     // Fix your controller code:

public function buscar()
{
    // Handle AJAX request first
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) {
        // Process the AJAX update request
        $produtoId = $_POST['produto_id'] ?? null;
        $codigo = $_POST['codigo_produto'] ?? null;
        $descricao = $_POST['descricao'] ?? null;
        $referencia = $_POST['referencia'] ?? null;
        $referencia2 = $_POST['referencia2'] ?? null;
        $codigoBarra = $_POST['codigobarra'] ?? null;
        $preco = $_POST['preco'] ?? null;
       
        if ($produtoId) {
            $resultado = $this->produtoApi->atualizarProduto($produtoId, [
                'codigo' => $codigo,
                'descricao' => $descricao,
                'referencia' => $referencia,
                'referencia2' => $referencia2,
                'codigobarra' => $codigoBarra,
                'preco' => $preco
            ]);
           
            // Return JSON response and exit to prevent rendering the HTML
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso']);
            exit; // Important! This prevents the rest of the page from loading
        } else {
            // Return error response
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'ID do produto não fornecido']);
            exit;
        }
    }

    // Normal page load flow continues here
    $termo = $_GET['termo'] ?? '';
    $produtos = [];
    
    if (!empty($termo)) {
        $produtos = $this->produtoApi->buscarTodos($termo, true, limite: 15);
    }

    View::render('page/search2.html.php', [
        'produtos' => $produtos,
        'termo' => $termo,
    ],js:'product');
}
   



}

    
$productController = new ProdutoController;
$productController->buscar();
    
    








// function atualizar(ProdutoApi $produtoApi) {

//         // Verificar se é uma requisição PUT (enviada via POST com flag PUT)
//     if (isset($_POST['PUT'])) {

//         // Remover a flag PUT do array de dados
//         $dadosProduto = $_POST;
//         unset($dadosProduto['PUT']);
        
//         // Tratar os dados recebidos
//         $produtoId = $dadosProduto['modalProdutoId'] ?? null;
//         $codigo = $dadosProduto['modalCodigo'] ?? null;
//         $descricao = $dadosProduto['modalDescricao'] ?? null;
//         $referencia = $dadosProduto['modalReferencia'] ?? null;
//         $referencia2 = $dadosProduto['modalReferencia2'] ?? null;
//         $codigoBarra = $dadosProduto['modalCodigoBarras'] ?? null;
//         $preco = $dadosProduto['modalPreco'] ?? null;
        
//         // Agora você pode atualizar o produto usando sua API
//         if ($produtoId) {
//             $resultado = $produtoApi->atualizarProduto($produtoId, [
//                 'codigo' => $codigo,
//                 'descricao' => $descricao,
//                 'referencia' => $referencia,
//                 'referencia2' => $referencia2,
//                 'codigobarra' => $codigoBarra,
//                 'preco' => $preco
//             ]);
            
//             // Retornar resposta como JSON para o cliente
//             header('Content-Type: application/json');
//             echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso']);
//             return;
//         }   
//     }}
    
















































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



























