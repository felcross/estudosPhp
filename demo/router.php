<?php

$uri = parse_url($_SERVER['QUERY_STRING'])['path'];




$routes = [

      ''=> 'controllers/home.php',
      'contac'=> 'controllers/contact.php',
      'about'=> 'controllers/about.php',
      'notes'=> 'controllers/notes.php',
      'note'=> 'controllers/note.php',
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