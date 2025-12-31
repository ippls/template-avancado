<?php 
    checkUserAuth();
?>
<div class="dashboard-container">
    <div class="welcome">
        <h1>
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </h1>
        <h2>
            <p class="userLogged">Bem-vindo, <?= e($_SESSION['user_name']) ?></p>
        </h2>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h3>Usuários</h3>
                <p class="stat-number">150</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-box"></i></div>
            <div class="stat-info">
                <h3>Produtos</h3>
                <p class="stat-number">42</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-info">
                <h3>Pedidos</h3>
                <p class="stat-number">28</p>
            </div>
        </div>
    </div>
    <a href="<?= url('/logout') ?>">Sair</a>
    <div class="dashboard-content">
        <p>Conteúdo aqui...</p>
    </div>
</div>