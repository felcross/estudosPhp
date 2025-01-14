<?php
namespace Components\Widgets;

use Components\Base\Element;
use Components\Base\Field;
use Components\Base\FormElementInterface;

class Entry extends Field implements FormElementInterface 
{    
    protected $properties;

       public function show() 
       {
            // atribui as propriedades da TAG
        $tag = new Element('input');
        $tag->class = 'field';		  // classe CSS
        $tag->name = $this->name;     // nome da TAG
        $tag->value = $this->value;   // valor da TAG
        $tag->type = 'text';          // tipo de input
       // $tag->style = "width:{$this->size}"; // tamanho em pixels
        $tag->style = "width:{$this->size};
                       border: 2px solid #ccc;
                       border-radius: 50px;
                       padding: 12px;
                       margin: 10px 0;";
        //$tag->style = "border-radius: 50px";

           if(!parent::getEditable())
           {
               $tag->readonly = "1";
           }

           if($this->properties)
           {    foreach($this->properties as $property =>$value)
               {
                    $tag->$property = $value;
               }
            }

           $tag->show();
       }


    
}