<?php
require_once 'Lib\\Web\\Core\\ClassLoader.php';
require_once 'App\\Model\\Pessoa.php';
$al = new Web\Core\ClassLoader;
$al->addNamespace('Web','Lib/Web');
$al->register();


require_once 'Lib\\Web\\Core\\AppLoader.php';
$al = new Web\Core\AppLoader;
//$al1->addDirectory('App/Controller');
$al->addDirectory('App/Model');
$al->register();

use Web\Database\Conn;
use Web\Database\Transaction;
use App\Model\Pessoa;

$obj1 = Conn::open('config');
var_dump($obj1);
echo '<br><br>';
Transaction::open('config');
var_dump(new Pessoa(21));
Transaction::close();



