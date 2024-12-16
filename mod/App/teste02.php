<?php
require_once 'autoloadApp.php';
use Model\CidadeControl;


$page = new CidadeControl;
$page->show($_GET);

