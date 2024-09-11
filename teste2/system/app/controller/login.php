<?php
 session_start();
include '../config/config.php';
if(file_exists(db)){
 
    $json = json_decode(file_get_contents(db),true);

    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $retorno = 0;

    foreach ($json as $key => $value) {
      if($user == $value['user'] && $pass == $value['pass'] ){
        $_SESSION['tokenSessionLogin'] = md5(uniqid());

        $retorno = 1;             
    }
     
    }
  echo $retorno;





    //var_dump($json);
} else { echo 'tá dando erro';}