<?php
// session.php

class SessionManager
{
    private static bool $initialized = false;

    public static function init(): void
    {
        if (self::$initialized) {
            return;
        }

        // Configurações de segurança
        ini_set('session.gc_maxlifetime', 82800);
        ini_set('session.cookie_lifetime', 82800);
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', isset($_SERVER['HTTPS'])); // HTTPS se disponível
        ini_set('session.use_strict_mode', 1);
        ini_set('session.cookie_samesite', 'Strict');

        // Headers de segurança
        header("X-Frame-Options: DENY");
        header_remove("X-Powered-By");
        header('Content-Type: text/html; charset=utf-8');
        header('X-Content-Type-Options: nosniff');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');

        // Inicia sessão se não estiver ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_name('LOCALIZADOR');
            session_start();
        }

        self::$initialized = true;
    }

    /**
     * Regenera ID da sessão (usar após login para segurança)
     */
    public static function regenerate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    /**
     * Destrói sessão completamente
     */
    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            
            // Remove cookie da sessão
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
            }
            
            session_destroy();
        }
    }

    /**
     * Define dados de login
     */
    public static function setUserLogin(array $userData): void
    {
        $_SESSION['user'] = $userData;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        $_SESSION['chaveEMAUTO'] = self::generateSecureToken();
        
        // Regenera ID por segurança
        self::regenerate();
    }

    /**
     * Gera token seguro
     */
    private static function generateSecureToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Limpa dados de login
     */
    public static function clearUserLogin(): void
    {
        unset($_SESSION['user'], $_SESSION['logged_in'], $_SESSION['login_time'], $_SESSION['chaveEMAUTO']);
    }
}