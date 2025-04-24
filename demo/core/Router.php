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
               return require $_SERVER['DOCUMENT_ROOT'] . '/' . 'demo/' . $route['controller'];
           }
       }
       
       // Se chegou aqui, significa que nenhuma rota foi encontrada
       http_response_code(404);
       echo 'Página não encontrada!';
   }


     public function add($method,$uri,$controller): void       
     {
      $this->routes[] = compact('method','uri','controller');
     }


   

     public function get($uri,$controller): void       
     {
       $this->add('GET',$uri,$controller );
     }

     public function post($uri,$controller)
     {
      $this->add('POST',$uri,$controller );

     }

     public function delete($uri,$controller)
     {
      $this->add('DELETE',$uri,$controller );

     }



}