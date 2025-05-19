
<body>

    <div class="container my-5">
        <h1 class="mb-4">Busca de Produtos</h1>



        <form action="index.php?uri=&" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="termo" class="form-control"
                        placeholder="Digite o código, referência ou código de barras"
                        value="<?= htmlspecialchars($termo) ?>">
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>



<!-- Tabela de Produtos -->
<div class="table-responsive mt-4">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
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
            <?php if (empty($produtos)): ?>
                <tr>
                    <td colspan="7" class="text-center">Nenhum produto encontrado.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($produtos as $produto): ?>
                    <tr data-id="<?= htmlspecialchars($produto['PRODUTO']) ?>">
                        <td><?= htmlspecialchars($produto['PRODUTO']) ?></td>
                        <td data-campo="descricao"><?= htmlspecialchars($produto['NOME']) ?></td>
                        <td data-campo="referencia"><?= htmlspecialchars($produto['REFERENCIA'] ?? '') ?></td>
                        <td data-campo="referencia2"><?= htmlspecialchars($produto['REFERENCIA2'] ?? '') ?></td>
                        <td data-campo="codigobarra"><?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?></td>
                        <td data-campo="preco">R$ <?= number_format(($produto['PRECO_VENDA'] ?? 0), 2, ',', '.') ?></td>
                        <td>
                            <button type="button" 
                                    class="btn btn-primary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditarProduto"
                                    data-id="<?= htmlspecialchars($produto['PRODUTO']) ?>"
                                    data-codigo="<?= htmlspecialchars($produto['PRODUTO']) ?>"
                                    data-descricao="<?= htmlspecialchars($produto['NOME']) ?>"
                                    data-referencia="<?= htmlspecialchars($produto['REFERENCIA'] ?? '') ?>"
                                    data-referencia2="<?= htmlspecialchars($produto['REFERENCIA2'] ?? '') ?>"
                                    data-codigobarra="<?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?>"
                                    data-preco="<?= $produto['PRECO_VENDA'] ?? 0 ?>">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Inclui o Modal para Editar Produto -->
<div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="modalEditarProdutoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarProduto">
                    <!-- Campo oculto para ID do produto (usado na API) -->
                    <input type="hidden" id="modalProdutoId" name="modalProdutoId">
                    
                    <div class="mb-3">
                        <label for="modalCodigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="modalCodigo" name="modalCodigo" readonly>
                        <small class="text-muted">O código do produto não pode ser alterado.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalDescricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="modalDescricao" name="modalDescricao" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalReferencia" class="form-label">Referência</label>
                        <input type="text" class="form-control" id="modalReferencia" name="modalReferencia">
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalReferencia2" class="form-label">Referência 2</label>
                        <input type="text" class="form-control" id="modalReferencia2" name="modalReferencia2">
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalCodigoBarras" class="form-label">Código de Barras</label>
                        <input type="text" class="form-control" id="modalCodigoBarras" name="modalCodigoBarras">
                    </div>
                    
                    <div class="mb-3">
                        <label for="modalPreco" class="form-label">Preço</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" id="modalPreco" name="modalPreco" 
                                   pattern="^\d+(\,\d{1,2})?$" placeholder="0,00">
                        </div>
                        <small class="text-muted">Use vírgula como separador decimal (ex: 10,50)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarAlteracoes">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

