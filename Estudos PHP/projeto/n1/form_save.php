<?php 

$dados = $_POST;

$conn = pg_connect('host=localhost port=5433 dbname=postgres
user=postgres password=123');


$sql = "INSERT INTO pessoa(nome,endereco,bairro,telefone, email, id_cidade) 
       VALUES(
       '{$dados['nome']}',
       '{$dados['endereco']}',
       '{$dados['bairro']}',
       '{$dados['tel']}',
       '{$dados['email']}',
       '{$dados['id_cidade']}')";



$result = pg_query($conn,$sql);

if($result)
{
    print 'Registro com sucesso';
} else {
   print pg_last_error($conn);
}

pg_close($conn);


?>