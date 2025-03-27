<html>
<head>  
    <meta charset="utf-8">
    <title>Alterar Cadastro</title> 
    <link href="css/form.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
<?php 
       if(!empty($_GET['id']))
       $conn = pg_connect('host=localhost port=5433 dbname=postgres
       user=postgres password=123');
      $id = (int) $_GET['id']; 
      $result =  pg_query($conn,"SELECT * FROM pessoa WHERE id='{$id}'");
            
       $row = pg_fetch_assoc($result);
      
         $id = $row['id'];
         $nome =$row['nome'];
         $end =$row['endereco'];
         $bairro =$row['bairro'];
         $tel =$row['telefone'];
         $email =$row['email'];
         $id_cidade =$row['id_cidade'];
      

         // print_r($row);
       
       ?>     

    <form enctype="multipart/form-data" method="post" action="form_update.php">

    <label>ID</label>
     <input name="id" readonly="1"  type="text" style="width:20%" value="<?=$id?>">
     <label>Nome</label>
     <input name="nome" type="text" style="width:20%" value="<?=$nome?>">
     <label>Endereço</label>
     <input name="endereco"  type="text" style="width:20%" value="<?=$end?>">
     <label>Bairro</label>
     <input name="bairro"  type="text" style="width:20%" value="<?=$bairro?>">
     <label>Tel</label>
     <input name="tel"  type="text" style="width:20%" value="<?=$tel?>">
     <label>Email</label>
     <input name="email"  type="text" style="width:20%" value="<?=$email?>">
     <label>Cidade</label>
     <select name="id_cidade"  style="width:20%" >
       <?php 
       require_once 'buscaCidade.php';
       print cidade_list($id_cidade);
      
       
       ?>     
    </select>

     <input type="submit">
 


    </form>    
</body>
</html>