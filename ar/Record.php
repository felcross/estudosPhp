
<?php
abstract class Record
{
    Private $data;
    
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

  public function load($id){}
  public function store(){}
  public function delete(){}
    
}


class ProdutoRecord extends Record {

 const TABLENAME = 'Produto' ;





}
