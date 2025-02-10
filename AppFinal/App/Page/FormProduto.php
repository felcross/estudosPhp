<?php
namespace Page;

use Controller\PageControl;
use Controller\Action;
use Components\Widgets\Form;
use Components\Widgets\Entry;
use Components\Widgets\Combo;
use Components\Widgets\RadioGroup;
use Database\Transaction;
use Database\Repository;
use Traits\SaveTrait;
use Traits\EditTrait;


use Components\Decorator\FormWrapper;



use Model\Fabricante;
use Model\Tipo;
use Model\Unidade;

/**
 * Cadastro de Produtos
 */
class FormProduto extends PageControl
{
    private $form; // formulário
    private $connection;
    private $activeRecord;

    use SaveTrait;
    use EditTrait;

     
    
    
    
    /**
     * Construtor da página
     */
    public function __construct()
    {
        parent::__construct();

        $this->connection = 'configCasa2';
        $this->activeRecord = 'produto';
        
        // instancia um formulário
        $this->form = new FormWrapper(new Form('form_produtos'));
        $this->form->setTitle('Produto');
        
        // cria os campos do formulário
        $codigo      = new Entry('id');
        $descricao   = new Entry('descricao');
        $estoque     = new Entry('estoque');
        $preco_custo = new Entry('preco_custo');
        $preco_venda = new Entry('preco_venda');
        $fabricante  = new Combo('id_fabricante');
        $tipo        = new RadioGroup('id_tipo');
        $unidade     = new Combo('id_unidade');
        
        // carrega os fabricantes do banco de dados
        Transaction::open('configCasa2');

        $repository = new Repository('fabricante');
        $fabricantes = $repository->all();
        $items = array();
        foreach ($fabricantes as $obj_fabricante) {
            $items[$obj_fabricante->id] = $obj_fabricante->nome;
        }
        $fabricante->addItems($items);
        
        $repository = new Repository('tipo');
        $tipos = $repository->all();
        $items = array();
        foreach ($tipos as $obj_tipo) {
            $items[$obj_tipo->id] = $obj_tipo->nome;
        }
        $tipo->addItems($items);
        
        $repository = new Repository('unidade');
        $unidades = $repository->all();
        $items = array();
        foreach ($unidades as $obj_unidade) {
            $items[$obj_unidade->id] = $obj_unidade->nome;
        }
        $unidade->addItems($items);
        Transaction::close();
        
        // define alguns atributos para os campos do formulário
        $codigo->setEditable(FALSE);
        
        $this->form->addField('Código',    $codigo, '30%');
        $this->form->addField('Descrição', $descricao, '70%');
        $this->form->addField('Estoque',   $estoque, '70%');
        $this->form->addField('Preço custo',   $preco_custo, '70%');
        $this->form->addField('Preço venda',   $preco_venda, '70%');
        $this->form->addField('Fabricante',   $fabricante, '70%');
        $this->form->addField('Tipo',   $tipo, '70%');
        $this->form->addField('Unidade',   $unidade, '70%');
        $this->form->addAction('Salvar', new Action(array($this, 'onSave')));
        
        // adiciona o formulário na página
        parent::add($this->form);
    }
}
