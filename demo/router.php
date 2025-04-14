<?php

$uri = $_SERVER['QUERY_STRING'];

$routes = [

      ''=> 'controllers/home.php',
      'contac'=> 'controllers/contact.php',
      'about'=> 'controllers/about.php',
];


function routeToController($uri,$routes) {
      if(array_key_exists($uri, $routes)) 
{
    require $routes[$uri];
}  else {
      http_response_code(404);
      echo 'Pagina errada';
       }

}


routeToController($uri,$routes);