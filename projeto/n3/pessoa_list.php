

  <tbody>
    <?php 
       $conn = pg_connect('host=localhost port=5433 dbname=postgres
       user=postgres password=123');
       if(!empty($_GET['action']) and ($_GET['action'] == 'delete') )
       {
         $id = (int) $_GET['id'];
         pg_query($conn,"DELETE FROM pessoa WHERE id ='{$id}'");
       }  
      
      
       $result =  pg_query($conn,'SELECT * FROM pessoa ORDER BY id');
       
      $items = '';
          // fetch_assoc retornar em vetor 
      while ($row = pg_fetch_assoc($result)) 
      {
        //print $row['codigo'] . '-' . $row['nome'] . '<br>'
      
         $item = file_get_contents('html/item.html');
         $item = str_replace('{id}',$row['id'], $item);
         $item = str_replace('{nome}', $row['nome'], $item);
         $item = str_replace('{endereco}', $row['endereco'], $item);
         $item = str_replace('{bairro}', $row['bairro'], $item);
         $item = str_replace('{telefone}', $row['telefone'], $item);
         $item = str_replace('{email}', $row['email'], $item);
         $item = str_replace('{id_cidade}', $row['id_cidade'], $item);

        $items .= $item;  
     
    
      }
      $list = file_get_contents('html/pessoa_list.html');
      $list = str_replace('{lista}',$items, $list);
     // var_dump();
      print $list; 

     
    ?>
  