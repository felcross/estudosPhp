<?php

$routes = require 'routes.php';


function routeToController($uri,$routes) {
      if(array_key_exists($uri, $routes)) 
{
    require $routes[$uri];
}  else {
      http_response_code(404);
      echo 'Pagina errada';
       }

}

$uri = parse_url($_SERVER['QUERY_STRING'])['path'];


routeToController($uri,$routes);