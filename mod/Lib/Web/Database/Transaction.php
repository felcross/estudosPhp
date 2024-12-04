<?php 
namespace  Web\Database;

 use Logger;

 class Transaction {

   private static $conn;
   private static $Logger;
    private function __construct() {}
   
    public static function open($database){
      
        self::$conn = Conn::open($database);
        self::$conn->beginTransaction();
        self::$Logger = null;
         

    }


    public static function close(){
      
        if(self::$conn) {
        self::$conn->commit();
        self::$conn = null;
        }         

    }


    public static function get(){
      
        return   self::$conn;

    }

    public static function rollback(){
      if(self::$conn)
      { self::$conn->rollback();
        self::$conn = null; 
      }       

    }

    public static function setLogger(Logger $Logger){
       
         self::$Logger = $Logger;
               
  
      }

    public static function log($message){
          if(self::$Logger){ 
        self::$Logger->write($message);
          }
      }






 }