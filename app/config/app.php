<?php
/**
 * Configuração da Aplicação - Template Avançado
 */

define('APP_NAME', 'Template Avançado IPPLS');
define('APP_URL', 'http://localhost');
if (!defined('APP_ENV')) {
    define('APP_ENV', 'development'); // production, development
}
define('APP_VERSION', '1.0.0');

// Timezone
date_default_timezone_set('Africa/Luanda');

// Error reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', STORAGE_PATH . '/logs/app.log');
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', STORAGE_PATH . '/logs/app.log');
}

// Upload settings
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_execution_time', '300');

// Sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

// Definir session.cookie_secure automaticamente quando estiver em HTTPS
$cookieSecure = false;
if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (strpos(APP_URL, 'https://') === 0)) {
    $cookieSecure = true;
}
ini_set('session.cookie_secure', $cookieSecure ? 1 : 0);

// Expor flag para bootstrap (index.php) iniciar a sessão com a mesma configuração
define('SESSION_COOKIE_SECURE', $cookieSecure ? 1 : 0);

// Observação: a sessão e a geração do token CSRF são feitas no bootstrap (index.php)
// para evitar chamadas duplicadas a session_start() em ambientes que incluam este arquivo.