<?php
 session_start();
//trás as classes do PHP 
include '../config/config.php';

if(file_exists(db)){
   
    // transforma Json em obj ou array , com true ele vira array 
    //file_get_contents(db) <--- faz o get e trás tudo como string
    $json = json_decode(file_get_contents(db),true);

   // variavel global busca todos os post 
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $retorno = 0;
  
//criando a sessao 
    foreach ($json as $key => $value) {
      if($user == $value['user'] && $pass == $value['pass'] ){
        $_SESSION['tokenSessionLogin'] = md5(uniqid());

        $retorno = 1;             
    }
     
    }
  echo $retorno;





    //var_dump($json);
} else { echo 'tá dando erro';}