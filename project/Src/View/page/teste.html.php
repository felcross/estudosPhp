<div class="con">
  <div class="header">
    <h1>Welcome to My Website</h1>
  </div>

  <div class="content">
  <div class="container my-5">    
        <h1 class="mb-4">Lista de Produtos</h1>
         
        <div class="row">
            <?php if (empty($produtos)): ?>
                <div class="col-12">
                    <div class="alert alert-info">Nenhum produto encontrado.</div>
                </div>  
            <?php else: ?>
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                        
                            
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($produto['NOME'] ?? 'Sem título') ?></h5>
                                


                                
                                <?php if (isset($produto['REFERENCIA'])): ?>
                                    <p class="card-text">Ref: <?= htmlspecialchars($produto['REFERENCIA']) ?></p>
                                <?php endif; ?>

                                <?php if (isset($produto['REFERENCIA2'])): ?>
                                    <p class="card-text">Ref2: <?= htmlspecialchars($produto['REFERENCIA2']) ?></p>
                                <?php endif; ?>



                                <?php if (isset($produto['CODIGOBARRA'])): ?>
                                    <p class="card-text">CódBarra: <?= htmlspecialchars($produto['CODIGOBARRA']) ?></p>
                                <?php endif; ?>
                                
                                <?php if (isset($produto['CUSTO'])): ?>
                                    <p class="card-text fw-bold">Preço: R$ <?= number_format($produto['CUSTO'], 2, ',', '.') ?></p>
                                <?php endif; ?>
                                
                                <a href="produto/detalhe/<?= htmlspecialchars($produto['Codigo'] ?? 0) ?>" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
  </div>

  <div class="footer">
    <p>&copy; 2023 Your Company Name. All rights reserved.</p>
  </div>
</div>

<!-- <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head> -->
<!-- <body> -->
  
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->