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
            && isset($_SESSION['chaveEMAUTO']);
    }

    /**
     * Redireciona para login se não estiver autenticado
     */
    public static function requireAuth(): void
    {
        if (!self::isAuthenticated()) {
            header('Location: /login');
            exit();
        }
    }

    /**
     * Redireciona para dashboard se já estiver autenticado
     */
    public static function requireGuest(): void
    {
        if (self::isAuthenticated()) {
            header('Location: /dashboard');
            exit();
        }
    }

    /**
     * Verifica se a sessão ainda é válida (opcional)
     */
    public static function isSessionValid(): bool
    {
        if (!isset($_SESSION['login_time'])) {
            return false;
        }

        // Verifica se a sessão não expirou (23 horas = 82800 segundos)
        $sessionLifetime = 82800;
        return (time() - $_SESSION['login_time']) < $sessionLifetime;
    }
}