<?php
namespace Traits;

use Database\Transaction;
use Components\Dialog\Message;
use Model\Produto;
use Exception;

trait SaveTrait
{
    /**
     * Salva os dados do formulário
     */
    function onSave()
    {
        try
        {
            Transaction::open( $this->connection );
            
            $class = 'Model\\' . $this->activeRecord;
            $dados = $this->form->getData();

            echo 'classseee' . $class;
            
            
            $object = new $class; // instancia objeto
            $object->fromArray( (array) $dados); // carrega os dados
            $object->store(); // armazena o objeto
            
            $dados->id = $object->id;
            $this->form->setData($dados);
            
            Transaction::close(); // finaliza a transação
            new Message('info', 'Dados armazenados com sucesso');
            
        }
        catch (Exception $e)
        {
            new Message('error', $e->getMessage());
        }
    }
}
