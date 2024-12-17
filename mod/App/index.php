<?php
require_once 'autoloadApp.php';


use Model\CidadeControl;

$obj = new CidadeControl;
$obj->Ola();


/*

if($_GET){

$class = $_GET['class'];

$page = new $class;
$page->show();

//var_dump($class);



 /* if(class_exists($class))
  {   var_dump('entrei');

    $page = new $class;
    $page->show();
    
      
  }*/
    
  

  