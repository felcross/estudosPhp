<?php 

class Repository {

    private $ar;
    public function __construct($class)
    {
        $this->ar = $class;
    }


    public function load(Criteria $criteria)
    {

        $sql = "SELECT * FROM " . constant($this->ar .'::TABLENAME');

        if($criteria)
        {
            $expression = $criteria->dump();
                if($expression)
                {
                    $sql .= 'WHERE' .  $expression;
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

        }

    public function delete(Criteria $criteria){

        $sql = "DELETE FROM {$this->getEntity()} WHERE id =" . (int) $id;
    }

    public function count(Criteria $criteria){}

}