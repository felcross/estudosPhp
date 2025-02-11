<?php
namespace Page;

use Controller\PageControl;
use Controller\Action;
use Components\Widgets\Form;
use Components\Widgets\Entry;
use Components\Container\VBox;
use Components\Widgets\Datagrid;
use Components\Widgets\DatagridColumn;
use Components\Decorator\FormWrapper;
use Components\Decorator\DatagridWrapper;
use Traits\DeleteTrait;
use Traits\ReloadTrait;
use Traits\SaveTrait;
use Database\Transaction;
use Model\Fabricante;


/*
 * classe FabricantesFormList
 * Cadastro de Fabricantes
 * Contém o formuláro e a listagem
 */
class FabricanteFormList extends PageControl
{
    private $form;      // formulário de cadastro
    private $datagrid;  // listagem
    private $loaded;
    private $connection;
    private $activeRecord;
    
    use DeleteTrait;
    use ReloadTrait {
        onReload as onReloadTrait;
    }
    use SaveTrait {
        onSave as onSaveTrait;
    }
    
    
    /*
     * método construtor
     * Cria a página, o formulário e a listagem
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->activeRecord = 'Fabricante';
        $this->connection   = 'configLoja';
        
        // instancia um formulário
        $this->form = new FormWrapper(new Form('form_fabricantes'));
        $this->form->setTitle('Fabricantes');
        
        // cria os campos do formulário
        $codigo = new Entry('id');
        $nome   = new Entry('nome');
        $site   = new Entry('site');
        $codigo->setEditable(FALSE);
        
        $this->form->addField('Código', $codigo, '30%');
        $this->form->addField('Nome',   $nome, '70%');
        $this->form->addField('Site',   $site, '70%');
        $this->form->addAction('Salvar', new Action(array($this, 'onSave')));
        $this->form->addAction('Limpar', new Action(array($this, 'onEdit')));
        
        // instancia objeto DataGrid
        $this->datagrid = new DatagridWrapper(new DataGrid);
        
        // instancia as colunas da DataGrid
        $codigo   = new DataGridColumn('id',       'Código',  'center',  '10%');
        $nome     = new DataGridColumn('nome',     'Nome',    'left',  '60%');
        $site     = new DataGridColumn('site',     'Site',    'left',  '30%');
        
        // adiciona as colunas à DataGrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($nome);
        $this->datagrid->addColumn($site);
        
        $this->datagrid->addAction( 'Editar',  new Action([$this, 'onEdit']),   'id', 'bi bi-pencil');
        $this->datagrid->addAction( 'Excluir', new Action([$this, 'Delete']), 'id', 'bi bi-trash3');
        
        // monta a página através de uma caixa
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
    
    /**
     * Carrega os dados
     */
    public function onReload()
    {
        $this->onReloadTrait();   
        $this->loaded = true;
    }
    
    /**
     * Carrega registro para edição
     */
    public function onEdit($param)
    {
        if (isset($param['key']))
        {
            $key = $param['key']; // obtém a chave
            Transaction::open('livro'); // inicia transação com o BD
            $fabricante = Fabricante::find($key); // instancia o Active Record
            $this->form->setData($fabricante); // lança os dados no formulário
            Transaction::close(); // finaliza a transação
            $this->onReload();
        }
    }
    
    /**
     * Exibe a página
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
