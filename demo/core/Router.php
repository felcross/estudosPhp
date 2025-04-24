<?php

namespace Core;

class Router 
{    public $routes = [];

    public function router($uri, $method)       
     {
         foreach($this->routes as $route)
         {   
             if($route['uri'] == $uri && $route['method'] == strtoupper($method)) 
             {
                // var_dump($_SERVER['DOCUMENT_ROOT'] . '/' . 'demo/' . $route['controller']);

                return require $_SERVER['DOCUMENT_ROOT'] . '/' . 'demo/' . $route['controller'];
             } else
             
             {
                http_response_code(404);
                echo 'Pagina errada!!!';
             }

         }
     }

   

     public function get($uri,$controller): void       
     {
       $this->routes[] =  
       ['uri'=> $uri,
       'controller'=> $controller,
       'method'=> 'GET'
       ];
     }

     public function post($uri,$controller)
     {
        $this->routes[] =  
        ['uri'=> $uri,
        'controller'=> $controller,
        'method'=> 'POST'
        ];

     }

     public function delete($uri,$controller)
     {
        $this->routes[] =  
        ['uri'=> $uri,
        'controller'=> $controller,
        'method'=> 'DELETE'
        ];

     }



}