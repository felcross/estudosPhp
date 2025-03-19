<?php
namespace Page;

use Controller\PageControl;
use Database\Record;
use Database\Transaction;
use Database\Repository;
use Exception;
use Model\Funcionario;
use Core\Session;
use PDO;

class teste extends PageControl{

    public function teste(){

      Session::set('teste','jwt');

      Session::dump();

    }
    public  function listar() {
        try{
             //PDO está configurado pra trazer a linha como obj
           //$db =  new PDO('sqlite:loja.db','','',[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]);

          /* $db->exec("INSERT INTO funcionario (nome, email, contrato) VALUES
           ('Carlos Silva', 'carlos.silva@email.com','CLT'),
           ('Mariana Souza', 'mariana.souza@email.com', 'PJ'),
           ('Roberto Lima', 'roberto.lima@email.com','CLT'),
           ('Fernanda Alves', 'fernanda.alves@email.com','Freelancer');
           ");*/
         
       
       /*   $result = $db->query("select rowid,*  from funcionario");
           $funcionarios =  $result->fetchAll(); 

        foreach($funcionarios as $key => $funcionario )
        {
           echo $funcionario->nome;
        }*/

         
           $funcionario = new Funcionario();

          $teste = $funcionario->findby('contrato','CLT');

            var_dump($teste);


          
          
       

        }
        
        catch(Exception $e)
        {
            print  $e->getMessage();           
         }
    }

    public  function buscar() {
        try{  

           $user = new Funcionario();

           $funcionarios =  $user->all();

           foreach($funcionarios as $key => $funcionario )
           {
              echo $funcionario->nome . '<br>';
              echo $funcionario->contrato . '<br>';
           }
           

             


        }
        
        catch(Exception $e)
        {
            print  $e->getMessage();           
         }
    }

    public function view() {

          ob_start();

          echo 'home';
          
          $content = ob_get_contents();

          ob_end_clean();

          var_dump('content', $content);
    }
   
}