<?php
// Test the ProvincesController homepageSection method
require_once '/var/www/casino-portal/vendor/autoload.php';

use App\Services\ProvincesService;
use App\Controllers\ProvincesController;

try {
    $provincesService = new ProvincesService(null);
    $controller = new ProvincesController($provincesService);
    echo "Testing homepageSection method:\n";
    echo $controller->homepageSection();
    echo "\n\nDone.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString();
}
?>
