<body>
    <!-- Container para alertas -->
    <div id="alertContainer" class="position-fixed top-0 start-50 translate-middle-x" style="z-index: 1055; width: 100%; max-width: 500px; padding-top: 1rem;"></div>

    <!-- Tabela de Produtos -->
    <div class="container my-5">
        <h1 class="mb-4">Busca de Produtos</h1>

        <form action="index.php?uri=&" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="form-floating">
                        <input type="text" name="termo" class="form-control" id="searchTerm"
                            placeholder="Digite o código, descrição ou código de barras"
                            value="<?= htmlspecialchars($termo ?? '') ?>">
                        <label for="searchTerm">Digite o código, descrição ou código de barras</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary h-100 w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Qtd. Max. Armazenagem</th>
                        <th>Local</th>
                        <th>Local 2</th>
                        <th>Local 3</th>
                        <th>Código de Barras</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produtos)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="bi bi-search"></i> Nenhum produto encontrado.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produtos as $produto): ?>
                            <tr data-id="<?= htmlspecialchars($produto['PRODUTO']) ?>">
                                <td class="fw-bold"><?= htmlspecialchars($produto['PRODUTO']) ?></td>
                                <td data-campo="descricao"><?= htmlspecialchars($produto['NOME']) ?></td>
                                <td data-campo="qtd_max" class="text-center">
                                    <?= number_format(($produto['QTD_MAX_ARMAZENAGEM'] ?? 0), 0, ',', '.') ?>
                                </td>
                                <td data-campo="local"><?= htmlspecialchars($produto['LOCAL'] ?? '') ?></td>
                                <td data-campo="local2"><?= htmlspecialchars($produto['LOCAL2'] ?? '') ?></td>
                                <td data-campo="local3"><?= htmlspecialchars($produto['LOCAL3'] ?? '') ?></td>
                                <td data-campo="codigobarra"><?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?></td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-primary btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditarProduto"
                                            data-id="<?= htmlspecialchars($produto['PRODUTO']) ?>"
                                            data-codigo="<?= htmlspecialchars($produto['PRODUTO']) ?>"
                                            data-descricao="<?= htmlspecialchars($produto['NOME']) ?>"
                                            data-qtd-max="<?= $produto['QTD_MAX_ARMAZENAGEM'] ?? 0 ?>"
                                            data-local="<?= htmlspecialchars($produto['LOCAL'] ?? '') ?>"
                                            data-local2="<?= htmlspecialchars($produto['LOCAL2'] ?? '') ?>"
                                            data-local3="<?= htmlspecialchars($produto['LOCAL3'] ?? '') ?>"
                                            data-codigobarra="<?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?>">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Editar Produto -->
    <div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="modalEditarProdutoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarProdutoLabel">
                        <i class="bi bi-pencil-square"></i> Editar Produto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <form id="formEditarProduto" novalidate>
                    <div class="modal-body">
                        <!-- Campo oculto para ID do produto -->
                        <input type="hidden" id="modalProdutoId" name="modalProdutoId">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="modalCodigo" name="modalCodigo" readonly>
                                    <label for="modalCodigo">Código do Produto</label>
                                    <div class="form-text">O código do produto não pode ser alterado.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="modalQtdMax" name="modalQtdMax" min="0" step="1" required>
                                    <label for="modalQtdMax">Quantidade Máxima de Armazenagem</label>
                                    <div class="invalid-feedback">
                                        Por favor, informe uma quantidade válida.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modalDescricao" name="modalDescricao" required>
                            <label for="modalDescricao">Descrição do Produto</label>
                            <div class="invalid-feedback">
                                Por favor, informe a descrição do produto.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="modalLocal" name="modalLocal">
                                    <label for="modalLocal">Local</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="modalLocal2" name="modalLocal2">
                                    <label for="modalLocal2">Local 2</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="modalLocal3" name="modalLocal3">
                                    <label for="modalLocal3">Local 3</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="modalCodigoBarras" name="modalCodigoBarras" 
                                   pattern="[0-9]*" title="Apenas números são permitidos">
                            <label for="modalCodigoBarras">Código de Barras</label>
                            <div class="form-text">Apenas números são permitidos.</div>
                            <div class="invalid-feedback">
                                Por favor, informe um código de barras válido (apenas números).
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSalvarAlteracoes">
                            <i class="bi bi-check-circle"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>