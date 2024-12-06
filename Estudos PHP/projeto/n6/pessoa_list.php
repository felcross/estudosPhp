

  <tbody>
    <?php 
        require_once 'classes/Pessoa.php';
    try{
       if(!empty($_GET['action']) and ($_GET['action'] == 'delete') )
       {
         $id = (int) $_GET['id'];
         Pessoa::delete($id);
       }  
      
      
       $pessoas =  Pessoa::All();
      } catch(Exception $e) {
        print $e->getMessage();
      }
       
      $items = '';
          // fetch_assoc retornar em vetor 
      if($pessoas){
       foreach($pessoas as $row) 
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
     
    
      }}
      $list = file_get_contents('html/pessoa_list.html');
      $list = str_replace('{lista}',$items, $list);
     // var_dump();
      print $list; 

     
    ?>
  