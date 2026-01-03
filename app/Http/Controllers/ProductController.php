<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $total = $this->productModel->count();
        $pagination = paginate($total);
        $products = $this->productModel->paginate($pagination['offset'], $pagination['per_page']);

        $controller = $this;
        $title = 'Gestão de Produtos';
        $content = PAGES_PATH . '/products.php';
        require LAYOUTS_PATH . '/main.php';
    }

    public function create(): void
    {
        $name = clean($_POST['name'] ?? '');
        $description = clean($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);

        if (!validateRequired($name) || !validateRequired($description) || $price <= 0) {
            flash('error', 'Preencha todos os campos obrigatórios.');
            redirect('/products');
        }

        // Upload de imagem (obrigatório)
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = uploadFile($_FILES['image'], 'uploads/products');
        }else {
            flash('warning', 'Para cadastrar um produto, selecione uma imagem!');
            redirect('/products');
        }

        if ($this->productModel->create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image
        ])) {
            flash('success', 'Produto criado com sucesso!');
        } else {
            flash('error', 'Erro ao criar produto.');
        }

        redirect('/products');
    }

    public function update(): void
    {
        // Similar ao create, implementar atualização
        flash('success', 'Produto atualizado com sucesso!');
        redirect('/products');
    }

    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);

        if ($this->productModel->delete($id)) {
            flash('success', 'Produto deletado com sucesso!');
        } else {
            flash('error', 'Erro ao deletar produto.');
        }

        redirect('/products');
    }
}