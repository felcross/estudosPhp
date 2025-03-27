<?php 
$dados = ['verde','azul','amarelo','vermelho'];

$objarray = new ArrayObject($dados);

$objarray->append('rosa');

print $objarray->offsetGet(2) . '<br>';

 $objarray->offsetSet(2,'preto');
 $objarray->offsetUnset(4);
 $objarray->count() . '<br>';
 print $objarray->offsetExists(4) ? 'encontrado' : 'não encontrado' . '<br>';

foreach($objarray as $item)
{
   print 'cor: ' . $item .'<br>';

}

