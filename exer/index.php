<?php   
     //variaveis normais
        $saudeMental = "boa";
        $pagina = "php";
      //tipando
        $valor1 = intval("2");
      //constante 
        define("LIES","cleitinho kkk ");
     //mostra o tipo e debug
        $valor2 = 33;
        var_dump($valor2);
      // setar data 
        
        date_default_timezone_set("America/Sao_Paulo");
        $date = date("d/m/Y H:i:s");
        echo $date; 

        $cursos = array("tipo0","tipo1","tipo2","tipo3");
        print_r($cursos);

        $array = ["pwd" => "2000", "P1" => ["Cep"=>"3215421"]];

        print_r($array["P1"]);


       // for($i =1; $i < 10 ; $i++){
      //       $cod = $i;
        //   echo $cod;
        //}


       function  soma() : int {
         $x =10 + 20;
          return $x ;
        }

        $arr1 = [10,20,3,4,5,6];  
        $arr2 = [3,4,5,6,7,8]; 

       // $qtd_no_arr = count($arr1);

  /* for($i =0; $i < 6 ; $i++){
        echo $arr1[$i] ;
     } 
echo "-----------------" ;
     foreach($arr2 as $value) {
       echo $value ;
     }*/

     $bollean = false;

   while(!$bollean){
    $arr2 = [3,4,5,6,7,8];
    foreach($arr2 as $value) {
      echo $value ;
      $bollean = true;
    }

   }
           // echo $qtd_no_arr;

       // echo soma();

      //   if($saudeMental === "boa") {
            
       // echo "vou fazer paginas agora em $pagina";

       //  return printf("vou fazer paginas agora em $pagina");

        //    } 




?>