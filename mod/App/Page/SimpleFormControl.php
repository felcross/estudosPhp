<?php
namespace Page;

use Components\SimpleForm;
use Controller\PageControl;

class SimpleFormControl extends PageControl{

   public function __construct()
   {
       //parent::__construct();

       $form = new SimpleForm('my_form');
       $form->setTitle('Título');
       $form->addField('Nome','Name','Text','Maria','form-control');
       $form->addField('Telefone','telefone','Text','999999','form-control');
       $form->setAction('index.php?class=\page\SimpleFormControl&method=gravar');
       $form->show();

       
   } 


   public function gravar($param)
    {
        var_dump($param);
    }

}