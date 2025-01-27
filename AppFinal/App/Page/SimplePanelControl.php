<?php
namespace Page;

use Components\Container\Panel;
use Controller\PageControl;
use Components\Widgets\SimpleForm;


class  SimplePanelControl extends PageControl{

   public function __construct()
   {
       parent::__construct();

       $panel= new Panel('Título do painel');
       $panel->style = 'margin:40px';
       //$panel->add('conteúdo conteúdo conteúdo conteúdo conteúdo');
      // $panel->addFooter('rodapé');

       $form = new SimpleForm('my_form');
       $form->setTitle('Meu formulário');
       $form->addField('Nome','Name','Text','Maria','form-control');
       $form->addField('Telefone','telefone','Text','999999','form-control');
       $form->addField('Endereço','end','Text','Rua xxx','form-control');
       $form->setAction('index.php?class=\page\SimpleFormControl&method=gravar');
       $panel->add($form);

       
       parent::add($panel);
      



       
   } 

/*
   public function gravar($param)
    {
        var_dump($param);
    }*/

}