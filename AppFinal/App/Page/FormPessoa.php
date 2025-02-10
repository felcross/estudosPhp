<?php

namespace Page;

use Components\Widgets\Form;
use Controller\PageControl;
use Components\Decorator\FormWrapper;
use Components\Widgets\Button;
use Components\Widgets\Combo;
use Components\Widgets\Entry;
use Components\Widgets\CheckGroup;
use COmponents\Widgets\RadioGroup;
use Controller\Action;
use Database\Transaction;
use Components\Dialog\Message;
use Database\Repository;
use Model\Grupo;
use Exception;
use Model\Pessoa;

class FormPessoa extends PageControl
{
   private $form;
   public function __construct()
   {
      parent::__construct();

      $this->form = new FormWrapper(new Form('Form_cli'));
      $this->form->setTitle('Cadastro de Clientes');

      $id = new Entry('id');
      $id->setEditable(false);
      $nome =  new Entry('nome');
      $endereco = new Entry('endereco');
      $bairro = new Entry('bairro');
      $tel = new Entry('telefone');
      $email = new Entry('email');
      $cidade = new Combo('id_cidade');
      $grupo = new CheckGroup('id_grupo');
      $grupo->setLayout('horizontal');

      Transaction::open('configCasa2');
      $repository = new Repository('cidade');
      $cidades = $repository->all();
      $itens = array();

      foreach ($cidades as $obj_cidade) {      //indice                  // valor 
         $itens[$obj_cidade->id] =  $obj_cidade->nome;
      }

      $cidade->addItems($itens);

      $repository = new Repository('Grupo');
      $grupos = $repository->all();
      $itensGrupos = array();

      foreach ($grupos as $obj_grupo) {      //indice                  // valor 
         $itensGrupos[$obj_grupo->id] =  $obj_grupo->nome;
      }

      $grupo->addItems($itensGrupos);



      Transaction::close();



      $this->form->addField('Id', $id, '50px');
      $this->form->addField('Nome', $nome, '300px');
      $this->form->addField('Email', $email, '300px');
      $this->form->addField('Endereço', $endereco, '300px');
      $this->form->addField('Bairro', $bairro, '300px');
      $this->form->addField('Telefone', $tel, '300px');
      $this->form->addField('Cidade', $cidade, '300px');
      $this->form->addField('Grupo', $grupo, '300px');



      $this->form->addAction('Enviar', new Action([$this, 'onSave']));
      $this->form->addAction('Editar', new Action([$this, 'onEdit']),'id');

      parent::add($this->form);
   }


   public function onSave()
   {
      try {
         Transaction::open('configLoja');
         // puxando o dados do form, vem em Objeto
         $dados = $this->form->getData();
         // matendo o form preenchido após post
        // $this->form->setData($dados);

         //cria um objeto vazio
         $pessoa = new Pessoa;
         $pessoa->fromArray( (array) $dados);
         $pessoa->store();
         $pessoa->delGrupos();


         if ($dados->id_grupo) {
            foreach ($dados->id_grupo as $id_grupo) {
               $pessoa->addGrupo(new Grupo($id_grupo));
               
            }
         }
        Transaction::close();

        new Message('info', 'Dados Salvos com sucesso');
      } catch (Exception $e) {

         new Message('error', $e->getMessage());
         Transaction::rollback();
      }
   }


   public function onEdit($param)
   {
      try {


         $id = isset($param['id']) ? $param['id'] : null;
         Transaction::open('configLoja');
         $p1 = Pessoa::find($id);

         if ($p1) {

            $p1->id_grupo = $p1->getIdsGrupos();
            $this->form->setData($p1);
         }





         Transaction::close();
      } catch (Exception $e) {

         new Message('error', $e->getMessage());
         Transaction::rollback();
      }
   }
}
