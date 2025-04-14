<?php
foreach(new DirectoryIterator('C:\Users\Pichau\Desktop\FiveRings') as $file) 
{
  //print (string) $file . '<br';
  print 'Nome: ' . $file->getFilename() . '<br>';
  print 'Extensão: ' . $file->getExtension() . '<br>';
  print 'Tamanho: ' . $file->getSize() . '<br>';
  print '<br><br>';
}