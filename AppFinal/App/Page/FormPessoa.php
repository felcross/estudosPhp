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


class FormPessoa extends PageControl 
{
     private $form;
     public function __construct()
     {  
            parent::__construct();

            $this->form = new FormWrapper(new Form('Form_cli'));
            $this->form->setTitle('Cadastro de Clientes');

            $nome = new Entry('nome');
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

              foreach( $cidades as $obj_cidade)
               {      //indice                  // valor 
               $itens[$obj_cidade->id] =  $obj_cidade->nome;
                }

             $cidade->addItems($itens);
             
             $repository = new Repository('Grupo');
             $grupos = $repository->all();
             $itensGrupos = array();

             foreach( $grupos as $obj_grupo)
             {      //indice                  // valor 
                $itensGrupos[$obj_grupo->id] =  $obj_grupo->nome;
             }

             $grupo->addItems($itensGrupos);

            
            
            Transaction::close();
            
       
           
     
       //  $this->form->addField( 'Id',$id,'80');
         $this->form->addField( 'Nome',$nome,'300px');
         $this->form->addField('Email',$email,'300px');
         $this->form->addField('Endereço',$endereco,'300px');
         $this->form->addField('Bairro',$bairro,'300px');
         $this->form->addField('Telefone',$tel,'300px');
         $this->form->addField('Cidade',$cidade,'300px');
         $this->form->addField('Grupo',$grupo,'300px');
        
        
         
           $this->form->addAction('Enviar', new Action([$this,'onSave']));
   
            parent::add($this->form);

    }


    public function onSave() 
      {   
           try{
                 Transaction::open('config');
        
            


                 Transaction::close();


           }
           catch(Exception $e){

              new Message('error', $e->getMessage());
           }
         
      }


}