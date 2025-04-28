<?php

namespace utils;

class Sanitizantes
{

    /**
     * Função que sanitiza uma string e retorna a string tratada.
     * @access public
     * @return string
     */

    public static function filtro(string $string): string
    {
        $to_replace = array("UPDATE", "INSERT", "SELECT", "UNION", "UNION SELECT", "UNION INSERT", "UNION DELETE", "UNION UPDATE", "uid", "uid", "pwd", "pwd", "admin", "admin", "exec master", "cdmshell", "net user", "or uid", "username", "username ", "ALTER TABLE", "alter table", "--", "OR 1=", "or 1=1", "OR 1=1", "or 1=", "%3Cscript");
        foreach ($to_replace as $key => $value) {
            $string = str_replace($value, "", $string);
        }

        $string = trim($string);
        $string = strip_tags($string);
        $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        $string = addslashes($string);

        $final = preg_replace('/[@#$*\/!"\'=~^[\]\\\]/', '', $string);

        return $final;
    }

    /**
     * Função que filtro a string e recebida, trata com algumas exceções e retorna a string tratada.
     * @access public
     * @return string
     */

    public static function filtroUrl(string $string): string
    {
        $to_replace = array("UPDATE", "INSERT", "SELECT", "UNION", "UNION SELECT", "UNION INSERT", "UNION DELETE", "UNION UPDATE", "uid", "uid", "pwd", "pwd", "admin", "admin", "exec master", "cdmshell", "net user", "or uid", "username", "username ", "ALTER TABLE", "table", "--", "OR 1=", "or 1=1", "OR 1=1", "or 1=", "%3Cscript");
        foreach ($to_replace as $key => $value) {
            $string = str_replace($value, "", $string);
        }
        $string = preg_replace('/[$*!"\'~^[\]\\\]/', '', $string);
        $string = addslashes($string);
        return $string;
    }



     /**
     * Função que sanitiza a string enviada e permanece somente os números
     * @access public
     * @return string
     */

    public static function somenteNumbers(string $dado) {
        preg_match_all('/\d+/', $dado, $matches);
        return $matches[0] ?? 0;

    }
}
