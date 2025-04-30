<?php

use Core\View;
use model\ProdutoApi;


    
    
    
        $produtoApi = new ProdutoApi;
    
    

    
        // Buscar produtos (por exemplo, 20 produtos)
        $produtos = $produtoApi->buscarProdutos('A12', false);

        dd($produtos);

     
        




View::render('page/home.html.php', ['produtos' => $produtos ] , js: 'teste');








