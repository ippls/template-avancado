<?php
/**
 * Rotas Web - Template Avançado
 * Sistema de roteamento com URLs amigáveis
 */

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CsrfMiddleware;

// ===============================
// PARSEAMENTO DA URL
// ===============================
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($scriptName, '/');

// Remover base path e query string
$uri = substr($requestUri, strlen($basePath));
$uri = strtok($uri, '?');
$uri = trim($uri, '/');

// Dividir URI em segmentos
$segments = $uri ? explode('/', $uri) : [];
$page = $segments[0] ?? 'home';
$action = $segments[1] ?? null;
$id = $segments[2] ?? null;

// ===============================
// ROTAS PÚBLICAS (SEM AUTENTICAÇÃO)
// ===============================

try {
    // Aplicar verificação CSRF para todas as requisições POST Web
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        CsrfMiddleware::handle();
    }
    // HOME
    if ($page === '' || $page === 'home') {
        $controller = new HomeController();
        $controller->index();
        exit;
    }

    // DOCUMENTAÇÃO
    if ($page === 'docs') {
        $controller = new HomeController();
        $controller->docs();
        exit;
    }

    // AUTENTICAÇÃO
    if ($page === 'login') {
        $controller = new AuthController();
        $controller->showLogin();
        exit;
    }

    if ($page === 'register') {
        $controller = new AuthController();
        $controller->showRegister();
        exit;
    }

    if ($page === 'logout') {
        $controller = new AuthController();
        $controller->logout();
        exit;
    }

    // Processar login/registro
    if ($page === 'auth') {
        $controller = new AuthController();
        if ($action === 'login') {
            $controller->login();
        } elseif ($action === 'register') {
            $controller->register();
        }
        exit;
    }

    // ===============================
    // MIDDLEWARE DE AUTENTICAÇÃO
    // ===============================
    AuthMiddleware::handle();

    // ===============================
    // ROTAS PROTEGIDAS (COM AUTENTICAÇÃO)
    // ===============================

    // DASHBOARD
    if ($page === 'dashboard') {
        $controller = new HomeController();
        $controller->dashboard();
        exit;
    }

    // USUÁRIOS
    if ($page === 'users') {
        $controller = new UserController();

        if ($action === null) {
            $controller->index();
        } elseif ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->create();
        } elseif ($action === 'edit' && $id) {
            $controller->edit((int)$id);
        } elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update();
        } elseif ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->delete();
        } else {
            $controller->index();
        }
        exit;
    }

    // PRODUTOS
    if ($page === 'products') {
        $controller = new ProductController();

        if ($action === null) {
            $controller->index();
        } elseif ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->create();
        } elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update();
        } elseif ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->delete();
        } else {
            $controller->index();
        }
        exit;
    }

    // ===============================
    // ROTA 404
    // ===============================
    http_response_code(404);
    require ERRORS_PATH . '/404.php';
    exit;

} catch (\Exception $e) {
    // ===============================
    // TRATAMENTO DE ERROS 500
    // ===============================
    error_log("ERRO NO SISTEMA: " . $e->getMessage());
    error_log("ARQUIVO: " . $e->getFile() . " | LINHA: " . $e->getLine());

    http_response_code(500);

    if (APP_ENV === 'development') {
        echo "<h1>Erro 500 - Desenvolvimento</h1>";
        echo "<p><strong>Mensagem:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
        echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    } else {
        require ERRORS_PATH . '/500.php';
    }
}