<?php
namespace Components\Container;

use Components\Element;


class Hbox extends Element {
    
    private $body;
    private $footer;

    public function __construct()
    {  
        parent::__construct('div');
   }


    public function add($child) {

        $wrapper = new Element('div');
        $wrapper->style = 'display:inline-block';
        $wrapper->add($child);
        parent::add($wrapper);
          
        return $wrapper;
    }

   
}