<?php
namespace Page;
use Controller\PageControl;
use Database\Transaction;
use Model\Cidade;
use Model\Estado;
use Exception;

class TesteLoja extends PageControl  {



  public function show() {

     try{
              Transaction::open('configLoja');

              $c1 = Cidade::find(12);
              print $c1->nome .'<br>';
              print $c1->get_estado()->nome .'<br>';

              Transaction::close();

     }catch(Exception $e) 
     {  
         echo $e->getMessage();

     }

  }



}