<?php

namespace utils;

class Erros
{


    /**
     * Função que salva os erros em formato json
     * @access public
     * @param string $requisitante - Informação de quem envio o erro
     * @param mixed $error - Erro declarado
     * @return void
     */

    public static function salva(string $requisitante, mixed $error): void
    {

        date_default_timezone_set("America/Sao_Paulo");
        $arquivo =  NomeSistema . 'logs/' . date("d-m-y") . ".json";
        if (file_exists($arquivo)) {
            $dados = json_decode(file_get_contents($arquivo), true);
        }

        $conteudo = ($dados ?? []);

        $conteudo[] = [
            "Referente" => $requisitante,
            "Horário" => date("d-m-Y H:i:s"),
            "Erro" => $error
        ];

        file_put_contents($arquivo, json_encode($conteudo, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }


    /**
     * Remove todos os arquivos da pasta de logs caso haja 30 ou mais arquivos.
     * 
     * @return void
     */
    public static function limpaLogs()
    {
        $caminho =  NomeSistema . 'logs/';
        $arquivos = array_diff(scandir($caminho), ['.', '..']);

        if (count($arquivos) >= 30) {
            foreach ($arquivos as $arquivo) {
                $caminhoArquivo = $caminho . $arquivo;

                if (is_file($caminhoArquivo)) {
                    unlink($caminhoArquivo);
                }
            }
        }
    }
}
