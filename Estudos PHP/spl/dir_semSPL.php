<?php
$dir = opendir('C:\Users\Pichau\Desktop\FiveRings');

while($arquivo = readdir($dir))
{
   print $arquivo . '<br>';
}

closedir($dir);