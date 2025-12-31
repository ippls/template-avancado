<?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
    <div class="pagination">
        <?php if ($pagination['has_prev']): ?>
            <a href="?page=<?= $pagination['current_page'] - 1 ?>" class="pagination-link">
                <i class="fas fa-chevron-left"></i> Anterior
            </a>
        <?php endif; ?>

        <span class="pagination-info">
            Página <?= $pagination['current_page'] ?> de <?= $pagination['total_pages'] ?>
        </span>

        <?php if ($pagination['has_next']): ?>
            <a href="?page=<?= $pagination['current_page'] + 1 ?>" class="pagination-link">
                Próxima <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>