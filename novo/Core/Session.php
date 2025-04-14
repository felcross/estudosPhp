<?php
namespace Core;


class Session {


    public static function set(String $index , mixed $value)
    {
          $_SESSION[$index] = $value;

    }
    
    public static function has(string $index)
    {
        return  isset($_SESSION[$index]);
        

    }

    public static function get(string $index)
    {
       
       return self::has($index)?$_SESSION[$index]:'Não existe';
        

    }


    public static function dump()
    {
        var_dump($_SESSION);
        die();

    }

    public static function remove(string $index)
    {
         if(self::has($index))
         unset($_SESSION[$index]);
       

    }

    
    public static function remove_all()
    {
        session_destroy();

    }

    public static function flash(String $index , mixed $value)
    {
          $_SESSION['__flash'][$index] = $value;

    }

    public static function remove_flash()
    {
         if($_SERVER['REQUEST_METHOD'] == 'GET' &&   self::has('__flash'))
         unset($_SESSION['__flash']);   

    }

    
}