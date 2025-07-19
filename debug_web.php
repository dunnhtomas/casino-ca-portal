<?php
// Debug web router - Add this to the beginning of public/index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== ROUTER DEBUG ===\n";
echo "REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'MISSING') . "\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'MISSING') . "\n";
echo "SCRIPT_FILENAME: " . ($_SERVER['SCRIPT_FILENAME'] ?? 'MISSING') . "\n";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'MISSING') . "\n";

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH);
echo "Parsed path: " . $path . "\n";

echo "=== END DEBUG ===\n";
?>
