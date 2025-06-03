<?php
// src/view/components/ProductsTable.php
/**
 * Props esperadas:
 * - $produtos: array - lista de produtos
 */

if (!empty($produtos) && is_array($produtos)): ?>
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
                    <?= \Core\View::component('ProductTableRow', [
                        'produto' => $produto,
                        'index' => $index
                    ]) ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>