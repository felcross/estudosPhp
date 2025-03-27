<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('HTTP/1.1 200 Success');
    header('Content-Type: application/json');
    $dados = $_POST;
    echo json_encode($dados);
} else {
    header('HTTP/1.1 500 Error');
}