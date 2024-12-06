<?php 

require_once './Orcamento.php';
require_once './Produto.php';
require_once './Service.php';
require_once './OInterface.php';


$orc = new Orcamento;
$orc->add(new Produto('Barra de chocolate', 10 , 22),1);
$orc->add(new Produto('TV', 8 , 590),2);


$orc->add(new Service('Conserto de TV', 290),1);

print $orc->calculaTotal();  


?>