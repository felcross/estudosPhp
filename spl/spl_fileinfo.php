<?php
 $file = new  SplFileInfo('arq.txt');

print 'nome: ' . $file->getFilename() . '<br>';
print 'extensão: ' . $file->getExtension(). '<br>';
print 'tipo: ' . $file->getType(). '<br>';
print 'tamanho: ' . $file->getSize(). '<br>';
print 'podegravar: ' . $file->isWritable();
