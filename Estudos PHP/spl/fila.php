<?php
$ingredientes = new SplQueue(); // fifo

$ingredientes->enqueue('Peixe');
$ingredientes->enqueue('Sal');
$ingredientes->enqueue('Limão');

// manipular fila 

print $ingredientes->count();
echo '<br>';
print $ingredientes->dequeue();
echo '<br>';

foreach($ingredientes as $item)
{
   print 'Items:' . $item . '<br>'; 
}
