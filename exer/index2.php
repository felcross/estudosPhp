<?php   
    function f1() {
        echo "F1 Faz parte da exceção"."<br/>" ;
    }

    function f2($int) {
      
    if(!is_int($int))
       {
         throw new Exception("Isso não é um inteiro seu idiota");
       } else { echo "F2 tá tudo certo"."<br/>";  }
    
       f3();  }

       function f3() {
        echo "F3 está depois da exceção"."<br/>" ;
    }

   
    f1();
    f2(int:5);

    $funcionarios = array(
        array("nome" => "Alex", "idade" => 21, "salario" => 1285.27, "ativo" => true),
        array("nome" => "Emerson", "idade" => 35, "salario" => 3885.27, "ativo" => false),
        array("nome" => "Osvaldo", "idade" => 54, "salario" => 5285.27, "ativo" => true),
     );
     
     $bonificacao = 10;
     
     foreach($funcionarios as $funcionario){
       
     
          echo "Funcionario: {$funcionario["nome"]}"."<br/>"."{$funcionario["salario"]}"."<br/>";
     
         
     }


    $array = array(
        "chave1" => 1,
        "chave2" => "PHP",
        "chave3" => "false"
        );
    foreach($array as $chave => $valor){
        echo "{$chave} {$valor}"."<br/>";
     }

     $iof = 0;
     $cambio = 5;
     echo  "valor = " . $cambio *= $iof;
     //$valor = $iof;

   if (empty($iof)) {
     echo "tá vazio";
   }
?>