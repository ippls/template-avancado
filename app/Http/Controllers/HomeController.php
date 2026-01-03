<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;

class HomeController
{
    private $userModel;
    private $productModel;

    public function __construct(){
        $this->userModel = new User();
        $this->productModel = new Product();
    }
    public function index(): void
    {
        $title = 'Template Avançado MVC - IPPLS';
        $content = PAGES_PATH . '/home.php';
        require LAYOUTS_PATH . '/main.php';
    }

    public function docs(): void
    {
        $title = 'Documentação - Template Avançado';
        $content = PAGES_PATH . '/docs.php';
        require LAYOUTS_PATH . '/main.php';
    }

    public function dashboard(): void
    {
        // Total de utilizadores
        $totalUsers = $this->userModel->count();
        // Total de produtos
        $totalProducts = $this->productModel->count();
        $title = 'Dashboard - Template Avançado';
        $content = PAGES_PATH . '/dashboard.php';
        require LAYOUTS_PATH . '/dashboard.php';
    }
}