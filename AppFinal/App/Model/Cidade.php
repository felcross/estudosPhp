<?php
namespace Model;
use Database\Record;
use Model\Estado;
use Database\Transaction;
use Exception;


class Cidade extends Record
{
    const TABLENAME = 'cidade';
    private $estado;
    
    public function get_estado()
    {   
        if (empty($this->estado))
        {    
            $this->estado = new Estado($this->id_estado);
        }
        
        return $this->estado;
    }
    
    public function get_nome_estado()
    {
        if (empty($this->estado))
        {
            $this->estado = new Estado($this->id_estado);
        }
        
        return $this->estado->nome;
    }



}