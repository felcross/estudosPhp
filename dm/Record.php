
<?php
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
      . '(' . implode(array_keys($this->data)) . ')' . 'values' . '(' . implode(array_values($this->data)) . ')'; 

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
    
}


class ProdutoRecord extends Record {

 const TABLENAME = 'Produto' ;





}
