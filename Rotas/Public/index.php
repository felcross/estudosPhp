<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);


require "../vendor/autoload.php";
require "../App/Routes/routes.php";




try {
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    $request = $_SERVER['REQUEST_METHOD'];

    var_dump('uri' .$uri . PHP_EOL . 'request' . $request);
   
    
    if (!isset($router[$request])) {
      throw new Exception("A routa não existe");
    }

    if (!array_key_exists($uri, $router[$request])) {
      throw new Exception("A routa não existe");
    }

    $controller = $router[$request][$uri];
    $controller();

  } catch (Exception $e) {
    $e->getMessage();
  }

?>