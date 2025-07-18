<?php
// Define application constants
define('ROOT_PATH', __DIR__);
define('PUBLIC_PATH', __DIR__ . '/public');
define('SRC_PATH', ROOT_PATH . '/src');
define('VIEWS_PATH', SRC_PATH . '/Views');

// Load environment variables
require_once ROOT_PATH . '/vendor/autoload.php';
use Dotenv\Dotenv;

// Initialize environment
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

use App\Controllers\CasinoGridController;

try {
    echo "Testing CasinoGridController section method...\n";
    
    $controller = new CasinoGridController();
    
    // Test section method
    ob_start();
    $output = $controller->section();
    $buffered = ob_get_clean();
    
    echo "Direct return (length): " . strlen($output ?? '') . " characters\n";
    echo "Buffered output (length): " . strlen($buffered) . " characters\n";
    
    // Check what type of output we're getting
    if (!empty($output)) {
        echo "✓ section() method returns content directly\n";
        if (strpos($output, 'casino-grid-section') !== false) {
            echo "✓ Direct output contains casino-grid-section\n";
        } else {
            echo "✗ Direct output does NOT contain casino-grid-section\n";
        }
    } else {
        echo "✗ section() method returns empty/null\n";
    }
    
    if (!empty($buffered)) {
        echo "✓ section() method outputs to buffer\n";
        if (strpos($buffered, 'casino-grid-section') !== false) {
            echo "✓ Buffered output contains casino-grid-section\n";
        } else {
            echo "✗ Buffered output does NOT contain casino-grid-section\n";
        }
    } else {
        echo "✗ section() method does not output to buffer\n";
    }
    
    // Show the method signature
    $reflection = new ReflectionMethod($controller, 'section');
    echo "Method return type: " . ($reflection->getReturnType() ?? 'none') . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
