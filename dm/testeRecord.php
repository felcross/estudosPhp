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
     
    $p1 = new ProdutoRecord();
    $p1->descricao = "Vinho Importado";
    $p1->estoque= 59;
    $p1->preco_custo= 40;
    $p1->preco_venda= 55.99;
    $p1->codigo_barras= "58914143";
    $p1->data_cadastro= '2024-05-08';
    $p1->origem = "S"; 
    $p1->store();


    Transaction::close();


  } catch(Exception $e){

    return throw $e->getMessage();
  }