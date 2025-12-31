<?php
/**
 * Copia .env.example para .env se não existir.
 * Uso: php scripts/env-setup.php
 */

$root = dirname(__DIR__);
$src = $root . DIRECTORY_SEPARATOR . '.env.example';
$dest = $root . DIRECTORY_SEPARATOR . '.env';

if (!file_exists($src)) {
    fwrite(STDERR, ".env.example não encontrado.\n");
    exit(1);
}

if (file_exists($dest)) {
    echo ".env já existe — nenhuma ação tomada.\n";
    exit(0);
}

if (!copy($src, $dest)) {
    fwrite(STDERR, "Falha ao copiar .env.example para .env\n");
    exit(1);
}

echo ".env criado a partir de .env.example. Ajuste conforme necessário.\n";
exit(0);
