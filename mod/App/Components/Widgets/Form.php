<?php
namespace Components\Widgets;


class Form {

    protected $title;
    protected $name;
    protected $fields = [];
    protected $actions= [];  

    public function __construct($name = 'my_form')
    {
         $this->setName($name);
    }

     public function setName($name){
        $this->name = $name;
     }
     public function getName(){

        return $this->name;
     }
     public function setTitle($title){
        $this->title = $title;
     }
     public function getTitle(){
        return $this->title;
     }
     public function addField(){}
     public function getField(){}
     public function addAction(){}
     public function getAction(){}
     public function setData(){}
     public function getData(){}
     


}