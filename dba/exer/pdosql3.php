<?php 
 try {
 $conn = new PDO('pgsql: dbname=postgres user=postgres password=fel123 
 host=localhost port=5432');
 $conn->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
        //metodo retorna do banco em OBJETO
 $result =  $conn->query("SELECT * from FAMOSOS ");

 if($result) {
    
      //foreach($result as $row)
     // while($row = $result->fetch(PDO::FETCH_OBJ))
      while($row = $result->fetchObject())
      {
         
        print $row->codigo . '-' . $row->nome . '<br>';
      }
    
 }
 $conn = null;

 } catch(PDOException $e){

   print 'Erro' . $e->getMessage();
 }