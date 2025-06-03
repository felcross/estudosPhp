<?php
// src/view/components/SearchResultsInfo.php
/**
 * Props esperadas:
 * - $termo: string - termo de busca
 * - $produtos: array - lista de produtos encontrados
 */

if (!empty($termo)): ?>
    <div class="alert alert-info">
        Resultados da busca por: <strong><?= htmlspecialchars($termo) ?></strong>.
        <?php if (isset($produtos) && is_array($produtos)): ?>
            <?= count($produtos) ?> produto(s) encontrado(s) nesta página.
        <?php endif; ?>
    </div>
<?php endif; ?>