<?php
namespace Page;

use Components\Panel;
use Controller\PageControl;


class  SimplePanelControl extends PageControl{

   public function __construct()
   {
       parent::__construct();

       $panel= new Panel('Título do painel');
       $panel->style = 'margin:40px';
       $panel->add('conteúdo conteúdo conteúdo conteúdo conteúdo');
       $panel->addFooter('rodapé');

       
       parent::add($panel);
      



       
   } 

/*
   public function gravar($param)
    {
        var_dump($param);
    }*/

}