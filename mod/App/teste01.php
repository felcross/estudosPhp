<?php

require_once 'autoloadApp.php';


use Model\PessoaControl;

$page = new PessoaControl;
$page->show($_GET);

