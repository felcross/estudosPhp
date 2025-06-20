<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar Minimalista</title>

 
     <!-- jQuery -->
     <script src=".\js\sass\jquery-3.7.1.min.js"></script>     

       <!-- Bootstrap CSS -->
    <link href=".\css\bootstrap.min.css"   rel="stylesheet" ></link>

  
     
     <!-- Bootstrap JS -->
    <script src=".\js\sass\bootstrap.bundle.min.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      display: flex;
      min-height: 100vh;
      background-color: #f4f4f4;
    }

    .sidebar {
      width: 60px;
      background-color: #222;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 0;
      transition: width 0.3s;
    }

    .sidebar:hover {
      width: 200px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      width: 100%;
      padding: 15px;
      display: flex;
      align-items: center;
      transition: background 0.2s;
    }

    .sidebar a:hover {
      background-color: #333;
    }

    .sidebar i {
      margin-right: 10px;
      min-width: 20px;
      text-align: center;
    }

    .label {
      overflow: hidden;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s;
    }

    .sidebar:hover .label {
      opacity: 1;
    }

    .content {
      flex-grow: 1;
      padding: 20px;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

  <div class="sidebar">
    <a href="#"><i class="fas fa-search"></i><span class="label">Busca</span></a>
    <a href="#"><i class="fas fa-user"></i><span class="label">Perfil</span></a>
    <a href="#"><i class="fas fa-cog"></i><span class="label">Configurações</span></a>
    <a href="#"><i class="fas fa-sign-out-alt"></i><span class="label">Sair</span></a>
  </div>
<!-- 
  <div class="content">
    <h1>Conteúdo Principal</h1>
    <p>Aqui fica o conteúdo da sua página.</p>
  </div> -->

</body>
</html>



           

