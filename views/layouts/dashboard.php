<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= url('vendor/fontawesome/css/all.min.css') ?>">
</head>
<body>
    <!-- Barra de navegação (Menu) -->
    <?php require COMPONENTS_PATH . '/navbar.php'; ?>
    <!-- Mensagens flash -->
    <?php require COMPONENTS_PATH . '/flashMessage.php' ?>


    <!-- Script para Menu Mobile -->
    <script src="<?= asset('js/components/navbar.js') ?>"></script>

    <!-- Conteúdo do dashboard -->
    <div class="dashboard-wrapper">
        <?php require $content; ?>
    </div>

    <!-- Rodapé -->
    <?php require COMPONENTS_PATH . '/footer.php'; ?>
    
    <!-- Scripts do Botão Voltar ao Topo ( O botão será criado automaticamente pelo JavaScript ) -->
    <script src="<?= asset('js/components/backToTop.js') ?>"></script>
</body>
</html>