<?php
// src/view/components/SearchForm.php
/**
 * Props esperadas:
 * - $termo: string - termo de busca atual
 * - $class: string - classe do controller
 * - $method: string - método do controller
 */
?>

<style>
.search-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}

.search-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #6610f2, #e83e8c, #fd7e14);
    background-size: 300% 100%;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.search-input-group {
    position: relative;
}

.search-input {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 0.75rem 1rem 0.75rem 3rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.search-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1.1rem;
    z-index: 2;
    transition: color 0.3s ease;
}

.search-input:focus + .search-icon {
    color: #007bff;
}

.search-btn {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    position: relative;
    overflow: hidden;
}

.search-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.search-btn:hover::before {
    left: 100%;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
}

.search-btn:active {
    transform: translateY(0);
}

.search-title {
    color: #495057;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.search-title i {
    color: #007bff;
}

.floating-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.particle {
    position: absolute;
    background: rgba(0, 123, 255, 0.1);
    border-radius: 50%;
    animation: float 4s ease-in-out infinite;
}

.particle:nth-child(1) {
    width: 8px;
    height: 8px;
    top: 20%;
    left: 15%;
    animation-delay: 0s;
}

.particle:nth-child(2) {
    width: 6px;
    height: 6px;
    top: 70%;
    right: 20%;
    animation-delay: 1s;
}

.particle:nth-child(3) {
    width: 10px;
    height: 10px;
    bottom: 30%;
    left: 70%;
    animation-delay: 2s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-10px) rotate(120deg); }
    66% { transform: translateY(5px) rotate(240deg); }
}

@media (max-width: 768px) {
    .search-container {
        padding: 1rem;
        border-radius: 12px;
    }
    
    .search-btn {
        margin-top: 0.5rem;
    }
}
</style>

<div class="search-container">
    <div class="floating-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="search-title">
        <i class="fas fa-search"></i>
        Buscar Produtos
    </div>
    
    <form type="busc" class="mb-0">
        <input type="hidden" name="class" value="<?= htmlspecialchars($class ?? 'ProductController') ?>">  
        <input type="hidden" name="method" value="<?= htmlspecialchars($method ?? 'buscar') ?>">
        
        <div class="row g-3">
            <div class="col-md-8">
                <div class="search-input-group">
                    <input type="text" 
                           name="termo" 
                           class="form-control search-input"
                           placeholder="Digite o código, descrição ou código de barras"
                           value="<?= htmlspecialchars($termo ?? '') ?>"
                           autocomplete="off">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary search-btn w-100">
                    <i class="fas fa-search me-2"></i>
                    Buscar
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Adiciona funcionalidade de busca ao pressionar Enter
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="termo"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.closest('form').submit();
            }
        });
        
        // Foco automatico no input quando a página carregar
        searchInput.focus();
        
        // Efeito de digitação suave
        searchInput.addEventListener('input', function() {
            this.style.transform = 'scale(1.01)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    }
});
</script>