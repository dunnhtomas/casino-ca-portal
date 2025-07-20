<?php
/**
 * Test Single Casino Research
 * Process one casino at a time with live output
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load environment
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

use App\Services\CasinoResearchService;

// Get casino ID from command line argument
$casinoId = $argv[1] ?? 'bonrush_001';

echo "🎯 Testing Single Casino Research\n";
echo "================================\n";
echo "Casino ID: {$casinoId}\n";
echo "Timestamp: " . date('Y-m-d H:i:s') . "\n\n";

try {
    // Load the affiliate database
    $databasePath = __DIR__ . '/casino-affiliates-database.json';
    $database = json_decode(file_get_contents($databasePath), true);
    
    // Find the casino
    $targetCasino = null;
    foreach ($database['casinos'] as $casino) {
        if ($casino['id'] === $casinoId) {
            $targetCasino = $casino;
            break;
        }
    }
    
    if (!$targetCasino) {
        echo "❌ Casino not found: {$casinoId}\n";
        exit(1);
    }
    
    echo "🏛️ Found casino: {$targetCasino['name']}\n";
    echo "🌐 Website: " . ($targetCasino['website_url'] ?? 'N/A') . "\n";
    echo "⭐ Current rating: {$targetCasino['rating']}\n\n";
    
    // Initialize research service
    echo "🔬 Initializing research service...\n";
    $researchService = new CasinoResearchService();
    
    echo "🔄 Starting research process...\n";
    echo "================================\n";
    
    $startTime = microtime(true);
    
    // Research the casino
    $result = $researchService->researchCasino($targetCasino);
    
    $duration = round(microtime(true) - $startTime, 2);
    
    echo "\n✅ Research completed in {$duration} seconds!\n";
    echo "===============================================\n\n";
    
    // Display results
    if (isset($result['basic_info'])) {
        echo "📋 BASIC INFO:\n";
        echo "• Name: " . ($result['basic_info']['name'] ?? 'N/A') . "\n";
        echo "• Website: " . ($result['basic_info']['website'] ?? 'N/A') . "\n";
        echo "• License: " . ($result['basic_info']['license'] ?? 'N/A') . "\n";
        echo "• Founded: " . ($result['basic_info']['founded'] ?? 'N/A') . "\n";
        echo "\n";
    }
    
    if (isset($result['ratings'])) {
        echo "⭐ RATINGS:\n";
        echo "• Overall: " . ($result['ratings']['overall_rating'] ?? 'N/A') . "/10\n";
        echo "• Games: " . ($result['ratings']['games_rating'] ?? 'N/A') . "/10\n";
        echo "• Bonuses: " . ($result['ratings']['bonuses_rating'] ?? 'N/A') . "/10\n";
        echo "• Support: " . ($result['ratings']['support_rating'] ?? 'N/A') . "/10\n";
        echo "\n";
    }
    
    if (isset($result['games'])) {
        echo "🎮 GAMES:\n";
        echo "• Total games: " . number_format($result['games']['total_games'] ?? 0) . "\n";
        echo "• Slots: " . number_format($result['games']['slots'] ?? 0) . "\n";
        echo "• Table games: " . number_format($result['games']['table_games'] ?? 0) . "\n";
        echo "• Live dealer: " . number_format($result['games']['live_dealer'] ?? 0) . "\n";
        echo "\n";
    }
    
    if (isset($result['bonuses'])) {
        echo "💎 BONUSES:\n";
        echo "• Welcome bonus: " . ($result['bonuses']['welcome_bonus'] ?? 'N/A') . "\n";
        echo "• No deposit: " . ($result['bonuses']['no_deposit_bonus'] ?? 'N/A') . "\n";
        echo "• Free spins: " . ($result['bonuses']['free_spins'] ?? 'N/A') . "\n";
        echo "\n";
    }
    
    // Save result
    $resultFile = "casino-research-{$casinoId}-" . date('Y-m-d-H-i-s') . ".json";
    file_put_contents($resultFile, json_encode($result, JSON_PRETTY_PRINT));
    
    echo "💾 Results saved to: {$resultFile}\n";
    echo "🏆 Single casino research completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " (line " . $e->getLine() . ")\n";
    exit(1);
}
