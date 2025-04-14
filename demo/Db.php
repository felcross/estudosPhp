<?php 



//Data Source Name
class Db 
{
    public $conn;
    public function __construct() 
    {  
     

        $dsn = 'sqlite:banco.db';
        $this->conn = new PDO($dsn, options:[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
       
    }

public function queryAll($sql): mixed
{

    $statement = $this->conn->prepare($sql);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

public function query($sql, $param = []): mixed
{

    $statement = $this->conn->prepare($sql);

    $statement->execute($param);

    return $statement->fetch(PDO::FETCH_ASSOC);
}




}