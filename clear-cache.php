<?php
// Clear OPcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache cleared\n";
} else {
    echo "OPcache not available\n";
}

// Test if new casino data is loading
require_once __DIR__ . '/vendor/autoload.php';
use App\Services\CasinoDataService;

$casinoDataService = new CasinoDataService();
$casinos = $casinoDataService->getAllCasinos();

echo "Casino count: " . count($casinos) . "\n";
if (!empty($casinos)) {
    echo "First casino: " . $casinos[0]['name'] . "\n";
}
?>
