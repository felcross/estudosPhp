<?php
namespace Components\Widgets;


class SimpleForm {

    private $name,$action,$fields,$title; 

    public function __construct($name)
    {
        $this->name = $name;
        $this->fields = [];
        $this->title = '';
    }

    public function setTitle($title) {
         $this->title = $title;
    }

    public function addField($label,$name,$type,$value, $class ='') 
    {
        $this->fields[] = ['label' => $label ,
                           'name' =>  $name , 
                           'type' => $type, 
                           'value' =>  $value,
                           'class' =>  $class]; 


    }

    public function setAction($action) 
    {
         $this->action = $action;

    }

    public function show() {

          echo "<div class='panel panel-default' style ='margin: 40px;'> \n";
          echo "<div class='panel-heading'> {$this->title} </div> \n";
          echo "<div class='panel-body'>\n";
          echo "<form method='POST' action={$this->action} class='form-horizontal'>\n";
            if($this->fields) 
            {  
                 foreach($this->fields as $field) 
                 {
                    echo "<div class='form-group'> \n";
                     echo "<label class='col-sm-2 control-label'>{$field['label']} </label> \n";
                     echo "<div class='col-sm-10'> \n";
                     echo  "<input type='{$field['type']}' name='{$field['name']}' value='{$field['value']}'  class='{$field['class']}' \n";
                     echo "</div> \n";
                     echo "</div> \n";
                 }

            }

            echo  "<div class='col py-2 px-sm-3 '>";
            echo  "<button class='btn btn-success ' type='submit' value='Enviar' >Button</button> \n";
         //   echo  "<button class='btn btn-primary' type='button'>Button</button>"
  
            echo "</div> \n";




          echo "</form> \n";
          echo "</div> \n";
          echo "</div> \n";

    }
    
}