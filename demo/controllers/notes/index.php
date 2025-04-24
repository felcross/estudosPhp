<?php

$db = new Db();

$id = $_GET['note?id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $db->query('DELETE FROM notes WHERE id = :id' , ['id'=> $_GET['note?id']]);
}


$sql = "SELECT * FROM notes WHERE id = :id";
$params = [':id' => $id];

$note = $db->query($sql,$params );

if(!$note) {  echo 'não existe'; }


view('notes/index.view.php', ['note' => $note]);