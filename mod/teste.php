<?php
require_once 'Lib/Web/Core/ClassLoader.php';
$al = new Web\Core\ClassLoader;
$al->addNamespace('Web','Lib/Web');
$al->register();

require_once 'Lib/Web/Core/AppLoader.php';
$al1 = new Web\Core\AppLoader;
//$al1->addDirectory('App/Controller');
$al1->addDirectory('App/Model');
$al1->register();

use Web\Database\Conn;
use Web\Database\Transaction;

$obj1 = Conn::open('config');
var_dump($obj1);

Transaction::open('config');
var_dump(new Pessoa(21));
Transaction::close();
