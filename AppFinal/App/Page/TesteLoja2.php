<?php
namespace Page;
use Controller\PageControl;
use Database\Transaction;
use Model\Cidade;
use Model\Estado;
use Exception;
use Model\Grupo;
use Model\Pessoa;

class TesteLoja2 extends PageControl  {



  public function show() {

     try{
              Transaction::open('configLoja');

              $p1 =  Pessoa::find(15);
              $grupos=  $p1->getGrupos();

               //$p1->addGrupo(new Grupo(1));
               //$p1->addGrupo(new Grupo(3));
              
               foreach($grupos as $grupo){

                  print  $grupo->nome . '<br>';
               }
            

              Transaction::close();

     }catch(Exception $e) 
     {  
         echo $e->getMessage();

     }

  }



}