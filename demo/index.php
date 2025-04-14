<?php

require './functions.php';

require './router.php';

require './Db.php';

$db = new Db();


$data = $db->query("SELECT * FROM POSTS");
//dd($data);

/*foreach ($data as $key => $value) { 

    echo  "<li>" .  $value['id'] .  $value["title"] . "<li>";
}*/

foreach ($data as $value) { 

    echo  "<pre>" . $value["id"] . '  ' . $value["title"] . "<pre>";
}




