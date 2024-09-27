<html>
<head>  
    <meta charset="utf-8">
    <title>Cadastro de Pessoa</title> 
    <link href="css/form.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
    <form enctype="multipart/form-data" method="post" action="form_save.php">

     <label>Codigo</label>
     <input name="id" readonly="1" type="text" style="width:20%">
     <label>Nome</label>
     <input name="nome" type="text" style="width:20%">
     <label>Endereço</label>
     <input name="end"  type="text" style="width:20%">
     <label>Bairro</label>
     <input name="bairro"  type="text" style="width:20%">
     <label>Tel</label>
     <input name="tel"  type="text" style="width:20%">
     <label>Email</label>
     <input name="email"  type="text" style="width:20%">
     <label>Cidade</label>
     <select name="id_cidade"  style="width:20%">

     

     </select>

     <input type="submit">
 


    </form>    
</body>
</html>