<?php
namespace Page;

use Components\Container\Hbox;
use Components\Container\Panel;
use Controller\PageControl;
use Components\SimpleForm;


class  SimpleboxControl extends PageControl{

   public function __construct()
   {
       parent::__construct();

       $panel= new Panel('Card1');
       $panel->style = 'margin:10px';
       $panel->add('Card1');

       $panel2= new Panel('Card2');
       $panel2->style = 'margin:10px';
       $panel2->add('Card2');

       $box = new Hbox();
       $box->add($panel);
       $box->add($panel2);
       
       
       parent::add($box);
      



       
   } 

/*
   public function gravar($param)
    {
        var_dump($param);
    }*/

}