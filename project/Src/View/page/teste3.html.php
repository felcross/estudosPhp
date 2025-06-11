<?php
// src/view/page/teste3.html.php
use Core\View;
?>

<div class="container my-5">
    <h1 class="mb-4">Busca e Edição de Produtos</h1>

    <!-- Área para mensagens flash -->
    <div id="flashMessages" class="mb-4">
        <!-- Mensagens flash serão inseridas aqui dinamicamente -->
    </div>

    <!-- Formulário de Busca -->
    <?= View::component('SearchForm', [
        'termo' => $termo ?? '',
        'class' => $class ?? 'ProductController',
        'method' => $method ?? 'buscar'
    ]) ?>

    <!-- Informações dos Resultados -->
    <?= View::component('SearchResultsInfo', [
        'termo' => $termo ?? '',
        'produtos' => $produtos ?? []
    ]) ?>

    <!-- Tabela de Produtos -->
    <?= View::component('ProductsTable', [
        'produtos' => $produtos ?? []
    ]) ?>

    <!-- Paginação -->
    <?= View::component('Pagination', [
        'produtos' => $produtos ?? [],
        'pagina' => $pagina ?? 1,
        'limite' => $limite ?? 25,
        'class' => $class ?? 'ProductController',
        'method' => $method ?? 'buscar',
        'termo' => $termo ?? ''
    ]) ?>

    <!-- Mensagem de Nenhum Resultado -->
    <?= View::component('NoResults', [
        'termo' => $termo ?? '',
        'produtos' => $produtos ?? []
    ]) ?>
</div>

<!-- Modal de Edição -->
<?= View::component('EditProductModal') ?>
