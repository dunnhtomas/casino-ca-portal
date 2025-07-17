<?php
require_once '/var/www/html/vendor/autoload.php';

try {
    echo "Testing MobileAppService...\n";
    $service = new CasinoPortal\Services\MobileAppService();
    echo "Service instantiated successfully\n";
    
    $apps = $service->getFeaturedMobileApps();
    echo "Found " . count($apps) . " mobile apps\n";
    
    $stats = $service->getMobileStats();
    echo "Found " . count($stats) . " stats\n";
    
    $advantages = $service->getMobileAdvantages();
    echo "Found " . count($advantages) . " advantages\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
