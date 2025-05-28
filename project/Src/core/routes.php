<?php 



   // $router->get('home', './src/controller/ProductController.php');
   // $router->post('home', './src/controller/ProductController.php');


   // $router->get('', './src/controller/Prod.php');
   // $router->post('', './src/controller/Prod.php');


// Criando o roteador

use src\controller\ProdutoController;



// Registrando rotas
$router->get('/produtos', [ProdutoController::class, 'buscar']);
$router->post('/produtos', [ProdutoController::class, 'buscar']);




// Este arquivo só REGISTRA as rotas, não executa nada!

// $router já foi criado no index.php, então usamos ele aqui

// Rota para página inicial
//$router->get('/', [HomeController::class, 'index']);

// Rota para buscar produtos (sua rota atual)
//$router->get('/produtos/buscar', [ProdutoController::class, 'buscar']);

// Outras rotas
//$router->get('/produtos', [ProdutoController::class, 'listar']);
//$router->post('/produtos', [ProdutoController::class, 'criar']);
//$router->get('/sobre', [AboutController::class, 'mostrar']);




