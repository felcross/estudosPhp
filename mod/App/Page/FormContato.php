<?php
namespace Page;
use Components\Widgets\Combo;
use Components\Widgets\Form;
use Components\Widgets\Text;
use Controller\PageControl;
use Components\Decorator\FormWrapper;
use Components\Widgets\Entry;
use Components\Widgets\Label;
use Controller\Action;

class FormContato extends PageControl 
{     
     
      private $form;
      public function __construct()
      {
         parent::__construct();
         
         $this->form = new FormWrapper(new Form('form_contato'));
         $this->form->setTitle('Formulario de Contato');

         $nome = new Entry('nome');
         $email = new Entry('email');
         $assunto = new Combo('assunto');
         $mensagem = new Text('mensagem');
         $label = new Label('Nome');

         $assunto->addItems(['1' => 'Sugestão',
                             '2' => 'Reclação',
                             '3' => 'Mensagem']);

      $this->form->addField( 'nome',$nome);
      $this->form->addField('email',$email);
      $this->form->addField('assunto',$assunto);
      $this->form->addField('mensagem',$mensagem );

      $mensagem->setSize(300,80);

        $this->form->addAction('enviar', new Action([$this,'onSend']));
         parent::add($this->form);
      }


      public function onSend(){}
}