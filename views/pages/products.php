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
            <?php if (!empty($products)): ?>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Descrição</th>
                                <th>Imagem</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><strong>#<?= $product['id'] ?></strong></td>
                                    <td><?= e($product['name']) ?></td>
                                    <td><?= e($product['price']) ?></td>
                                    <td><?= e($product['description']) ?></td>
                                    <td><img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>" srcset=""></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= url("/products/edit/{$product['id']}") ?>" class="btn btn-sm btn-edit">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form method="POST" action="<?= url('/products/delete') ?>" class="inline-form"
                                                  onsubmit="return confirm('Tem certeza?');">
                                                <?= csrfField() ?>
                                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i> Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php require COMPONENTS_PATH . '/pagination.php'; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox fa-4x"></i>
                    <h3>Nenhum Produto</h3>
                    <p>Crie o primeiro Produto usando o formulário acima.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>