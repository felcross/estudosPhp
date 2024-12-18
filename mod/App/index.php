<?php

require_once 'autoloadApp.php';


if ($_GET) {
    // Captura o valor do parâmetro 'class' (exemplo: Controllers\CidadeControl)
    $class = $_GET['class'];

        // Substitui as barras invertidas do namespace por barras normais
        $classPath = str_replace('\\', '/', $class) . '.php';
    
        // Caminho base do projeto (diretório atual)
        $file = __DIR__ . '\\' . 'Model' . '\\' . $classPath;
    
        // Depuração: Mostra o caminho gerado
        echo "Tentando carregar a classe: {$class} no caminho: {$file}<br>";

        if (class_exists($file)) {
          var_dump('Classe encontrada!');
        }

      }

    /*
    if (class_exists($class)) {
        var_dump('Classe encontrada!');

        // Instancia a classe
        $page = new $class;
        $page->show();
    } else {
        echo "Erro: A classe {$class} não existe.";
    }
}*/



/*
require_once 'autoloadApp.php';

if($_GET){

$class = $_GET['class'];
  var_dump($class);

  $page = new $class;
  $page->show();

  if(class_exists($class))
  {   var_dump('entrei');

    $page = new $class;
    $page->show();
    
      
  }
} */
    
  

  