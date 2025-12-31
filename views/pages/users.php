<div class="main-container">
    <?php require COMPONENTS_PATH . '/breadcrumbs.php'; ?>

    <h1 class="hero-title">
        CRUD - <span class="hero-title-highlight">CREATE</span> READ <span class="hero-title-highlight">UPDATE</span> DELETE
    </h1><br>

    <div class="page-header">
        <h1><i class="fas fa-users"></i> Gestão de Usuários</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h2><?= isset($editUser) ? 'Editar Usuário' : 'Novo Usuário' ?></h2>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= isset($editUser) ? url('/users/update') : url('/users/create') ?>">
                <?= csrfField() ?>
                <?php if (isset($editUser)): ?>
                    <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                <?php endif; ?>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nome *</label>
                        <input type="text" id="name" name="name" class="form-input"
                               value="<?= e($editUser['name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" class="form-input"
                               value="<?= e($editUser['email'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?= isset($editUser) ? 'Atualizar' : 'Criar' ?>
                    </button>
                    <?php if (isset($editUser)): ?>
                        <a href="<?= url('/users') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Usuários Cadastrados</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($users)): ?>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><strong>#<?= $user['id'] ?></strong></td>
                                    <td><?= e($user['name']) ?></td>
                                    <td><?= e($user['email']) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= url("/users/edit/{$user['id']}") ?>" class="btn btn-sm btn-edit">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form method="POST" action="<?= url('/users/delete') ?>" class="inline-form"
                                                  onsubmit="return confirm('Tem certeza?');">
                                                <?= csrfField() ?>
                                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
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
                    <h3>Nenhum Usuário</h3>
                    <p>Crie o primeiro usuário usando o formulário acima.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>