<?php
require_once 'vendor/autoload.php';
require_once 'src/Core/Router.php';
require_once 'src/Core/Database.php';

try {
    $router = new \App\Core\Router();
    require_once 'src/routes.php';
    echo "Routes loaded successfully\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
