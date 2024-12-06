<?php
//intercepitando o get e set acessados sem permissão da classe.
class teste {

 private $data= array();


public function getNome() {
return  $this->data;
}

public function __get($data)
{
    print 'Não tem acesso';
}

public function __set($name, $value)
{
    return  print 'Não tem acesso 2';
}
    


}


$teste = new teste;

print $teste->getNome();
$teste->__get($nome);




