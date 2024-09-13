<?php

use patterns\singleton;

 require_once 'patterns/singleton.php';

 $p1 = singleton::getInstance();
 var_dump($p1);

?>