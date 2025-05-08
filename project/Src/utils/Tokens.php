<?php

namespace utils;
use utils\Crypto;

class Tokens {

     /**
     * Função que gera Token CSRF.
     * @access public
     * @param string $regenerar - parametro para informar se o token deve ser regenerar
     * @return void
     */


     public static function geraTokenCSRF(string $regerar = "N"): void
     {
         if ($regerar != "S") {
             if (!isset($_SESSION['TokenCSRF'])) {
                 $resultado =  md5(date("ymdiss") . uniqid(mt_rand(), true));
                 $_SESSION['TokenCSRF'] = $resultado;
             }
         } else {
             $resultado =  md5(date("ymdiss") . uniqid(mt_rand(), true));
             $_SESSION['TokenCSRF'] = $resultado;
         }
     }


      /**
     * Função que cria chave Integrity para arquivos javascript
     * @access public
     * @param string $conteudo - nome do arquivo JS
     * @param string $caminho  - informa se precisa passar o caminho, ou seguir o padrão, caso sim, basta passá-lo pelo mesmo parametro
     * @return string
     */


    public static function chaveIntegrityJS(string $conteudo, string $caminho = "NO"): ?string
    {
        if ($caminho != "NO") {
            $scriptContent = file_get_contents(js .  $caminho . $conteudo);
        }
        if ($caminho == "NO") {
            $scriptContent = file_get_contents(js .  $conteudo);
        }
        if ($scriptContent !== false) {
            $hash = 'sha384-' . base64_encode(openssl_digest($scriptContent, 'sha384', true));
            return $hash;
        } else {

            return null;
        }
    }


     /**
     * Função que verifica o token CSRF
     * @access public
     * @param string $token
     * @return bool
     */


     public static function verificaTokenCSRF(string $token)
     {
 
 
         if ($_SESSION['TokenCSRF']) {
             $input = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');
             if ($input == $_SESSION['TokenCSRF']) {
                 return true;
             } else {
                 return false;
             }
         } else {
             return false;
         }
     }
 

}