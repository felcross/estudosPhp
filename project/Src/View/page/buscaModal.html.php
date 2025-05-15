<div class="container my-5">
    <h1 class="mb-4">Busca de Produtos</h1>
    
    <form method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="termo" class="form-control" 
                       placeholder="Digite o código, referência ou código de barras" 
                       value="<?= htmlspecialchars($termo) ?>">
            </div>
            <div class="col-md-2">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="parcial" name="parcial" value="1">
                    <label class="form-check-label" for="parcial">
                        Busca parcial
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Buscar</button>
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
                                <button type="button" class="btn btn-sm btn-primary editar-produto" 
                                        data-bs-toggle="modal" data-bs-target="#editarProdutoModal"
                                        data-produto="<?= htmlspecialchars($produto['PRODUTO'] ?? '') ?>"
                                        data-descricao="<?= htmlspecialchars($produto['DESCRICAO'] ?? '') ?>"
                                        data-referencia="<?= htmlspecialchars($produto['REFERENCIA'] ?? '') ?>"
                                        data-referencia2="<?= htmlspecialchars($produto['REFERENCIA2'] ?? '') ?>"
                                        data-codigobarra="<?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?>"
                                        data-preco="<?= htmlspecialchars($produto['PRECO'] ?? 0) ?>">
                                    Editar
                                </button>
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

<!-- Modal de Edição de Produto -->
<div class="modal fade" id="editarProdutoModal" tabindex="-1" aria-labelledby="editarProdutoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarProdutoModalLabel">Editar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formEditarProduto" method="POST" action="produto/atualizar">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="editProduto" class="form-label">Código</label>
                            <input type="text" class="form-control" id="editProduto" name="produto" readonly>
                        </div>
                        <div class="col-md-8">
                            <label for="editDescricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="editDescricao" name="descricao" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editReferencia" class="form-label">Referência</label>
                            <input type="text" class="form-control" id="editReferencia" name="referencia">
                        </div>
                        <div class="col-md-6">
                            <label for="editReferencia2" class="form-label">Referência 2</label>
                            <input type="text" class="form-control" id="editReferencia2" name="referencia2">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editCodigoBarra" class="form-label">Código de Barras</label>
                            <input type="text" class="form-control" id="editCodigoBarra" name="codigobarra">
                        </div>
                        <div class="col-md-6">
                            <label for="editPreco" class="form-label">Preço (R$)</label>
                            <input type="number" class="form-control" id="editPreco" name="preco" step="0.01" min="0" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editObservacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="editObservacoes" name="observacoes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para manipular o modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Seleciona todos os botões de editar
    const botoesEditar = document.querySelectorAll('.editar-produto');
    
    // Adiciona o evento de clique para cada botão
    botoesEditar.forEach(botao => {
        botao.addEventListener('click', function() {
            // Recupera os dados do produto a partir dos atributos data-*
            const codigo = this.getAttribute('data-produto');
            const descricao = this.getAttribute('data-descricao');
            const referencia = this.getAttribute('data-referencia');
            const referencia2 = this.getAttribute('data-referencia2');
            const codigoBarra = this.getAttribute('data-codigobarra');
            const preco = this.getAttribute('data-preco');
            
            // Preenche o formulário do modal com os dados do produto
            document.getElementById('editProduto').value = codigo;
            document.getElementById('editDescricao').value = descricao;
            document.getElementById('editReferencia').value = referencia;
            document.getElementById('editReferencia2').value = referencia2;
            document.getElementById('editCodigoBarra').value = codigoBarra;
            document.getElementById('editPreco').value = preco;
            
            // Atualiza o título do modal com o código do produto
            document.getElementById('editarProdutoModalLabel').textContent = 'Editar Produto: ' + codigo;
        });
    });
    
    // Manipulador para o envio do formulário
    document.getElementById('formEditarProduto').addEventListener('submit', function(e) {
        // Aqui você pode adicionar validação adicional se necessário
        
        // Para demonstrar o funcionamento sem recarregar a página
        // Remova esta parte e deixe o formulário ser enviado normalmente quando estiver pronto
        e.preventDefault();
        
        // Exibe mensagem de sucesso (para demonstração)
        alert('Produto atualizado com sucesso!');
        
        // Fecha o modal
        const modalElement = document.getElementById('editarProdutoModal');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance.hide();
    });
});
</script>