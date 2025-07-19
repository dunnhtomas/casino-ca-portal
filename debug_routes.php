<?php
// Debug router script
require_once 'vendor/autoload.php';
require_once 'src/Core/Router.php';
require_once 'src/Core/Database.php';

$router = new \App\Core\Router();
require_once 'src/routes.php';

echo "Routes loaded:\n";
echo "GET routes: " . count($router->getRoutes()['GET'] ?? []) . "\n";
echo "First 5 GET routes:\n";
$routes = $router->getRoutes()['GET'] ?? [];
$i = 0;
foreach ($routes as $path => $handler) {
    echo "  $path => $handler\n";
    if (++$i >= 5) break;
}
?>
