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
use Components\Widgets\CheckGroup;
use Components\Widgets\RadioGroup;
use Database\Transaction;
use Exception;
use Model\Funcionario;
use stdClass;

class FormFuncionario extends PageControl 
{     
     
      private $form;
      public function __construct()
      {
         parent::__construct();
         
         $this->form = new FormWrapper(new Form('form_funcionario'));
         $this->form->setTitle('Cadastro de Funcionário');
          
          $id = new Entry('id');
          $id->setEditable(false);
         $nome = new Entry('nome');
         $endereco = new Entry('endereco');
         $email = new Entry('email');
         
         $departamento = new Combo('departamento');
         $idiomas = new CheckGroup('idiomas');
         $contrato = new RadioGroup('contrato');
  
      $this->form->addField( 'Id',$id,'80');
      $this->form->addField( 'Nome',$nome,'300px');
      $this->form->addField('Email',$email,'300px');
      $this->form->addField('Endereço',$endereco,'300px');
      $this->form->addField('Departamento',$departamento);
      $this->form->addField('Idiomas',$idiomas);
      $this->form->addField('Contratação',$contrato);

      $departamento->addItems(['1' => 'RH',
                             '2' => 'Atendimento',
                             '3' => 'Engenharia']);
                             
       $idiomas->addItems(['1' => 'Inglês',
                             '2' => 'Francês',
                             '3' => 'Italiano']);

      $contrato->addItems(['1' => 'CLT',
                           '2' => 'PJ',
                           '3' => 'Estágio']);

       $departamento->setSize(150,80);

        $this->form->addAction('Enviar', new Action([$this,'onSave']));

         parent::add($this->form);
      }


      public function onSave() 
      {   
           try{
                 Transaction::open('config');
               $data = $this->form->getData();
               if(empty($data->nome)){

                  throw new Exception('Compo Nome vazio');
               }

               $funcionario = new Funcionario();
               $funcionario->fromArray((array) $data);
               $funcionario->idiomas = implode(',',(array) $data->idiomas);
               $funcionario->store();

              // $data->id = $funcionario->id;

               //$this->form->setData($data);

               new Message('info','Dados salvos com Sucesso');

                /*$funcionario->nome = $data->nome;
                $funcionario->endereco = $data->endereco;
                $funcionario->email = $data->email;
                $funcionario->departamento = $data->departamento;
                $funcionario->idiomas = $data->idiomas;
                $funcionario->contrato = $data->contrato;*/
            


                 Transaction::close();


           }
           catch(Exception $e){

              new Message('error', $e->getMessage());
           }
         
      }


      public function onSend($params)
      {  
           
            //mantem as informações no formulario
           //$this->form->setData($data);
           try{
               $data = $this->form->getData();
                
               if(empty($data->nome)){

                  throw new Exception('Compo Nome vazio');
               }
            
               if(empty($data->end)){

                  throw new Exception('Compo Endereço vazio');
               }

               if(empty($data->email)){

                  throw new Exception('Compo Email vazio');
               }     

              // print_r($data);

               $res =  "Nome:{$data->nome}<br>";
               $res .= "End:{$data->endereco}<br>";
               $res .= "Email:{$data->email}<br>";

               new Message('info',$res);
               

            } catch(Exception $e)
            {      
                  new Message('error', $e->getMessage());
 
            }  
 
      }

      public function onEdit($param) 
      {
           try{        Transaction::open('config');
                     $id = isset($param['id'])? $param['id'] : null;
                     $funcionario = Funcionario::find($id);
                     if($funcionario)
                     {        if(isset($funcionario->idiomas))
                              {       
                                    $funcionario->idiomas = explode(',',$funcionario->idiomas);
                              }
                             
                         $this->form->setData($funcionario);

                     }
                       Transaction::close();
                        

              

           }catch(Exception $e)
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