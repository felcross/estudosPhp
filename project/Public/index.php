<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../Public/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../Public/css/styles.css">
</head>

<body>
    <script src="../Public/js/jquery-3.7.1.min.js" crossorigin="anonymous"></script>



    <main class="content">
        <div class="container-fluid pt-4">
            <?php

            require '../autoLoad.php';
            //require '../vendor/autoload.php';
            require '../Src/Controller/MyController.php';

            
           
          $app = new App($_GET);



       /*   $uri = $_SERVER["QUERY_STRING"];

          var_dump($uri);
          
          if($uri === '/')
        {
          require '../Src/Model/Teste.php';
        
        }*/
            ?>
        </div>
    </main>




    <script src="../Public/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>