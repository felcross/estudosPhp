<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Produtos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionais, se necessário */
    </style>
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4">Busca de Produtos</h1>



    <form action="<?= $_SERVER['PHP_SELF']?>" method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="termo" class="form-control"
                       placeholder="Digite o código, referência ou código de barras"
                       value="<?= htmlspecialchars($termo) ?>">
            </div>
            <div class="col-md-2">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="parcial" name="parcial" value="1"
                           <?= $parcial ? 'checked' : '' ?>>
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
                                <!-- Botão Editar modificado para acionar o modal -->
                                <button type="button" class="btn btn-sm btn-primary btn-editar-produto"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditarProduto"
                                        data-id="<?= htmlspecialchars($produto['PRODUTO'] ?? '') ?>"
                                        data-codigo="<?= htmlspecialchars($produto['PRODUTO'] ?? '') ?>"
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

<!-- Modal Editar Produto -->
<div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="modalEditarProdutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Produto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarProduto">
                    <!-- Campo oculto para o ID do produto, se for diferente do código visível -->
                    <input type="hidden" id="modalProdutoId" name="produto_id">

                    <div class="mb-3">
                        <label for="modalCodigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="modalCodigo" name="codigo_produto" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modalDescricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="modalDescricao" name="descricao">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modalReferencia" class="form-label">Referência</label>
                            <input type="text" class="form-control" id="modalReferencia" name="referencia">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modalReferencia2" class="form-label">Referência 2</label>
                            <input type="text" class="form-control" id="modalReferencia2" name="referencia2">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="modalCodigoBarras" class="form-label">Código de Barras</label>
                        <input type="text" class="form-control" id="modalCodigoBarras" name="codigobarra">
                    </div>
                    <div class="mb-3">
                        <label for="modalPreco" class="form-label">Preço</label>
                        <input type="number" step="0.01" class="form-control" id="modalPreco" name="preco">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarAlteracoes">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle (Popper.js incluído) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEditarProduto = document.getElementById('modalEditarProduto');
    if (modalEditarProduto) {
        modalEditarProduto.addEventListener('show.bs.modal', function (event) {
            // Botão que acionou o modal
            var button = event.relatedTarget;

            // Extrai informações dos atributos data-*
            var produtoId = button.getAttribute('data-id'); // O ID original do produto
            var codigo = button.getAttribute('data-codigo');
            var descricao = button.getAttribute('data-descricao');
            var referencia = button.getAttribute('data-referencia');
            var referencia2 = button.getAttribute('data-referencia2');
            var codigobarra = button.getAttribute('data-codigobarra');
            var preco = button.getAttribute('data-preco');

            // Atualiza o conteúdo do modal
            var modalTitle = modalEditarProduto.querySelector('.modal-title');
            var modalProdutoIdInput = modalEditarProduto.querySelector('#modalProdutoId');
            var modalCodigoInput = modalEditarProduto.querySelector('#modalCodigo');
            var modalDescricaoInput = modalEditarProduto.querySelector('#modalDescricao');
            var modalReferenciaInput = modalEditarProduto.querySelector('#modalReferencia');
            var modalReferencia2Input = modalEditarProduto.querySelector('#modalReferencia2');
            var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
            var modalPrecoInput = modalEditarProduto.querySelector('#modalPreco');

            modalTitle.textContent = 'Editar Produto: ' + codigo;
            if (modalProdutoIdInput) modalProdutoIdInput.value = produtoId; // ID para submissão
            if (modalCodigoInput) modalCodigoInput.value = codigo;
            if (modalDescricaoInput) modalDescricaoInput.value = descricao;
            if (modalReferenciaInput) modalReferenciaInput.value = referencia;
            if (modalReferencia2Input) modalReferencia2Input.value = referencia2;
            if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
            if (modalPrecoInput) modalPrecoInput.value = parseFloat(preco).toFixed(2);
        });
    }

    // Lógica para o botão "Salvar Alterações" (exemplo)
    var btnSalvar = document.getElementById('btnSalvarAlteracoes');
    if (btnSalvar) {
        btnSalvar.addEventListener('click', function() {
            // Aqui você pegaria os dados do formulário do modal
            var form = document.getElementById('formEditarProduto');
            var formData = new FormData(form);

            // Exemplo: exibir os dados no console
            console.log("Dados do formulário para salvar:");
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ': '+ pair[1]);
            }

            // Aqui você implementaria a lógica para enviar os dados para o servidor
            // (por exemplo, usando fetch ou XMLHttpRequest para uma requisição AJAX)
            // Ex: fetch('url_para_salvar.php', { method: 'POST', body: formData })
            //    .then(response => response.json())
            //    .then(data => { console.log('Sucesso:', data); bootstrap.Modal.getInstance(modalEditarProduto).hide(); })
            //    .catch((error) => { console.error('Erro:', error); });
              console.log(form);
            // Exibe mensagem de sucesso (para demonstração)
           // alert('Lógica de salvar ainda não implementada. Verifique o console.');
            // bootstrap.Modal.getInstance(modalEditarProduto).hide(); // Para fechar o modal após salvar
        });
    }
});
</script>

</body>
</html>