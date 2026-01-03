<section class="hero-section">
    <div class="hero-container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="welcome-container">
                    <span class="welcome-icon">👋</span>
                    <span class="welcome-text">Bem-vindo ao Template Avançado</span>
                </div>
                <h1 class="hero-title">
                    Template <span class="hero-title-highlight">MVC AVANÇADO</span>
                </h1>
                <p class="hero-subtitle">
                    URLs amigáveis, middleware, upload, paginação e API REST. Evolução natural do Template Padrão.
                </p>
                <div class="hero-buttons">
                    <a href="<?= url('/users') ?>" class="btn-hero btn-hero-primary">
                        <i class="fas fa-users"></i> Gestão de Usuários
                    </a>
                    <a href="<?= url('/docs') ?>" class="btn-hero btn-hero-secondary">
                        <i class="fas fa-book"></i> Documentação
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="decoration-block-top">
                    <img src="<?= asset('images/logo/ippls-logo-removebg-preview.png') ?>" alt="IPPLS" class="logo">
                </div>
                <div class="feature-card">
                    <h2 class="feature-card-title">Profissional. Moderno. Prático.</h2>
                    <p class="feature-card-subtitle">IPPLS - Instituto Politécnico</p>
                </div>
                <div class="decoration-block-bottom">
                    <img src="<?= asset('images/logo/ippls-logo-removebg-preview.png') ?>" alt="IPPLS" class="logo">
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- <h1 class="hero-title">
        CRUD - <span class="hero-title-highlight">CREATE</span> READ <span class="hero-title-highlight">UPDATE</span> DELETE
    </h1><br> -->

<!--Secção do CRUD -->
<?php require_once VIEWS_PATH . '/components/sections/crud.php'; ?>

<!--Recursos Avançados -->
<?php require_once VIEWS_PATH . '/components/sections/features.php'; ?>

<!--Requisitos Técnicos -->
<?php require_once VIEWS_PATH . '/components/sections/skills.php'; ?>