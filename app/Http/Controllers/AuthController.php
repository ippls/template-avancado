<?php

namespace App\Http\Controllers;
use App\Models\User;

class AuthController
{
    private User $userModel;

    public function __construct(){
        $this->userModel = new User();
    }

    // Página de login
    public function showLogin(): void
    {
        // Título da página
        $title = 'Login - Template Avançado';
        // Conteúdo da página
        $content = PAGES_PATH . '/auth/login.php';
        // Redireciona para a view do layout
        require LAYOUTS_PATH . '/auth.php';
    }

    // Página de cadastro
    public function showRegister(): void
    {
        // Título da página
        $title = 'Registro - Template Avançado';
        // Conteúdo da página
        $content = PAGES_PATH . '/auth/register.php';
        // Redireciona para a view do layout
        require LAYOUTS_PATH . '/auth.php';
    }

    public function login(): void
    {
        $email = clean($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        try {
            if (!empty($email) && !empty($password)) {
                // Autenticar usuário: buscar por email e verificar senha
                $userAuthenticated = $this->userModel->userAuthenticated($email, $password);
                if ($userAuthenticated === null) {
                    flash('error', 'Credenciais inválidas.');
                    redirect('/login');
                    return;
                }

                // Regenerar id da sessão para evitar session fixation
                session_regenerate_id(true);

                // Iniciar sessão
                $_SESSION['user_id'] = $userAuthenticated['id'];
                $_SESSION['user_name'] = $userAuthenticated['name'];
                $_SESSION['user_email'] = $userAuthenticated['email'];
                flash('success', 'Sessão iniciada com sucesso!');
                redirect('/dashboard');
            } else {
                flash('error', 'Por favor, preencher todos os campos para continuar.');
                redirect('/login');
                return;
            }

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function register(): void
    {
        $name = clean($_POST['name'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        try {
            // Validações básicas
            if (empty($name) || empty($email) || empty($password)) {
                flash('error', 'Todos os campos são obrigatórios.');
                redirect('/register');
                return;
            }

            if ($password !== $confirmPassword) {
                flash('error', 'As senhas não coincidem.');
                redirect('/register');
                return;
            }

            if (strlen($password) < 8) {
                flash('error', 'A senha deve ter pelo menos 8 caracteres.');
                redirect('/register');
                return;
            }

            if ($this->userModel->emailExists($email)) {
                flash('error', 'Este email já está associado a uma conta!');
                redirect('/register');
                return;
            }

            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => generatePasswordHash($password)
            ];
            // Salvar no banco de dados
            $save = $this->userModel->create($userData);
            if ($save) {
                // Buscar usuário criado e iniciar sessão
                $userCreated = $this->userModel->getUserByEmail($email);
                if ($userCreated) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $userCreated['id'];
                    $_SESSION['user_name'] = $userCreated['name'];
                    $_SESSION['user_email'] = $userCreated['email'];
                }
                flash('success', 'A sua conta foi criada com sucesso!');
                redirect('/dashboard');
            }else {
                flash('error', 'Erro ao registrar utilizador! Tente novamente.');
                redirect('/register');
                return;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function logout(): void
    {
        // Limpar sessão de forma segura
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        redirect('/login');
    }
}