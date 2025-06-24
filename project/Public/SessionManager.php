<?php

class SessionManager 
{
    private static bool $initialized = false;
    
    /**
     * Inicializa a sessão com configurações de segurança
     * Deve ser chamado no início de cada página que usa sessão
     */
    public static function init(): void
    {
        if (self::$initialized) {
            return;
        }
        
        // Configurações de segurança da sessão
        ini_set('session.gc_maxlifetime', 82800);        // 23 horas
        ini_set('session.cookie_lifetime', 82800);       // 23 horas
        ini_set('session.cookie_httponly', 1);           // Impede acesso via JavaScript
        ini_set('session.cookie_secure', isset($_SERVER['HTTPS'])); // HTTPS se disponível
        ini_set('session.use_strict_mode', 1);           // Modo estrito
        ini_set('session.cookie_samesite', 'Strict');    // Proteção CSRF
        
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
     * Previne session fixation attacks
     */
    public static function regenerate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
    
    /**
     * Destrói sessão completamente
     * Remove todos os dados e cookies
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
 * Gera token CSRF seguro
 * @return string
 */
private static function generateSecureToken(): string
{
    return bin2hex(random_bytes(32));
}

/**
 * Obtém token CSRF atual ou gera um novo se não existir
 * @return string
 */
public static function getCsrfToken(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = self::generateSecureToken();
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Valida token CSRF
 * @param string $token - token recebido do formulário
 * @return bool
 */
public static function validateCsrfToken(string $token): bool
{
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}
   public static function setUserLogin(array $userData): void
{
    $_SESSION['user'] = $userData;
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();
  //  $_SESSION['csrf_token'] = self::generateSecureToken(); // ← ADICIONAR ESTA LINHA
    
    // Regenera ID por segurança
    self::regenerate();
}
    
    /**
     * Verifica se usuário está logado
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Obtém dados do usuário logado
     * @return array|null
     */
    public static function getUserData(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
    
    /**
     * Obtém valor específico da sessão
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }
    
    /**
     * Define valor na sessão
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Remove valor da sessão
     * @param string $key
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    
    /**
     * Faz logout do usuário
     */
    public static function logout(): void
    {
        unset($_SESSION['user']);
        unset($_SESSION['logged_in']);
        unset($_SESSION['login_time']);
        unset($_SESSION['csrf_token']); // ← ADICIONAR ESTA LINHA

        
        self::regenerate();
    }
    
    /**
     * Verifica se a sessão expirou
     * @param int $maxTime - tempo máximo em segundos (padrão: 23 horas)
     * @return bool
     */
    public static function isExpired(int $maxTime = 82800): bool
    {
        if (!isset($_SESSION['login_time'])) {
            return true;
        }
        
        return (time() - $_SESSION['login_time']) > $maxTime;
    }
}

