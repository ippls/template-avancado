<?php

namespace App\Http\Middleware;

class CsrfMiddleware
{
    /**
     * Verifica token CSRF em requisições POST
     */
    public static function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrf()) {
                http_response_code(419);
                die('Token CSRF inválido. Recarregue a página e tente novamente.');
            }
        }
    }

    /**
     * Gera novo token CSRF
     */
    public static function generateToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}