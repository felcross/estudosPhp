<?php
require_once 'ProdutoGateway.php';
try 
{  //abre conexão
    $conn = new PDO('pgsql: dbname=postgres user=postgres password=123 
    host=localhost port=5433');
    $conn->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
   //diz qual vai usar e seta no gateway
    ProdutoGateway::setConnection($conn);
  
  /*  $data = new stdClass;
    $data->descricao = "Produto Exemplo 3";
    $data->estoque= 5;
    $data->preco_custo= 765;
    $data->preco_venda= 355.99;
    $data->codigo_barras= "12335555890123";
    $data->data_cadastro= '2024-05-08';
    $data->origem = "N"; */

   $gw = new ProdutoGateway;
   //$gw->save($data);
 
 /*  $produto = $gw->find(1);
   $produto->estoque += 4 ;
   $gw->save($produto);*/
  

   foreach($gw->all('estoque <= 10') as $produto ) {

     print $produto->descricao . '<br>';
   }






} 
catch( Exception $e){

    return  $e->getMessage();
}