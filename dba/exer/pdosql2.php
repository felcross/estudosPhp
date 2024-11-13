<?php 
 try {
 $conn = new PDO('pgsql: dbname=postgres user=postgres password=fel123 
 host=localhost port=5432');
 $conn->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);

 $conn->exec("INSERT INTO famosos (codigo,nome) VALUES (10,'Teste99')");
 $conn->exec("INSERT INTO famosos (codigo,nome) VALUES (11,'Teste49')");
 $conn->exec("INSERT INTO famosos (codigo,nome) VALUES (12,'Teste39')");

 $conn = null;
 } catch(PDOException $e){

   print 'Erro' . $e->getMessage();
 }