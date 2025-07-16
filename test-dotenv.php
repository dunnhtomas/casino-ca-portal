<?php
// Test with Dotenv loading
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');

echo "Loading autoloader...\n";
require_once ROOT_PATH . '/vendor/autoload.php';

echo "Loading Dotenv...\n";
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

echo "Loading Router...\n";
require_once SRC_PATH . '/Core/Router.php';

echo "Success! All loaded.";
?>
