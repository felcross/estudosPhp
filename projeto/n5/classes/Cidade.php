<?php 
 class Cidade {

    
     public static function all(){
        $conn = new PDO("pgsql:dbname=postgres;user=postgres;password=123;host=localhost;port=5433");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

       $result = $conn->query("SELECT * FROM cidade ORDER BY id");
        return $result->fetchAll();
     }
   


 }