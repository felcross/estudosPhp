<?php
// src/view/page/login.html.php
use Core\View;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Login - Sistema') ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/login.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="./js/sass/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="./js/sass/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?= View::component('LoginForm', [
        'logoPath' => './photo/logo.png',
        'showForgotPassword' => true
    ]) ?>
    
    <footer class="Rodape">
        <div class="grid text-end fixed-bottom">
            <div class="g-col-4 g-col-md-4"></div>
            <div class="g-col-4 g-col-md-4"></div>
        </div>
        
        <div class="sub-rodape">
            Sistemas de Gestão Empresarial no Setor de Varejo e Distribuição de Autopeças.
        </div>
       
        <p>&copy;Portal de Clientes V 2.0</p>
    </footer>
</body>
</html>