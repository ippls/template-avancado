<?php

namespace App\Models;

use PDO;

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = db();
    }

    /**
     * Lista produtos com paginação
     */
    public function paginate(int $offset = 0, int $limit = ITEMS_PER_PAGE): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM products ORDER BY id DESC LIMIT :offset, :limit"
        );
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Conta total de produtos
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM products");
        return (int)$stmt->fetchColumn();
    }

    /**
     * Busca produto por ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Cria produto
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO products (name, description, price, image, created_at)
             VALUES (?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $data['price'],
            $data['image'] ?? null
        ]);
    }

    /**
     * Atualiza produto
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $data['price'],
            $data['image'] ?? null,
            $id
        ]);
    }

    /**
     * Deleta produto
     */
    public function delete(int $id): bool
    {
        // Buscar e deletar imagem se existir
        $product = $this->find($id);
        if ($product && $product['image']) {
            $imagePath = PUBLIC_PATH . '/' . $product['image'];
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}