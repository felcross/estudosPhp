<?php

/*spl_autoload_register(function ($class) {
   var_dump($class . '*classes');
 $var = function ($i) use($class) {
    $url = explode('\\', $class);
    return $url[$i] . DIRECTORY_SEPARATOR;
 };

 $end = __DIR__ . DIRECTORY_SEPARATOR . $var(0) . $var(1) . $var(2) . '.php';
 //$end = substr($end,0 , -1);
 $end = str_replace('\\.', '.', $end);
 var_dump($end . '*endereço');
 

 require $end;

});*/

spl_autoload_register(function($class){
   include_once './Config/Config.php';
   if(file_exists($class . '.php'))
   {require_once $class . '.php';}
});

