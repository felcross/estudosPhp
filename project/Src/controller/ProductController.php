<?php

use Core\View;
use model\ProdutoApi;



// Controller
$produtoApi = new ProdutoApi;

$termo = $_POST['termo'] ?? '';



$produtos = [];
if (!empty($termo)) {

    dd($termo);
    $produtos = $produtoApi->buscarTodos($termo, $buscaParcial, 10);
}








// Para requisições normais, renderiza a view completa
View::render('page/search.html.php', [
    'produtos' => $produtos,
    'termo' => $termo,
    'buscaParcial' => $buscaParcial
], js: 'product');





// $produtoApi = new ProdutoApi;

// $termo = $_GET['termo'] ?? '';
// $buscaParcial = isset($_GET['parcial']) ? (bool)$_GET['parcial'] : true;

// $produtos = [];
// if (!empty($termo)) {
//     $produtos = $produtoApi->buscarTodos($termo,true,10);
// }





// View::render('page/search.html.php', [
//     'produtos' => $produtos,
//     'termo' => $termo,
//     'buscaParcial' => $buscaParcial
// ], js: 'product');

    // if ($category) {
    //     $filteredProducts = array_filter($filteredProducts, function ($product) use ($category) {
    //         return $product['category'] === $category;
    //     });
    // }










