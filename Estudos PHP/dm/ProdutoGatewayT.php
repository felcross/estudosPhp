<?php
class ProdutoGatewayT
{   
    private static $conn;
  public static function setConnection(PDO $conn) {
    
     self::$conn = $conn;

  }

   public function find($id, $class = 'stdClass')
   {  
      $sql = "SELECT * FROM produto WHERE id = '$id' ";
      $result = self::$conn->query($sql);
      return $result->fetchObject($class);
;
   }
   public function delete($id)
   {
      $sql = "DELETE FROM produto WHERE id = '$id' ";
      return $result = self::$conn->query($sql);
   }
   public function all($filter = '', $class = 'stdClass')
   {

    $sql = "SELECT * FROM produto";    
    if($filter)
    {
       $sql .= " WHERE  $filter";
    }

    $result = self::$conn->query($sql);
    print "$sql <br>";
    //var_dump($result->fetchAll(PDO::FETCH_CLASS,$class));
    return $result->fetchAll(PDO::FETCH_CLASS,$class);
    
   }

   public function save($data)
   {

      if (empty($data->id)) {

         $sql = "INSERT INTO produto (descricao, estoque, preco_custo, preco_venda, codigo_barras, data_cadastro, origem)
                 VALUES 
                 ('{$data->descricao}', 
                 '{$data->estoque}', 
                 '{$data->preco_custo}', 
                 '{$data->preco_venda}', 
                 '{$data->codigo_barras}',
                 '{$data->data_cadastro}', 
                 '{$data->origem}')";  

      } else {

      

         $sql = "UPDATE produto SET 
             descricao = '{$data->descricao}',
             estoque = '{$data->estoque}',
             preco_custo = '{$data->preco_custo}',
             preco_venda = '{$data->preco_venda}',
             codigo_barras = '{$data->codigo_barras}',
             data_cadastro = '{$data->data_cadastro}',
             origem = '{$data->origem}'
             WHERE '{$data->id}'";
      }
      
      print "$sql <br>";
      return self::$conn->exec($sql);

   }

      
}
