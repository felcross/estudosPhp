<?php

$xml = simplexml_load_file('teste.xml');

/*
print 'Nome: ' . $xml->pais->nome . '<br>';
print 'idioma: ' . $xml->pais->idioma . '<br>';
print 'capital: ' . $xml->pais->capital . '<br>';
print 'moeda: ' . $xml->pais->moeda . '<br>';
print 'prefixo: ' . $xml->pais->prefixo . '<br>';*/

print 'Nome: ' . $xml->nome . '<br>';
print 'idioma: ' . $xml->idioma . '<br>';
print 'capital: ' . $xml->capital . '<br>';
print 'moeda: ' . $xml->moeda . '<br>';
print 'prefixo: ' . $xml->prefixo . '<br>';

print '---------------------- <br>';

foreach($xml->children() as $elemento => $valor)
{
   print "$elemento : $valor <br>";
}

$xml->capital = 'Rio de janeiro';
$xml->addChild('Presidente', 'Felipe o foda');

echo $xml->asXML();

file_put_contents('teste2.xml',$xml->asXML());
