<?php
namespace Model;


use Database\Transaction;
use Database\Criteria;
use Database\Repository;
use Controller\PageControl;
use Exception;




class CidadeControl  {


     

        public  function listar() {
            try{
                Transaction::open('config');
                 $criteria = new Criteria;
                 $criteria->setProperty('order','id');
                 $repo = new Repository('Cidade');
                 $cidades = $repo->load($criteria);
        if($cidades){
                 foreach($cidades as $cidade){

                    print "{$cidade->id} - {$cidade->nome} <br>";
                 } 
                }

                Transaction::close();
                

            }
            
            catch(Exception $e)
            {
                print  $e->getMessage();           
             }
        }

        public function Ola() {

            print 'Emsoft cleitin, Boa Tarde  !! ';
        }


        public function show($param){

            if(isset($param['method']) && ($param['method'] == 'listar')) {
                $this->listar();
            }


            if(isset($param['method']) && ($param['method'] == 'ola')) {
                $this->Ola();
            }
        }

}