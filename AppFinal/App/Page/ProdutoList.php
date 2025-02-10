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
use Components\Dialog\Question;
use Traits\DeleteTrait;
use Traits\ReloadTrait;
use Database\Transaction;
use Database\Repository;
use Database\Criteria;
use Exception;
use Model\Pessoa;

/**
 * Listagem de Pessoas
 */
class ProdutoList extends PageControl
{  private $form;
    private $datagrid;
    private $loaded;
    private $connection;
    private $activeRecord;
    private $filters;
    
    use DeleteTrait;
    use ReloadTrait {
        onReload as onReloadTrait;
    }
    
    /**
     * Construtor da página
     */
    public function __construct()
    {
        parent::__construct();
        
        // Define o Active Record
        $this->activeRecord = 'Produto';
        $this->connection   = 'configCasa2';
        
        // instancia um formulário
        $this->form = new FormWrapper(new Form('form_busca_produtos'));
        $this->form->setTitle('Produtos');
        
        // cria os campos do formulário
        $descricao = new Entry('descricao');
        
        $this->form->addField('Descrição',   $descricao, '100%');
        $this->form->addAction('Buscar', new Action(array($this, 'onReload')));
        $this->form->addAction('Cadastrar', new Action(array(new FormProduto, 'onEdit')));
        
        // instancia objeto Datagrid
        $this->datagrid = new DatagridWrapper(new Datagrid);
        
        // instancia as colunas da Datagrid
        $codigo   = new DatagridColumn('id',             'Código',    'center',  '10%');
        $descricao= new DatagridColumn('descricao',      'Descrição', 'left',   '30%');
        $fabrica  = new DatagridColumn('id_fabricante','Fabricante','left',   '30%');
        $estoque  = new DatagridColumn('estoque',        'Estoq.',    'right',  '15%');
        $preco    = new DatagridColumn('preco_venda',    'Venda',     'right',  '15%');
        
        // adiciona as colunas à Datagrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($descricao);
        $this->datagrid->addColumn($fabrica);
        $this->datagrid->addColumn($estoque);
        $this->datagrid->addColumn($preco);
        
        $this->datagrid->addAction( 'Editar',  new Action([new FormProduto, 'onEdit']), 'id', 'bi bi-pencil');
        $this->datagrid->addAction( 'Excluir', new Action([$this, 'onDelete']),          'id', 'bi bi-trash3');
        
        // monta a página através de uma caixa
        $box = new VBox;
        $box->style = 'display:block';
        $box->add($this->form);
        $box->add($this->datagrid);
        
        parent::add($box);
    }


    /**
     * Pergunta sobre a exclusão de registro
     */
    public function onDelete($param)
    {
        $id = $param['id']; // obtém o parâmetro $id
        $action1 = new Action(array($this, 'Delete'));
        $action1->setParameter('id', $id);
        
        new Question('Deseja realmente excluir o registro?', $action1);
    }
    
    public function onReload()
    {
        // obtém os dados do formulário de buscas
        $dados = $this->form->getData();
        
        // verifica se o usuário preencheu o formulário
        if ($dados->descricao)
        {
            // filtra pela descrição do produto
            $this->filters[] = ['descricao', 'like', "%{$dados->descricao}%", 'and'];
        }
        
        $this->onReloadTrait();   
        $this->loaded = true;
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
   
   
   