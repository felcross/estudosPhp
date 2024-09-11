<?php

spl_autoload_register(function($classe){
    include "./system/app/classes/".$classe.".php";
});


?>