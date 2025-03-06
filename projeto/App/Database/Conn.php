<?php 
namespace  Database;

use Exception;
use PDO;

 class Conn {

   
    private function __construct() {

       
    }
   //"config/{$name}.ini"
    public static function open($name){
        //var_dump(config_ini);
        if(file_exists("config/{$name}.ini")) {

            $init = parse_ini_file("config/{$name}.ini");
        }  else  {

            throw new Exception("Arquivo {$name} não existe") ;
        }

       $name = $init['name'] ? $init['name']: null; 
       $host = $init['host'] ? $init['host']: null;;
       $user = $init['user'] ? $init['user']: null;;
       $password = $init['password'] ? $init['password']:null ;
       $type = $init['type']  ? $init['type']:null ;

         switch ($type) {
            case 'pgsql':
                $port = $init['port'] ? $init['port']: null;
                $conn = new PDO("pgsql:dbname={$name};user={$user};
                password={$password};host={$host};port={$port}");
       
                break;

                case 'sqlite':
                //$port = $init['port'] ? $init['port']: null;
                $conn = new PDO('sqlite:loja.db','','',[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
                    break;
                
            case 'Outrobanco 2':    
                break;

         }
         $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
         return $conn;

        

    }




 }