<?php

require_once __DIR__ . "/config/base.php";

spl_autoload_register(function ($class) {
   $path = $_SERVER['DOCUMENT_ROOT'] . '/project/src/controller/' . $class . '.php';
   require $path;

   return;
});