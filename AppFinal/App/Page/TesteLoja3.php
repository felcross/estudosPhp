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

class TesteLoja3 extends PageControl  {



  public function show() {

     try{
              Transaction::open('configLoja');

             $venda = new Venda;
             $venda->set_cliente(new Pessoa(2));
             $venda->data_venda= date('Y-m-d');
             $venda->desconto = 10;
             $venda->acrescimos =0;
             $venda->obs ='teste 3';

             $venda->addItem( new Produto(2),2);
             $venda->addItem( new Produto(2),1);

             $venda->valor_final = $venda->valor_venda + $venda->acrescimo - $venda->desconto;

             $venda->store();
            

              Transaction::close();

     }catch(Exception $e) 
     {  
         echo $e->getMessage();

     }

  }



}