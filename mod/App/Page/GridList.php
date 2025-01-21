<?php
namespace Page;
use Controller\PageControl;
use Components\Decorator\DatagridWrapper;
use Components\Dialog\Message;
use Components\Widgets\Datagrid;
use Components\Widgets\DatagridColumn;
use Controller\Action;
use Database\Criteria;
use Database\Repository;
use Database\Transaction;
use Exception;
use stdClass;

class GridList extends PageControl{

   private $datagrid;
    public function __construct()
    {
         parent::__construct();
        //classe que envelopa(MOSTRA) DatagridWrapper e classe qua guarda e manipula os dados DATAGRID , padrão decorador. 
         $this->datagrid = new DatagridWrapper(new Datagrid);
         // COLUNAS = atributo, Label, Alinhamento, largura
          $codigo = new DatagridColumn('id','Código','center', '10%');
          $nome = new DatagridColumn('nome','Nome','left', '15%');
          $email = new DatagridColumn('email','Email','left', '15%');
          //$assunto = new DatagridColumn('assunto','Assunto','left', '15%');

          
          $this->datagrid->addColumn($codigo);
          $this->datagrid->addColumn($nome);
          $this->datagrid->addColumn($email);
          //$this->datagrid->addColumn($assunto);

          /*$nome->setTransformer( function($value){
            return strtoupper($value);
          });*/

        $this->datagrid->addAction('visualizar', new Action([$this, 'onMessage']),'nome');

          parent::add($this->datagrid);
    }

    public function onMessage($param){

        new Message('info', 'você clicou no registo: ' . $param['nome']);
    }


    public function onReload(){

        
      try{ 
        
        $this->datagrid->clear();
        Transaction::open('config');
        $repository = new Repository('funcionario');
        $criteria =  new Criteria;
        $criteria->setProperty('order','id');

        $funcionarios = $repository->load($criteria);

        if ($funcionarios)

        {
                foreach($funcionarios as $funcinario) 
                {
                   $this->datagrid->addItem($funcinario);
                }

        }





        Transaction::close();
        


      }catch(Exception $e)
      {      Transaction::rollback();
             new Message('info', $e->getMessage());
 
       }
       
      
    }

   // quando desejo carregar os dados junto com a tela. 
    public function show(){

        $this->onReload();
        parent::show();
    }

}