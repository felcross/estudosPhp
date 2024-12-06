<html>

<head>
  <meta charset="utf-8">
  <title>Alterar Cadastro</title>
  <link href="css/form.css" rel="stylesheet" type="text/css" media="screen">
</head>

<body>
  <?php
  $id = '';
  $nome = '';
  $end = '';
  $bairro = '';
  $tel = '';
  $email = '';
  $id_cidade = '';

  if (!empty($_REQUEST['action'])) {
    $conn = pg_connect('host=localhost port=5433 dbname=postgres
       user=postgres password=123');
    if ($_REQUEST['action'] == 'edit') {
      if (!empty($_GET['id'])) {

        $id = (int) $_GET['id'];
        $result =  pg_query($conn, "SELECT * FROM pessoa WHERE id='{$id}'");

        $row = pg_fetch_assoc($result);

        $id = $row['id'];
        $nome = $row['nome'];
        $end = $row['endereco'];
        $bairro = $row['bairro'];
        $tel = $row['telefone'];
        $email = $row['email'];
        $id_cidade = $row['id_cidade'];
      }
    } else if ($_REQUEST['action'] == 'save') {
      $id = $_POST['id'];
      $nome = $_POST['nome'];
      $end = $_POST['endereco'];
      $bairro = $_POST['bairro'];
      $tel = $_POST['tel'];
      $email = $_POST['email'];
      $id_cidade = $_POST['id_cidade'];

      if (empty($_POST['id'])) {
        $sql = "INSERT INTO pessoa(nome,endereco,bairro,telefone, email, id_cidade) 
        VALUES(
        '{$nome}',
        '{$end}',
        '{$bairro}',
        '{$tel}',
        '{$email}',
        '{$id_cidade}')";
       $result = pg_query($conn, $sql);

      } else {
        $sql = "UPDATE pessoa SET 
       nome ='{$nome}',
       endereco ='{$end}',
       bairro   ='{$bairro}',
       telefone  ='{$tel}',
       email   ='{$email}',
       id_cidade ='{$id_cidade}'
       WHERE id = '{$id}'";
      $result = pg_query($conn, $sql);
      }
      print ($result) ? 'Registro salvo com sucesso' : pg_last_error($conn);
      pg_close($conn); 
    }
  }


  // print_r($row);

  ?>

  <form enctype="multipart/form-data" method="post" action="pessoa_form.php?action=save">

    <label>ID</label>
    <input name="id" readonly="1" type="text" style="width:20%" value="<?= $id ?>">
    <label>Nome</label>
    <input name="nome" type="text" style="width:20%" value="<?= $nome ?>">
    <label>Endereço</label>
    <input name="endereco" type="text" style="width:20%" value="<?= $end ?>">
    <label>Bairro</label>
    <input name="bairro" type="text" style="width:20%" value="<?= $bairro ?>">
    <label>Tel</label>
    <input name="tel" type="text" style="width:20%" value="<?= $tel ?>">
    <label>Email</label>
    <input name="email" type="text" style="width:20%" value="<?= $email ?>">
    <label>Cidade</label>
    <select name="id_cidade" style="width:20%">
      <?php
      require_once 'buscaCidade.php';
      print cidade_list($id_cidade);


      ?>
    </select>

    <input type="submit">



  </form>
</body>

</html>