<?php
spl_autoload_register(function($class){
    include_once './Config/Config.php';
    if(file_exists($class . '.php')) 
    {require_once $class . '.php';}
 });


