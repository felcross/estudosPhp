<?php
 function get_pessoa($id){
    $conn = pg_connect('host=localhost port=5432 dbname=postgres
    user=postgres password=fel123');

    $result =  pg_query($conn,"SELECT * FROM pessoa WHERE id = '{$id}' ");
    $pessoa = pg_fetch_assoc($result);
    pg_close($conn);
    return $pessoa;

 }
 function excluir_pessoa($id){
   $conn = pg_connect('host=localhost port=5432 dbname=postgres
   user=postgres password=fel123');

    $result =  pg_query($conn,"DELETE FROM pessoa WHERE id ='{$id}'");
    pg_close($conn);
    return $result;

 }
 function insert_pessoa($pessoa){
   $conn = pg_connect('host=localhost port=5432 dbname=postgres
   user=postgres password=fel123');

    $sql = "INSERT INTO pessoa(nome,endereco,bairro,telefone, email, id_cidade) 
        VALUES(
        '{$pessoa['nome']}',
        '{$pessoa['endereco']}',
        '{$pessoa['bairro']}',
        '{$pessoa['telefone']}',
        '{$pessoa['email']}',
        '{$pessoa['id_cidade']}')";
       $result = pg_query($conn, $sql);
       pg_close($conn);
       return $result;

 }
 function update_pessoa($pessoa){

   $conn = pg_connect('host=localhost port=5432 dbname=postgres
   user=postgres password=fel123');

    $sql =  $sql = "UPDATE pessoa SET 
    nome ='{$pessoa['nome']}',
    endereco ='{$pessoa['endereco']}',
    bairro   ='{$pessoa['bairro']}',
    telefone  ='{$pessoa['telefone']}',
    email   ='{$pessoa['email']}',
    id_cidade ='{$pessoa['id_cidade']}'
    WHERE id = '{$pessoa['id']}'";
       $result = pg_query($conn, $sql);
       pg_close($conn);
       return $result;
 }

 function list_pessoa(){
   $conn = pg_connect('host=localhost port=5432 dbname=postgres
   user=postgres password=fel123');

    $result =  pg_query($conn,"SELECT * FROM pessoa ORDER BY id");
    $list = pg_fetch_all($result);
    pg_close($conn);
    return $list;
 }