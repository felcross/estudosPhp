<?php

class FrontController
{
    private array $config;
    private string $configFile = 'config/controllers.json';
    private string $controllerNamespace = '\\controller\\';

    public function __construct( $configFile = null)
    {
        $this->configFile = $configFile ?? $this->configFile;
        $this->loadConfig();
    }

    public function dispatch(): void
    {
        try {
            // Inicializa sessão
            SessionManager::init();

            // Sempre força login primeiro se não estiver logado
            if (!$this->isUserLoggedIn()) {
                $this->redirectToLogin();
                return;
            }

            $controller = $this->getController();
            $method = $this->getMethod();

            $this->validateAccess($controller, $method);
            $this->executeController($controller, $method);

        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    private function loadConfig(): void
    {
        if (!file_exists($this->configFile)) {
            throw new Exception("Arquivo de configuração não encontrado: {$this->configFile}");
        }

        $json = file_get_contents($this->configFile);
        $this->config = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Erro ao decodificar JSON: " . json_last_error_msg());
        }
    }

    private function isUserLoggedIn(): bool
    {
        return AuthMiddleware::isAuthenticated();
    }

    private function redirectToLogin(): void
    {
        $this->executeController('LoginController', 'login');
    }

    private function getController(): string
    {
        $controller = $this->sanitize($_GET['class'] ?? '');
        
        if (empty($controller)) {
            return 'ControllerLogin';
        }

        if (!str_ends_with($controller, 'Controller')) {
            $controller .= 'Controller';
        }

        return $controller;
    }

    private function getMethod(): string
    {
        $method = $this->sanitize($_GET['method'] ?? '');
        return empty($method) ? 'login' : $method;
    }

    private function validateAccess(string $controller, string $method): void
    {
        // Valida controller
        if (!in_array($controller, $this->config['controllers'])) {
            throw new SecurityException("Controller não autorizado: {$controller}");
        }

        // Valida método se especificado na configuração
        if (isset($this->config['methods'][$controller])) {
            if (!in_array($method, $this->config['methods'][$controller])) {
                throw new SecurityException("Método não autorizado: {$method}");
            }
        }

        // Verifica se classe existe
        $fullClass = $this->controllerNamespace . $controller;
        if (!class_exists($fullClass)) {
            throw new NotFoundException("Controller não encontrado: {$controller}");
        }

        // Validações de segurança do método
        $this->validateMethod($fullClass, $method);
    }

    private function validateMethod(string $className, string $method): void
    {
        if (!method_exists($className, $method)) {
            throw new NotFoundException("Método não encontrado: {$method}");
        }

        $reflection = new ReflectionMethod($className, $method);
        
        if (!$reflection->isPublic() || $reflection->isStatic()) {
            throw new SecurityException("Método não acessível: {$method}");
        }

        // Bloqueia métodos mágicos
        if (str_starts_with($method, '__')) {
            throw new SecurityException("Método protegido: {$method}");
        }
    }

    private function executeController(string $controller, string $method): void
    {
        $fullClass = $this->controllerNamespace . $controller;
        $instance = new $fullClass();
        
        if (method_exists($instance, $method)) {
            $instance->$method();
        } else {
            $instance->show();
        }
    }

    private function sanitize(string $input): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', substr($input, 0, 50));
    }

    private function handleError(Exception $e): void
    {
        error_log("FrontController: " . $e->getMessage());

        http_response_code($e instanceof SecurityException ? 403 : 
                          ($e instanceof NotFoundException ? 404 : 500));

        if ($_ENV['APP_DEBUG'] ?? false) {
            echo "<div class='error'><h4>Erro:</h4><p>{$e->getMessage()}</p></div>";
        } else {
            echo "<div class='error'><h4>Erro</h4><p>Tente novamente.</p></div>";
        }
    }
}

class SecurityException extends Exception {}
class NotFoundException extends Exception {}