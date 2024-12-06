<?php 

 $array = ['vermelho', 'verde', 'amarelo'];

 /*array_push($array,'ciano');
 array_unshift($array,'purpura');
 array_shift($array);
 array_pop($array);*/

    $cores = array_reverse($array);

  
  $merge = array_merge($array,['magente','azul']);

  //var_dump($cores);

 $carros = [];

 $carros[5255] = 'carro 02';
 $carros[1255] = 'carro 05';
 $carros[3255] = 'carro 03';
 $carros[4255] = 'carro 09';
 //sort($carros);
 //asort($carros);
 //ksort($carros);
 
 echo '<prev>';
 //array_keys($carros);
 //var_dump(array_keys($carros));
 var_dump(array_values($carros));
 var_dump(count($carros));
 var_dump(in_array('carro 02',$carros));

 $data = '2013-05-12';
 $parte = explode('-', $data);
 echo $parte[0];

 $data2 = ['2013','30','25'];
  print implode('-',$data2);
?> 