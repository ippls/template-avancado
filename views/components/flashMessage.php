<head>
    <link rel="stylesheet" href="<?= asset('css/components/alerts.css') ?>">
</head>
<?php $flash = getFlash(); if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] ?>">
        <i class="fas <?= $flash['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i>
        <span><?= e($flash['message']) ?></span>
    </div>
<?php endif; ?>
<script src="<?= asset('js/components/flashMessage.js') ?>"></script>