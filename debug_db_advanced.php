<?php
require_once '../vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment configuration
$dotenv = Dotenv::createImmutable('..');
$dotenv->load();

try {
    // Try direct connection with hardcoded values
    $pdo = new PDO(
        "mysql:host=localhost;dbname=casino_portal;charset=utf8mb4",
        'root',
        'secure_password_123',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    
    echo "✓ Direct hardcoded connection successful!\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM bonuses");
    $result = $stmt->fetch();
    echo "✓ Bonuses table has {$result->count} records\n";
    
} catch (Exception $e) {
    echo "✗ Direct hardcoded connection failed: " . $e->getMessage() . "\n";
    
    // Try with socket
    try {
        $pdo = new PDO(
            "mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=casino_portal;charset=utf8mb4",
            'root',
            'secure_password_123',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        
        echo "✓ Socket connection successful!\n";
        
    } catch (Exception $e2) {
        echo "✗ Socket connection failed: " . $e2->getMessage() . "\n";
        
        // Try without password (for socket auth)
        try {
            $pdo = new PDO(
                "mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=casino_portal;charset=utf8mb4",
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            
            echo "✓ Socket connection (no password) successful!\n";
            
        } catch (Exception $e3) {
            echo "✗ Socket connection (no password) failed: " . $e3->getMessage() . "\n";
        }
    }
}
?>
