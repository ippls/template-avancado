<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Lista usuários com paginação
     */
    public function index(): void
    {
        $total = $this->userModel->count();
        $pagination = paginate($total);
        $users = $this->userModel->paginate($pagination['offset'], $pagination['per_page']);

        $controller = $this;
        $title = 'Gestão de Usuários';
        $content = PAGES_PATH . '/users.php';
        require LAYOUTS_PATH . '/main.php';
    }

    /**
     * Cria usuário
     */
    public function create(): void
    {
        $name = clean($_POST['name'] ?? '');
        $email = clean($_POST['email'] ?? '');

        // Validação
        if (!validateRequired($name) || !validateRequired($email)) {
            flash('error', 'Preencha todos os campos obrigatórios.');
            redirect('/users');
        }

        if (!validateEmail($email)) {
            flash('error', 'Email inválido.');
            redirect('/users');
        }

        if ($this->userModel->emailExists($email)) {
            flash('error', 'Este email já está cadastrado.');
            redirect('/users');
        }

        if ($this->userModel->create(['name' => $name, 'email' => $email])) {
            flash('success', 'Usuário criado com sucesso!');
        } else {
            flash('error', 'Erro ao criar usuário.');
        }

        redirect('/users');
    }

    /**
     * Edita usuário
     */
    public function edit(int $id): void
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            flash('error', 'Usuário não encontrado.');
            redirect('/users');
        }

        $controller = $this;
        $title = 'Editar Usuário';
        $content = PAGES_PATH . '/users.php';
        $editUser = $user;
        require LAYOUTS_PATH . '/main.php';
    }

    /**
     * Atualiza usuário
     */
    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $name = clean($_POST['name'] ?? '');
        $email = clean($_POST['email'] ?? '');

        if ($id <= 0) {
            flash('error', 'ID inválido.');
            redirect('/users');
        }

        if (!validateRequired($name) || !validateRequired($email)) {
            flash('error', 'Preencha todos os campos.');
            redirect("/users/edit/{$id}");
        }

        if (!validateEmail($email)) {
            flash('error', 'Email inválido.');
            redirect("/users/edit/{$id}");
        }

        if ($this->userModel->emailExists($email, $id)) {
            flash('error', 'Este email já está cadastrado.');
            redirect("/users/edit/{$id}");
        }

        if ($this->userModel->update($id, ['name' => $name, 'email' => $email])) {
            flash('success', 'Usuário atualizado com sucesso!');
        } else {
            flash('error', 'Erro ao atualizar usuário.');
        }

        redirect('/users');
    }

    /**
     * Deleta usuário
     */
    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            flash('error', 'ID inválido.');
            redirect('/users');
        }

        if ($this->userModel->delete($id)) {
            flash('success', 'Usuário deletado com sucesso!');
        } else {
            flash('error', 'Erro ao deletar usuário.');
        }

        redirect('/users');
    }
}