<?php 
namespace  Database;
use Exception;


class Repository {

    private $ar;
    public function __construct($class)
    {   $model = '\Model\\' . $class;
        $this->ar = new $model;
    }


    public function load(Criteria $criteria)
    {     // var_dump($criteria);
           var_dump($this->ar->TABLENAME);
 
        $sql = "SELECT * FROM " . $this->ar->TABLENAME ;
        //var_dump($sql);
        
        if($criteria)
        {
            $expression = $criteria->dump();
                if($expression)
                {
                    $sql .= ' WHERE' .  $expression;
                }  

                 $order = $criteria->getProperty('order');
                 $limit = $criteria->getProperty('limit');
                 $offset = $criteria->getProperty('offset');

                 if($order){

                    $sql .= 'ORDER BY ' . $order;
                 }
                 if($limit){

                    $sql .= 'LIMIT ' . $order;
                 }
                 if($offset){

                    $sql .= 'OFFSET ' . $order;
                 }
                 
                
            }  

              if($conn = Transaction::get()) 
              {   
                 Transaction::log($sql);
                 $result = $conn->query($sql); 
                 var_dump($result);
                       if($result)
                        {
                            $results = [];
                            while($row = $result->fetchObject($this->ar->TABLENAME))
                            {
                                $results[]= $row;
                            }
                        

                            return $results;
                        }
                    
              } 
              else { 
                   throw new Exception('Não há conexão aberta');

              } 

         }

    public function delete(Criteria $criteria){

        $sql = "DELETE FROM " . constant($this->ar .'::TABLENAME');


        if($criteria)
        {
            $expression = $criteria->dump();
                if($expression)
                {
                    $sql .= ' WHERE' .  $expression;
                }  
            
        }


        if($conn = Transaction::get()) 
              {   
                 Transaction::log($sql);
                 $result = $conn->exec($sql); 
                       if($result)
                        {
                            $results = [];
                            while($row = $result->fetchObject($this->ar))
                            {
                                $results[]= $row;
                            }
                            return $results;
                        }
                    
              } 
              else { 
                   throw new Exception('Não há conexão aberta');

              } 
    }

    public function count(Criteria $criteria)
    {
        $sql = "SELECT count(*) from " . constant($this->ar .'::TABLENAME');


        if($criteria)
        {
            $expression = $criteria->dump();
                if($expression)
                {
                    $sql .= ' WHERE' .  $expression;
                }  
            
        }


        if($conn = Transaction::get()) 
              {   
                 Transaction::log($sql);
                 $result = $conn->query($sql); 
                       if($result)
                        {
                           $row = $result->fetch();

                           return $row[0];
                            
                        }
                    
              } 
              else { 
                   throw new Exception('Não há conexão aberta');

              } 

    }

}