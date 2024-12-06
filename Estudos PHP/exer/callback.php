<?php
 function apresenta($nome){
    print "Meu nome é $nome";
 }

 $funcao = 'apresenta';
 call_user_func($funcao,'Felipe');
echo '<br>';
 class Pessoa{

    public static function apresenta($nome)
    { print "Meu nome é $nome"; }
 }

 //Pessoa::apresenta('Flipe');
 $classe = 'Pessoa';
 $metodo ='apresenta';
 call_user_func([$classe,$metodo],'Flipe');