<?php
// src/view/components/Pagination.php
/**
 * Props esperadas:
 * - $produtos: array - lista de produtos para calcular se tem próxima página
 * - $pagina: int - página atual
 * - $limite: int - limite de resultados por página
 * - $class: string - classe do controller
 * - $method: string - método do controller
 * - $termo: string - termo de busca atual
 */

if (!empty($produtos) && is_array($produtos)):
    // Lógica para determinar se os botões devem estar ativos ou desativados
    $paginaAtual = $pagina ?? 1;
    $limiteResultados = $limite ?? 25;
    $numeroDeProdutosNestaPagina = count($produtos);

    $temAnterior = ($paginaAtual > 1);
    $temProxima = ($numeroDeProdutosNestaPagina === $limiteResultados);
?>
    <nav aria-label="Navegação da página de produtos">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= !$temAnterior ? 'disabled' : '' ?>">
                <a class="page-link" 
                   href="index.php?class=<?= $class ?>&method=<?= $method ?>&termo=<?= htmlspecialchars($termo) ?>&pagina=<?= $paginaAtual - 1 ?>" 
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
<?php endif; ?>