<?php

  
$obj1 = new stdClass;
$obj1-> descricao = 'Chocolate';
$obj1-> qtd = 20 ;
$obj1-> preco = 7;

$vetor = (array) $obj1;

$vetor2 = ["descricao"=>'Café',
          "estoque"=>50,
          "preco"=>15,];

$obj2 = (object) $vetor2; 


var_dump($vetor);
var_dump($obj2)

?>