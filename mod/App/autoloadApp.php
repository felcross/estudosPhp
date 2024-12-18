<?php

spl_autoload_register(function($class){
    include_once './Config/Config.php';
    if(file_exists($class . '.php')) 
    {require_once $class . '.php';}
 });

/*
spl_autoload_register(function($class) {
    // Substitui as barras invertidas do namespace por barras normais
    $classPath = str_replace('\\', '/', $class) . '.php';
    
    // Caminho base do projeto (diretório atual)
    $file = __DIR__ . '\\' . $classPath;

    // Depuração: Mostra o caminho gerado
    echo "Tentando carregar a classe: {$class} no caminho: {$file}<br>";

    // Verifica se o arquivo existe e inclui
    if (file_exists($file)) {
        require_once $file;
    } else {
        echo "Erro: Não foi possível carregar a classe {$class} no caminho {$file}.";
    }
});*/





/*
spl_autoload_register(function($class) {
   // Caminho base do projeto (ajuste conforme necessário)
   $baseDir = __DIR__ . '\\' . 'Model' . '\\'; // Usa o diretório atual como base

   var_dump($baseDir . 'basedir');
   echo '<br>';
   // Substitui as barras invertidas do namespace por barras de diretório
   $classPath =  $class . '.php';
   
   // Caminho completo para o arquivo
   $file = $baseDir . $classPath;

   var_dump($file . 'FILE');
   echo '<br>';

   // Verifica se o arquivo existe e o inclui
   if (file_exists($file)) {
       require_once $file;
   } else {
       echo "Autoload: Não foi possível carregar a classe {$class} em {$file}.";
   }
});*/

