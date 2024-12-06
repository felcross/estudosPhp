<?php

$dados = $_GET;

if ($dados['id']) {
    $conn = pg_connect('host=localhost port=5433 dbname=postgres
user=postgres password=123');

    $id = (int) $dados['id'];
    $sql = "DELETE FROM pessoa WHERE id = '{$id}'";

    //print $sql;
}
    $result = pg_query($conn, $sql);

    if ($result) {
        print 'Registro deletado com sucesso';
    } else {
        print pg_last_error($conn);
    }

    pg_close($conn);

