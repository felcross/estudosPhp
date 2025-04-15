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

public function queryAll($sql,$params = []): mixed
{

    $statement = $this->conn->prepare($sql);

    $statement->execute($params);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

public function query($sql, $params = []): mixed
{

    $statement = $this->conn->prepare($sql);

    $statement->execute($params);

    return $statement->fetch(PDO::FETCH_ASSOC);
}




}