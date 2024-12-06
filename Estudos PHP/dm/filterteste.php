<?php

require_once 'Criteria.php';
require_once 'Conn.php';
require_once 'Logger.php';
require_once 'LoggerTXT.php';
require_once 'ProdutoRecord.php';
require_once 'Transaction.php';
require_once 'Repository.php';
require_once 'Record.php';

try{ 
    Transaction::open('config');
    Transaction::setLogger(new LoggerTXT('log.txt'));


    
$criteria = new Criteria;
$criteria->add('estoque','>',10 ,'or');
$criteria->add('origem','=','N');
$criteria2 = new Criteria;
$criteria2->add('origem','=','N');

 $repository = new Repository('ProdutoRecord');
 $produtos = $repository->load($criteria);

 if($produtos)
 {
     foreach($produtos as $produto)
     {
         print 'Id:' . $produto->id;
         print '- Descrição:' . $produto->descricao;
         print '- Estoque:' . $produto->estoque;
         print '<br>';
     }
 }
/*
 $Qtd = $repository->count($criteria);

 print  'Quantidade: ' . $Qtd;
*/



print $criteria->dump() . "<br>";
     


    Transaction::close();


  } catch(Exception $e){

     return $e->getMessage();
    Transaction::rollback();
  }