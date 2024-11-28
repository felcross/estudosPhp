<?php 

require_once   'Logger.php';
require_once   'LoggerTXT.php';
require_once   'Transaction.php';
require_once   'Conn.php';
require_once   'Record.php';
require_once   'ProdutoRecord.php';

try{ 
    Transaction::open('config');
    Transaction::setLogger(new LoggerTXT('log.txt'));
     
  //  $p1 = new ProdutoRecord(20);
  //  print $p1->descricao . '<br>';

    $p2 = ProdutoRecord::find(9);
     
    if($p2)
    { print 'Descrição: ' . $p2->descricao . '<br>';
      print 'Estoque: ' . $p2->estoque . '<br>';
      
      $p2->estoque += 10;
      $p2->store();
    }
    

    Transaction::close();


  } catch(Exception $e){
    Transaction::rollback();
    print  $e->getMessage();
  }