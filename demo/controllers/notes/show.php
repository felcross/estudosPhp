<?php

$db = new Db();

$notes = $db->queryAll("SELECT * FROM notes");


view('notes/list.view.php',['notes' => $notes ] );

