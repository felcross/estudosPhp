<?php
require '../config/sessoes.php';
require '../autoLoad.php';
require '../vendor/autoload.php';
require '../functions.php';
require 'FrontController.php';

// CSRF
//utils\Tokens::geraTokenCSRF();

// Detecta AJAX
$isAjax = (
    !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
);

// Layout inicial (se não for AJAX) - removido daqui pois será controlado pela View
// A View agora controla quando incluir ou não o sidebar

$frontController = new FrontController();

// Controllers 
$frontController->addAllowedController('LoginController');


// Métodos
$frontController->addAllowedMethods('LoginController', ['login', 'logout']);

$frontController->dispatch();

// Layout final removido - será controlado pela View