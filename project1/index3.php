<?php 

declare(strict_types =1);
   
   $lista = ['vermelho','amarelo', 'azul'];

var_dump($lista);


 function gerar_html(string $action, ?string $label): string {
    
   $label = $label ?? "Trocar aqui";
   return "<a href='$action'>$label</a>";

  /* $a = 10;
    return <<<HTML

<script>alert('Oi');</script>
<h1> {{ $a}} </h1>

HTML;*/
     
 }


 $a = ($b ?? 'Não existe');

 echo $a;

 print gerar_html("delete.php",null)
?>