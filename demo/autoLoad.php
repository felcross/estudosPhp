<?php

spl_autoload_register(function ($class) {
   $path = $_SERVER['DOCUMENT_ROOT'] . '//demo/' . $class . '.php';
   require $path;
 
   return;
});