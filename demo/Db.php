<?php 



//Data Source Name
class Db 
{
    public $conn;
    public function __construct() 
    {  
        $dsn = 'sqlite:banco.db';
        $this->conn = new PDO($dsn,'','',[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
       
    }

public function query($sql): mixed
{

    $statement = $this->conn->prepare($sql);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}




}