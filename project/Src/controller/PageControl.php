<?php 
namespace controller;


use Exception;

class PageControl  
{
    /**
     * Método principal que processa a requisição
     * Mantém compatibilidade com seu código atual
     */
    public function show() 
    {
        if ($_GET) {
            $method = isset($_GET['method']) ? $_GET['method'] : null;
            
            if ($method) {
                // Validações de segurança antes de executar
                $this->validateMethodCall($method);
                
                // Executa o método se passou nas validações
                if (method_exists($this, $method)) {
                    // Usa call_user_func ao invés de $_REQUEST por segurança
                    call_user_func([$this, $method], $this->getCleanRequest());                   
                }
            } else {
                // Se não tem método, chama o método padrão (se existir)
                $this->defaultAction();
            }
        } else {
            // Se não tem GET, chama ação padrão
            $this->defaultAction();
        }
    }
    
    /**
     * Valida se o método pode ser chamado com segurança
     */
    private function validateMethodCall(string $method): void
    {
        // 1. Verifica se não é método proibido
        if ($this->isDangerousMethod($method)) {
            throw new SecurityException("Método '{$method}' não pode ser executado");
        }
        
        
        // 3. Sanitiza o nome do método
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $method)) {
            throw new SecurityException("Nome do método contém caracteres inválidos");
        }
    }
    
    /**
     * Verifica se é um método perigoso
     */
    private function isDangerousMethod(string $method): bool
    {
        $dangerousMethods = [
            '__construct', '__destruct', '__call', '__callStatic',
            '__get', '__set', '__isset', '__unset', '__sleep',
            '__wakeup', '__serialize', '__unserialize', '__toString',
            '__invoke', '__set_state', '__clone', '__debugInfo',
            'show', 'validateMethodCall', 'getCleanRequest', 'isDangerousMethod'
        ];
        
        return in_array($method, $dangerousMethods);
    }
    
    /**
     * Retorna dados limpos da requisição (sem usar $_REQUEST diretamente)
     */
    private function getCleanRequest(): array
    {
        // Combina GET e POST, mas de forma mais segura
        $data = [];
        
        // Adiciona dados do GET (já filtrados)
        foreach ($_GET as $key => $value) {
            $data[$key] = $this->sanitizeInput($key, $value);
        }
        
        // Adiciona dados do POST (filtrados)
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->sanitizeInput($key, $value);
        }
        
        return $data;
    }
    
    /**
     * Sanitiza input individual
     */
    private function sanitizeInput(string $key, $value)
    {
        // Lista de campos que não devem ser sanitizados (senhas, tokens, etc.)
        $noSanitize = ['password', 'senha', 'token', 'csrf_token'];
        
        if (in_array($key, $noSanitize)) {
            return $value; // Retorna sem sanitizar
        }
        
        // Sanitiza strings
        if (is_string($value)) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        
        // Arrays recursivos
        if (is_array($value)) {
            return array_map(function($item) use ($key) {
                return $this->sanitizeInput($key, $item);
            }, $value);
        }
        
        return $value;
    }
    
    /**
     * Ação padrão quando não há método específico
     * Pode ser sobrescrita pelos controllers filhos
     */
    protected function defaultAction(): void
    {
        // Verifica se existe método 'index'
        if (method_exists($this, 'index')) {
            $this->show();
        } else {
            echo "<div class='alert alert-info'>";
            echo "<h4>Bem-vindo!</h4>";
            echo "<p>Nenhuma ação específica foi solicitada.</p>";
            echo "</div>";
        }
    }
    
    /**
     * Helper para validar dados de input de forma mais fácil
     */
    protected function getInput(string $key, int $filter = FILTER_SANITIZE_SPECIAL_CHARS, $default = null)
    {
        $value = $_GET[$key] ?? $_POST[$key] ?? $default;
        
        if ($value === null) {
            return $default;
        }
        
        return filter_var($value, $filter) ?: $default;
    }
    
    /**
     * Helper para verificar se é requisição POST
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Helper para verificar se é requisição AJAX
     */
    protected function isAjax(): bool
    {
        return (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        );
    }
}

/**
 * Exceções customizadas
 */
class SecurityException extends Exception {}
class NotFoundException extends Exception {}
class ReflectionMethod extends Exception {}

