<?php

require_once 'ProdutoVenda.php';
require_once 'Venda.php';
require_once 'VendaMapper.php';
require_once 'Conn.php';
require_once 'Logger.php';
require_once 'LoggerTXT.php';
require_once 'ProdutoT.php';
require_once 'ProdutoGatewayT.php';
require_once 'Transaction.php';

try {

   /* $p1 = new ProdutoVenda;
    $p1->id_produto = 1;
    $p1->id_venda = 1;
    $p1->preco = 23;
    $p2 = new ProdutoVenda;
    $p2->id_produto = 2;
    $p2->id_venda = 2;
    $p2->preco = 13;*/


   // Usando o table data gateway
   // $conn = CONN::open('config');
   // ProdutoT::setConnection($conn);
   //---------
   Transaction::open('config');
   Transaction::setLogger(new LoggerTXT('log.txt'));

    $data = new ProdutoVenda;
    $data->descricao = "Café fraco";
    $data->estoque= 102;
    $data->preco_custo= 15;
    $data->preco_venda= 25.99;
    $data->codigo_barras= "58914143";
    $data->data_cadastro= '2024-05-08';
    $data->origem = "N"; 
    $data->save();

    Transaction::close();
     
  
    

  /*
    $venda = new Venda;
    $venda->addItem(4,$p1);
    $venda->addItem(4,$p2);
    
    $conn = new PDO('pgsql: dbname=postgres user=postgres password=fel123 
    host=localhost port=5432');
    $conn->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);

    VendaMapper::setConnection($conn);
    VendaMapper::save($venda); */

 


} catch( Exception $e){
    
  Transaction::rollback();
  print  $e->getMessage();
}
