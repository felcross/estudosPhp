<?php
namespace Page;

use Controller\PageControl;
use Controller\Action;
use Components\Widgets\Form;
use Components\Widgets\Entry;
use Components\Container\VBox;
use Components\Widgets\Datagrid;
use Components\Widgets\DatagridColumn;
use Components\Dialog\Message;
use Components\Dialog\Question;
use Components\Container\Panel;
use Components\Decorator\FormWrapper;
use Components\Decorator\DatagridWrapper;
use Database\Transaction;
use Database\Repository;
use Database\Criteria;
use Exception;
use Model\Pessoa;
use Page\FormPessoa;

/**
 * Listagem de Pessoas
 */
class PessoasList extends PageControl
{
    private $form;     // formulário de buscas
    private $datagrid; // listagem
    private $loaded;

    /**
     * Construtor da página
     */
    public function __construct()
    {
        parent::__construct();
        
        // instancia um formulário de buscas
        $this->form = new FormWrapper(new Form('form_busca_pessoas'));
        $this->form->setTitle('Clientes');
        
        $nome = new Entry('nome');
        $this->form->addField('Nome', $nome, '100%');
        $this->form->addAction('Buscar', new Action(array($this, 'onReload')));
        $this->form->addAction('Novo', new Action(array(new FormPessoa, 'onEdit')));
        
        // instancia objeto Datagrid
        $this->datagrid = new DatagridWrapper(new Datagrid);

        // instancia as colunas da Datagrid
        $codigo   = new DatagridColumn('id',         'Código', 'center', '10%');
        $nome     = new DatagridColumn('nome',       'Nome',    'left', '40%');
        $endereco = new DatagridColumn('endereco',   'Endereco','left', '30%');
        $bairro   = new DatagridColumn('bairro','Bairro', 'left', '20%');

        // adiciona as colunas à Datagrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($nome);
        $this->datagrid->addColumn($endereco);
        $this->datagrid->addColumn($bairro);

        $this->datagrid->addAction( 'Editar',  new Action([new FormPessoa, 'onEdit']), 'id', 'bi bi-pencil');
        $this->datagrid->addAction( 'Excluir',  new Action([$this, 'onDelete']),         'id', 'bi bi-trash3');
        
        // monta a página através de uma caixa
        $box = new VBox;
        $box->style = 'display:block';
        $box->add($this->form);
        $box->add($this->datagrid);
        
        parent::add($box);
    }

    /**
     * Carrega a Datagrid com os objetos do banco de dados
     */
    public function onReload()
    {
        Transaction::open('configLoja'); // inicia transação com o BD
        $repository = new Repository('Pessoa');

        // cria um critério de seleção de dados
        $criteria = new Criteria;
        $criteria->setProperty('order', 'id');

        // obtém os dados do formulário de buscas
        $dados = $this->form->getData();

        // verifica se o usuário preencheu o formulário
        if ($dados->nome)
        {
            // filtra pelo nome do pessoa
            $criteria->add('nome', 'like', "%{$dados->nome}%");


        }

        // carrega os produtos que satisfazem o critério
        $pessoas = $repository->load($criteria);

        $this->datagrid->clear();
        if ($pessoas)
        {
            foreach ($pessoas as $pessoa)
            {
                // adiciona o objeto na Datagrid
                $this->datagrid->addItem($pessoa);
   
               
            }
        }

        // finaliza a transação
        Transaction::close();
        $this->loaded = true;
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

    /**
     * Exclui um registro
     */
    public function Delete($param)
    {
        try
        {
            $id = $param['id']; // obtém a chave
            Transaction::open('configLoja'); // inicia transação com o banco 'livro'
            $pessoa = Pessoa::find($id);
            $pessoa->delete(); // deleta objeto do banco de dados
            Transaction::close(); // finaliza a transação
            $this->onReload(); // recarrega a datagrid
            new Message('info', "Registro excluído com sucesso");
        }
        catch (Exception $e)
        {
            new Message('error', $e->getMessage());
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
