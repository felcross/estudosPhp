<?php
namespace Page;

use Controller\PageControl;
use Controller\Action;
use Components\Widgets\Form;
use Components\Widgets\Entry;
use Components\Container\VBox;
use Components\Widgets\Datagrid;
use Components\Widgets\Combo;
use Components\Widgets\DatagridColumn;
use Components\Decorator\FormWrapper;
use Components\Decorator\DatagridWrapper;
use Database\Repository;
use Traits\DeleteTrait;
use Traits\ReloadTrait;
use Traits\SaveTrait;
use Traits\EditTrait;
use Database\Transaction;
use Components\Dialog\Message;
use Exception;

/**
 * Cadastro de cidades
 */
class CidadeFormList extends PageControl
{
    private $form;
    private $datagrid;
    private $loaded;
    private $connection;
    private $activeRecord;
    
    use EditTrait;
    use DeleteTrait;
    use ReloadTrait {
        onReload as onReloadTrait;
    }
    use SaveTrait {
        onSave as onSaveTrait;
    }

    
    /**
     * Construtor da página
     */
    public function __construct()
    {
        parent::__construct();

        $this->connection   = 'configLoja';
        $this->activeRecord = 'cidade';
        
        // instancia um formulário
        $this->form = new FormWrapper(new Form('form_cidades'));
        $this->form->setTitle('Cidades');
        
        // cria os campos do formulário
        $codigo    = new Entry('id');
        $descricao = new Entry('nome');
        $estado    = new Combo('id_estado');
        
        $codigo->setEditable(FALSE);
        
        Transaction::open('configLoja');

        $repository = new Repository('estado');
        $estados = $repository->all();
        $items = array();
        foreach ($estados as $obj_estado)
        {
            $items[$obj_estado->id] = $obj_estado->nome;
        }

        //Monta Form
        Transaction::close();
        
        $estado->addItems($items);
        
        $this->form->addField('Código', $codigo, '30%');
        $this->form->addField('Nome Cidade', $descricao, '70%');
        $this->form->addField('Estado', $estado, '70%');
        
        $this->form->addAction('Salvar', new Action(array($this, 'onSave')));
        $this->form->addAction('Limpar', new Action(array($this, 'onEdit')));
        
        // instancia a Datagrid
        $this->datagrid = new DatagridWrapper(new Datagrid);

        // instancia as colunas da Datagrid
        $codigo   = new DatagridColumn('id',     'Código', 'center', '10%');
      //  $estado   = new DatagridColumn('sigla','Sigla', 'center', '30%');
        $cidade   = new DatagridColumn('nome', 'Cidade', 'center', '30%');

        // adiciona as colunas à Datagrid
        $this->datagrid->addColumn($codigo);
      //  $this->datagrid->addColumn($estado);
        $this->datagrid->addColumn($cidade);

        $this->datagrid->addAction( 'Editar',  new Action([$this, 'onEdit']),   'id', 'fa fa-edit fa-lg blue');
        $this->datagrid->addAction( 'Excluir', new Action([$this, 'Delete']), 'id', 'fa fa-trash fa-lg red');
        
        // monta a página através de uma tabela
        $box = new VBox;
        $box->style = 'display:block';
        $box->add($this->form);
        $box->add($this->datagrid);
        
        
        parent::add($box);
    }
    
    /**
     * Salva os dados
     */
    public function onSave()
    {
        $this->onSaveTrait();
        $this->onReload();
    }



  /*  function onSave()
    {
        try
        {
            Transaction::open( $this->connection );
            $activeRecord = 'cidade';
            
            $class = 'Model\\' . $activeRecord;
            $dados = $this->form->getData();

            echo 'classseee' . $class;
            
            
            $object = new $class; // instancia objeto
            $object->fromArray( (array) $dados); // carrega os dados
            $object->store(); // armazena o objeto
            
            $dados->id = $object->id;
            $this->form->setData($dados);
            $this->onReload();
            
            Transaction::close(); // finaliza a transação
            new Message('info', 'Dados armazenados com sucesso');
            
        }
        catch (Exception $e)
        {
            new Message('error', $e->getMessage());
        }
    }*/

    
    /**
     * Carrega os dados
     */
    public function onReload()
    {
        $this->onReloadTrait();   
        $this->loaded = true;
    }

    /**
     * exibe a página
     */
    public function show()
    {
        // se a listagem ainda não foi carregada
        if (!$this->loaded)
        {
            $this->onReload();
        }
        parent::show();
    }
}
