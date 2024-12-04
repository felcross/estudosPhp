<?php
namespace  Web\Database;

use Exception;

abstract class Record
{
    Private $data;

    public function __construct($id= null)
    {    
          if($id)
          {   $object = $this->load($id);
                if($object)
                {
                     $this->fromArray($object->toArray());
                }
          }
      
    }
    
    public function __get($prop)
    {
     if(isset($this->data[$prop])){

       return $this->data[$prop];
     }
    
    }

    public function __set($prop, $value)
    {    
        if($value === null)
           {
            unset($this->data[$prop]);
            } 
            else 
            {  
                $this->data[$prop] = $value;
            }
       
    }
   //verifica se existe a propriedade no vetor
    public function __isset($propriedade)
{
    return isset($this->data[$propriedade]);
}

    //Apaga o campo ID quando o Obj é clonado.
    public function __clone()
    {
        unset($this->data['id']);
    }
     // converte os arrays recebidos pra obj
    public function fromArray($data)
    {
       $this->data = $data;

    }
    
    // exporta o obj em forma de vetor  
    public function toArray(){


        return $this->data;
    }

    public function getEntity()
    {
       $class = get_class($this);

       return constant("{$class}::TABLENAME");

    }

    public static function find($id){
       //metodo me diz que classe estou usando. 
        $classename = get_called_class();
        $ar= new $classename;
        return $ar->load($id);  
    }


  public function load($id){
 
    $sql = "SELECT * FROM {$this->getEntity()} WHERE id =" . (int) $id;
  //verifica se tem conexão existente
    if($conn = Transaction::get())
    {  Transaction::log($sql);
      $result = $conn->query($sql); 
         if($result)
         {
            return $result->fetchObject(get_class($this));

         }
    }
    else{
      $conn->rollback();
      throw new Exception('Não há transação ativa');
    }

  }

  public function store(){

    $prepared = $this->prepared($this->data);
     //segunda condição se o id que passou pro load não existir.
     if((empty($this->data['id'])) OR (!$this->load($this->data['id'])))
     {  $sql = "INSERT INTO {$this->getEntity()}" 
      . '(' . implode(', ',array_keys($prepared)) . ')' . 'values' . '(' . implode(', ',array_values($prepared)) . ')'; 

     }  else  {
         
         $prepared = $this->prepared($this->data);
        
         $set = [];
         foreach($prepared as $column => $value){
            
          $set [] =  "$column = $value";
         }
         $sql = "UPDATE {$this->getEntity()}";
         $sql .= " SET " . implode(', ', $set);
         $sql .= " WHERE id =" . (int) $this->data['id'];;

     }

    if($conn = Transaction::get())
    {  Transaction::log($sql);
      $conn->query($sql); 
    }
    else{
      $conn->rollback();
      throw new Exception('Não há transação ativa');
    }

  }


  public function delete($id){
    $sql = "DELETE FROM {$this->getEntity()} WHERE id =" . (int) $id;
    if($conn = Transaction::get())
    {  Transaction::log($sql);
      $conn->query($sql); 
    }
    else{
      $conn->rollback();
      throw new Exception('Não há transação ativa');
    }
    

  }

  // prepara as strings colocando dá forma correta para consulta 
  public function prepared($data) {
    
    $prepared = array();
     foreach($data as $key => $value) {
      if(is_scalar($value)){

        $prepared[$key] = $this->escape($value);
      }
     }  
     return $prepared;
  }


  public function escape($value){

     if (is_string($value) and (!empty($value)))
     {
      // add \ em aspas 
      $value = addslashes($value);
      return "'$value' ";
     } 
     else if  (is_bool($value)) {

        return $value ? 'TRUE':'FALSE';
     } else if($value !== '') {
       
       return $value;
     } else {
        return "NULL";
     }

  }
    
}



