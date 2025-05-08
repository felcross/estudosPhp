<?php


// use Core\View;
// use model\ProdutoApi;



   
//     $termo = $_POST['termo'] ?? '';
    

//     $produtoApi = new  ProdutoApi;
    
 
//     $produtos = [];
//     if (!empty($termo)) {
//         $produtos = $produtoApi->buscarTodos($termo, true, 10);
//     }
    
// View::render('page/search.html.php', [
//     'produtos' => $produtos,
//     'termo' => $termo,
//     'buscaParcial' => $buscaParcial
// ], js: 'product');


namespace src\controller;

use Core\View;
use model\ProdutoApi;

class ProductController
{
    public function search()
    {
        // pega termo e flag AJAX
        $termo = $_POST['termo'] ?? '';
        $isAjax = !empty($_POST['ajax']);

        // faz a busca na API
        $produtoApi = new ProdutoApi;
        $produtos = [];
        if ($termo !== '') {
            $produtos = $produtoApi->buscarTodos($termo, true, 10);
        }

        if ($isAjax) {
            // retorna JSON e encerra
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($produtos);
            exit;
        }

        // render normal de página
        View::render('page/search.html.php', [
            'produtos'    => $produtos,
            'termo'       => $termo,
            'buscaParcial'=> $buscaParcial ?? false
        ], js: 'product');
    }
}







