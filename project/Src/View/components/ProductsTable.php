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

    /* Responsividade melhorada */
    @media (max-width: 768px) {
        .modern-table-container {
            margin: 1rem 0;
            border-radius: 12px;
        }
        
        .table thead th {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.85rem;
        }
        
        .table tbody tr:hover {
            transform: none;
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
    </div>
<?php else: ?>
    <div class="table-empty">
        <i class="fas fa-search"></i>
        <h5>Nenhum produto encontrado</h5>
        <p class="mb-0">Tente ajustar os termos de busca ou verifique se há produtos cadastrados.</p>
    </div>
<?php endif; ?>