<?php 

namespace Model;

use Database\Transaction;
use Exception;
use PDO;

abstract class ModelClass  {

   protected string $table;


    /* public function __call($name, $arguments)
     {
        if(!str_starts_with($name,'findBy'))
        { throw new Exception('Não começa com find');}

        $findBy = strtolower(substr($name,6, strlen($name)));
        


     }*/

    public function findby(string $field, mixed $value) {

        Transaction::open('loja');
        $conn = Transaction::get();
        $prepare = $conn->query("SELECT * FROM {$this->getEntity()} WHERE {$field} = :{$field}");
        $prepare->execute([$field => $value]);

        return $prepare->fetchAll();
        Transaction::close();
    }

    public function all() {
        Transaction::open('loja');
        $conn = Transaction::get();
       // $pdo = new PDO('sqlite:loja.db','','',[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);
        $prepare = $conn->query("SELECT * FROM {$this->getEntity()}");
       // $prepare->execute([$field => $value]);

        return $prepare->fetchAll();
        Transaction::close();
    }

    
    public function getEntity()
    {
       $class = get_class($this);

       return constant("{$class}::TABLENAME");

    }
}