<?php
namespace Services;
use Database\Transaction;
use Exception;
use Log\LoggerTXT;
use Model\Pessoa;

class PessoaService  {


   public function getData($request) 
   {  
        $id_pessoa = $request['id'];

        Transaction::open('config');
        Transaction::setLogger(new LoggerTXT('log.txt'));

        $pessoa = Pessoa::find($id_pessoa);

        if($pessoa) 
        {
           $pessoa_array = $pessoa->toArray();

        } else  {
            throw new Exception("Pessoa{$id_pessoa} Não existe ");
        }
        Transaction::close();
        return $pessoa_array;


   }


}