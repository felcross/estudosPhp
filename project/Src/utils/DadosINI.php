<?php


namespace utils;

use utils\Crypto;
use utils\Sanitizantes;

class DadosINI
{
    /**
     * Função que recupera os dados de login da API EMAUTO
     * @access public
     * @return array|null
     */
    public function getUser(): ?array
    {

        $url = NomeSistema . "config/user.ini";
        if (file_exists($url)) {

            $dados = parse_ini_file($url, true);

            return $dados['USER'];
        }
        return null;
    }

    /**
     * Função que recupera o IP de conexão do EMAUTO
     * @access public
     * @return array|null
     */
    public function getIP(): ?array
    {

        $url = NomeSistema . "system/config/ip.ini";
        if (file_exists($url)) {

            $dados = parse_ini_file($url, true);

            return $dados['EMAUTO'];
        }
        return null;
    }

    /**
     * Função que recupera os campos padrões dos pedidos
     * @access public
     * @return array|null
     */
    public function getPadroesPedidos(): ?array
    {

        $url = padroesPedidos;
        if (file_exists($url)) {

            $dados = parse_ini_file($url, true);

            return $dados;
        }
        return null;
    }

    /**
     * Função que recupera os dados necessários para recuperar os XML's das notas fiscais
     * @access public
     * @return array|null
     */
    public function getDadosPastaNFE(): ?string
    {

        $url = dadosPastaNFE;
        if (file_exists($url)) {

            $dados = parse_ini_file($url, true);

            return Crypto::descriptografar($dados['PASTA']['caminho'] ?? '');
        }
        return null;
    }

    /**
     * Função que recupera os dados necessários para recuperar  a pasta de imagens
     * @access public
     * @return array|null
     */
    public function getDadosPastaIMG(): ?string
    {

        $url = dadosPastaIMG;
        if (file_exists($url)) {

            $dados = parse_ini_file($url, true);

            return Crypto::descriptografar($dados['PASTA']['caminho'] ?? '');
        }
        return null;
    }

    /**
     * Função que recupera os dados necessários para recuperar a tabela de preços
     * @access public
     * @return array|null
     */
    public function getTabelaPreco(): ?array
    {

        $url = NomeSistema . "config/tabCodigo.ini";
        if (file_exists($url)) {

            $dados = parse_ini_file($url, true);

            return $dados['TABELA'];
        }
        return null;
    }

    /**
     * Função que recupera os dados necessários para recuperar a tabela de preços
     * @access public
     * @return array|null
     */
    public function getDistribuicao(): ?array
    {

        $url = NomeSistema . "config/undCodigo.ini";
        if (file_exists($url)) {

            $dados = parse_ini_file($url, true);

            return $dados['UND'];
        }
        return null;
    }

    /**
     * DebugFunction
     * @access public
     * @return null|array
     */
    public function __debugInfo(): ?array
    {
        return ["DanosINI"];
    }

}
