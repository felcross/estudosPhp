<?php 

$conn = pg_connect('host=localhost port=5432 dbname=postgres
 user=postgres password=fel123');

 $query = 'SELECT codigo, nome FROM famosos';

 $result = pg_query($conn,$query);

 if($result) 
 {         // fetch_assoc retornar em vetor 
      while ($row = pg_fetch_assoc($result)) 
      {
        print $row['codigo'] . '-' . $row['nome'] . '<br>';
      }
 }

 //print_r($row);

 pg_close($conn);
