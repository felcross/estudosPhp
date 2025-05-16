

<?php
require '../config/sessoes.php';
require '../autoLoad.php';
require '../vendor/autoload.php';
require '../src/core/Router.php';
require '../src/core/View.php';
require '../functions.php';

// CSRF
\utils\Tokens::geraTokenCSRF();

// sei se veio AJAX (jQuery define esse header)
$isAjax = (
    !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
);

// só imprime o layout se **não** for AJAX
if (! $isAjax) {
    include __DIR__ . '/Layout/header.php';  // seu head/html inicial
}

// roda a rota (isso pode imprimir JSON, View::render, etc)
$router = new Core\Router;
$uri    = $_GET['uri'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
require '../src/core/routes.php';
$router->router($uri, $method);

// fecha a página se não for AJAX
if (! $isAjax) {
    include __DIR__ . '/Layout/footer.php';
}
