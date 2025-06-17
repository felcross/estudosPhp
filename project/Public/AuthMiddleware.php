<?php

class AuthMiddleware
{
    /**
     * Verifica se o usuário está autenticado
     */
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user']) 
            && isset($_SESSION['logged_in']) 
            && $_SESSION['logged_in'] === true
            && isset($_SESSION['chaveEMAUTO'])
            && self::isSessionValid();
    }

    /**
     * Verifica se a sessão ainda é válida
     */
    public static function isSessionValid(): bool
    {
        if (!isset($_SESSION['login_time'])) {
            return false;
        }

        // Verifica se a sessão não expirou (23 horas = 82800 segundos)
        $sessionLifetime = 82800;
        $isValid = (time() - $_SESSION['login_time']) < $sessionLifetime;

        // Se expirou, limpa a sessão
        if (!$isValid) {
            self::logout();
        }

        return $isValid;
    }

    /**
     * Força autenticação - redireciona para login se necessário
     */
    public static function requireAuth(): void
    {
        if (!self::isAuthenticated()) {
            // Salva URL de destino para redirect após login
            if (!empty($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== '/') {
                $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            }
            
            header('Location: ?class=ControllerLogin&method=login');
            exit();
        }
    }

    /**
     * Só permite acesso se NÃO estiver logado (páginas de login)
     */
    public static function requireGuest(): void
    {
        if (self::isAuthenticated()) {
            header('Location: ?class=Home&method=index');
            exit();
        }
    }

    /**
     * Faz logout completo
     */
    public static function logout(): void
    {
        SessionManager::clearUserLogin();
        SessionManager::destroy();
    }

    /**
     * Verifica permissão específica do usuário (opcional)
     */
    public static function hasPermission(string $permission): bool
    {
        if (!self::isAuthenticated()) {
            return false;
        }

        $userPermissions = $_SESSION['user']['permissions'] ?? [];
        return in_array($permission, $userPermissions);
    }

    /**
     * Require permissão específica
     */
    public static function requirePermission(string $permission): void
    {
        if (!self::hasPermission($permission)) {
            http_response_code(403);
            echo "<div class='alert alert-danger'><h4>Acesso Negado</h4><p>Você não tem permissão para acessar este recurso.</p></div>";
            exit();
        }
    }

    /**
     * Obtém dados do usuário logado
     */
    public static function getUser(): ?array
    {
        return self::isAuthenticated() ? $_SESSION['user'] : null;
    }

    /**
     * Obtém ID do usuário logado
     */
    public static function getUserId(): ?int
    {
        $user = self::getUser();
        return $user['id'] ?? null;
    }

    /**
     * Atualiza dados do usuário na sessão
     */
    public static function updateUser(array $userData): void
    {
        if (self::isAuthenticated()) {
            $_SESSION['user'] = array_merge($_SESSION['user'], $userData);
        }
    }
}