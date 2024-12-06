<?php

 use singleton\singleton;

 require_once '/Apache24/htdocs/estudo/singleton/singleton.php';

 $p1 = singleton::getInstance();
 $p2 = singleton::getInstance();
 print 'A linguagem é : ' . $p1->getData('language');
 $p1->setData('language','pt');
 //$p1->save();

 print '<br>';
 print 'A linguagem é : ' . $p2->getData('language');


// var_dump($p1);



?>