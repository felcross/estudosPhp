<?php


if($_SERVER['REQUEST_METHOD'] == 'POST') 
{ 
    $errors = [];

    if(strlen($_POST['text']) == 0 ) {
        $errors['body'] = " Texo se encontra vazio";
    }

    if(empty($errors)) {
        $db = new Db();
        $db->query('INSERT INTO notes (body,id_user) VALUES
        ( :body,:id_user)', ['body' => $_POST['text'],
                                     'id_user' => 2]);    
    }

} 




 base_path('/demo/views/notes/notes-create.view.php');