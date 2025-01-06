<?php
namespace Components\Widgets;

use Base\FormElementInterface;
use Controller\ActionInterface;
use stdClass;

class Form {

    protected $title;
    protected $name;
    protected $fields;
    protected $actions;  

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
     public function addField($label,FormElementInterface $object, $size ='100%'){
     
      $object->setValue($size);
      $object->setName($label);
      $this->fields[$object->getName()] = $object;

     }

     public function getField(){
      return $this->fields;
     }

     public function addAction($label,ActionInterface $action){
       $this->actions[$label] = $action;
     }
     public function getAction(){
      return $this->actions;
     }

     public function setData($object){
      
         foreach($this->fields as $name => $field)
         {
            if($name and isset($object->$name))
            {
               $field->setValue($object->$name);
            }
         }
     }
     public function getData($type = 'stdClass'){
       
       $object = new $type;
      foreach($this->fields as $name => $field)
      {
        $value = isset($_POST[$name]) ? isset($_POST[$name]) : '';
        $object->$name = $value;
      }

      return $object;

     }
     


}