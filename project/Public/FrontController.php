<?php

class FrontController
{
    private array $allowedControllers = [];
    private array $allowedMethods = [];
    private string $defaultController = 'HomeController';
    private string $defaultMethod = 'index';
    private string $controllerNamespace = '\\controller\\';

    public function __construct()
    {
        $this->setupAllowedControllers();
        $this->setupAllowedMethods();
    }

    /**
     * Processa a requisição atual
     */
    public function dispatch(): void
    {
        try {
            // Obtém e valida controller e método
            $controllerName = $this->getValidatedController();
            $methodName = $this->getValidatedMethod();

            // Executa o controller
            $this->executeController($controllerName, $methodName);

        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    /**
     * Configura controllers permitidos (whitelist)
     */
    private function setupAllowedControllers(): void
    {
        $this->allowedControllers = [
            'HomeController',
            'ProductController'
        ];
    }

    /**
     * Configura métodos permitidos por controller
     */
    private function setupAllowedMethods(): void
    {
        $this->allowedMethods = [
            'HomeController' => ['index', 'sobre', 'contato'],
            'ProductController' => ['processarAtualizacaoAjax', 'buscar']


        ];
    }

    /**
     * Obtém e valida o controller da requisição
     */
    private function getValidatedController(): string
    {
        $controller = $_GET['class'] ?? $this->defaultController;

        // Remove possíveis caracteres perigosos
        $controller = $this->sanitizeInput($controller);

        // Garante que termina com 'Controller'
        if (!str_ends_with($controller, 'Controller')) {
            $controller .= 'Controller';
        }

        // Valida se está na whitelist
        if (!$this->isControllerAllowed($controller)) {
            throw new SecurityException("Controller '{$controller}' não autorizado");
        }

        // Verifica se a classe existe
        $fullClassName = $this->controllerNamespace . $controller;
        if (!class_exists($fullClassName)) {
            throw new NotFoundException("Controller '{$controller}' não encontrado");
        }

        return $controller;
    }

    /**
     * Obtém e valida o método da requisição
     */
    private function getValidatedMethod(): string
    {
        $method = $_GET['method'] ?? $this->defaultMethod;

        // Remove possíveis caracteres perigosos
        $method = $this->sanitizeInput($method);

        // Valida formato do método (só letras, números e underscore)
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $method)) {
            throw new SecurityException("Método '{$method}' possui formato inválido");
        }

        return $method;
    }

    /**
     * Executa o controller validado
     */
    private function executeController(string $controllerName, string $methodName): void
    {
        $fullClassName = $this->controllerNamespace . $controllerName;

        // Instancia o controller
        $controller = new $fullClassName;

        // Validações finais de segurança (só se método foi especificado)
        if ($methodName && $methodName !== 'show') {
            $this->validateMethodExecution($controller, $controllerName, $methodName);
        }

        // Executa seguindo o padrão PageControl
        // Todos os controllers estendem PageControl que tem o método show()
        $controller->show();
    }

    /**
     * Valida se o método pode ser executado com segurança
     * Agora valida o método que será chamado pelo PageControl.show()
     */
    private function validateMethodExecution(object $controller, string $controllerName, string $methodName): void
    {
        // Se não há método específico, não precisa validar (show() vai usar default)
        if (!$methodName || $methodName === 'show') {
            return;
        }

        // 1. Verifica se o método existe
        if (!method_exists($controller, $methodName)) {
            throw new NotFoundException("Método '{$methodName}' não encontrado no controller '{$controllerName}'");
        }

        // 2. Verifica se o método é público (usando Reflection)
        $reflection = new ReflectionMethod($controller, $methodName);
        if (!$reflection->isPublic()) {
            throw new SecurityException("Método '{$methodName}' não é público");
        }

        // 3. Verifica se não é método estático
        if ($reflection->isStatic()) {
            throw new SecurityException("Métodos estáticos não podem ser executados via URL");
        }

        // 4. Verifica whitelist de métodos por controller (se configurado)
        if ($this->hasMethodWhitelist($controllerName)) {
            if (!$this->isMethodAllowed($controllerName, $methodName)) {
                throw new SecurityException("Método '{$methodName}' não autorizado para '{$controllerName}'");
            }
        }

        // 5. Bloqueia métodos "perigosos" (construtores, destrutores, mágicos)
        if ($this->isDangerousMethod($methodName)) {
            throw new SecurityException("Método '{$methodName}' não pode ser executado via URL");
        }

        // 6. Valida se não está tentando chamar o próprio método show() 
        // (para evitar recursão ou bypass)
        if ($methodName === 'show') {
            throw new SecurityException("Método 'show' não pode ser chamado diretamente via URL");
        }
    }

    /**
     * Sanitiza entrada do usuário
     */
    private function sanitizeInput(string $input): string
    {
        // Remove caracteres perigosos
        $input = preg_replace('/[^a-zA-Z0-9_]/', '', $input);

        // Limita tamanho
        $input = substr($input, 0, 50);

        return $input;
    }

    /**
     * Verifica se controller está autorizado
     */
    private function isControllerAllowed(string $controller): bool
    {
        return in_array($controller, $this->allowedControllers);
    }

    /**
     * Verifica se controller tem whitelist de métodos
     */
    private function hasMethodWhitelist(string $controller): bool
    {
        return isset($this->allowedMethods[$controller]);
    }

    /**
     * Verifica se método está autorizado para o controller
     */
    private function isMethodAllowed(string $controller, string $method): bool
    {
        return in_array($method, $this->allowedMethods[$controller] ?? []);
    }

    /**
     * Verifica se é um método perigoso que não deve ser executado
     */
    private function isDangerousMethod(string $method): bool
    {
        $dangerousMethods = [
            '__construct',
            '__destruct',
            '__call',
            '__callStatic',
            '__get',
            '__set',
            '__isset',
            '__unset',
            '__sleep',
            '__wakeup',
            '__serialize',
            '__unserialize',
            '__toString',
            '__invoke',
            '__set_state',
            '__clone',
            '__debugInfo',
            'show' // Adiciona 'show' pois ele deve ser chamado automaticamente, não via URL
        ];

        return in_array($method, $dangerousMethods);
    }

    /**
     * Manipula erros de forma centralizada
     */
    private function handleError(Exception $e): void
    {
        // Log do erro
        error_log("FrontController Error: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());

        // Determina tipo de erro
        if ($e instanceof SecurityException) {
            $this->handleSecurityError($e);
        } elseif ($e instanceof NotFoundException) {
            $this->handleNotFoundError($e);
        } else {
            $this->handleGenericError($e);
        }
    }

    /**
     * Manipula erros de segurança
     */
    private function handleSecurityError(SecurityException $e): void
    {
        http_response_code(403);

        if ($this->isDebugMode()) {
            echo "<div class='alert alert-danger'>";
            echo "<h4>Erro de Segurança:</h4>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-danger'>";
            echo "<h4>Acesso Negado</h4>";
            echo "<p>Você não tem permissão para acessar este recurso.</p>";
            echo "</div>";
        }
    }

    /**
     * Manipula erros 404
     */
    private function handleNotFoundError(NotFoundException $e): void
    {
        http_response_code(404);

        echo "<div class='alert alert-warning'>";
        echo "<h4>Página Não Encontrada</h4>";
        echo "<p>O recurso solicitado não foi encontrado.</p>";
        echo "</div>";
    }

    /**
     * Manipula erros genéricos
     */
    private function handleGenericError(Exception $e): void
    {
        http_response_code(500);

        if ($this->isDebugMode()) {
            echo "<div class='alert alert-danger'>";
            echo "<h4>Erro Interno:</h4>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-danger'>";
            echo "<h4>Ops! Algo deu errado.</h4>";
            echo "<p>Tente novamente mais tarde.</p>";
            echo "</div>";
        }
    }

    /**
     * Verifica se está em modo debug
     */
    private function isDebugMode(): bool
    {
        return $_ENV['APP_DEBUG'] ?? false;
    }

    /**
     * Adiciona controller à whitelist
     */
    public function addAllowedController(string $controller): void
    {
        if (!in_array($controller, $this->allowedControllers)) {
            $this->allowedControllers[] = $controller;
        }
    }

    /**
     * Adiciona métodos permitidos para um controller
     */
    public function addAllowedMethods(string $controller, array $methods): void
    {
        if (isset($this->allowedMethods[$controller])) {
            $this->allowedMethods[$controller] = array_merge($this->allowedMethods[$controller], $methods);
        } else {
            $this->allowedMethods[$controller] = $methods;
        }
    }

    /**
     * Define namespace dos controllers
     */
    public function setControllerNamespace(string $namespace): void
    {
        $this->controllerNamespace = $namespace;
    }
}

/**
 * Exceções customizadas
 */
class SecurityException extends Exception
{
}
class NotFoundException extends Exception
{
}