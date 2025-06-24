<?php
// src/view/components/ProductsTable.php
/**
 * Props esperadas:
 * - $produtos: array - lista de produtos
 */

if (!empty($produtos) && is_array($produtos)): ?>
    <style>
    .modern-table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.06);
        margin: 1.5rem 0;
        position: relative;
    }

    .modern-table-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #007bff, #6610f2, #e83e8c, #fd7e14);
        background-size: 300% 100%;
        animation: gradientFlow 4s ease infinite;
    }

    @keyframes gradientFlow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .table-responsive {
        border-radius: 0 0 16px 16px;
        background: white;
    }

    .table {
        margin-bottom: 0;
        border: none;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border: none;
        padding: 1rem 0.75rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        border-bottom: 3px solid #007bff;
    }

    .table thead th:first-child {
        border-top-left-radius: 0;
    }

    .table thead th:last-child {
        border-top-right-radius: 0;
    }

    .table thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: #007bff;
        transition: width 0.3s ease;
    }

    .table thead th:hover::after {
        width: 100%;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border: none;
        position: relative;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.03) 0%, rgba(0, 123, 255, 0.08) 100%);
        transform: translateX(3px);
        box-shadow: 3px 0 12px rgba(0, 123, 255, 0.15);
    }

    .table tbody tr:hover::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 0 4px 4px 0;
    }

    .table tbody td {
        border: none;
        padding: 1rem 0.75rem;
        vertical-align: middle;
        font-size: 0.9rem;
        color: #495057;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        position: relative;
    }

    .table tbody tr:nth-child(even) {
        background-color: rgba(248, 249, 250, 0.5);
    }

    .table tbody tr:nth-child(odd) {
        background-color: transparent;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Estilo para células com códigos */
    .table tbody td:first-child,
    .table tbody td:nth-child(2) {
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        font-weight: 500;
        color: #6f42c1;
        background: rgba(111, 66, 193, 0.05);
        border-radius: 6px;
        margin: 0.25rem;
        font-size: 0.85rem;
    }

    /* Estilo para células de quantidade */
    .table tbody td:nth-child(3) {
        font-weight: 600;
        color: #28a745;
        text-align: center;
        position: relative;
    }

    .table tbody td:nth-child(3)::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        background: #28a745;
        border-radius: 50%;
        z-index: -1;
        box-shadow: 0 0 0 8px rgba(40, 167, 69, 0.1);
    }

    /* Estilo para células de localização */
    .table tbody td:nth-child(4),
    .table tbody td:nth-child(5),
    .table tbody td:nth-child(6) {
        font-weight: 500;
        color: #fd7e14;
        position: relative;
    }

    .table tbody td:nth-child(4):not(:empty)::before,
    .table tbody td:nth-child(5):not(:empty)::before,
    .table tbody td:nth-child(6):not(:empty)::before {
        content: '📍';
        margin-right: 0.5rem;
        font-size: 0.8rem;
    }

    /* Estilo para coluna de ações */
    .table tbody td:last-child {
        text-align: center;
        padding: 0.75rem;
    }

    /* Animação de carregamento sutil */
    .table tbody {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* VERSÃO MOBILE - CARDS RESPONSIVOS */
    .mobile-cards-container {
        display: none;
        padding: 1rem;
        gap: 1rem;
        flex-direction: column;
        background: white;
        border-radius: 0 0 16px 16px;
        animation: fadeInUp 0.6s ease-out;
    }

    .product-card {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #007bff, #6610f2);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        border-color: rgba(0, 123, 255, 0.2);
    }

    .product-card:hover::before {
        transform: scaleX(1);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    .card-codes {
        flex: 1;
    }

    .code-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
    }

    .code-item:last-child {
        margin-bottom: 0;
    }

    .code-label {
        font-weight: 600;
        color: #6c757d;
        min-width: 80px;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .code-value {
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        font-weight: 500;
        color: #6f42c1;
        background: rgba(111, 66, 193, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .card-quantity {
        text-align: center;
        min-width: 60px;
    }

    .quantity-badge {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        position: relative;
        overflow: hidden;
    }

    .quantity-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .quantity-badge:hover::before {
        left: 100%;
    }

    .card-locations {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 0.75rem;
        margin: 1rem 0;
    }

    .location-item {
        background: rgba(253, 126, 20, 0.1);
        border: 1px solid rgba(253, 126, 20, 0.2);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
    }

    .location-item:not(:empty) {
        color: #fd7e14;
        font-weight: 500;
    }

    .location-item:empty {
        opacity: 0.3;
        background: rgba(108, 117, 125, 0.1);
        border-color: rgba(108, 117, 125, 0.2);
    }

    .location-item:not(:empty)::before {
        content: '📍';
        margin-right: 0.5rem;
        font-size: 0.8rem;
    }

    .location-item:not(:empty):hover {
        background: rgba(253, 126, 20, 0.15);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(253, 126, 20, 0.2);
    }

    .location-label {
        font-size: 0.7rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
        display: block;
    }

    .card-actions {
        text-align: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        margin-top: 1rem;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .modern-table-container {
            margin: 1rem 0;
            border-radius: 12px;
        }

        

        /* Esconder tabela no mobile */
        .table-responsive {
            display: none;
        }

        /* Mostrar cards no mobile */
        .mobile-cards-container {
            display: flex;
        }

        .product-card {
            padding: 1rem;
        }

        .card-header {
            flex-direction: column;
            gap: 0.75rem;
        }

        .card-quantity {
            align-self: flex-end;
        }

        .card-locations {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
    }

    @media (min-width: 769px) {
        /* No desktop, manter comportamento original */
        .table thead th {
            padding: 1rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .table tbody td {
            padding: 1rem 0.75rem;
            font-size: 0.9rem;
        }
    }

    /* Efeito de loading para quando não há dados */
    .table-empty {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 16px;
        margin: 1.5rem 0;
    }

    .table-empty i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
        display: block;
    }
    </style>

    <div class="modern-table-container">
        <!-- Versão Desktop - Tabela -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
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

        <!-- Versão Mobile - Cards -->
        <div class="mobile-cards-container">
            <?php foreach ($produtos as $index => $produto): ?>
                <div class="product-card" id="produto-card-<?= $index ?>">
                
                    <div class="card-header">
                        <div class="card-codes">
                            <div class="code-item">
                                <span class="code-label">Interno:</span>
                                <span class="code-value"><?= htmlspecialchars($produto->PRODUTO ?? '') ?></span>
                            </div>
                            <div class="code-item">
                                <span class="code-label">Barras:</span>
                                <span class="code-value"><?= htmlspecialchars($produto->CODIGOBARRA ?? '') ?></span>
                            </div>
                        </div>
                        <div class="card-quantity">
                            <div class="quantity-badge">
                                <?= htmlspecialchars($produto->QTD_MAX_ARMAZENAGEM ?? '0') ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-locations">
                        <div class="location-item <?= empty($produto->LOCAL) ? 'empty' : '' ?>">
                            <span class="location-label">Local 1</span>
                            <?= htmlspecialchars($produto->LOCAL ?? '') ?>
                        </div>
                        <div class="location-item <?= empty($produto->LOCAL2) ? 'empty' : '' ?>">
                            <span class="location-label">Local 2</span>
                            <?= htmlspecialchars($produto->LOCAL2 ?? '') ?>
                        </div>
                        <div class="location-item <?= empty($produto->LOCAL3) ? 'empty' : '' ?>">
                            <span class="location-label">Local 3</span>
                            <?= htmlspecialchars($produto->LOCAL3 ?? '') ?>
                        </div>
                    </div>

                    <div class="card-actions">
                        <?= \Core\View::component('ProductCardRow', [
                            'produto' => $produto,
                            'index' => $index,
                            'mobile_mode' => true
                        ]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="table-empty">
        <i class="fas fa-search"></i>
        <h5>Nenhum produto encontrado</h5>
        <p class="mb-0">Tente ajustar os termos de busca ou verifique se há produtos cadastrados.</p>
    </div>
<?php endif; ?>