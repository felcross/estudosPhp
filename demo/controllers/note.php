<?php

$db = new Db();

$id = $_GET['note?id'];


$sql = "SELECT * FROM notes WHERE id_user = :id";
$params = [':id' => $id];

$note = $db->query($sql,$params );


require './views/note.view.php';