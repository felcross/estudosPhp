<?php
$ingredientes = new SplStack; // lifo

$ingredientes->push('Peixe');
$ingredientes->push('Sal');
$ingredientes->push('Limão');

// manipular fila 

print $ingredientes->count();
echo '<br>';
print $ingredientes->pop();
echo '<br>';

foreach($ingredientes as $item)
{
   print 'Items:' . $item . '<br>'; 
}
