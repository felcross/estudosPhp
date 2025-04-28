<?php

namespace utils;

class JsonManual
{


    /**
     * Função que converte o conteudo em JSON, respeitando todas as características dos dados
     * @access public
     * @param array $conteudo
     * @return string
     */

    public static function encode(array $conteudo): string
    {
        $jsonManual = '{';
        $first = true;

        foreach ($conteudo as $key => $value) {
            if (!$first) {
                $jsonManual .= ',';
            }

            // Tratamento para arrays
            if (is_array($value)) {
                $jsonManual .= '"' . $key . '":[';
                $firstSub = true;
                foreach ($value as $subValue) {
                    if (!$firstSub) {
                        $jsonManual .= ',';
                    }
                    // Subarray recursivo ou valor simples
                    $jsonManual .= is_array($subValue) ? self::encode($subValue) : (is_numeric($subValue) ? $subValue : '"' . self::limpeString($subValue) . '"');
                    $firstSub = false;
                }
                $jsonManual .= ']';

                // Tratamento para valores numéricos
            } elseif (is_numeric($value)) {
                $jsonManual .= '"' . $key . '":';

                // Se o valor for exatamente "0", ele deve ser 0 (número)
                if ($value === 0 || $value === "0.00") {
                    $jsonManual .= '0';

                    // Se o valor começar com "0" mas não for "0.", deve ser string
                } elseif (strpos($value, '0') === 0 && strpos($value, '0.') !== 0) {
                    $jsonManual .= '"' . $value . '"';

                    // Se o valor começar com "0." (como "0.1", "0.05"), deve ser tratado como float
                } elseif (strpos($value, '0.') === 0) {
                    $jsonManual .= $value;

                    // Qualquer outro valor numérico
                } else {
                    $jsonManual .= $value;
                }


                // Tratamento para strings
            } else {
                $jsonManual .= '"' . $key . '":"' . self::limpeString($value) . '"';
            }

            $first = false;
        }

        $jsonManual .= '}';

        return $jsonManual;
    }



    /**
     * Função que converte o json em array, permanecendo os formato original dos dados
     * @access public
     * @param string $json
     * @return null|array
     */


    public static function decode(string $json): ?array
    {

        $decoded = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

        if ($decoded) {
            return self::convertNumerosEmStrings($decoded);
        } else {
            return null;
        }
    }


    /**
     * Função que converte os números em strings para manter o formato original de pontos flutuantes
     * @access public
     * @param array $array
     * @return array
     */


    private static function convertNumerosEmStrings($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {

                $array[$key] = self::convertNumerosEmStrings($value);
            } elseif (is_numeric($value) && strpos($value, '.') !== false) {

                $array[$key] = strval($value);
            }
        }

        return $array;
    }



    /**
     * Função que altera o valor para string, sejam eles float ou int, para ser limpo posteriormente
     * @access public
     * @param int|float $valor
     * @return string
     */

    public static function defineString(string | int | float $valor): string
    {
        return "s:" . $valor;
    }


    /**
     * Função que limpa a string removendo a definição
     * @access public
     * @param string $valor
     * @return string
     */

    public static function limpeString(?string $valor): string
    {
        if (is_null($valor)) {
            return '';
        }
        return str_replace('s:', '', $valor);
    }
}
