<?php
// src/view/components/ProductTableRow.php
/**
 * Props esperadas:
 * - $produto: array - dados do produto
 * - $index: int - índice da linha
 */
?>

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
        <button type="button" 
                class="btn btn-sm btn-primary btn-editar-produto"
                data-bs-toggle="modal" 
                data-bs-target="#modalEditarProduto"
                data-row-index="<?= $index ?>"
                data-id_produto="<?= htmlspecialchars($produto['PRODUTO'] ?? '') ?>"
                data-codigobarra="<?= htmlspecialchars($produto['CODIGOBARRA'] ?? '') ?>"
                data-qtd_max_armazenagem="<?= htmlspecialchars($produto['QTD_MAX_ARMAZENAGEM'] ?? 0) ?>"
                data-local="<?= htmlspecialchars($produto['LOCAL'] ?? '') ?>"
                data-local2="<?= htmlspecialchars($produto['LOCAL2'] ?? '') ?>"
                data-local3="<?= htmlspecialchars($produto['LOCAL3'] ?? '') ?>"
                data-referencia="<?= htmlspecialchars($produto['REFERENCIA'] ?? '') ?>"
                data-referencia2="<?= htmlspecialchars($produto['REFERENCIA2'] ?? '') ?>"
                data-nome="<?= htmlspecialchars($produto['NOME'] ?? 'Sem título') ?>">
            Editar
        </button>
    </td>
</tr>