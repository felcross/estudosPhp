<?php
 $file = new  SplFileObject('spl_fileobj.php');

print 'nome: ' . $file->getFilename() . '<br>';
print 'extensão: ' . $file->getExtension(). '<br>';

$file2 = new SplFileObject('novo.txt', 'w');
$bytes = $file2->fwrite('OI mundo');

print 'Bytes' . $bytes;
