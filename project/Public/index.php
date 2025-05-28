<?php
//ini_set('display_errors',1);
//  ini_set('display_startup_erros',1);
//  error_reporting(E_ALL);
require '../config/sessoes.php';
require '../autoLoad.php';
require '../vendor/autoload.php';
require '../src/core/routers/Router.php';  // A classe Router que criamos
require '../src/core/View.php';
require '../functions.php';

use Routers\Router;

// CSRF
\utils\Tokens::geraTokenCSRF();

// Verifica se é AJAX
$isAjax = (
    !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
);

// Layout (se não for AJAX)
if (!$isAjax) {
    include __DIR__ . '/Layout/header.php';
}



// 1. Cria o roteador
$router = new Router;

// 2. Inclui o arquivo que DEFINE as rotas
require '../src/core/routes.php';  // ← Este arquivo só REGISTRA as rotas

// 3. Descobre qual URL o usuário acessou
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

var_dump($currentPath);

// 4. Executa a rota correspondente
try {
    $router->dispatch($currentPath);  // ← AQUI que o executeController é chamado automaticamente
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

// Layout (se não for AJAX)
if (!$isAjax) {
    include __DIR__ . '/Layout/footer.php';
}










// require '../config/sessoes.php';
// require '../autoLoad.php';
// require '../vendor/autoload.php';
// require '../src/core/Router.php';
// require '../src/core/View.php';
// require '../functions.php';

// // CSRF
// \utils\Tokens::geraTokenCSRF();

// // sei se veio AJAX (jQuery define esse header)
// $isAjax = (
//     !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
//     && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
// );

// // só imprime o layout se **não** for AJAX
// if (! $isAjax) {
//     include __DIR__ . '/Layout/header.php';  // seu head/html inicial
// }

// // roda a rota (isso pode imprimir JSON, View::render, etc)
// new Core\routers\Router;
// $uri    = $_GET['uri'] ?? '';
// $method = $_SERVER['REQUEST_METHOD'];
// require '../src/core/routes.php';
// //$router->add($uri, $method);

// // fecha a página se não for AJAX
// if (! $isAjax) {
//     include __DIR__ . '/Layout/footer.php';
// }
