<?php

require_once 'autoloadApp.php';

//echo '<link rel="stylesheet" href="App/Templates/bootstrap.min.css">';

/*echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>';*/

$template = file_get_contents('Templates/index2.html');
$content = '';


$class = $_GET['class'];

if ($_GET) 
{
   echo 'estou no estagio 1';
if (class_exists($class)) {

  try{
      $page = new $class;
      ob_start();
      $page->show();
      $content= ob_get_contents();
      ob_end_clean();

  }catch(Exception $e){
    $content = $e->getMessage() . '<br>' . $e->getTraceAsString();
  }
  
} 
else 
{
  $content = "Erro: A classe {$class} não existe.";
}

$output = str_replace('{content}', $content , $template);
$output = str_replace('{class}', $class , $output);
echo $output;


}







    
  

  