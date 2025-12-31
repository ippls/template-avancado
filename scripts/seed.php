<?php
/**
 * Script simples de seed para popular a base de dados com dados de exemplo.
 * Uso: php scripts/seed.php
 */

declare(strict_types=1);

$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'projeto_avancado';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    fwrite(STDERR, "Erro conectando ao DB: " . $e->getMessage() . PHP_EOL);
    exit(1);
}

$appEnv = getenv('APP_ENV') ?: 'development';
echo "Conectado a {$db} em {$host}\n";

// Criar tabelas se não existirem
$queries = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        image VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
];

foreach ($queries as $sql) {
    $pdo->exec($sql);
}

echo "Tabelas verificadas/criadas.\n";

// Inserir usuários de exemplo (não inserir se já existem)
$users = [
    ['name' => 'Pai Grande Ngola', 'email' => 'paigrandengola@gmail.com', 'password' => 'password1'],
    ['name' => 'Kelson Filipe Dev', 'email' => 'kelsonfilipedev@gmail.com', 'password' => 'password2'],
    ['name' => 'Afonso Adriano', 'email' => 'afonso.adriano@gmail.com', 'password' => 'password3'],
    ['name' => 'Anacleto Hebo', 'email' => 'anacletohebo@gmail.com', 'password' => 'password4'],
    ['name' => 'Iliano Nicolau', 'email' => 'iliano.nicolau@gmail.com', 'password' => 'password5'],
    ['name' => 'António RDC', 'email' => 'antonio.rdc@gmail.com', 'password' => 'password6'],
    ['name' => 'Kiaku Fonseca', 'email' => 'kiakufonseca@gmail.com', 'password' => 'password7'],
    ['name' => 'Elizandro Kapoko', 'email' => 'elizandrokapoko@gmail.com', 'password' => 'password8'],
    ['name' => 'Eugênio Gome Lenda', 'email' => 'eugeniogomelenda@gmail.com', 'password' => 'password9'],
    ['name' => 'José Adriano Mbala', 'email' => 'jose.adriano.mbala@gmail.com', 'password' => 'password10'],
    ['name' => 'José Lengo Júnior', 'email' => 'jose.lengo.junior@gmail.com', 'password' => 'password11'],
    ['name' => 'João Victorino Bin', 'email' => 'joaovictorinobin@gmail.com', 'password' => 'password12'],
    ['name' => 'Adário Mutembele Assunção', 'email' => 'adariomutembele@gmail.com', 'password' => 'password13'],
    ['name' => 'Zenaida Barbose', 'email' => 'zenaidabarbose@gmail.com', 'password' => 'password14'],
    ['name' => 'Eng. Vanilson Manuel', 'email' => 'vanilsonmanuel@gmail.com', 'password' => 'password15'],
];

$insertUserStmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
foreach ($users as $u) {
    // verificar existência
    $exists = $pdo->prepare('SELECT id FROM users WHERE email = :email');
    $exists->execute(['email' => $u['email']]);
    if ($exists->fetch()) {
        echo "Usuário {$u['email']} já existe — pulando.\n";
        continue;
    }

    $hash = password_hash($u['password'], PASSWORD_DEFAULT);
    $insertUserStmt->execute(['name' => $u['name'], 'email' => $u['email'], 'password' => $hash]);
    if ($appEnv === 'development') {
        echo "Inserido usuário: {$u['email']} (senha: {$u['password']})\n";
    } else {
        echo "Inserido usuário: {$u['email']}\n";
    }
}

// Inserir produtos de exemplo
$products = [
    ['name' => 'Laptop IPPLS', 'description' => 'Computador portátil para estudantes', 'price' => '150000.00'],
    ['name' => 'Mouse Wireless', 'description' => 'Mouse sem fio ergonômico', 'price' => '2500.00'],
    ['name' => 'Teclado Mecânico', 'description' => 'Teclado para programadores', 'price' => '8500.00'],
];

$insertProductStmt = $pdo->prepare('INSERT INTO products (name, description, price) VALUES (:name, :description, :price)');
foreach ($products as $p) {
    // simples verificação por nome
    $exists = $pdo->prepare('SELECT id FROM products WHERE name = :name');
    $exists->execute(['name' => $p['name']]);
    if ($exists->fetch()) {
        echo "Produto {$p['name']} já existe — pulando.\n";
        continue;
    }

    $insertProductStmt->execute(['name' => $p['name'], 'description' => $p['description'], 'price' => $p['price']]);
    echo "Inserido produto: {$p['name']}\n";
}

echo "Seed concluído.\n";

exit(0);
