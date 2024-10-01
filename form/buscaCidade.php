<?php

function cidade_list(){
  
    $conn = pg_connect('host=localhost port=5432 dbname=postgres
 user=postgres password=fel123');

 $output='';
 $result = pg_query($conn,'SELECT ID, NOME FROM CIDADE');

 if($result) 
 {         // fetch_assoc retornar em vetor 
      while ($row = pg_fetch_assoc($result)) 
      {
        //print $row['codigo'] . '-' . $row['nome'] . '<br>';
         $id = $row['id'];
         $nome =$row['nome'];
         $output .= "<option value={'{$id}'}>$nome</option>";
      }
 }
 pg_close($conn);
 return $output;

}

