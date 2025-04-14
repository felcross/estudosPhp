<?php
class ProdutoRecord22
{
    Private $data;

    private static $conn;
    public static function setConnection(PDO $conn) {
    
     self::$conn = $conn;

    }
    
    public function __get($prop)
    {
        return $this->data[$prop];
    }

    public function __set($prop, $value)
    {
        $this->data[$prop] = $value;
    }

    public  static function find($id) {

        $sql = "SELECT * FROM produto WHERE id = '$id' ";
        $result = self::$conn->query($sql);
        return $result->fetchObject(__CLASS__);
  ;

    }

    public static function all($filter = '') {

        $sql = "SELECT * FROM produto";    
    if($filter)
    {
       $sql .= " WHERE  $filter";
    }

    $result = self::$conn->query($sql);
    print "$sql <br>";
    
    return $result->fetchAll(PDO::FETCH_CLASS,__CLASS__);
    
    }


    public  function delete() 
    {
        $sql = "DELETE FROM produto WHERE id = '{$this->id}' ";
        return $result = self::$conn->query($sql);
    }

    public  function save() 
    {
        if (empty($this->data['id'])) {

            $sql = "INSERT INTO produto (descricao, estoque, preco_custo, preco_venda, codigo_barras, data_cadastro, origem)
                    VALUES 
                    ('{$this->descricao}', 
                    '{$this->estoque}', 
                    '{$this->preco_custo}', 
                    '{$this->preco_venda}', 
                    '{$this->codigo_barras}',
                    '{$this->data_cadastro}', 
                    '{$this->origem}')";  
   
         } else {
   
         
   
            $sql = "UPDATE produto SET 
                descricao = '{$this->descricao}',
                estoque = '{$this->estoque}',
                preco_custo = '{$this->preco_custo}',
                preco_venda = '{$this->preco_venda}',
                codigo_barras = '{$this->codigo_barras}',
                data_cadastro = '{$this->data_cadastro}',
                origem = '{$this->origem}'
                WHERE '{$this->id}'";
         }
         
         print "$sql <br>";
         return self::$conn->exec($sql);
    }

    public  function getMargemLucro() 
    {

       return  ($this->preco_venda - $this->preco_custo / $this->preco_custo) * 100; 
    }

    public  function registraCompra($custo, $qtd) 
    {

        $this->custo= $custo;
        $this->estoque += $qtd;
    }
}
