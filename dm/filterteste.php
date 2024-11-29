<?php

require_once 'Criteria.php';

$criteria = new Criteria;
$criteria->add('idade','<',16);
$criteria->add('idade','<',60 , 'or');

print $criteria->dump() . "<br>\n";