<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Busca de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container my-5">
        <h1 class="mb-4">Busca e Edição de Produtos</h1>

        <form action="index.php?uri=&" method="GET" class="mb-4">
            
                <div class="col-md-8">
                    <input type="text" name="termo" class="form-control"
                           placeholder="Digite o código, descrição ou código de barras"
                           value="<?= htmlspecialchars($termo ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

           <?php if (!empty($termo)): ?>
            <div class="alert alert-info">
                Resultados da busca por: <strong><?= htmlspecialchars($termo) ?></strong>.
                <?php if (isset($produtos) && is_array($produtos)): ?>
                    <?= count($produtos) ?> produto(s) encontrado(s).
                <?php endif; ?>
            </div>
        <?php endif; ?>
        

        <?php if (!empty($produtos) && is_array($produtos)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cód. Interno</th>
                            <th>Cód. Barras</th>
                            <th>Qtd. Máx. Arm.</th>
                            <th>Local</th>
                            <th>Local 2</th>
                            <th>Local 3</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $index => $produto): ?>
                            <tr id="produto-row-<?= $index ?>">
                                <td class="cell-produto-codigo"><?= htmlspecialchars($produto['PRODUTO'] ?? '') ?></td>
                                <td class="cell-produto-codigobarra"><?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?></td>
                                <td class="cell-produto-qtd_max_armazenagem"><?= htmlspecialchars($produto['QTD_MAX_ARMAZENAGEM'] ?? 0) ?></td>
                                <td class="cell-produto-local"><?= htmlspecialchars($produto['LOCAL'] ?? '') ?></td>
                                <td class="cell-produto-local2"><?= htmlspecialchars($produto['LOCAL2'] ?? '') ?></td>
                                <td class="cell-produto-local3"><?= htmlspecialchars($produto['LOCAL3'] ?? '') ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary btn-editar-produto"
                                            data-bs-toggle="modal" data-bs-target="#modalEditarProduto"
                                            data-row-index="<?= $index ?>"
                                            data-id_produto="<?= htmlspecialchars($produto['PRODUTO'] ?? '') ?>"
                                            data-codigobarra="<?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?>"
                                            data-qtd_max_armazenagem="<?= htmlspecialchars($produto['QTD_MAX_ARMAZENAGEM'] ?? 0) ?>"
                                            data-local="<?= htmlspecialchars($produto['LOCAL'] ?? '') ?>"
                                            data-local2="<?= htmlspecialchars($produto['LOCAL2'] ?? '') ?>"
                                            data-local3="<?= htmlspecialchars($produto['LOCAL3'] ?? '') ?>">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


    <?php if ($totalPaginas > 1): ?>
        <nav aria-label="Navegação da Paginação">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($paginaAtual <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?termo=<?= urlencode($termo) ?>&pagina=<?= $paginaAtual - 1 ?>" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                        <a class="page-link" href="?termo=<?= urlencode($termo) ?>&pagina=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($paginaAtual >= $totalPaginas) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?termo=<?= urlencode($termo) ?>&pagina=<?= $paginaAtual + 1 ?>" aria-label="Próximo">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
    <?php elseif (!empty($termo)): ?>
    <div class="alert alert-warning">
        Nenhum produto encontrado com o termo de busca.
    </div>
<?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>