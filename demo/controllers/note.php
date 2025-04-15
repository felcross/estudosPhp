<?php

$db = new Db();

$id = $_GET['note?id'];


$sql = "SELECT * FROM notes WHERE id = :id";
$params = [':id' => $id];

$note = $db->query($sql,$params );

if(!$note) {  echo 'não existe'; }


require './views/note.view.php';