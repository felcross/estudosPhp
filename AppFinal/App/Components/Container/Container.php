<?php
namespace Components\Container;

use Components\Base\Element;



class Container extends Element {
    
    private $body;
    private $footer;

    public function __construct($panel_title = null)
    {  
        parent::__construct('div');
        $this->class ='container-fluid';
        $this->style = 'background-color:;
                        margin:50px;
                        padding-left:20%';

        if($panel_title){
            $head = new Element('div');
            $head->class = '';

           // $title = new Element('div');
           // $title->class = 'panel-title';

            $label = new Element('h4');
            $label->class = '';
            $label->add($panel_title);

            $head->add($label);
           // $title->add($label);

            parent::add($head);
        }

        $this->body = new Element('body');
        $this->body->class = 'mb-3';
      //  $this->body->style = 'margin: 50px';
        parent::add($this->body);
        $this->footer = new Element('div');
        $this->footer->class = 'mb-3';


    }


    public function add($content) {

        $this->body->add($content);
    }

    public function addFooter($footer) {

        $this->footer->add($footer);
        parent::add($this->footer);
    }
}