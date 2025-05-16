<?php require '../config/sessoes.php'; ?>

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

            

           
            require '../autoLoad.php';
            require '../vendor/autoload.php';
            require '../src/core/Router.php';
            require '../src/core/View.php';
            require '../functions.php';
            
            
          \utils\Tokens::geraTokenCSRF();
            $router = new Core\Router;
            
            $uri = $_GET['uri'] ?? '';

            $method = $_SERVER["REQUEST_METHOD"];
            
            require '../src/core/routes.php';
         
              //dd($uri);
            $router->router($uri,$method );
     
         


            ?>
        </div> 
    </main>
   <input type="hidden" id="token" value="<?php echo $_SESSION['TokenCSRF'] ?? ''; ?>">
 
    <script src="../public/js/ext/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>