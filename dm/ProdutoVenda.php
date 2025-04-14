<?php
class ProdutoVenda
{
    Private $data;

    
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
    //verificando qual é a transação(conexão) vigente. 
        $conn = Transaction::get();
        Transaction::log($sql);
        $result = $conn->query($sql);
      
        return $result->fetchObject(__CLASS__);
  ;

    }

    public static function all($filter = '') {

        $sql = "SELECT * FROM produto";    
    if($filter)
    {
       $sql .= " WHERE  $filter";
    }
    $conn = Transaction::get();
    Transaction::log($sql);
    $result = $conn->query($sql);
    print "$sql <br>";
    
    return $result->fetchAll(PDO::FETCH_CLASS,__CLASS__);
    
    }


    public  function delete() 
    {
        $sql = "DELETE FROM produto WHERE id = '{$this->id}' ";
        $conn = Transaction::get();
        Transaction::log($sql);
        return $result = $conn->query($sql);
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
         $conn = Transaction::get();
         Transaction::log($sql);
         return $conn->exec($sql);
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
