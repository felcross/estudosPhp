<?php


class Login
{
    public static function  is_logado():bool
    {
        // função nativa do PHP pra chamar todas as sessoes
        session_start();
           
        
      // verificando se a sessão existe. 
        if(isset($_SESSION['tokenSessionLogin'])) {

            return true;

        } 
        
        return false;

    }
   
}
