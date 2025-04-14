<?php 
 class Pessoa {

     public static function find($id){
 
           $conn = new PDO("pgsql:dbname=postgres;user=postgres;password=123;host=localhost;port=5433");       
           $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

          $result = $conn->query("SELECT * FROM pessoa WHERE id = '{$id}' ");
           return $result->fetch();
     }
     public static function delete($id){

        $conn = new PDO("pgsql:dbname=postgres;user=postgres;password=123;host=localhost;port=5433");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

       $result = $conn->query("DELETE FROM pessoa WHERE id = '{$id}' ");
        return $result;
     }
     public static function all(){

        $conn = new PDO("pgsql:dbname=postgres;user=postgres;password=123;host=localhost;port=5433");    
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

       $result = $conn->query("SELECT * FROM pessoa ORDER BY id");
        return $result->fetchAll();
     }
     public static function save($pessoa){
          
        $conn = new PDO("pgsql:dbname=postgres;user=postgres;password=123;host=localhost;port=5433");      
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
         
         if(empty($pessoa['id']))
         {
            $sql = "INSERT INTO pessoa(nome,endereco,bairro,telefone, email, id_cidade) 
            VALUES(
            '{$pessoa['nome']}',
            '{$pessoa['endereco']}',
            '{$pessoa['bairro']}',
            '{$pessoa['telefone']}',
            '{$pessoa['email']}',
            '{$pessoa['id_cidade']}')";
         } 
         else 
         {
            $sql =  $sql = "UPDATE pessoa SET 
            nome ='{$pessoa['nome']}',
            endereco ='{$pessoa['endereco']}',
            bairro   ='{$pessoa['bairro']}',
            telefone  ='{$pessoa['telefone']}',
            email   ='{$pessoa['email']}',
            id_cidade ='{$pessoa['id_cidade']}'
            WHERE id = '{$pessoa['id']}'";
         }
       // echo $result = $conn->query($sql);
         return $conn->query($sql);
        
     }


 }