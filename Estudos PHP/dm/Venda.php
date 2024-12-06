<?php 

 class Venda {

     private $id;
     private $itens;

    public function setId($id)
    {
        return $this->id[$id];
    }

    public function getId()
    {
       return  $this->id;
    
    }

    public function addItem($qtd , ProdutoVenda $produto ){

        $this->itens [] = [$qtd,$produto] ;
    }
   
    public function getItens()
    {
       return  $this->itens;
    
    }











 }