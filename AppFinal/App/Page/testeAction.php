<?php
namespace Page;

use Components\Base\Element;
use Controller\Action;
use Controller\PageControl;

class testeAction extends PageControl{


     public function __construct()
     {  
         parent::__construct();
     //Criando elemento html
          $button = new Element('a');
          $button->add('Ação');
          $button->class = 'btn btn-success';
         

        // ação string 
          $action = new Action([$this,'action']);
          $action->setParameter('codigo',4);
          $action->setParameter('nome','fel');
          $action->setParameter('idade','37');
        //transformando em Url com serialize()
          $button->href =  $action->serialize();

          parent::add($button);

     }

  public function action($param) 
  {
     var_dump($param);
  }


}