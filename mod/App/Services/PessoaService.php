<?php
namespace Services;
use Database\Transaction;
use Exception;
use Log\LoggerTXT;
use Model\Pessoa;

class PessoaService  {


   public static function getData($request) 
   {  
        $id_pessoa = $request['id'];

        Transaction::open('configCasa');
        Transaction::setLogger(new LoggerTXT('log.txt'));
      //trás do banco o OBJ 
        $pessoa = Pessoa::find($id_pessoa);

        if($pessoa) 
        {  //converte em vetor para ser tratado do outro lado.
           $pessoa_array = $pessoa->toArray();

        } else  {
            throw new Exception("Pessoa{$id_pessoa} Não existe ");
        }
        Transaction::close();
        return $pessoa_array;


   }


}