<?php 





$router->get('', 'controllers/home.php');
$router->get('contac', 'controllers/contact.php');
$router->get('about', 'controllers/about.php');
$router->get('notes', 'controllers/notes/show.php');
$router->get('notes/create', 'controllers/notes/create.php');
$router->get('note', 'controllers/notes/index.php');


