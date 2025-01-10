<?php
namespace Components\Widgets;

use Components\Base\Element;
use Components\Base\Field;
use Components\Base\FormElementInterface;

class Label extends Field implements FormElementInterface
{
    private $tag;
    
    /**
     * Construtor
     * @param $value text label
     */
    public function __construct($value)
    {
        // set the label's content
        $this->setValue($value);
        
        // create a new element
        $this->tag = new Element('label');
    }
    
    /**
     * Adiciona conteúdo no label
     */
    public function add($child)
    {
        $this->tag->add($child);
    }
    
    /**
     * Exibe o widget
     */
    public function show()
    {
        $this->tag->add($this->value);
        $this->tag->show();
    }
}
