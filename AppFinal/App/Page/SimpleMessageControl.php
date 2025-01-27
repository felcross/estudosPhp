<?php
namespace Page;

use Components\Container\Panel;
use Components\Dialog\Message;
use Controller\PageControl;
use Components\Widgets\SimpleForm;


class  SimpleMessageControl extends PageControl{

   public function __construct()
   {
       parent::__construct();

         new Message('info', 'Teste de info');

         new Message('error', 'Teste de error');
       
   } 

/*
   public function gravar($param)
    {
        var_dump($param);
    }*/

}