
  <?php
      require_once 'db/dados.php';
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
   
    if ($_REQUEST['action'] == 'edit') {
      if (!empty($_GET['id'])) {

        $id = (int) $_GET['id'];
        $pessoa =  get_pessoa($id);

       
      }
    } else if ($_REQUEST['action'] == 'save') {
      //$id = $_POST['id'];
      $pessoa = $_POST;
  

      if (empty($_POST['id'])) {
        
       $result = insert_pessoa($pessoa);

      } else {
        
      $result = update_pessoa($pessoa);
      }
      print ($result) ? 'Registro salvo com sucesso' : 'Problemas ao Salvar';
       
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

   