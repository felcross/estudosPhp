<?php 


function dump($value) {

    echo '<pre>';
var_dump($value);
    echo '<pre>';

    die();

}



function url($value) {

return $_SERVER['REQUEST_URI'] === $value;
}