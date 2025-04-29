<?php

use Core\View;
use model\ProdutoApi;


    
    
    
        $produtoApi = new ProdutoApi();
    
    

    
        // Buscar produtos (por exemplo, 20 produtos)
        $produtos = $produtoApi->getProduto(1);
        




View::render('page/home.html.php', [], js: 'teste');








