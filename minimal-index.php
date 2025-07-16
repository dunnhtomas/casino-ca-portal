<?php
// Minimal index.php for debugging
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');

// Load autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Load the router
require_once SRC_PATH . '/Core/Router.php';

echo "Success! Router loaded.";
?>
