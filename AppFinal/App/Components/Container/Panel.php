<?php
namespace Components\Container;

use Components\Base\Element;



class Panel extends Element {
    
    private $body;
    private $footer;

    public function __construct($panel_title = null)
    {  
        parent::__construct('div');
        $this->class ='container-fluid';

        if($panel_title){
            $head = new Element('div');
            $head->class = '';

           // $title = new Element('div');
            //$title->class = 'panel-title';

            $label = new Element('h4');
            $label->class = '';
            $label->add($panel_title);

            $head->add($label);
           // $title->add($label);

            parent::add($head);
        }

        $this->body = new Element('div');
        $this->body->class = 'mb-3';
        parent::add($this->body);
        $this->footer = new Element('div');
        $this->footer->class = 'card-footer';

    }


    public function add($content) {

        $this->body->add($content);
    }

    public function addFooter($footer) {

        $this->footer->add($footer);
        parent::add($this->footer);
    }
}