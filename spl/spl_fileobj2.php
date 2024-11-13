<?php
 $file = new  SplFileObject('novo.txt');

 //eof end of file, maneiras de percorrer o arquivo
while(!$file->eof())
{   
   // file get, retorna uma linha do arquivo. 
    print $file->fgets() . '<br>';
}
print '------------------ <br>';

foreach($file as $linha => $valor)
{
   print "$linha : $valor <br>"; 
}