
  <?php
  $pessoa= [];
  $pessoa['id']   = '';
  $pessoa['nome'] = '';
  $pessoa['endereco']  = '';
  $pessoa['bairro'] = '';
  $pessoa['telefone']    = '';
  $pessoa['email']  = '';
  $pessoa['id_cidade'] = '';
 // logica do crud
  if (!empty($_REQUEST['action'])) {
    $conn = pg_connect('host=localhost port=5433 dbname=postgres
       user=postgres password=123');
    if ($_REQUEST['action'] == 'edit') {
      if (!empty($_GET['id'])) {

        $id = (int) $_GET['id'];
        $result =  pg_query($conn, "SELECT * FROM pessoa WHERE id='{$id}'");

        $pessoa = pg_fetch_assoc($result);

       
      }
    } else if ($_REQUEST['action'] == 'save') {
      //$id = $_POST['id'];
      $pessoa = $_POST;
  

      if (empty($_POST['id'])) {
        $sql = "INSERT INTO pessoa(nome,endereco,bairro,telefone, email, id_cidade) 
        VALUES(
        '{$pessoa['nome']}',
        '{$pessoa['endereco']}',
        '{$pessoa['bairro']}',
        '{$pessoa['telefone']}',
        '{$pessoa['email']}',
        '{$pessoa['id_cidade']}')";
       $result = pg_query($conn, $sql);

      } else {
        $sql = "UPDATE pessoa SET 
       nome ='{$pessoa['nome']}',
       endereco ='{$pessoa['endereco']}',
       bairro   ='{$pessoa['bairro']}',
       telefone  ='{$pessoa['telefone']}',
       email   ='{$pessoa['email']}',
       id_cidade ='{$pessoa['id_cidade']}'
       WHERE id = '{$pessoa['id']}'";
      $result = pg_query($conn, $sql);
      }
      print ($result) ? 'Registro salvo com sucesso' : pg_last_error($conn);
      pg_close($conn); 
    }
  }
  require_once 'buscaCidade.php';
  $cidades = cidade_list($pessoa['id_cidade']);
  // Função Ler aquivo e reorna em String 
  $form = file_get_contents('html/pessoa_form.html');
  $form = str_replace('{id}',$pessoa['id'], $form);
  $form = str_replace('{nome}', $pessoa['nome'], $form);
  $form = str_replace('{endereco}', $pessoa['endereco'], $form);
  $form = str_replace('{bairro}', $pessoa['bairro'], $form);
  $form = str_replace('{telefone}', $pessoa['telefone'], $form);
  $form = str_replace('{email}', $pessoa['email'], $form);
  $form = str_replace('{id_cidade}', $pessoa['id_cidade'], $form);
  $form = str_replace('{Cidades}', $cidades, $form);

  print $form;

  ?>

   