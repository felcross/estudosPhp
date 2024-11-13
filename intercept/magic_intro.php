<?php
//intercepitando o get e set acessados sem permissão da classe.
class teste {

public function __get($name)
{
    print 'Não tem acesso';
}

public function __set($name, $value)
{
    return  print 'Não tem acesso 2';
}
    


}


$teste = new teste;

$teste->valor;
$teste->teste = 200;
