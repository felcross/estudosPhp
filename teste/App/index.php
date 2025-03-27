<?php

require_once 'autoloadApp.php';

//echo '<link rel="stylesheet" href="App/Templates/bootstrap.min.css">';

echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>';


$class = $_GET['class'];

if ($_GET) 
{
   echo 'estou no estagio 1';
if (class_exists($class)) {
  $page = new $class;
  $page->show();
} 
else 
{
  echo "Erro: A classe {$class} não existe.";
}


}







    
  

  