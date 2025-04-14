<?php

 $url = parse_url($_SERVER['REQUEST_URI']);
 
 echo '<pre>';
 var_dump($url);
 echo '<pre>';

 switch($url){

    case 'teste': echo 'Primeira opção';
    break;

}
 