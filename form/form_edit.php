<html>
<head>  
    <meta charset="utf-8">
    <title>Alterar Cadastro</title> 
    <link href="css/form.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
    <form enctype="multipart/form-data" method="post" action="form_save.php">

    
     <label>Nome</label>
     <input name="nome" type="text" style="width:20%">
     <label>Endereço</label>
     <input name="endereco"  type="text" style="width:20%">
     <label>Bairro</label>
     <input name="bairro"  type="text" style="width:20%">
     <label>Tel</label>
     <input name="tel"  type="text" style="width:20%">
     <label>Email</label>
     <input name="email"  type="text" style="width:20%">
     <label>Cidade</label>
     <select name="id_cidade"  style="width:20%">
       <?php 
       require_once 'buscaCidade.php';
       print cidade_list();
      
       
       ?>     
    </select>

     <input type="submit">
 


    </form>    
</body>
</html>