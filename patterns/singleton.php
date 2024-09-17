<?php 
namespace patterns;

 class singleton {

       private $data;
       private static $instance;

       private function __construct() {
            //vetor que guarda as preferencias da aplicação
            $this->data = parse_ini_file('application.ini');
       }

       public static function  getInstance()
       {   if(empty(self::$instance)) 
           //não existindo ele cria 
          {self::$instance = new self;}
          // existindo ele devolve a instacia já criada
            return self::$instance; }


      //metodos pra manipular o vetor
        public function getData($key){
            //buscando uma chave e trazendo o valor 
            return $this->data[$key];
        } 

        public function setData($key,$value){
            //setando um valor na posição X[key] que é igual a value 
            //$string = '';
            $string = "{$key} = \"{$value}\"";
            //var_dump($string);
            //return $this->data[$key] = $value;
            file_put_contents('application.ini',$string);
            
        } 
       
        public function save() {
           // metodo pra gravar preferencias no arquivo caso seja modificado 
          $string = '';
          var_dump($string);
          //percorrendo esse vetor de dados e escrevendo novamente no arquivo 
          if($this->data){
            foreach($this->data as $key => $value) {
                 // montando string 
                  $string . "{$key} = \" {$value}\" \n";
            }
          var_dump($string);
          //file_put_contents('application.ini',$string);
          }
             // gravando novamente no arquivo
             file_put_contents('application.ini',$string);
          
      }



       

 }


?>