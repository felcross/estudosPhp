<?php 

 class CSVParser {
       private $filename;
       private $separador;
       private $contador;
       private $data;
       private $header;
       public function __construct($filename,$separador=',')
       {
          $this->filename = $filename;
          $this->separador = $separador;
          $this->contador = 1;
       }

       public function parse()
       {  
             if(!file_exists($this->filename)){
               throw new Exception("Arquivo {$this->filename} não encontrado");
             }
             if(!is_readable($this->filename)){
              throw new Exception("Arquivo {$this->filename} não encontrado");
            }
         
         /* func FILE ler o arquivo e retorna um vetor sendo cada linha do arq um vetor*/ 
           $this->data = file($this->filename);
          /* func str_getcsv  quebra strings de arq csv, param vetor, param separador*/  
           $this->header = str_getcsv($this->data[0],$this->separador);
           return TRUE;
       }

       public function fetch()
       {  //verifica se existe linhas no arq para ler 
          if(isset($this->data[$this->contador]))
          {  
            //row agora é um vetor de strings de uma linha
            $row = str_getcsv($this->data[$this->contador++],$this->separador);
            foreach($row as $key => $value)
            {
                $row[$this->header[$key]] = $value;    
            }
            return $row;
          }
       }
 }