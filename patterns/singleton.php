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
            return $this->data[$key] = $value;
        } 
       
        public function save() {
           // metodo pra gravar preferencias no arquivo caso seja modificado 
          $string = '';
          //percorrendo esse vetor de dados e escrevendo novamente no arquivo 
          if($this->data){
            foreach($this->data as $key => $value) {
                 // montando string 
                  $string . "{$key} = \" {$value}\" \n";
            }
          }
          // gravando novamente no arquivo
          file_put_contents('application.ini',$string);
      }



       

 }


?>