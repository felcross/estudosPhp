<?php

require '../vendor/autoload.php';

require_once '../core/library/Auth.php';

use Core\library\Auth;

$auth = new Auth;

$teste = $_GET['param'];

var_dump($teste);