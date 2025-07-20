<?php
/**
 * Router debug test
 */
require_once __DIR__ . '/vendor/autoload.php';

// Simulate the router setup
$router = new \CasinoPortal\Router\Router();

// Add the research routes manually to test
$router->get('/casino-research', 'CasinoResearchController@dashboard');
$router->get('/casino-research/execute', 'CasinoResearchController@executeFullResearch');
$router->get('/casino-research/single/{casinoId}', 'CasinoResearchController@researchSingleCasino');

echo "🚀 Router Debug Test\n";
echo "===================\n\n";

// Test different URLs
$testUrls = [
    '/casino-research',
    '/casino-research/execute',
    '/casino-research/single/bonrush_001',
    '/casino-research/single/test123'
];

foreach ($testUrls as $url) {
    echo "Testing URL: $url\n";
    
    try {
        // Simulate a request
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = $url;
        
        // Get route match
        $route = $router->resolve('GET', $url);
        
        if ($route) {
            echo "✅ Route matched: {$route['controller']}@{$route['action']}\n";
            if (!empty($route['params'])) {
                echo "   Parameters: " . json_encode($route['params']) . "\n";
            }
        } else {
            echo "❌ No route match found\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "🔍 Routes registered in router:\n";
try {
    // Try to get routes (if method exists)
    $reflection = new ReflectionClass($router);
    echo "Router class: " . get_class($router) . "\n";
    echo "Available methods: " . implode(', ', array_slice(get_class_methods($router), 0, 10)) . "\n";
} catch (Exception $e) {
    echo "Could not inspect router: " . $e->getMessage() . "\n";
}
