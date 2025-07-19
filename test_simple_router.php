<?php
// Simple router test
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Test router creation and basic functionality
try {
    require_once 'src/Core/Router.php';
    $router = new \App\Core\Router();
    
    echo "Router created successfully!\n";
    echo "Testing route handling...\n";
    
    // Test homepage
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    
    ob_start();
    $router->dispatch();
    $output = ob_get_clean();
    
    if (strlen($output) > 100) {
        echo "✅ Homepage renders successfully (" . strlen($output) . " chars)\n";
    } else {
        echo "❌ Homepage failed or returned minimal content: $output\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
