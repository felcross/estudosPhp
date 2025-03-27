<?php
//intercepitando o get e set acessados sem permissão da classe.
class Titulo {

private $data;
public function __get($propriedade)
{
    return print $this->data[$propriedade];
}

public function __set($propriedade, $value)
{
    $this->data[$propriedade] = $value ;
}
    //ESSA FUNÇÃO TORNA POSSIVEL FAZER ISSO E RETORNAR SE EXISTE.
public function __isset($propriedade)
{
    return isset($this->data[$propriedade]);
}

    //ESSA FUNÇÃO TORNA POSSIVEL DESTRUIR O OBJ CRIADO
    public function __unset($propriedade)
    {
        unset($this->data[$propriedade]);
    }

}


$teste = new Titulo;

$teste->produto = 'geladeira';
$teste->valor = 200;


if(isset($teste->valor)){
   print 'tem valor';
}
echo '<pre>';
var_dump($teste);

unset($teste->valor);

echo '<pre>';
var_dump($teste);
