<?php 

require_once './OInterface.php';

class Produto implements OInterface {

    

   public function __construct(private $descricaco,private $estoque,private $preco){

     
   }
   
  public function getDescricaco(){
   return $this->descricaco;
  }

  public function getEstoque(){
    return $this->estoque;
  }

  public function getPreco(){
    return $this->preco;
  }

   

}



?>