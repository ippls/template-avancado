<?php 

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!-- Barra de Navegação Principal -->
<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="navbar-brand">
            <a href="<?= url('/') ?>" class="navbar-logo">
                <img src="<?= asset('images/logo/ippls-logo-removebg-preview.png') ?>" alt="IPPLS" class="navbar-logo-img">
                <span class="navbar-logo-text">IPPLS</span>
            </a>
        </div>

        <!-- Menu Toggle (Mobile) -->
        <button class="navbar-toggle" id="navbarToggle" aria-label="Menu">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

        <!-- Links de Navegação -->
        <ul class="navbar-menu" id="navbarMenu">
            <li class="navbar-item">
                <a href="<?=url('/') ?>" class="navbar-link <?= isActive('/') ?>">
                    <i class="fas fa-home"></i> Início
                </a>
            </li>
            <li class="navbar-item">
                <a href="<?=url('/users') ?>" class="navbar-link <?= isActive('/users') ?>">
                    <i class="fas fa-users"></i> Usuários
                </a>
            </li>
            <li class="navbar-item">
                <a href="<?=url('/products') ?>" class="navbar-link <?= isActive('/products') ?>">
                    <i class="fas fa-box"></i> Produtos
                </a>
            </li>
            <li class="navbar-item">
                <a href="<?=url('/docs') ?>" class="navbar-link <?= isActive('/docs') ?>">
                    <i class="fas fa-book"></i> Documentação
                </a>
            </li>
        </ul>


        <?php 
            // Botões de Ação 
            if (empty($_SESSION['user_id'])): ?>
            <div class="navbar-actions">
                <a href="<?=url('/login') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-lock"></i> Login
                </a>
            </div>
            
            <?php elseif(!empty($_SESSION['user_id'])): ?>
                <div class="navbar-actions">
                    <a href="<?=url('/dashboard') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </div>
            ?>
        <?php endif; ?>
    </div>
</nav>