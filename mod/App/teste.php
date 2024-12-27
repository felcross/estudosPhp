<?php
require_once 'autoloadApp.php';
require_once 'vendor/autoload.php';


use Controller\PageControl;
use Twig\Attribute\FirstClassTwigCallableReady;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class teste extends PageControl{

   public function __construct()
   {
        //$loader = new FirstClassTwigCallableReady();
        $loader = new FilesystemLoader('Templates');
        $twig = new Environment($loader);
        $template = $twig->load('form.html');

        $replaces =[];
        $replaces['nome'] = 'Deu bom';
        $replaces['Password'] = 'Deu bom 2';
        $replaces['action'] = 'index.php?class=\Page\TwigControl&method=onGravar';

        print $template->render($replaces);

       
   } 


   public function gravar($param)
    {
        var_dump($param);
    }

}








/*
use Database\Conn;
use Database\Transaction;
use Log\LoggerTXT;
use Database\Criteria;
use Database\Repository;
use Model\Pessoa;
use Model\ProdutoRecord;

//$obj1 = Conn::open('config');
//var_dump($obj1);


try{ 

    

    Transaction::open('configCasa');
    Transaction::setLogger(new LoggerTXT('log.txt'));

  //$obj2 = new Pessoa(21);
   $obj1 = new ProdutoRecord(7);
 var_dump($obj1);


  //var_dump($_SERVER['DOCUMENT_ROOT']);



    
/*
    
$criteria = new Criteria;
$criteria->add('estoque','>',10 ,'or');
$criteria->add('origem','=','N');
//$criteria2 = new Criteria;
//$criteria2->add('origem','=','N');

 $repository = new Repository('Produto');
 $produtos = $repository->load($criteria);

 var_dump($produtos);

 if($produtos)
 {
     foreach($produtos as $produto)
     {
         print 'Id:' . $produto->id;
         print '- Descrição:' . $produto->descricao;
         print '- Estoque:' . $produto->estoque;
         print '<br>';
     }
 }

 $Qtd = $repository->count($criteria);

 print  'Quantidade: ' . $Qtd;




//print $criteria->dump() . "<br>";
     


  Transaction::close();


  } catch(Exception $e){

     return $e->getMessage();
    Transaction::rollback();
  } */