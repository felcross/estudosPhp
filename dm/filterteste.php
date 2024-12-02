<?php

require_once 'Criteria.php';

/*$criteria = new Criteria;
$criteria->add('idade','<',16 ,'and');
//$criteria->add('idade','<',60 , 'or');

print $criteria->dump() . "<br>";*/


// Exemplo de uso
$criteria = new Criteria();
//$criteria->add('age', '>', 18);
$criteria->add('name', 'IN', ['John', 'Jane'], 'or');
$criteria->add('status', '=', 'active');

echo $criteria->dump() . '<br>';