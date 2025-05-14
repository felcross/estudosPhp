<?php

namespace src\controller;

use Core\View;
use model\ProdutoApi;

// Controller

class ProdutoController
{
    private $produtoApi;

    public function __construct()
    {
        $this->produtoApi = new ProdutoApi();
    }
    public function buscar()
    {
        $termo = $_GET['termo'] ?? '';


        $produtos = [];
        if (!empty($termo)) {
            $produtos = $this->produtoApi->buscarTodos($termo, true, limite: 15);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) 
        {  
              var_dump($_POST);
           //  $produtos = $this->produtoApi->atualizarProduto($termo, true, limite: 15);
           return;
        }



        View::render('page/search2.html.php', [
            'produtos' => $produtos,
            'termo' => $termo,
            //   'buscaParcial' => $buscaParcial
        ]);
    }
}





// Instancia o controller
$productController = new ProdutoController;
$productController->buscar();




















































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



























