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
   require '../core/Router.php';
   require '../functions.php';


$router = new Core\Router;

$uri = parse_url($_SERVER['QUERY_STRING'])['path'];
$method = $_SERVER["REQUEST_METHOD"];

require '../core/routes.php';

//dd($uri);

$router->router($uri,$method );




?>
        </div>
    </main>




    <script src="../public/js/ext/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>



