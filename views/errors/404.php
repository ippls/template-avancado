<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página Não Encontrada | IPPLS</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <div class="error-icon">
                <span class="error-number">404</span>
                <div class="error-decoration"></div>
            </div>

            <h1 class="error-title">PÁGINA NÃO ENCONTRADA</h1>

            <p class="error-message">
                A página que você está procurando não existe ou foi movida.
            </p>

            <div class="error-suggestions">
                <h2>O que você pode fazer:</h2>
                <ul>
                    <li>Verificar se digitou o endereço corretamente</li>
                    <li>Voltar para a página inicial</li>
                    <li>Usar o menu de navegação</li>
                </ul>
            </div>

            <div class="error-actions">
                <a href="<?= url('/') ?>" class="btn-hero btn-hero-primary">
                    ← Voltar para Início
                </a>
                <a href="javascript:history.back()" class="btn-hero btn-hero-secondary">
                    Página Anterior
                </a>
            </div>

            <div class="error-footer">
                <img src="<?= asset('images/logo/ippls-logo-removebg-preview.png') ?>" alt="IPPLS" class="error-logo">
                <p>IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos</p>
            </div>
        </div>
    </div>

    <script>
        // Animação de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const errorContent = document.querySelector('.error-content');
            errorContent.style.opacity = '0';
            errorContent.style.transform = 'translateY(20px)';

            setTimeout(() => {
                errorContent.style.transition = 'all 0.6s ease';
                errorContent.style.opacity = '1';
                errorContent.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>