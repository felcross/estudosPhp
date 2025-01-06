<?php
namespace Decorator;

use Components\Widgets\Form;

class FormWrapper {

private $decorated;

public function __construct(Form $form) 
{
    $this->decorated =$form;
}

// Quando o metodo que não existe é chamado nessa classe ele cai no _call que vai redirecionar ele para $this->decorated como a classe passada 
//pro FormWrapper  e chamando nessa classe o metodo informado.
public function __call($method, $parameters)
{
    call_user_func_array([$this->decorated, $method],$parameters);
}


public function show(){}

}