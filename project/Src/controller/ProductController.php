<?php

use Core\View;
use model\ProdutoApi;


    
    
    
        $produtoApi = new ProdutoApi;
    
    

    
        // Buscar produtos (por exemplo, 20 produtos)
        $produtos = $produtoApi->buscarProdutos('31002150', '11101010102', '7896587300721',  '7896587300946', buscaParcial: true);




        




View::render('page/home.html.php', ['produtos' => $produtos ] , js: 'teste');








