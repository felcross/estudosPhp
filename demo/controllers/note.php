<?php

$db = new Db();


$sql = "SELECT * FROM notes WHERE id = :id";

$notes = $db->query($sql, [':id' => $_GET["id"]]);



require './views/note.view.php';