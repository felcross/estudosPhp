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
    
    public function buscar() {
        $termo = $_POST['termo'] ?? '';
        $buscaParcial = isset($_POST['parcial']) ? (bool)$_POST['parcial'] : true;
        
        $produtos = [];
        if (!empty($termo)) {
            $produtos = $this->produtoApi->buscarTodos($termo, true, limite:15);
        }
        
        View::render('page/search2.html.php', [
            'produtos' => $produtos,
            'termo' => $termo,
            'buscaParcial' => $buscaParcial
        ]);
    }}

    
  
$productController = new ProdutoController;
$productController->buscar();
    



























// class ProductController
// {
//     public function search()
//     {
//         // pega termo e flag AJAX
//         $termo = $_POST['termo'] ?? '';
//        // $isAjax = !empty($_POST['ajax']);

//         // faz a busca na API
//         $produtoApi = new ProdutoApi;
//         $produtos = [];
//         if ($termo !== '') {
//             $produtos = $produtoApi->buscarTodos($termo, true, 10);
//         }

//         // if ($isAjax) {
//         //     // retorna JSON e encerra
//         //     header('Content-Type: application/json; charset=utf-8');
//         //     echo json_encode($produtos);
//         //     exit;
//         // }

//         // render normal de página
//         View::render('page/search.html.php', [
//             'produtos'    => $produtos,
//             'termo'       => $termo,
//             'buscaParcial'=> $buscaParcial ?? false
//         ], js: 'product');
//     }
// }
  
// $productController = new ProductController;
// $productController->search();








