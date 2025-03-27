<?php

spl_autoload_register(function ($class) {
   $path = $_SERVER['DOCUMENT_ROOT'] . '/project/src/' . $class . '.php';
   require $path;
 
   return;
});