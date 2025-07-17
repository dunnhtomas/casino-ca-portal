<?php
// Debug script to check router configuration
require_once 'vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Try to instantiate the router and see what routes are loaded
try {
    $router = new App\Core\Router();
    
    // Include routes
    require_once 'src/routes.php';
    
    echo "Router loaded successfully\n";
    echo "Testing slots route...\n";
    
    // Simulate the request
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/slots';
    
    // Check if route exists
    $router->dispatch();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
?>
