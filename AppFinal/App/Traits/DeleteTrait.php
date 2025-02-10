<?php
namespace Traits;

use Database\Transaction;
use Components\Dialog\Message;
use Exception;

trait DeleteTrait
{
    /**
     * Carrega registro para edição
     */
    function Delete($param)
    {
        try
        {
            if (isset($param['id']))
            {
                $id = $param['id']; // obtém a chave
                Transaction::open( $this->connection ); // inicia transação com o BD
                
                $class = 'Model\\' . $this->activeRecord;
                $object = $class::find($id); // instancia o Active Record
                $object->delete();
                $this->form->setData($object); // lança os dados no formulário
                Transaction::close(); // finaliza a transação
            }
        }
        catch (Exception $e)
        {
            new Message('error', $e->getMessage());
            Transaction::rollback();
        }
    }
}
