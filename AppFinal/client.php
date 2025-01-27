<?php
$location = "http://localhost/mod/App/rest.php";

$parameters = [];
$parameters['class'] = '\Services\PessoaService';
$parameters['method'] = 'getData';
$parameters['id'] = '21';

$url = $location . '?' . http_build_query($parameters);

var_dump(json_decode(file_get_contents($url)));