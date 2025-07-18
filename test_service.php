<?php
require "vendor/autoload.php";
try {
    $service = new App\Services\CategoryComparisonService();
    echo "Service loaded successfully\n";
    $data = $service->getCategoryLeaders();
    echo "Data loaded: " . count($data) . " categories\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
