<!-- Tabela de Produtos -->
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEditarProduto = document.getElementById('modalEditarProduto');
    var bootstrapModalInstance; // Guardar a instância do modal do Bootstrap

    if (modalEditarProduto) {
        bootstrapModalInstance = new bootstrap.Modal(modalEditarProduto); // Inicializa a instância do modal

        modalEditarProduto.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var produtoId = button.getAttribute('data-id'); // ID original para identificar na API
            var codigo = button.getAttribute('data-codigo');
            var descricao = button.getAttribute('data-descricao');
            var referencia = button.getAttribute('data-referencia');
            var referencia2 = button.getAttribute('data-referencia2');
            var codigobarra = button.getAttribute('data-codigobarra');
            var preco = button.getAttribute('data-preco');

            var modalTitle = modalEditarProduto.querySelector('.modal-title');
            var modalProdutoIdInput = modalEditarProduto.querySelector('#modalProdutoId');
            var modalCodigoInput = modalEditarProduto.querySelector('#modalCodigo');
            var modalDescricaoInput = modalEditarProduto.querySelector('#modalDescricao');
            var modalReferenciaInput = modalEditarProduto.querySelector('#modalReferencia');
            var modalReferencia2Input = modalEditarProduto.querySelector('#modalReferencia2');
            var modalCodigoBarrasInput = modalEditarProduto.querySelector('#modalCodigoBarras');
            var modalPrecoInput = modalEditarProduto.querySelector('#modalPreco');

            modalTitle.textContent = 'Editar Produto: ' + codigo;
            if (modalProdutoIdInput) modalProdutoIdInput.value = produtoId; // Usado para enviar à API qual produto atualizar
            if (modalCodigoInput) modalCodigoInput.value = codigo; // Código visível, pode ou não ser editável/enviado
            if (modalDescricaoInput) modalDescricaoInput.value = descricao;
            if (modalReferenciaInput) modalReferenciaInput.value = referencia;
            if (modalReferencia2Input) modalReferencia2Input.value = referencia2;
            if (modalCodigoBarrasInput) modalCodigoBarrasInput.value = codigobarra;
            if (modalPrecoInput) modalPrecoInput.value = precoFormatado(preco);
        });
    }

    // Função para formatar o preço para exibição
    function precoFormatado(valor) {
        if (!valor) return "0,00";
        // Converte para número e formata com 2 casas decimais
        return parseFloat(valor).toFixed(2).replace('.', ',');
    }

    var btnSalvar = document.getElementById('btnSalvarAlteracoes');
    if (btnSalvar) {
        btnSalvar.addEventListener('click', function() {
            var form = document.getElementById('formEditarProduto');
            
            // Verificação de validação básica
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            var formData = new FormData(form);

            // Adicionar feedback visual de carregamento
            btnSalvar.disabled = true;
            btnSalvar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...';

            // Enviar dados para o controller PHP
            fetch('index.php?uri=', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                return response.json(); // Converte a resposta para JSON
            })
            .then(data => {
                console.log('Resposta do servidor:', data);
                
                if (data.success) {
                    // Mostra mensagem de sucesso
                    exibirAlerta('success', 'Produto atualizado com sucesso!');
                    
                    // Fecha o modal
                    if (bootstrapModalInstance) {
                        bootstrapModalInstance.hide();
                    }
                    
                    // Atualiza a linha na tabela (se aplicável)
                    atualizarLinhaProduto(formData.get('modalProdutoId'), data.data);
                } else {
                    // Mostra mensagem de erro
                    exibirAlerta('danger', 'Erro ao salvar: ' + (data.message || 'Ocorreu um erro desconhecido.'));
                    console.error("Detalhes do erro:", data.details);
                }
            })
            .catch((error) => {
                console.error('Erro na requisição fetch:', error);
                exibirAlerta('danger', 'Erro de comunicação: ' + error.message);
            })
            .finally(() => {
                // Restaura o botão
                btnSalvar.disabled = false;
                btnSalvar.innerHTML = 'Salvar Alterações';
            });
        });
    }
    
    // Função para mostrar alertas na página
    function exibirAlerta(tipo, mensagem) {
        // Cria o elemento de alerta
        var alertEl = document.createElement('div');
        alertEl.className = 'alert alert-' + tipo + ' alert-dismissible fade show';
        alertEl.setAttribute('role', 'alert');
        alertEl.innerHTML = mensagem + 
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>';
        
        // Insere o alerta no topo da página
        var container = document.querySelector('.container') || document.body;
        container.insertBefore(alertEl, container.firstChild);
        
        // Configura para desaparecer após 5 segundos
        setTimeout(function() {
            alertEl.classList.remove('show');
            setTimeout(function() {
                alertEl.remove();
            }, 150);
        }, 5000);
    }
    
    // Função para atualizar uma linha na tabela de produtos
    function atualizarLinhaProduto(produtoId, dados) {
        var linhaProduto = document.querySelector('tr[data-id="' + produtoId + '"]');
        if (!linhaProduto) return; // Se não encontrar a linha, não faz nada
        
        // Atualiza os dados na linha
        if (dados.NOME) {
            var colDescricao = linhaProduto.querySelector('td[data-campo="descricao"]');
            if (colDescricao) colDescricao.textContent = dados.NOME;
        }
        
        if (dados.REFERENCIA) {
            var colReferencia = linhaProduto.querySelector('td[data-campo="referencia"]');
            if (colReferencia) colReferencia.textContent = dados.REFERENCIA;
        }
        
        if (dados.REFERENCIA2) {
            var colReferencia2 = linhaProduto.querySelector('td[data-campo="referencia2"]');
            if (colReferencia2) colReferencia2.textContent = dados.REFERENCIA2;
        }
        
        if (dados.CODIGOBARRA) {
            var colCodigoBarra = linhaProduto.querySelector('td[data-campo="codigobarra"]');
            if (colCodigoBarra) colCodigoBarra.textContent = dados.CODIGOBARRA;
        }
        
        if (dados.PRECO_VENDA) {
            var colPreco = linhaProduto.querySelector('td[data-campo="preco"]');
            if (colPreco) colPreco.textContent = 'R$ ' + precoFormatado(dados.PRECO_VENDA);
        }
        
        // Atualiza também os atributos data- do botão de editar
        var btnEditar = linhaProduto.querySelector('button[data-id="' + produtoId + '"]');
        if (btnEditar) {
            if (dados.NOME) btnEditar.setAttribute('data-descricao', dados.NOME);
            if (dados.REFERENCIA) btnEditar.setAttribute('data-referencia', dados.REFERENCIA);
            if (dados.REFERENCIA2) btnEditar.setAttribute('data-referencia2', dados.REFERENCIA2);
            if (dados.CODIGOBARRA) btnEditar.setAttribute('data-codigobarra', dados.CODIGOBARRA);
            if (dados.PRECO_VENDA) btnEditar.setAttribute('data-preco', dados.PRECO_VENDA);
        }
        
        // Destaca brevemente a linha atualizada
        linhaProduto.classList.add('table-success');
        setTimeout(function() {
            linhaProduto.classList.remove('table-success');
        }, 3000);
    }
});
</script>