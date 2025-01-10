<?php
namespace Components\Widgets;


use Controller\ActionInterface;

use Components\Base\FormElementInterface;
use stdClass;

class Form {

    protected $title;
    protected $name;
    protected $fields;
    protected $actions;  

    public function __construct($name = '')
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
     public function addField($label,FormElementInterface $object, $size =''){
      
      $object->setName($label);
      $object->setValue($size);
    
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
     

     /**
     * Retorna os dados do formulário em forma de objeto
     */
    public function getData($class = 'stdClass')
    {
        $object = new $class;
        
        foreach ($this->fields as $key => $fieldObject)
        {
            $val = isset($_POST[$key]) ? $_POST[$key] : '';
            $object->$key = $val;
        }
        // percorre os arquivos de upload
        foreach ($_FILES as $key => $content)
        {
            $object->$key = $content['tmp_name'];
        }
        return $object;
    }
     


}