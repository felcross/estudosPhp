<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca e Edição de Produtos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
 
</head>

<body> 

    <div class="container my-5">
        <h1 class="mb-4">Busca e Edição de Produtos</h1>

        <!-- Formulário de Busca -->
        <form action="index.php?uri=&" method="GET" class="mb-4">
            <!-- Se você usa uma variável 'uri' no seu roteamento, descomente e ajuste: -->
            <!-- <input type="hidden" name="uri" value="sua/rota/de/busca"> -->
            <div class="row g-3">
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

        <!-- Feedback da Busca -->
        <?php if (!empty($termo)): ?>
            <div class="alert alert-info">
                Resultados da busca por: <strong><?= htmlspecialchars($termo) ?></strong>.
                <?php if (isset($produtos) && is_array($produtos)): ?>
                    <?= count($produtos) ?> produto(s) encontrado(s).
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Tabela de Produtos -->
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
                                    <!-- Campos ocultos para armazenar todos os dados do produto -->
                                    <div class="produto-dados-completos" style="display: none;" 
                                         id="produto-dados-<?= $index ?>"
                                         data-produto="<?= htmlspecialchars(json_encode($produto)) ?>">
                                    </div>
                                    
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
        <?php elseif (!empty($termo)): ?>
            <div class="alert alert-warning">
                Nenhum produto encontrado com o termo de busca.
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Editar Produto -->
    <div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="modalEditarProdutoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarProduto" method="POST">
                        <input type="hidden" id="modalIdProduto" name="id_produto">
                        <input type="hidden" id="modalRowIndex" name="row_index">
                        
                        <!-- Container para campos ocultos dinamicamente adicionados -->
                        <div id="camposOcultos"></div>

                        <div class="mb-3">
                            <label for="modalCodigoInterno" class="form-label">Código Interno (Produto)</label>
                            <input type="text" class="form-control" id="modalCodigoInterno" name="id_produto" readonly>
                        </div>
                  
                        <div class="mb-3">
                            <label for="modalCodigoBarras" class="form-label">Código de Barras</label>
                            <input type="text" class="form-control" id="modalCodigoBarras" name="CODIGOBARRA">
                        </div>
                        <div class="mb-3">
                            <label for="modalQtdMaxArmazenagem" class="form-label">Qtd. Máx. Armazenagem</label>
                            <input type="number" class="form-control" id="modalQtdMaxArmazenagem" name="QTD_MAX_ARMAZENAGEM" min="0" value="0" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="modalLocal" class="form-label">Local</label>
                                <input type="text" class="form-control" id="modalLocal" name="LOCAL">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="modalLocal2" class="form-label">Local 2</label>
                                <input type="text" class="form-control" id="modalLocal2" name="LOCAL2">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="modalLocal3" class="form-label">Local 3</label>
                                <input type="text" class="form-control" id="modalLocal3" name="LOCAL3">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary" id="btnSalvarAlteracoes">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Popper.js incluído) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para manipular os dados completos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manipulador para o botão Editar
            const botoesEditar = document.querySelectorAll('.btn-editar-produto');
            botoesEditar.forEach(botao => {
                botao.addEventListener('click', function() {
                    const rowIndex = this.getAttribute('data-row-index');
                    const dadosCompletosContainer = document.getElementById(`produto-dados-${rowIndex}`);
                    const dadosCompletos = JSON.parse(dadosCompletosContainer.getAttribute('data-produto'));
                    
                    // Preenche os campos visíveis do modal
                    document.getElementById('modalIdProduto').value = dadosCompletos.PRODUTO || '';
                    document.getElementById('modalCodigoInterno').value = dadosCompletos.PRODUTO || '';
                    document.getElementById('modalCodigoBarras').value = dadosCompletos.CODIGOBARRA || '';
                    document.getElementById('modalQtdMaxArmazenagem').value = dadosCompletos.QTD_MAX_ARMAZENAGEM || 0;
                    document.getElementById('modalLocal').value = dadosCompletos.LOCAL || '';
                    document.getElementById('modalLocal2').value = dadosCompletos.LOCAL2 || '';
                    document.getElementById('modalLocal3').value = dadosCompletos.LOCAL3 || '';
                    document.getElementById('modalRowIndex').value = rowIndex;
                    
                    // Limpa os campos ocultos anteriores
                    const camposOcultos = document.getElementById('camposOcultos');
                    camposOcultos.innerHTML = '';
                    
                    // Adiciona todos os campos do produto como campos ocultos, exceto os que já estão visíveis
                    const camposVisiveis = ['PRODUTO', 'CODIGOBARRA', 'QTD_MAX_ARMAZENAGEM', 'LOCAL', 'LOCAL2', 'LOCAL3'];
                    
                    for (const [chave, valor] of Object.entries(dadosCompletos)) {
                        if (!camposVisiveis.includes(chave)) {
                            const inputOculto = document.createElement('input');
                            inputOculto.type = 'hidden';
                            inputOculto.name = chave;
                            inputOculto.value = valor !== null ? valor : '';
                            camposOcultos.appendChild(inputOculto);
                        }
                    }
                });
            });
            
            // Manipulador para o botão Salvar Alterações
            document.getElementById('btnSalvarAlteracoes').addEventListener('click', function() {
                const formData = new FormData(document.getElementById('formEditarProduto'));
                const rowIndex = formData.get('row_index');
                
                // Aqui você pode implementar o envio via AJAX
                // Exemplo de como poderia ser:
                fetch('sua_url_de_atualizacao', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Produto atualizado com sucesso!');
                        // Atualiza os dados na tabela sem recarregar a página
                        atualizarLinhaTabela(rowIndex, formData);
                        // Fecha o modal
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalEditarProduto'));
                        modalInstance.hide();
                    } else {
                        alert('Erro ao atualizar o produto: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Ocorreu um erro ao processar a solicitação.');
                });
                
                // Função para atualizar a linha da tabela com os novos dados
                function atualizarLinhaTabela(index, formData) {
                    const row = document.getElementById(`produto-row-${index}`);
                    if (row) {
                        // Atualiza os campos visíveis na tabela
                        row.querySelector('.cell-produto-codigobarra').textContent = formData.get('CODIGOBARRA');
                        row.querySelector('.cell-produto-qtd_max_armazenagem').textContent = formData.get('QTD_MAX_ARMAZENAGEM');
                        row.querySelector('.cell-produto-local').textContent = formData.get('LOCAL');
                        row.querySelector('.cell-produto-local2').textContent = formData.get('LOCAL2');
                        row.querySelector('.cell-produto-local3').textContent = formData.get('LOCAL3');
                        
                        // Atualiza também os dados completos armazenados
                        const dadosProduto = {};
                        formData.forEach((valor, chave) => {
                            dadosProduto[chave] = valor;
                        });
                        
                        const dadosContainer = document.getElementById(`produto-dados-${index}`);
                        dadosContainer.setAttribute('data-produto', JSON.stringify(dadosProduto));
                    }
                }
            });
        });
    </script>
</body>
</html>