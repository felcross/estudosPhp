<?php
// Imports necessários
require '../config/sessoes.php';
require '../autoLoad.php';
require '../vendor/autoload.php';
require '../functions.php';
require 'FrontController.php'; // Nossa classe de segurança
//require 'PageControl.php'; // Classe base segura dos controllers

// CSRF
utils\Tokens::geraTokenCSRF();

// Detecta AJAX
$isAjax = (
    !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
);

// Layout inicial (se não for AJAX)
if (!$isAjax) {
    include __DIR__ . '/Layout/header.php';
}

// Cria e configura o FrontController
$frontController = new FrontController();

// Configurações adicionais (se necessário)
// $frontController->addAllowedController('CustomController');
// $frontController->addAllowedMethods('ProductController', ['novoMetodo', 'outroMetodo']);

// Executa a requisição (que vai chamar $page->show() internamente)
$frontController->dispatch();

// Layout final (se não for AJAX)
if (!$isAjax) {
    include __DIR__ . '/Layout/footer.php';
}














































// // CSRF
// utils\Tokens::geraTokenCSRF();

// // sei se veio AJAX (jQuery define esse header)
// $isAjax = (
//     !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
//     && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
// );

// // só imprime o layout se **não** for AJAX
// if (! $isAjax) {
//     include __DIR__ . '/Layout/header.php';  // seu head/html inicial
// }

//      $class = $_GET['class'];

    

//         $c = '\\controller\\' . $class;

//       $page = new $c;

//       $page->show();

   


 

    
// // fecha a página se não for AJAX
// if (! $isAjax) {
//     include __DIR__ . '/Layout/footer.php';
// }
