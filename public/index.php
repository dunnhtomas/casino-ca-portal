<?php
/**
 * Best Casino Portal - Main Entry Point
 * Exact casino.ca replica with OpenAI-powered content generation
 * 
 * @author Best Casino Portal Team
 * @version 1.0
 * @since 2025-07-16
 */

// Define application constants
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('SRC_PATH', ROOT_PATH . '/src');
define('VIEWS_PATH', SRC_PATH . '/Views');

// Load environment variables
require_once ROOT_PATH . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment configuration
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Set error reporting based on environment
if ($_ENV['APP_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Start session
session_start();

// Initialize the application
try {
    // Load the router
    require_once SRC_PATH . '/Core/Router.php';
    require_once SRC_PATH . '/Core/Database.php';
    
    // Initialize router with correct namespace
    $router = new \App\Core\Router();
    
    // Handle the request
    $router->dispatch();
    
} catch (Exception $e) {
    if ($_ENV['APP_ENV'] === 'development') {
        echo "<h1>Application Error</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    } else {
        // Log error and show generic error page
        error_log($e->getMessage());
        http_response_code(500);
        include VIEWS_PATH . '/errors/500.php';
    }
}
