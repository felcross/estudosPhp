<?php


namespace utils;

class Crypto
{

   /**
 * Gera uma chave criptográfica aleatória e a salva em um arquivo.
 * 
 * Este método utiliza a função `openssl_random_pseudo_bytes` para gerar uma chave de 32 bytes 
 * (256 bits) e a armazena no arquivo "chave_privada.pem" localizado na pasta "./system/config".
 * Após salvar a chave, exibe uma mensagem informando o sucesso da operação e instruções sobre 
 * a configuração do usuário e o uso correto do comando.
 * 
 * @return void
 */
public static function gerarChaves(): void  
{
    $chave = openssl_random_pseudo_bytes(32); // Gera uma chave aleatória de 32 bytes (256 bits)
    file_put_contents(NomeSistema . "config/chave_privada.pem", $chave);
}


/**
     * Função que utiliza a chave gerada para criptograr dados
     * @access public
     * @param mixed $conteudo - Dado a ser criptografado
     * @return string
     */

    public static function criptografar(mixed $conteudo): string
    {

        if (file_exists( NomeSistema . "config/chave_privada.pem")) {
            $key = file_get_contents( NomeSistema . "config/chave_privada.pem");

            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $textoCriptografado = openssl_encrypt($conteudo, 'aes-256-cbc', $key, 0, $iv);
            return base64_encode(base64_encode($iv . $textoCriptografado));
        } else {
            return "Não Criptografado - Ocorreu um erro";
        }
    }



    /**
     * Função que utiliza a chave gerada para descriptograr dados
     * @access public
     * @param mixed $conteudo - Dado a ser descriptografado
     * @return string
     */


    public static function descriptografar(mixed $conteudo): string
    {

        if (!$conteudo) {
            return '';
        }
        $data = base64_decode(base64_decode($conteudo));
        $iv = substr($data, 0, 16);
        $textoCriptografado = substr($data, 16);
        $key = file_get_contents( NomeSistema . "config/chave_privada.pem");
        return openssl_decrypt($textoCriptografado, 'aes-256-cbc', $key, 0, $iv);
    }
}
