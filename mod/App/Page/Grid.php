<?php
namespace Page;
use Controller\PageControl;
use Components\Decorator\DatagridWrapper;
use Components\Dialog\Message;
use Components\Widgets\Datagrid;
use Components\Widgets\DatagridColumn;
use Controller\Action;
use stdClass;

class Grid extends PageControl{

   private $datagrid;
    public function __construct()
    {
         parent::__construct();

         $this->datagrid = new DatagridWrapper(new Datagrid);
         // atributo, Label, Alinhamento, largura
          $codigo = new DatagridColumn('id','Código','center', '10%');
          $nome = new DatagridColumn('nome','Nome','left', '15%');
          $email = new DatagridColumn('email','Email','left', '15%');
          $assunto = new DatagridColumn('assunto','Assunto','left', '15%');

          
          $this->datagrid->addColumn($codigo);
          $this->datagrid->addColumn($nome);
          $this->datagrid->addColumn($email);
          $this->datagrid->addColumn($assunto);

          $nome->setTransformer( function($value){
            return strtoupper($value);
          });

        $this->datagrid->addAction('visualizar', new Action([$this, 'onMessage']),'nome');

          parent::add($this->datagrid);
    }

    public function onMessage($param){

        new Message('info', 'você clicou no registo: ' . $param['nome']);
    }


    public function onReload(){

        $this->datagrid->clear();
        
        $m1 = new stdClass; 
        $m1->id   = 1;
        $m1->nome = 'Maria';
        $m1->email = 'maria@asdfasf';
        $m1->assunto = 'Dúvida 1';
        $this->datagrid->addItem($m1);
        
        $m2 = new stdClass;
        $m2->id   = 2;
        $m2->nome = 'Pedro';
        $m2->email = 'pedro@asdfasf';
        $m2->assunto = 'Dúvida 2';
        $this->datagrid->addItem($m2);
        
        $m3 = new stdClass;
        $m3->id   = 3;
        $m3->nome = 'José';
        $m3->email = 'jose@asdfasf';
        $m3->assunto = 'Dúvida 3';
        $this->datagrid->addItem($m3);
    }

   // quando desejo carregar os dados junto com a tela. 
    public function show(){

        $this->onReload();
        parent::show();
    }

}