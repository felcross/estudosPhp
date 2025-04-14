<?php 

 require_once 'funcionario.php';

 $rc = new ReflectionClass('funcionario');

 echo '<pre>';
 print_r($rc->getMethods()); 
 print_r($rc->getProperties()); 
 print_r($rc->getParentClass()); 