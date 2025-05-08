<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Produtos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
  <h1 class="mb-4">Busca de Produtos</h1>

  <form class="mb-4">
    <input type="hidden" id="token" name="token" value="<?= $_SESSION['csrf_token'] ?>">
    <div class="row g-3">
      <div class="col-md-6">
        <input type="text" name="termo" class="form-control" placeholder="Código, ref ou código de barras" value="<?= htmlspecialchars($termo) ?>">
      </div>
      <div class="col-md-2">
        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" name="buscaParcial" <?= $buscaParcial ? 'checked' : '' ?>>
          <label class="form-check-label">Busca parcial</label>
        </div>
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary" id="buscar">Buscar</button>
      </div>
    </div>
  </form>

  <!-- Aqui o AJAX vai injetar os resultados -->
  <div id="resultados"></div>
</div>

   