<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;

class ApiController
{
    /**
     * GET /api/users
     */
    public function getUsers(): void
    {
        $userModel = new User();
        $users = $userModel->paginate(0, 100);

        echo json_encode([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * GET /api/users/{id}
     */
    public function getUser(int $id): void
    {
        $userModel = new User();
        $user = $userModel->find($id);

        if ($user) {
            echo json_encode([
                'success' => true,
                'data' => $user
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Usuário não encontrado'
            ]);
        }
    }

    /**
     * POST /api/users
     */
    public function createUser(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userModel = new User();

        if ($userModel->create($data)) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Usuário criado com sucesso'
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Erro ao criar usuário'
            ]);
        }
    }

    /**
     * PUT /api/users/{id}
     */
    public function updateUser(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userModel = new User();

        if ($userModel->update($id, $data)) {
            echo json_encode([
                'success' => true,
                'message' => 'Usuário atualizado'
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Erro ao atualizar'
            ]);
        }
    }

    /**
     * DELETE /api/users/{id}
     */
    public function deleteUser(int $id): void
    {
        $userModel = new User();

        if ($userModel->delete($id)) {
            echo json_encode([
                'success' => true,
                'message' => 'Usuário deletado'
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Erro ao deletar'
            ]);
        }
    }

    /**
     * GET /api/products
     */
    public function getProducts(): void
    {
        $productModel = new Product();
        $products = $productModel->paginate(0, 100);

        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * GET /api/products/{id}
     */
    public function getProduct(int $id): void
    {
        $productModel = new Product();
        $product = $productModel->find($id);

        if ($product) {
            echo json_encode([
                'success' => true,
                'data' => $product
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Produto não encontrado'
            ]);
        }
    }
}