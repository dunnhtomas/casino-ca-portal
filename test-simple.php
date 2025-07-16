<?php
echo "Testing Router.php include...\n";

$routerPath = dirname(__DIR__) . '/src/Core/Router.php';
echo "Router path: $routerPath\n";
echo "File exists: " . (file_exists($routerPath) ? 'YES' : 'NO') . "\n";

if (file_exists($routerPath)) {
    require_once $routerPath;
    echo "Router.php included successfully!\n";
} else {
    echo "Router.php file not found!\n";
}
?>
