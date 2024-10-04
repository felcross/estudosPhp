<?php 

$dados = $_POST;

$conn = pg_connect('host=localhost port=5432 dbname=postgres
user=postgres password=fel123');


$sql = "INSERT INTO pessoa(nome,endereco,bairro,telefone, email, id_cidade) 
       VALUES(
       '{$dados['nome']}',
       '{$dados['endereco']}',
       '{$dados['bairro']}',
       '{$dados['tel']}',
       '{$dados['email']}',
       '{$dados['id_cidade']}')";


/*$sql = "INSERT INTO pessoa(nome,endereco,bairro,telefone, email, id_cidade) 
       VALUES(";

$sql .= "'".$dados['nome']."',";
      $sql.= "'".$dados['endereco']."',";
       $sql.= "'".$dados['bairro']."',";
       $sql.= "'".$dados['tel']."',";
       $sql.="'".$dados['email']."',";
       $sql.= "'".$dados['id_cidade']."'";
       $sql .=  ")";*/

//print $sql;
$result = pg_query($conn,$sql);

if($result)
{
    print 'Registro com sucesso';
} else {
   print pg_last_error($conn);
}

pg_close($conn);


?>