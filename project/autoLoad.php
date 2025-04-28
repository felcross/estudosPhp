<?php

require_once __DIR__ . "/config/base.php";

spl_autoload_register(function ($class) {
   $path = NomeSistema  . 'src/core/' .  $class . '.php';

   var_dump($path);
   require $path;

   return;
});


// spl_autoload_register(function ($class) {
//    $path = NomeSistema . 'src/controller/' . $class . '.php';
//    var_dump($path);

//    require $path;

//    return;
// });