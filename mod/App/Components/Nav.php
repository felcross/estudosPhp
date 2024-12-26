<?php
namespace Components;


class Nav {

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

         echo "<nav class='navbar navbar-expand-lg bg-body-tertiary'>
  <div class='container-fluid'>
    <a class='navbar-brand' href='#'>EmsoftTest</a>
    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
      <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarNav'>
      <ul class='navbar-nav'>
        <li class='nav-item'>
          <a class='nav-link active' aria-current='page' href='#'>{$this->title}</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link' href='#'>Features</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link' href='#'>Pricing</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link disabled' aria-disabled='true'>Disabled</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
";

    }
    
}