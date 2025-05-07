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
    
    <form action="" method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="termo" class="form-control" 
                       placeholder="Digite o código, referência ou código de barras" 
                       value="<?= htmlspecialchars($termo) ?>">
            </div>
            <div class="col-md-2">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="" name="" value="" 
                           <?= $buscaParcial ? 'checked' : '' ?>>
                    <label class="form-check-label" for="parcial">
                        Busca parcial
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary" id="buscar">Buscar</button>
            </div>
        </div>
    </form>
    
    <?php if (!empty($termo)): ?>
        <div class="alert alert-info">
            Resultados da busca por: <strong><?= htmlspecialchars($termo) ?></strong>
            <?= count($produtos) ?> produto(s) encontrado(s)
        </div>
    <?php endif; ?>
    
    <?php if (!empty($produtos)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Referência</th>
                        <th>Referência 2</th>
                        <th>Código de Barras</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= htmlspecialchars($produto['PRODUTO'] ?? '') ?></td>
                            <td><?= htmlspecialchars($produto['DESCRICAO'] ?? '') ?></td>
                            <td><?= htmlspecialchars($produto['REFERENCIA'] ?? '') ?></td>
                            <td><?= htmlspecialchars($produto['REFERENCIA2'] ?? '') ?></td>
                            <td><?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?></td>
                            <td>R$ <?= number_format($produto['PRECO'] ?? 0, 2, ',', '.') ?></td>
                            <td>
                                <a href="produto/editar/<?= htmlspecialchars($produto['PRODUTO'] ?? '') ?>" 
                                   class="btn btn-sm btn-primary">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php elseif (!empty($termo)): ?>
        <div class="alert alert-warning">
            Nenhum produto encontrado com o termo de busca.
        </div>
    <?php endif; ?>
</div>
  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>