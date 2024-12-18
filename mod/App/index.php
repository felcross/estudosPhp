<?php

require_once 'autoloadApp.php';



$class = $_GET['class'];

if ($_GET) 
{

if (class_exists($class)) {
  $page = new $class;
  $page->show();
} 
else 
{
  echo "Erro: A classe {$class} não existe.";
}


}





    
  

  