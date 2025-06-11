<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Dashboard</title>
    <link rel="stylesheet" href=".\css\components\sidebar.css">


</head>
<body>
    <!-- Sidebar aqui -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Meu App</h3>
        </div>
        
        <ul class="list-unstyled">
            <li class="active">
                <a href="#"><i class="fas fa-home"></i> Início</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-box-open"></i> Produtos</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-info-circle"></i> Sobre</a>
            </li>
            <li>
                <a href="#"><i class="fas fa-envelope"></i> Contato</a>
            </li>
            <li>
                <a href="/logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </li>
        </ul>
    </nav>

    <main id="main-content">
        <button type="button" id="toggle-sidebar-btn" class="btn">
            <i class="fas fa-bars"></i>
        </button>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById('toggle-sidebar-btn');
            const body = document.body;
            
            toggleBtn.addEventListener('click', function() {
                body.classList.toggle('sidebar-active');
            });
        });
        </script>