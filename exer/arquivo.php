<?php


/*$handler =  fopen('C:\Users\emsoft\Desktop\teste.txt','r');

 while(!feof($handler)) {
  
    echo fgets($handler,4096);
    echo '<br>';
 }
fclose($handler);*/

/*
$handler =  fopen('C:\Users\emsoft\Desktop\teste2.txt','w');

fwrite($handler,'Linha 1 teste' . PHP_EOL);
fwrite($handler,'Linha 2 teste'. PHP_EOL);

fclose($handler);*/

// outra forma de ler
//echo file_get_contents('C:\Users\emsoft\Desktop\teste2.txt');

//echo file_put_contents('C:\Users\emsoft\Desktop\teste3.txt', 'escreve lá \n')

/*$handler = file('C:\Users\emsoft\Desktop\teste.txt');
  
foreach($handler as $linhas ){

    echo $linhas . '<br>';
} */

if(file_exists('C:\Users\emsoft\Desktop\teste.txt')){
   
    echo 'Esse arquivo existe';
}
?>