<?php
require_once '../vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment configuration
$dotenv = Dotenv::createImmutable('..');
$dotenv->load();

echo "Environment variables:\n";
echo "DB_HOST: " . ($_ENV['DB_HOST'] ?? 'not set') . "\n";
echo "DB_NAME: " . ($_ENV['DB_NAME'] ?? 'not set') . "\n";
echo "DB_USER: " . ($_ENV['DB_USER'] ?? 'not set') . "\n";
echo "DB_PASS: " . (isset($_ENV['DB_PASS']) ? '[SET]' : 'not set') . "\n";

try {
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    $dbname = $_ENV['DB_NAME'] ?? 'casino_portal';
    $username = $_ENV['DB_USER'] ?? 'casino_user';
    $password = $_ENV['DB_PASS'] ?? 'secure_password_123';
    
    echo "\nTrying connection with:\n";
    echo "Host: $host\n";
    echo "Database: $dbname\n";
    echo "Username: $username\n";
    echo "Password: [" . strlen($password) . " chars]\n";
    
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    
    echo "\n✓ Database connection successful!\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM bonuses");
    $result = $stmt->fetch();
    echo "✓ Bonuses table has {$result->count} records\n";
    
} catch (Exception $e) {
    echo "\n✗ Database connection failed: " . $e->getMessage() . "\n";
}
?>
