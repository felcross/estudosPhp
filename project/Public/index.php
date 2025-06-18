<?php
require '../autoLoad.php';
require '../vendor/autoload.php';
require '../functions.php';
require_once 'SessionManager.php';
//require_once 'AuthMiddleware.php';
require_once 'FrontController.php';


try {
    // Instancia e executa o FrontController
   
    $frontController = new FrontController('config/controllers.json');
    $frontController->dispatch();
    
} catch (Exception $e) {
    error_log("Erro crítico: " . $e->getMessage());
    echo "<h3>Sistema indisponível</h3>";
}

