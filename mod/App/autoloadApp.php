<?php

spl_autoload_register(function($class) {
   // Caminho base do projeto (ajuste conforme necessário)
   $baseDir = __DIR__ . '\\'; // Usa o diretório atual como base
   
   // Substitui as barras invertidas do namespace por barras de diretório
   $classPath = str_replace('\\', '/', $class) . '.php';
   
   // Caminho completo para o arquivo
   $file = $baseDir . $classPath;



   // Verifica se o arquivo existe e o inclui
   if (file_exists($file)) {
       require_once $file;
   } else {
       echo "Autoload: Não foi possível carregar a classe {$class} em {$file}.";
   }
});







/*
spl_autoload_register(function($class){
   include_once './Config/Config.php';
   if(file_exists($class . '.php')) 
   {require_once $class . '.php';}
});*/

