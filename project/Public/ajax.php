<?php
require '../autoLoad.php';
require '../vendor/autoload.php';

if (isset($_POST['token'])) {
    http_response_code(200);
    $token = \utils\Tokens::verificaTokenCSRF($_POST['token']);

 
} else {
    http_response_code(400);
    echo "Token não enviado";
}
;

