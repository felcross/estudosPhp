<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../public/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/styles.css">
</head>

<body>
    <script src="../public/js/ext/jquery-3.7.1.min.js" crossorigin="anonymous"></script>



    <main class="content">
        <div class="container-fluid pt-4">
            <?php

use api\TokensControl;
use utils\Crypto;
use utils\Erros;
use utils\JsonManual;
use utils\Sanitizantes;
use utils\Temp;


            require '../autoLoad.php';
            require '../vendor/autoload.php';
            require '../src/core/Router.php';
            require '../src/core/View.php';
            require '../functions.php';
            

            $router = new Core\Router;
            
            $uri = parse_url($_SERVER['QUERY_STRING'])['path'];
            $method = $_SERVER["REQUEST_METHOD"];
            
            require '../src/core/routes.php';
            


            $router->router($uri,$method );

            //$teste = Sanitizantes::filtro("SELECT * FROM usuarios WHERE id = 1; @@@ '' & DROP TABLE usuarios; -- ");
           // Crypto::gerarChaves();
            //$teste2 =  Crypto::criptografar("SELECT * FROM usuarios WHERE id = 1; @@@ '' & DROP TABLE usuarios; -- ");
           // $teste3 =  Crypto::descriptografar($teste2);

            // $teste =  JsonManual::encode([
            //     "nome" => "Lucas",
            //     "idade" => JsonManual::defineString(20.59),
            //     "endereco" => [
            //         "rua" => "Rua A",
            //         "numero" => 123,
            //         "cidade" => "São Paulo"
            //     ],
            //     "telefones" => [
            //         ["tipo" => "celular", "numero" => "(11) 98765-4321"],
            //         ["tipo" => "residencial", "numero" => "(11) 1234-5678"]
            //     ]
            // ]);


        //   $teste2 = new Temp;
        //   $teste2->setDataUltUpdateProdutos("teste");
        //   $t = $teste2->recuperaJSON("data.json");
          
    //   $token = new TokensControl;
    //   $token->__construct();
           
         


            ?>
        </div>
    </main>

    <script src="../public/js/ext/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>