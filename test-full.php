<?php
// Test like index.php but skip potentially problematic parts
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('SRC_PATH', ROOT_PATH . '/src');

echo "Starting test...\n";

// Test autoloader
echo "Testing autoloader...\n";
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
    echo "Autoloader loaded successfully!\n";
} else {
    echo "Autoloader not found!\n";
}

// Test Router
echo "Testing Router include...\n";
if (file_exists(SRC_PATH . '/Core/Router.php')) {
    require_once SRC_PATH . '/Core/Router.php';
    echo "Router.php included successfully!\n";
} else {
    echo "Router.php file not found!\n";
}

echo "Test completed successfully!\n";
?>
