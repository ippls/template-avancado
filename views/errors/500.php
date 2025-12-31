<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Erro Interno | IPPLS</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <div class="error-icon">
                <span class="error-number">500</span>
                <div class="error-decoration"></div>
            </div>

            <h1 class="error-title">ERRO INTERNO DO SERVIDOR</h1>

            <p class="error-message">
                Desculpe, ocorreu um erro inesperado no servidor. Nossa equipe foi notificada e está trabalhando para resolver o problema.
            </p>

            <div class="error-suggestions">
                <h2>O que você pode fazer:</h2>
                <ul>
                    <li>Aguardar alguns minutos e tentar novamente</li>
                    <li>Voltar para a página inicial</li>
                    <li>Entrar em contato com o suporte se o problema persistir</li>
                </ul>
            </div>

            <div class="error-actions">
                <a href="<?= url('/') ?>" class="btn-hero btn-hero-primary">
                    ← Voltar para Início
                </a>
                <a href="javascript:location.reload()" class="btn-hero btn-hero-secondary">
                    Tentar Novamente
                </a>
            </div>

            <div class="error-footer">
                <img src="<?= asset('images/logo/ippls-logo-removebg-preview.png') ?>" alt="IPPLS" class="error-logo">
                <p>IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos</p>
            </div>
        </div>
    </div>

    <script>
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