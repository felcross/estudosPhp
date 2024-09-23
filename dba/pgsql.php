<?php 

$conn = pg_connect('host=localhost port=5432 dbname=postgres
 user=postgres password=fel123');

 pg_query($conn,"INSERT INTO famosos (codigo,nome) VALUES (1,'Teste01')");

 pg_close($conn);
