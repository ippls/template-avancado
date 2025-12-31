<?php
/**
 * Funções Auxiliares - Template Avançado
 */

use App\Config\Database;

// ============================================
// DATABASE
// ============================================

if (!function_exists('db')) {
    /**
     * Retorna instância PDO do banco de dados
     */
    function db(): PDO
    {
        return Database::getInstance()->getConnection();
    }
}

// ============================================
// REDIRECT
// ============================================

if (!function_exists('redirect')) {
    /**
     * Redireciona para URL especificada
     */
    function redirect(string $url): void
    {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $fullUrl = $baseUrl . '/' . ltrim($url, '/');
        header("Location: {$fullUrl}");
        exit;
    }
}

if (!function_exists('back')) {
    /**
     * Redireciona para página anterior
     */
    function back(): void
    {
        $referrer = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: {$referrer}");
        exit;
    }
}

// ============================================
// ESCAPE / SANITIZE
// ============================================

if (!function_exists('e')) {
    /**
     * Escapa HTML
     */
    function e($text): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('clean')) {
    /**
     * Remove tags HTML e espaços
     */
    function clean($text): string
    {
        return trim(strip_tags($text ?? ''));
    }
}

// ============================================
// FLASH MESSAGES
// ============================================

if (!function_exists('flash')) {
    /**
     * Define mensagem flash
     */
    function flash(string $type, string $message): void
    {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('getFlash')) {
    /**
     * Recupera e limpa mensagem flash
     */
    function getFlash(): ?array
    {
        $flash = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        return $flash;
    }
}

// ============================================
// URL
// ============================================

if (!function_exists('url')) {
    /**
     * Gera URL absoluta
     */
    function url(string $path = ''): string
    {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    /**
     * Gera URL para asset
     */
    function asset(string $path): string
    {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        return $baseUrl . '/public/assets/' . ltrim($path, '/');
    }
}

    // ============================================
    // ROUTE HELPERS
    // ============================================

    if (!function_exists('isActive')) {
        /**
         * Retorna 'active' se a rota atual corresponder ao caminho informado.
         */
        function isActive(string $path): string
        {
            $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
            $scriptName = dirname($_SERVER['SCRIPT_NAME']);
            $basePath = rtrim($scriptName, '/');

            // Remover basePath do início da URI, se presente
            if ($basePath !== '' && strpos($requestUri, $basePath) === 0) {
                $requestUri = substr($requestUri, strlen($basePath));
            }

            $current = '/' . ltrim($requestUri, '/');
            $target  = '/' . ltrim($path, '/');

            return rtrim($current, '/') === rtrim($target, '/') ? 'active' : '';
        }
    }

// ============================================
// VALIDAÇÃO
// ============================================

if (!function_exists('validateEmail')) {
    /**
     * Valida email
     */
    function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('validateRequired')) {
    /**
     * Valida campo obrigatório
     */
    function validateRequired($value): bool
    {
        return !empty(trim($value ?? ''));
    }
}

// ============================================
// UPLOAD
// ============================================

if (!function_exists('uploadFile')) {
    /**
     * Faz upload de arquivo
     */
    function uploadFile(array $file, string $destination = 'uploads'): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if ($file['size'] > MAX_FILE_SIZE) {
            return null;
        }

        $uploadDir = PUBLIC_PATH . '/' . trim($destination, '/') . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Verificar MIME type real do arquivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowed = array_merge(ALLOWED_IMAGE_TYPES, ALLOWED_DOCUMENT_TYPES);
        if (!in_array($mime, $allowed, true)) {
            return null;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $safeName = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
        $filename = $safeName . '_' . uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            @chmod($filepath, 0644);
            return $destination . '/' . $filename;
        }

        return null;
    }
}

// ============================================
// PAGINAÇÃO
// ============================================

if (!function_exists('paginate')) {
    /**
     * Calcula valores de paginação
     */
    function paginate(int $total, int $perPage = ITEMS_PER_PAGE): array
    {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;

        return [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'offset' => $offset,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages
        ];
    }
}

// ============================================
// CSRF
// ============================================

if (!function_exists('csrfToken')) {
    /**
     * Retorna token CSRF
     */
    function csrfToken(): string
    {
        return $_SESSION['csrf_token'] ?? '';
    }
}

if (!function_exists('csrfField')) {
    /**
     * Gera campo hidden com token CSRF
     */
    function csrfField(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
    }
}

if (!function_exists('verifyCsrf')) {
    /**
     * Verifica token CSRF
     */
    function verifyCsrf(): bool
    {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        return hash_equals(csrfToken(), $token);
    }
}

// ============================================
// Hash para passwords
// ============================================

if (!function_exists('generatePasswordHash')) {
    /**
     * Hash para passwords
     */
    function generatePasswordHash($password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

}

// ============================================
// Comparação de strings
// ============================================

if (!function_exists('string_equals')) {
    /**
     * Comparação de strings
     */
    function string_equals(string $string1, string $string2): bool {
        return strcmp($string1, $string2) === 0;
    }

}

// ============================================
// Verificar se usuário está autenticado
// ============================================

if (!function_exists('checkUserAuth')) {
    /**
     * Verificar se usuário está autenticado
     */
    function checkUserAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id']) || empty($_SESSION['user_name']) || empty($_SESSION['user_email'])) {
            redirect('/login');
            return;
        }
    }
}