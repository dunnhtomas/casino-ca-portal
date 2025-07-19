<?php
echo "Testing router...\n";

// Include requirements
require_once 'vendor/autoload.php';
require_once 'src/Core/Router.php';
require_once 'src/Core/Database.php';

try {
    echo "Creating router...\n";
    $router = new \App\Core\Router();
    echo "Router created successfully\n";
    
    echo "Loading routes...\n";
    require_once 'src/routes.php';
    echo "Routes loaded successfully\n";
    
    echo "Testing dispatch...\n";
    // Simulate a request
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/';
    
    $router->dispatch();
    echo "Dispatch completed\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>
