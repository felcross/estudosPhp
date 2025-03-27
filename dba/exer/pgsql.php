<?php 

$conn = pg_connect('host=localhost port=5432 dbname=postgres
 user=postgres password=fel123');

 pg_query($conn,"INSERT INTO famosos (codigo,nome) VALUES (4,'Teste04')");
 pg_query($conn,"INSERT INTO famosos (codigo,nome) VALUES (2,'Teste02')");
 pg_query($conn,"INSERT INTO famosos (codigo,nome) VALUES (3,'Teste03')");

 pg_close($conn);
