<?php


class Funcionario
{
   public $nome;
   public $salario;  

  public function getSalario() {}

  public function setSalario() {}

  public function getNome() {}
  public function setNome() {}
}

class Estagiario extends Funcionario {
  public function bolsa(){}
}
