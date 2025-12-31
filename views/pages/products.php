<div class="main-container">
    <?php require COMPONENTS_PATH . '/breadcrumbs.php'; ?>

    <div class="page-header">
        <h1><i class="fas fa-box"></i> Gestão de Produtos</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Novo Produto</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= url('/products/create') ?>" enctype="multipart/form-data">
                <?= csrfField() ?>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nome *</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Preço *</label>
                        <input type="number" id="price" name="price" class="form-input" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea id="description" name="description" class="form-input" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem</label>
                        <input type="file" id="image" name="image" class="form-input" accept="image/*">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Criar Produto
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Produtos Cadastrados</h2>
        </div>
        <div class="card-body">
            <p>Implementar listagem de produtos...</p>
        </div>
    </div>
</div>