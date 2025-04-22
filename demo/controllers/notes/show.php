<?php

$db = new Db();

$notes = $db->queryAll("SELECT * FROM notes");


 base_path('/demo/views/notes/notes.view.php',['notes' => $notes ] );

