<?php
namespace Components\Decorator;

use Components\Widgets\Form;
use Components\Container\Panel;
use Components\Base\Element;
use Components\Widgets\Button;


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


public function show(){
      
    $element = new Element('form');
    $element->class   = 'form-horizontal';
    $element->enctype = 'multipart/form-data';
    $element->method  = 'post';
    $element->name    = $this->decorated->getName();
    $element->width   = '50px';
    
    foreach ($this->decorated->getField() as $field)
    {
        $group = new Element('div');
        $group->class = 'form-group';
        
        $label = new Element('div');
        $label->class = 'col-sm-2 control-label';
        $label->add($field->getLabel() );
        
        $col = new Element('div');
        $col->class = 'col-sm-10';
        $col->add( $field );
        $field->class = 'form-control';
        
      //  $group->add($label);
        $group->add($col);
        $element->add($group);
    }
    
    $footer = new Element('div');
    $i = 0;
    foreach ($this->decorated->getAction() as $label => $action)
    {
        $name   = strtolower(str_replace(' ', '_', $label));
        $button = new Button($name);
        $button->setFormName($this->decorated->getName());
        $button->setAction($action, $label);
        $button->class = 'btn ' . ( ($i==0) ? 'btn-success' : 'btn-default');
        
        $footer->add($button);
        $i ++;
    }
    
    $panel = new Panel( $this->decorated->getTitle() );
    $panel->add( $element );
    $panel->addFooter( $footer );
    $panel->show();


}

}