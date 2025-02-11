<?php
namespace Page;
use Controller\PageControl;
use Components\Container\VBox;
use Components\Decorator\DatagridWrapper;
use Components\Decorator\FormWrapper;
use Components\Widgets\Form;
use Components\Dialog\Message;
use Components\Dialog\Question;
use Components\Widgets\Datagrid;
use Components\Widgets\DatagridColumn;
use Controller\Action;
use Database\Criteria;
use Database\Repository;
use Database\Transaction;
use Components\Widgets\Entry;
use Log\LoggerTXT;
use Exception;
use Model\Funcionario;
use stdClass;

class GridBusca extends PageControl{

   private $datagrid;
    public function __construct()
    {
         parent::__construct();
         // instancia um formulário
         $this->form = new FormWrapper(new Form('form_busca_funcionarios'));

         // cria os campos do formulário
         $nome = new Entry('nome');
         
         $this->form->addField('Nome', $nome, 300);
         
         $this->form->addAction('Buscar', new Action(array($this, 'onReload')));
         $this->form->addAction('Novo', new Action(array(new FormFuncionario, 'onEdit')));

        //classe que envelopa(MOSTRA) DatagridWrapper e classe qua guarda e manipula os dados DATAGRID , padrão decorador. 
         $this->datagrid = new DatagridWrapper(new Datagrid);
         // COLUNAS = atributo, Label, Alinhamento, largura
          $codigo = new DatagridColumn('id','Código','center', '10%');
          $nome = new DatagridColumn('nome','Nome','left', '15%');
          $email = new DatagridColumn('email','Email','left', '15%');
          //$assunto = new DatagridColumn('assunto','Assunto','left', '15%');

          $codigo_order = new Action(array($this, 'onReload'));
          $codigo_order->setParameter('order', 'id');
          $codigo->setAction( $codigo_order );
          
          $nome_order = new Action(array($this, 'onReload'));
          $nome_order->setParameter('order', 'nome');
          $nome->setAction( $nome_order );

          
          $this->datagrid->addColumn($codigo);
          $this->datagrid->addColumn($nome);
          $this->datagrid->addColumn($email);
          //$this->datagrid->addColumn($assunto);

          /*$nome->setTransformer( function($value){
            return strtoupper($value);
          });*/

       // $this->datagrid->addAction('visualizar', new Action([$this, 'onMessage']),'nome');
        $this->datagrid->addAction('Editar', new Action([new FormFuncionario, 'onEdit']),'id');
        $this->datagrid->addAction('Deletar', new Action([$this, 'onDelete']),'id');
          
           // monta a página através de uma caixa
        $box = new VBox;
        $box->style = 'display:block; margin: 20px';
        $box->add($this->form);
        $box->add($this->datagrid);
        
        parent::add($box);
          
    }

    public function onMessage($param){

        new Message('info', 'você clicou no registo: ' . $param['nome']);
    }

    public function onDelete($param){
     
      $action = new Action([$this,'delete']);
      $action->setParameter('id',$param['id']);
     new Question('Deseja excluir o registro ??', $action);
  }

  public function delete($param) 
  {      
        try{  
            Transaction::open('configLoja');
            $data = Funcionario::find($param['id']);

           
             if($data)
            {
              $data->delete($data->id);
            }
            Transaction::close();
            $this->onReload();

            new Message('info', 'Deletado com Sucesso');


        }
       catch(Exception $e)
       {
         new Message('erro', $e->getMessage());
       }

  }


    public function onReload($param =null){

        
      try{ 
        
        $this->datagrid->clear();
        Transaction::open('configLoja'); //iniciar transação com banco
        Transaction::setLogger(new LoggerTXT('log.txt'));
        $repository = new Repository('funcionario');
        //criar critério de seleçãod e dados  
        $criteria =  new Criteria;
        $criteria->setProperty('order',isset($param['order']) ? $param['order']: 'id');

        //obtém os dados do formulário de buscas
        $dados = $this->form->getData();
        
        // veririca se o user preencheu o form 
        if($dados->nome){
          //filtra
           $criteria->add('nome','like', "%{$dados->nome}%");

        }
         
        //carrega os dados que satisfazem o criterio

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