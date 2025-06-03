<?php
// src/view/components/SearchForm.php
/**
 * Props esperadas:
 * - $termo: string - termo de busca atual
 * - $class: string - classe do controller
 * - $method: string - método do controller
 */
?>

<form type="busc" class="mb-4">
    <input type="hidden" name="class" value="<?= htmlspecialchars($class ?? 'ProductController') ?>">  
    <input type="hidden" name="method" value="<?= htmlspecialchars($method ?? 'buscar') ?>">
    
    <div class="row g-3">
        <div class="col-md-8">
            <input type="text" 
                   name="termo" 
                   class="form-control"
                   placeholder="Digite o código, descrição ou código de barras"
                   value="<?= htmlspecialchars($termo ?? '') ?>">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </div>
</form>