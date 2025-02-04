<?php 
namespace Database;
use Database\Criteria;
use Exception;


class Repository {
    
   private $ar;


    public function __construct($class)
    {  
        
        $this->ar = $class;
       
    }

    public function load(Criteria $criteria)
    {    
        $sql = "SELECT * FROM " . $this->ar ;
        
        if ($criteria) {
            $expression = $criteria->dump();
            if ($expression) {
                $sql .= ' WHERE ' . $expression;
            }  

            $order = $criteria->getProperty('order');
            $limit = $criteria->getProperty('limit');
            $offset = $criteria->getProperty('offset');

            if ($order) {
                $sql .= ' ORDER BY ' . $order;
            }
            if ($limit) {
                $sql .= ' LIMIT ' . $limit;
            }
            if ($offset) {
                $sql .= ' OFFSET ' . $offset;
            }
        }  

        if ($conn = Transaction::get()) {   
            Transaction::log($sql);
            $result = $conn->query($sql); 
          //  var_dump($result);
            if ($result) {
                $results = [];
              
                while ($row = $result->fetchObject()) {
                    $results[] = $row;
                }
                return $results;
            }
        } else { 
            throw new Exception('Não há conexão aberta no método ' . __METHOD__);
        }
    }

    public function delete(Criteria $criteria)
    {
        $sql = "DELETE FROM "  . $this->ar;

        if ($criteria) {
            $expression = $criteria->dump();
            if ($expression) {
                $sql .= ' WHERE ' . $expression;
            }  
        }

        if ($conn = Transaction::get()) {   
            Transaction::log($sql);
            $result = $conn->exec($sql); 
            return $result; // Retorna o número de linhas afetadas
        } else { 
            throw new Exception('Não há conexão aberta no método ' . __METHOD__);
        }
    }

    public function count(Criteria $criteria)
    {
        $sql = "SELECT count(*) FROM " . $this->ar ;

        if ($criteria) {
            $expression = $criteria->dump();
            if ($expression) {
                $sql .= ' WHERE ' . $expression;
            }  
        }

        if ($conn = Transaction::get()) {   
            Transaction::log($sql);
            $result = $conn->query($sql); 
            if ($result) {
                $row = $result->fetch();
                return $row[0];
            }
        } else { 
            throw new Exception('Não há conexão aberta no método ' . __METHOD__);
        } 
    }


    public function all()
    {    
        $sql = "SELECT * FROM " . $this->ar ;
        
       
        if ($conn = Transaction::get()) {   
            Transaction::log($sql);
            $result = $conn->query($sql); 
            //var_dump($result);
            if ($result) {
                $results = [];
              
                while ($row = $result->fetchObject()) {
                    $results[] = $row;
                }
                return $results;
            }
        } else { 
            throw new Exception('Não há conexão aberta no método ' . __METHOD__);
        }
    }
}
