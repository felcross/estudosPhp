<?php
namespace Page;

use Components\Dialog\Question;
use Controller\Action;
use Controller\PageControl;



class  SimpleQuestionControl extends PageControl{

   public function __construct()
   {
       parent::__construct();

       $action1= new Action([$this,'onYes']);
       $action2= new Action([$this,'onNot']);

       new Question('Você deseja confirmar?', $action1,$action2);

       
   } 


   public function onYes()
    {
        print 'Confirmado';
    }

    public function onNot()
    {
        print 'Não Confirmado';
    }

}