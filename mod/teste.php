<?php
require_once 'Lib/Web/Core/ClassLoader.php';
$al = new Web\Core\ClassLoader;
$al->addNamespace('Web','Lib/Web');
$al->register();

use Web\Database\Conn;
$obj1 = Conn::open('config');
var_dump($obj1);