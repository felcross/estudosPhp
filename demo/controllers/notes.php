<?php

$db = new Db();

$notes = $db->queryAll("SELECT * FROM NOTES");



require './views/notes.view.php';