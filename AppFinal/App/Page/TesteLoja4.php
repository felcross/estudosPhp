<?php
namespace Page;
use Controller\PageControl;
use Database\Transaction;
use Model\Cidade;
use Model\Estado;
use Exception;
use Model\Produto;
use Model\Pessoa;
use Model\Venda;

class TesteLoja4 extends PageControl  {



  public function show() {

     try{
              Transaction::open('configCasa2');

             $p1 = Pessoa::find(2);

             print 'Valor: ' . $p1->totalDebitos();

             $contas = $p1->getContasEmAberto();
             
             echo '<br>';
             foreach($contas as $conta) 
             {   
                print $conta->dt_emissao . ' - ';
                print $conta->valor . '<br>';


             }

              Transaction::close();

     }catch(Exception $e) 
     {  
         echo $e->getMessage();

     }

  }



}