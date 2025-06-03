<?php
// src/view/components/NoResults.php
/**
 * Props esperadas:
 * - $termo: string - termo de busca
 * - $produtos: array - lista de produtos (para verificar se está vazia)
 */

if (!empty($termo) && (empty($produtos) || !is_array($produtos))): ?>
    <div class="alert alert-warning">
        Nenhum produto encontrado com o termo de busca.
    </div>
<?php endif; ?>