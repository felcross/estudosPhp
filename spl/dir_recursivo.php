<?php
 
  $path = 'C:/Users/Pichau/Desktop/FiveRings';

foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path,RecursiveDirectoryIterator::SKIP_DOTS))
as $file) 
{
  print (string) $file . '<br>';
  //print 'Nome: ' . $file->getFilename() . '<br>';
  //print 'Extensão: ' . $file->getExtension() . '<br>';
  //print 'Tamanho: ' . $file->getSize() . '<br>';
  print '<br><br>';
}