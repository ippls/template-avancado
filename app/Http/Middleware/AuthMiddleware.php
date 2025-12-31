<?php

namespace App\Http\Middleware;

class AuthMiddleware
{
    /**
     * Verifica se usuário está autenticado
     */
    public static function handle(): void
    {
        if (!isset($_SESSION['user_id'])) {
            flash('error', 'Você precisa estar autenticado para acessar esta página.');
            redirect('/login');
        }
    }

    /**
     * Verifica se usuário é admin
     */
    public static function isAdmin(): bool
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    /**
     * Redireciona se não for admin
     */
    public static function requireAdmin(): void
    {
        if (!self::isAdmin()) {
            flash('error', 'Acesso negado. Apenas administradores.');
            redirect('/');
        }
    }
}