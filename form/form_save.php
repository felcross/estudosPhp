<?php 

$dados = $_POST;

$conn = pg_connect('host=localhost port=5432 dbname=postgres
user=postgres password=fel123');

$result = pg_query($conn,'SELECT max(id) as next FROM pessoa');
$row


$sql = "INSERT INTO pessoa(id,nome,end,bairro,email,id_cidade)
 VALUES";



print $dados['nome'];
print $dados['email'];
print $dados['id_cidade'];




?>