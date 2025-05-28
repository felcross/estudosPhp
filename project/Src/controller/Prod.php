<?php

namespace src\controller;

use Core\View;
use model\ProdutoApi;
use model\ProdutoApi2;


// Controller

class Prod
{
    private $produtoApi;

    public function __construct()
    {
        $this->produtoApi = new ProdutoApi2();
    }
    
    public function buscar()
    {
        $termo = $_GET['termo'] ?? '';
        $pagina = max(0, intval($_GET['pagina'] ?? 0));
        
        $produtos = [];
        if (!empty($termo)) {
            $produtos = $this->produtoApi->buscarProdutosPaginado($termo, $termo, $termo, $termo, true, 15, $pagina);
        }
    

         View::render('page/home.html.php', [
            'produtos' => $produtos,
            'termo' => $termo,
             'pagina' => $pagina
        ], 'Product');
    }
}

// Instancia o controller
$productController = new Prod;
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



























