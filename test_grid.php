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
    $controller = new CasinoGridController();
    echo "CasinoGridController instantiated successfully\n";
    
    $output = $controller->section();
    echo "section() method called successfully\n";
    echo "Output length: " . strlen($output) . " characters\n";
    
    // Check if output contains expected content
    if (strpos($output, 'casino-grid-section') !== false) {
        echo "✓ Output contains casino-grid-section\n";
    } else {
        echo "✗ Output does NOT contain casino-grid-section\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
