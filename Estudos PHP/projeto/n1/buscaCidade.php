<?php

function cidade_list($id_cidade = null){
   // port=5432  password=fel123
    $conn = pg_connect('host=localhost port=5433 dbname=postgres
 user=postgres password=123');

 $output='';
 $result = pg_query($conn,'SELECT ID, NOME FROM CIDADE');

 if($result) 
 {         // fetch_assoc retorna um vetor associativo 
      while ($row = pg_fetch_assoc($result)) 
      {
        //print $row['codigo'] . '-' . $row['nome'] . '<br>';
         $id = $row['id'];
         $nome =$row['nome'];
         $check = $id == $id_cidade ? 'selected=1' :'';
         $output .= "<option {$check} value='{$id}'>$nome</option>";
      }
 }
 pg_close($conn);
 return $output;

}

