<?php

$dados = $_POST;

if ($dados['id']) {
    $conn = pg_connect('host=localhost port=5433 dbname=postgres
user=postgres password=123');


    $sql = "UPDATE pessoa SET 
       nome ='{$dados['nome']}',
   endereco ='{$dados['endereco']}',
   bairro   ='{$dados['bairro']}',
  telefone  ='{$dados['tel']}',
    email   ='{$dados['email']}',
    id_cidade ='{$dados['id_cidade']}'
       WHERE id = '{$dados['id']}'";

    //print $sql;
}
    $result = pg_query($conn, $sql);

    if ($result) {
        print 'Registro atualizado com sucesso';
    } else {
        print pg_last_error($conn);
    }

    pg_close($conn);

