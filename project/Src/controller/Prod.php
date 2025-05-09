<?php

use Core\View;
use model\ProdutoApi;


$produtoApi = new ProdutoApi;

$termo = $_GET['termo'] ?? '';
$buscaParcial = isset($_GET['parcial']) ? (bool)$_GET['parcial'] : true;

$produtos = [];


if (empty($termo)) {
    $produtos = $produtoApi->buscarTodos('A14',true,10);
}


//dd($termo);


View::render('page/search2.html.php', [
    'produtos' => $produtos,
    'termo' => $termo,
    'buscaParcial' => $buscaParcial
], js: 'product');