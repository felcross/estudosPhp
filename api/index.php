<?php

session_start();
session_name("testeAPI");
ini_set('display_errors', 1);

include 'function.php';



$t = api('ServiceSistema/Login', 'POST', [
    'usuario' => 'edson',
    'senha' => 'chicosoft'
]);


$_SESSION['token'] = $t['response']->value;





$t =
    api(
        "/Produto?%24top=2",
        'GET',
        token: $_SESSION['token']
    );


$result = $t['response']->value;



foreach ($result as $key => $value) {
    echo <<<HTML
        <h1>{$value->PRODUTO}</h1>
        HTML;
}






