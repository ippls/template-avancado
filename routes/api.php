<?php
/**
 * Rotas API - Template Avançado
 * API REST para integrações
 */

use App\Http\Controllers\ApiController;

// Configurar resposta JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // Ajuste conforme necessário
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Parseamento da URL
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($scriptName, '/');

$uri = substr($requestUri, strlen($basePath));
$uri = strtok($uri, '?');
$uri = trim($uri, '/');

// Remover prefixo 'api/'
$uri = preg_replace('/^api\/?/', '', $uri);
$segments = $uri ? explode('/', $uri) : [];

$resource = $segments[0] ?? null;
$id = $segments[1] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

try {
    $controller = new ApiController();

    // USERS API
    if ($resource === 'users') {
        if ($method === 'GET' && $id === null) {
            $controller->getUsers();
        } elseif ($method === 'GET' && $id !== null) {
            $controller->getUser((int)$id);
        } elseif ($method === 'POST') {
            $controller->createUser();
        } elseif ($method === 'PUT' && $id !== null) {
            $controller->updateUser((int)$id);
        } elseif ($method === 'DELETE' && $id !== null) {
            $controller->deleteUser((int)$id);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
        }
        exit;
    }

    // PRODUCTS API
    if ($resource === 'products') {
        if ($method === 'GET' && $id === null) {
            $controller->getProducts();
        } elseif ($method === 'GET' && $id !== null) {
            $controller->getProduct((int)$id);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
        }
        exit;
    }

    // ENDPOINT NÃO ENCONTRADO
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint não encontrado']);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erro interno do servidor',
        'message' => APP_ENV === 'development' ? $e->getMessage() : null
    ]);
}