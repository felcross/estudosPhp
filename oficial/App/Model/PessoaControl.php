<?php
namespace Model;
use Database\Transaction;
use Database\Criteria;
use Database\Repository;
use Controller\PageControl;
use Exception;




class PessoaControl extends PageControl {


     

        public  function listar() {
            try{
                Transaction::open('config');
                 $criteria = new Criteria;
                 $criteria->setProperty('order','id');
                 $repo = new Repository('Pessoa');
                 $pessoas = $repo->load($criteria);
        if($pessoas){
                 foreach($pessoas as $pessoa){

                    print "{$pessoa->id} - {$pessoa->nome} <br>";
                 } 
                }

                Transaction::close();
                

            }
            
            catch(Exception $e)
            {
                print  $e->getMessage();           
             }
        }

  /*
        public function show($param){

            if(isset($param['method']) && ($param['method'] == 'listar')) {
                $this->listar();
            }
        }*/

}