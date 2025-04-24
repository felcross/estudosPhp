<?php

function dd( $value ) 
{
      echo '<pre>';
      var_dump( $value );
      echo '</pre>';

      die();

}


function base_path($path , $attributes = []) 
{
    extract($attributes);

  return require $_SERVER['DOCUMENT_ROOT'] . '//demo/' . $path ;
}


function view($path , $attributes = []) 
{
    extract($attributes);

  return require $_SERVER['DOCUMENT_ROOT'] . '/demo/views/' . $path ;
}
