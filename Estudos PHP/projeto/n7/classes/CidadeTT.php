<?php 
 class CidadeTT {

    private static $conn;
    public static function getConnection()
    {
       if(empty(self::$conn)){
       $init = parse_ini_file('config/config.ini');
       $name = $init['name'];
       $host = $init['host'];
       $user = $init['user'];
       $password = $init['password'];
       $port = $init['port'];
       self::$conn = new PDO("pgsql:dbname={$name};user={$user};
         password={$password};host={$host};port={$port}");
       }
       return self::$conn;
    }

     public static function all(){
    
        $conn = self::getConnection();
       $result = $conn->query("SELECT * FROM cidade ORDER BY id");
        return $result->fetchAll();
     }
   


 }