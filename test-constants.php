<?php
// Test constants like index.php does
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);
define('SRC_PATH', ROOT_PATH . '/src');

echo "ROOT_PATH: " . ROOT_PATH . "\n";
echo "SRC_PATH: " . SRC_PATH . "\n";
echo "Router path: " . SRC_PATH . '/Core/Router.php' . "\n";
echo "File exists: " . (file_exists(SRC_PATH . '/Core/Router.php') ? 'YES' : 'NO') . "\n";

if (file_exists(SRC_PATH . '/Core/Router.php')) {
    require_once SRC_PATH . '/Core/Router.php';
    echo "Router.php included successfully!\n";
} else {
    echo "Router.php file not found!\n";
}
?>
