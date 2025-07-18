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

use App\Controllers\HomeController;

try {
    echo "Starting homepage test...\n";
    
    $homeController = new HomeController();
    echo "HomeController instantiated successfully\n";
    
    ob_start();
    $output = $homeController->index();
    $buffered = ob_get_clean();
    
    echo "HomeController index() called successfully\n";
    echo "Total output length: " . strlen($output) . " characters\n";
    echo "Buffered output length: " . strlen($buffered) . " characters\n";
    
    // Check for casino grid section
    if (strpos($output, 'casino-grid-section') !== false) {
        echo "✓ Output contains casino-grid-section\n";
    } else {
        echo "✗ Output does NOT contain casino-grid-section\n";
    }
    
    // Check for CasinoGridController instantiation in buffered output
    if (strpos($buffered, 'CasinoGridController') !== false) {
        echo "✓ Buffered output mentions CasinoGridController\n";
    } else {
        echo "✗ Buffered output does NOT mention CasinoGridController\n";
    }
    
    // Save a snippet of the output around where casino grid should be
    if (strpos($output, 'Extended Top Casino List') !== false) {
        $pos = strpos($output, 'Extended Top Casino List');
        $snippet = substr($output, $pos, 2000);
        echo "\nSnippet after 'Extended Top Casino List':\n";
        echo substr($snippet, 0, 500) . "...\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
