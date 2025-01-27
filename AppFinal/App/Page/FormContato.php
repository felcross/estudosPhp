<?php
namespace Page;
use Components\Widgets\Combo;
use Components\Widgets\Form;
use Components\Widgets\Text;
use Controller\PageControl;
use Components\Decorator\FormWrapper;
use Components\Widgets\Entry;
use Controller\Action;
use  Components\Dialog\Message;
use Exception;
use stdClass;

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

         
         
        

         $assunto->addItems(['1' => 'Sugestão',
                             '2' => 'Reclamação',
                             '3' => 'Mensagem']);

      $this->form->addField('Nome',$nome,'300px');
      $this->form->addField('Email',$email,'300px');
      $this->form->addField('Assunto',$assunto,'300px');
      $this->form->addField('Mensagem',$mensagem);

      $mensagem->setSize(300,80);

        $this->form->addAction('Enviar', new Action([$this,'onSend']));
         parent::add($this->form);
      }


      public function onSend($params)
      {  
           
            //mantem as informações no formulario
           //$this->form->setData($data);
           try{
               $data = $this->form->getData();
                
               if(empty($data->email)){

                  throw new Exception('Email Vazio');
               }

               if(empty($data->nome)){

                  throw new Exception('Nome vazio');
               }     

               print_r($data);

               $res =  "Nome:{$data->nome}<br>";
               $res .= "Email:{$data->email}<br>";

               new Message('info',$res);
               

            } catch(Exception $e)
            {      
                  new Message('error', $e->getMessage());
 
            }  
 
      }

      public function onload() 
      {
            $data= new stdClass;
            $data->nome = 'seu nome';
            $data->email = 'seu email';

            $this->form->setData($data);
 
       }
}