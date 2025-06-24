<?php
// src/view/components/ProductCardRow.php
/**
 * Props esperadas:
 * - $produto: ProdutoDTO - dados do produto
 * - $index: int - índice do produto na lista
 */
?>

<button type="button" 
        class="btn btn-sm btn-primary btn-editar-produto"
        data-bs-toggle="modal" 
        data-bs-target="#modalEditarProduto"
        data-row-index="<?= $index ?>"
        data-id_produto="<?= htmlspecialchars($produto->PRODUTO ?? '') ?>"
        data-codigobarra="<?= htmlspecialchars($produto->CODIGOBARRA ?? '') ?>"
        data-qtd_max_armazenagem="<?= htmlspecialchars($produto->QTD_MAX_ARMAZENAGEM ?? 0) ?>"
        data-local="<?= htmlspecialchars($produto->LOCAL ?? '') ?>"
        data-local2="<?= htmlspecialchars($produto->LOCAL2 ?? '') ?>"
        data-local3="<?= htmlspecialchars($produto->LOCAL3 ?? '') ?>"
        data-referencia="<?= htmlspecialchars($produto->REFERENCIA ?? '') ?>"
        data-referencia2="<?= htmlspecialchars($produto->REFERENCIA2 ?? '') ?>"
        data-nome="<?= htmlspecialchars($produto->NOME ?? 'Sem título') ?>">
    Editar
</button>