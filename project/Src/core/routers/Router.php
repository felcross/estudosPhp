<?php
declare(strict_types=1);
namespace Routers;

use Exception;



/**
 * Classe Router - Gerenciador de rotas HTTP
 * 
 * Esta classe é responsável por:
 * 1. Armazenar uma lista de rotas registradas
 * 2. Registrar e formatar novas rotas
 * 3. Despachar (executar) uma função baseada na rota acessada
 */
class Router 
{
    /**
     * Array que armazena todas as rotas registradas
     * Estrutura: ['path' => string, 'method' => string, 'controller' => array, 'middlewares' => array]
     */
    private array $routes = [];

    /**
     * Registra uma nova rota no sistema
     * 
     * @param string $method - Método HTTP (GET, POST, PUT, DELETE, etc.)
     * @param string $path - Caminho da URL (/home, /about, etc.)
     * @param array $controller - Array contendo [classe, método] do controlador
     * @return void
     */
    public function add(string $method, string $path, array $controller): void 
    {
        // Normaliza o caminho para manter consistência
        // Ex: "/about", "about/", "/about/" todos viram "/about/"
        $path = $this->normalizePath($path);
        
        // Adiciona a rota ao array de rotas
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method), // Converte para maiúsculo (GET, POST, etc.)
            'controller' => $controller,
            'middlewares' => [] // Para futuras implementações de middleware
        ];
    }

    /**
     * Normaliza o caminho da rota para manter consistência
     * 
     * Exemplos de normalização:
     * "/about/john" -> "/about/john/"
     * "about/john" -> "/about/john/"
     * "/about/john/" -> "/about/john/"
     * "//about///john//" -> "/about/john/"
     * 
     * @param string $path - Caminho original
     * @return string - Caminho normalizado
     */
    private function normalizePath(string $path): string 
    {
        // Remove barras do início e fim
        $path = trim($path, '/');
        
        // Adiciona barras no início e fim
        $path = "/{$path}/";
        
        // Remove barras consecutivas (// vira /)
        $path = preg_replace('#[/]{2,}#', '/', $path);
        
        return $path;
    }

    /**
     * Despacha uma rota - encontra e executa o controlador correspondente
     * 
     * @param string $path - Caminho da URL atual
     * @return mixed - Retorno do controlador executado
     * @throws Exception - Se nenhuma rota for encontrada
     */
    public function dispatch(string $path)
    {
        // Normaliza o caminho da requisição
        $path = $this->normalizePath($path);
        
        // Obtém o método HTTP da requisição (GET, POST, etc.)
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        var_dump($path);
        // Percorre todas as rotas registradas
        foreach ($this->routes as $route) {
            // Verifica se o caminho corresponde usando regex
            // E se o método HTTP também corresponde
            if (!preg_match("#^{$route['path']}$#", $path) || $route['method'] !== $method) 
            {
                // Se não corresponder, continua para a próxima rota
                continue;
            }
            
            // Rota encontrada! Executa o controlador
            return $this->executeController($route['controller']);
        }
        
        // Se chegou até aqui, nenhuma rota foi encontrada
        $this->handleNotFound();
    }

    /**
     * Executa o controlador da rota encontrada
     * 
     * @param array $controller - Array [classe, método] do controlador
     * @return mixed - Retorno do método do controlador
     * @throws Exception - Se o controlador não for válido
     */
    private function executeController(array $controller)
    {
        // Valida se o array do controlador tem exatamente 2 elementos
        if (count($controller) !== 2) {
            throw new Exception("Controlador deve ter formato [classe, método]");
        }
        
        [$class, $method] = $controller;
        
        // Verifica se a classe existe
        if (!class_exists($class)) {
            throw new Exception("Classe controladora '{$class}' não encontrada");
        }
        
        // Cria instância da classe
        $instance = new $class();
        
        // Verifica se o método existe na classe
        if (!method_exists($instance, $method)) {
            throw new Exception("Método '{$method}' não encontrado na classe '{$class}'");
        }
        
        // Executa o método e retorna o resultado
        return $instance->$method();
    }

    /**
     * Trata casos onde nenhuma rota é encontrada (404)
     * 
     * @return void
     */
    private function handleNotFound(): void
    {
        // Define o código de status HTTP 404
        http_response_code(404);
        
        // Exibe mensagem de erro
        echo "404 - Página não encontrada";
        
        // Encerra a execução
        exit;
    }

    /**
     * Métodos auxiliares para registrar rotas por método HTTP específico
     * Estes métodos facilitam o uso da classe
     */
    
    /**
     * Registra uma rota GET
     */
    public function get(string $path, array $controller): void
    {
        $this->add('GET', $path, $controller);
    }
    
    /**
     * Registra uma rota POST
     */
    public function post(string $path, array $controller): void
    {
        $this->add('POST', $path, $controller);
    }
    
    /**
     * Registra uma rota PUT
     */
    public function put(string $path, array $controller): void
    {
        $this->add('PUT', $path, $controller);
    }
    
    /**
     * Registra uma rota DELETE
     */
    public function delete(string $path, array $controller): void
    {
        $this->add('DELETE', $path, $controller);
    }

    /**
     * Retorna todas as rotas registradas (útil para debug)
     * 
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}

// Exemplo de uso:
/*
// Criando o roteador
$router = new Router();

// Registrando rotas
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [AboutController::class, 'show']);
$router->post('/contact', [ContactController::class, 'store']);

// Despachando a rota atual
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($currentPath);
*/