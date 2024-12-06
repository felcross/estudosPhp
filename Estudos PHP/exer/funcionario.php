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

print  'mostra os metodos da class' . '<br>';
echo '<pre>';
print_r(get_class_methods('Funcionario'));
echo '</pre>';

$f1 = new Funcionario;
$f1->nome = 'Pasquin';
$f1->salario = 200;
print  'mostra os valores publicos do obj' . '<br>';
echo '<pre>';
print_r(get_object_vars($f1));
echo '</pre>';
$e1 = new Estagiario;
print  'mostra a classe do OBJ' . '<br>';
echo '<pre>';
print get_class($f1) . '<br>';
print get_class($e1) . '<br>';
echo '</pre>';
print  'mostra a classe mãe' . '<br>';
echo '<pre>';
print get_parent_class($e1) . '<br>';
print get_parent_class('Estagiario') . '<br>';
echo '<pre>';
print  'mostra se o metodo existe no objeto' . '<br>';
if (method_exists($f1, 'setNome'))
print 'tem o metodo';