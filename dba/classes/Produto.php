<?php
class Produto
{
    Private $data;

    public static function setConnection(PDO $conn) {
    
        ProdutoGateway::setConnection($conn);
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

        $gw = new ProdutoGateway;
        return $gw->find($id,'Produto'); 
    }

    public static function all($filter = '') {

        $gw = new ProdutoGateway;
        //var_dump($gw->all($filter,'Produto'));
        return $gw->all($filter,'Produto');
    }
    public  function delete($id) {
        $gw = new ProdutoGateway;
        return $gw->delete($id); 
    }

    public  function save() {
        $gw = new ProdutoGateway;
        return $gw->save((object) $this->data);
    }

    public  function getMargemLucro() {

       return  ($this->preco_venda - $this->preco_custo / $this->preco_custo) * 100; 
    }

    public  function registraCompra($custo, $qtd) {

        $this->custo= $custo;
        $this->estoque += $qtd;
    }
}
