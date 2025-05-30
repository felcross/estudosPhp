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

    <form type="busc" class="mb-4">
         <input type="hidden" name="class" value="ProductController">  
         <input type="hidden" name="method" value="buscar">
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

    <?php                        
 if (!empty($termo)): ?>
        <div class="alert alert-info">
            Resultados da busca por: <strong><?= htmlspecialchars($termo) ?></strong>.
            <?php if (isset($produtos) && is_array($produtos)): ?>
                <?= count($produtos) ?> produto(s) encontrado(s) nesta página.
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
                                        data-referencia="<?= htmlspecialchars($produto['REFERENCIA'] ?? '') ?>"
                                        data-referencia2="<?= htmlspecialchars($produto['REFERENCIA2'] ?? '') ?>"
                                        data-nome="<?= htmlspecialchars($produto['NOME'] ?? 'Sem título') ?>">Editar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php
            // Lógica para determinar se os botões devem estar ativos ou desativados
            $paginaAtual = $pagina ?? 1; // Pega a página atual vinda do controller
            $limiteResultados = $limite ?? 25; // Pega o limite vindo do controller (ou define um padrão)
            $numeroDeProdutosNestaPagina = count($produtos);

            $temAnterior = ($paginaAtual > 1);
            // Se o número de produtos for igual ao limite, assumimos que PODE haver uma próxima página.
            // É a melhor abordagem sem ter o total de páginas.
            $temProxima = ($numeroDeProdutosNestaPagina === $limiteResultados);
        ?>
        <nav aria-label="Navegação da página de produtos">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= !$temAnterior ? 'disabled' : '' ?>">
                    <a class="page-link" 
                       href="index.php?class=<?= $class ?>&method=<?= $method ?>&termo=<?= htmlspecialchars( $termo) ?>&pagina=<?= $paginaAtual - 1 ?>" 
                       aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li class="page-item active" aria-current="page">
                    <span class="page-link"><?= $paginaAtual ?></span>
                </li>

                <li class="page-item <?= !$temProxima ? 'disabled' : '' ?>">
                    <a type="busc" class="page-link" 
                       href="index.php?class=<?= $class ?>&method=<?= $method ?>&termo=<?= htmlspecialchars($termo) ?>&pagina=<?= $paginaAtual + 1 ?>" 
                       aria-label="Próxima">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        <?php elseif (!empty($termo)): ?>
        <div class="alert alert-warning">
            Nenhum produto encontrado com o termo de busca.
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="modalEditarProdutoLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Produto - <span id="modalNomeProduto"></span></h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form id="formEditarProduto" method="POST"> 
                     <input type="hidden" id="modalIdProduto" name="id_produto">
                     <input type="hidden" id="modalRowIndex" name="row_index">
                     <input type="hidden" id="modalReferencia" name="referencia">
                     <input type="hidden" id="modalReferencia2" name="referencia2">
                     <input type="hidden" id="modalNome" name="nome">
         
                     <div class="mb-3">
                         <label for="modalCodigoInterno" class="form-label">Código Interno (Produto)</label>
                         <input type="text" class="form-control" id="modalCodigoInterno" name="id_produto" readonly>
                     </div>

                     <div class="mb-3">
                         <label for="modalReferenciaDisplay" class="form-label">Referência</label>
                         <input type="text" class="form-control" id="modalReferenciaDisplay" name="referencia" readonly>
                     </div>

                     <div class="mb-3">
                         <label for="modalReferencia2Display" class="form-label">Referência 2</label>
                         <input type="text" class="form-control" id="modalReferencia2Display" name="referencia2" readonly>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



</body>



</html>