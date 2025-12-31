<?php
/**
 * Template Avançado - MVC com URLs Amigáveis
 * IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos
 *
 * ORDEM DE CARREGAMENTO:
 * 1. Composer Autoload (PSR-4)
 * 2. Configurações (app, database, constants, helpers)
 * 3. Sessão
 * 4. Middleware
 * 5. Rotas (web.php ou api.php)
 */

// ============================================
// 1. AUTOLOADER DO COMPOSER (PSR-4)
// ============================================
require_once __DIR__ . '/vendor/autoload.php';

// ============================================
// 2. CONFIGURAÇÕES DA APLICAÇÃO
// ============================================
// Garantir APP_ENV antes de carregar configs que dependem dele
if (!defined('APP_ENV')) {
    $env = getenv('APP_ENV') ?: 'development';
    define('APP_ENV', $env);
}

require_once __DIR__ . '/app/config/constants.php';
require_once __DIR__ . '/app/config/app.php';
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/config/helpers.php';

// ============================================
// 3. INICIAR SESSÃO
// ============================================
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Strict',
        'cookie_secure' => (bool)(defined('SESSION_COOKIE_SECURE') ? SESSION_COOKIE_SECURE : false)
    ]);
}

// Gerar token CSRF se não existir (após iniciar sessão)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Cabeçalhos de segurança mínimos
if (!headers_sent()) {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // Permitir recursos externos usados na documentação (ex.: highlight.js via cdnjs)
    // Mantemos 'self' e 'unsafe-inline' para compatibilidade, e liberamos o host do CDN.
    $cdnHost = 'https://cdnjs.cloudflare.com';
    $csp = "default-src 'self'; ";
    $csp .= "img-src 'self' data:; ";
    $csp .= "script-src 'self' 'unsafe-inline' {$cdnHost}; ";
    $csp .= "style-src 'self' 'unsafe-inline' {$cdnHost}; ";
    $csp .= "script-src-elem 'self' {$cdnHost}; ";
    $csp .= "style-src-elem 'self' {$cdnHost};";

    header('Content-Security-Policy: ' . $csp);
}

// ============================================
// 4. DETECTAR TIPO DE REQUISIÇÃO (WEB ou API)
// ============================================
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($scriptName, '/');

// Remover base path da URI
$uri = substr($requestUri, strlen($basePath));
$uri = strtok($uri, '?'); // Remover query string
$uri = trim($uri, '/');

// Verificar se é requisição API
if (str_starts_with($uri, 'api/') || str_starts_with($uri, 'api')) {
    // API REST
    header('Content-Type: application/json; charset=utf-8');
    require_once ROUTES_PATH . '/api.php';
    exit;
}

// ============================================
// 5. ROTAS WEB
// ============================================
require_once ROUTES_PATH . '/web.php';