
  <?php
  require_once 'classes/Pessoa.php';
  require_once 'classes/Cidade.php';
  $pessoa = [];
  $pessoa['id']   = '';
  $pessoa['nome'] = '';
  $pessoa['endereco']  = '';
  $pessoa['bairro'] = '';
  $pessoa['telefone']    = '';
  $pessoa['email']  = '';
  $pessoa['id_cidade'] = '';
  // logica do crud
  try{
  if (!empty($_REQUEST['action'])) {
  if ($_REQUEST['action'] == 'edit') {
      if (!empty($_GET['id'])) {

        $id = (int) $_GET['id'];
        $pessoa  = Pessoa::find($id);
      }
    } else if ($_REQUEST['action'] == 'save') {
      //$id =  $_POST['id'];
      $pessoa = $_POST;
      //print_r($pessoa);
      Pessoa::save($pessoa);
      print 'Registro salvo com sucesso';

    } 
  
  }  } catch(Exception $e){
    return $e->getMessage();
}

  try{
   $cidades = ''; 
   foreach(Cidade::all() as $cidade){
       $key=$cidade['id'];
       $nome=$cidade['nome'];
       $check = $cidade['id'] == $pessoa['id_cidade'] ? 'selected=1' :'';
      $cidades .= "<option {$check} value='{$key}'>{$nome} </option>";
    }


  }catch(Exception $e){ return $getMessage();}
  
  // Função Ler aquivo e reorna em String 
  $form = file_get_contents('html/pessoa_form.html');
  $form = str_replace('{id}', $pessoa['id'], $form);
  $form = str_replace('{nome}', $pessoa['nome'], $form);
  $form = str_replace('{endereco}', $pessoa['endereco'], $form);
  $form = str_replace('{bairro}', $pessoa['bairro'], $form);
  $form = str_replace('{telefone}', $pessoa['telefone'], $form);
  $form = str_replace('{email}', $pessoa['email'], $form);
  $form = str_replace('{id_cidade}', $pessoa['id_cidade'], $form);
  $form = str_replace('{Cidades}', $cidades, $form);

  print $form;

  ?>

   