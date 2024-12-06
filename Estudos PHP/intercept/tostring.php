<?php
//intercepitando o get e set acessados sem permissão da classe.
class tostring {
    
    private $valor;
    private $vencimento; 
public function __construct($valor,$vencimento)
{
    $this->valor = $valor;
    $this->vencimento = $vencimento;
}

public function __toString()
{
    return "valor :$this->valor, vencimento : $this->vencimento ";
}


}


$teste = new tostring(100,'2024-06-11');

print "titulo: ". $teste;