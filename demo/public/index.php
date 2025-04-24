<?php






// Carrega funções utilitárias

require_once '../functions.php';

// Carrega a classe de banco de dados
require_once '../Db.php';


// Carrega e executa o roteador
//require_once '../router.php';

//autoload
require '../autoLoad.php';




$router = new Core\Router;

$uri = parse_url($_SERVER['QUERY_STRING'])['path'];
$method = $_SERVER["REQUEST_METHOD"];

require_once '../routes.php';

$router->router($uri,$method );







