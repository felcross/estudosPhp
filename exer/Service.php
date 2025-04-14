<?php 
require_once './OInterface.php';

class Service implements OInterface {



    public  function __construct( private $descricao,private $preco ) {
      
    }


    public function getPreco()
    {
        return $this->preco; 
    }
}



?>