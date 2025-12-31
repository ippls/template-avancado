<?php

namespace App\Http\Controllers;

class HomeController
{
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
        $title = 'Dashboard - Template Avançado';
        $content = PAGES_PATH . '/dashboard.php';
        require LAYOUTS_PATH . '/dashboard.php';
    }
}