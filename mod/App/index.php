<?php
require_once 'autoloadApp.php';
if($_GET){

$class = $_GET['class'];

  if(class_exists($class))
  {   
    $page = new $class;
    $page->show();
      
  }}