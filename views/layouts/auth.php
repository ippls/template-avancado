<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Página de autenticação ou registro' ?></title>
    <link rel="stylesheet" href="<?= asset('css/auth-unified.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= url('vendor/fontawesome/css/all.min.css') ?>">
</head>
<body>
  <!-- Mensagens flash -->
  <?php require COMPONENTS_PATH . '/flashMessage.php' ?>
  <!-- Conteúdo das páginas de autenticação (login, register) são renderizados automaticamente aqui -->
  <?php require $content; ?>
  <!-- Mensagens flash -->
</body>
</html>