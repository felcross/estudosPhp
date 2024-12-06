<?php
require_once 'ProdutoGateway.php';
require_once 'Produto.php';
try 
{  //abre conexão
    $conn = new PDO('pgsql: dbname=postgres user=postgres password=fel123 
    host=localhost port=5432');
    $conn->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
   //diz qual vai usar e seta no gateway
    Produto::setConnection($conn);
      
    $produtos =  Produto::all();
    
    //$unis =  Produto::find(1);
   // $produtos2 =  Produto::all();
    //var_dump($produtos);
  
   foreach($produtos as $produto) {

      print  $produto->descricao. '<br>';  
      
    }
    $data = new Produto;
    $data->descricao = "Queijo";
    $data->estoque= 56;
    $data->preco_custo= 65;
    $data->preco_venda= 65.99;
    $data->codigo_barras= "5890123";
    $data->data_cadastro= '2021-05-08';
    $data->origem = "N"; 
    $data->save();

    foreach($produtos as $produto) {

      print  $produto->descricao. '<br>';  
      
    }

  //  var_dump(array_keys($teste2));



    //$produtos =  new Produto;
    //$produtos->all();

   // var_dump($produtos);

   

  
  /*$data = new Produto;
  $data->descricao = "vinho";
  $data->estoque= 56;
  $data->preco_custo= 65;
  $data->preco_venda= 65.99;
  $data->codigo_barras= "5890123";
  $data->data_cadastro= '2021-05-08';
  $data->origem = "N"; 
  $data->save();*/

  //$data = new Produto;
 // $data->delete(4);


} 
catch( Exception $e){

    return print  $e->getMessage();
}