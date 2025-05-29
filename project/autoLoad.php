<?php

require_once __DIR__ . "/config/base.php";
require_once __DIR__ . "/config/sessoes.php";

spl_autoload_register(function ($class) {
   $path = NomeSistema  . 'src/' .  $class . '.php';
   
   require $path;

   return;
});

