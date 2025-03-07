<?php 
// define constante para controlar o fluxo da aplicação 
define('CONTROL',TRUE);

//incluir arquivos

$routes = require_once('inc/routes.php');
require_once('inc/ApiConsumer.php');


// definir rota, vai buscar a query string, se tive na url  exe://site/index.php?route=valor
$route = $_GET[ 'route'] ?? 'home';

if(!in_array($route,$routes))
{$route = '404';}

//fluxo de rotas

switch($route)
{    case 'home':
        require_once 'inc/header.php';
        require_once 'scripts/home.php';
        require_once 'inc/footer.php';
      break;
      case '404':
        require_once 'inc/header.php';
        require_once 'scripts/404.php';
        require_once 'inc/footer.php';
      break;


}
