<?php
namespace Page;

use Components\Nav;
use Components\SimpleForm;
use Controller\PageControl;

class SimpleFormControl extends PageControl{

   public function __construct()
   {
       //parent::__construct();
        $nav = new Nav('my_nav');
        $nav->setTitle('opção 1');
     
        $nav->show();


       $form = new SimpleForm('my_form');
       $form->setTitle('Meu formulário');
       $form->addField('Nome','Name','Text','Maria','form-control');
       $form->addField('Telefone','telefone','Text','999999','form-control');
       $form->addField('Endereço','end','Text','Rua xxx','form-control');
       $form->setAction('index.php?class=\page\SimpleFormControl&method=gravar');
       $form->show();


       
   } 


   public function gravar($param)
    {
        var_dump($param);
    }

}