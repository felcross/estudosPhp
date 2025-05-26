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
                                <td class="cell-produto-qtd_max_armazenagem">
                                    <?= htmlspecialchars($produto['QTD_MAX_ARMAZENAGEM'] ?? 0) ?>
                                </td>
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
                                        data-local3="<?= htmlspecialchars($produto['LOCAL3'] ?? '') ?>"
                                    
                                  
                                     >Editar</button>
                                   
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <?php if (!empty($termo)): ?>
                <nav aria-label="Paginação de produtos">
                    <ul class="pagination justify-content-center mt-4">
                        <!-- Botão Anterior -->
                        <?php if ($pagina > 0): ?>
                            <li class="page-item">
                                <a class="page-link" href="?termo=<?= urlencode($termo) ?>&pagina=<?= $pagina - 1 ?>" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </span>
                            </li>
                        <?php endif; ?>

                        <!-- Páginas numeradas -->
                        <?php 
                        $paginaAtual = $pagina;
                        $totalPaginas = max(5, $paginaAtual + 3); // Estimativa, ajuste conforme necessário
                        $iniciarEm = max(0, $paginaAtual - 2);
                        $terminarEm = min($paginaAtual + 2, $totalPaginas - 1);
                        
                        for ($i = $iniciarEm; $i <= $terminarEm; $i++): ?>
                            <?php if ($i == $paginaAtual): ?>
                                <li class="page-item active">
                                    <span class="page-link"><?= $i + 1 ?></span>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="?termo=<?= urlencode($termo) ?>&pagina=<?= $i ?>"><?= $i + 1 ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <!-- Botão Próximo -->
                        <?php if (count($produtos) == 15): // Se retornou o limite máximo, provavelmente há mais páginas ?>
                            <li class="page-item">
                                <a class="page-link" href="?termo=<?= urlencode($termo) ?>&pagina=<?= $pagina + 1 ?>" aria-label="Próximo">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="page-item disabled">
                                <span class="page-link" aria-label="Próximo">
                                    <span aria-hidden="true">&raquo;</span>
                                </span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>

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
                    <form id="formEditarProduto" method="POST"> <!-- Removido action, será tratado por JS -->
                        <input type="hidden" id="modalIdProduto" name="id_produto">
                        <input type="hidden" id="modalRowIndex" name="row_index">
          
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
                            <input type="number" class="form-control" id="modalQtdMaxArmazenagem"
                                name="QTD_MAX_ARMAZENAGEM" min="0" value="0" required>
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
                            <button type="button" class="btn btn-primary" id="btnSalvarAlteracoes">Salvar
                                Alterações</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>