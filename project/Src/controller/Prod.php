<?php

use Core\View;
use model\ProdutoApi;


$produtoApi = new ProdutoApi;

$termo = $_GET['termo'] ?? '';
$buscaParcial = isset($_GET['parcial']) ? (bool)$_GET['parcial'] : true;

$produtos = [];
if (!empty($termo)) {
    $produtos = $produtoApi->buscarTodos($termo,true,10);
}





View::render('page/home.html.php', [
    'produtos' => $produtos,
    'termo' => $termo,
    'buscaParcial' => $buscaParcial
], js: 'product');