<?php 

 class VendaMapper {

    private static $conn;
    public static function setConnection(PDO $conn) {
    
     self::$conn = $conn;

    }

    public static function save(Venda $venda ){

        $data = date('Y-m-d');
        $sql = "INSERT INTO venda (data_venda) values ('{$data}')"; 
        print $sql .'<br>';
        self::$conn->query($sql);

        foreach($venda->getItens() as $item){
           $qtd = $item[0];
           $produto = $item[1];
           $preco = $produto->preco;
           $sql = "INSERT INTO item_venda (id_produto,id_venda,quantidade,preco)
            values ('{$produto->id_produto}','{$produto->id_venda}','{$qtd}','{$produto->preco}')"; 
             print $sql .'<br>';
            self::$conn->query($sql);

        }
    }


    public static function delete(Venda $venda ){

        $sql = "DELETE FROM produto WHERE id = '{$venda}' ";
        print $sql .'<br>';
        self::$conn->query($sql);
    }











 }