<?php
/**
 * Casino Research System Test
 * Quick test to validate the research functionality
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load environment
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

use App\Services\CasinoResearchService;

try {
    echo "🚀 Casino Research System Test\n";
    echo "==============================\n\n";
    
    // Initialize service
    echo "📊 Initializing research service...\n";
    $researchService = new CasinoResearchService();
    
    // Load affiliate database
    $databasePath = __DIR__ . '/casino-affiliates-database.json';
    if (!file_exists($databasePath)) {
        throw new Exception("Affiliate database not found!");
    }
    
    $database = json_decode(file_get_contents($databasePath), true);
    echo "✅ Loaded " . count($database['casinos']) . " casinos from affiliate database\n\n";
    
    // Test single casino research (first casino from database)
    $testCasino = $database['casinos'][0];
    echo "🎯 Testing research for: " . $testCasino['name'] . "\n";
    echo "🌍 Geographic coverage: " . implode(', ', array_slice($testCasino['geographic_coverage'], 0, 5)) . "\n";
    echo "💰 Commission model: " . $testCasino['commission_model'] . "\n\n";
    
    echo "🤖 Executing OpenAI research...\n";
    $startTime = microtime(true);
    
    $result = $researchService->researchCasino($testCasino);
    
    $duration = round(microtime(true) - $startTime, 2);
    echo "⏱️  Research completed in {$duration} seconds\n\n";
    
    // Display results
    echo "📋 Research Results:\n";
    echo "==================\n";
    echo "✅ Research Status: " . $result['research_status'] . "\n";
    echo "📅 Research Date: " . $result['research_date'] . "\n";
    
    if (isset($result['basic_info'])) {
        echo "🏢 Casino Name: " . $result['basic_info']['name'] . "\n";
        echo "🌐 Website: " . $result['basic_info']['website_url'] . "\n";
        echo "⭐ Overall Rating: " . $result['ratings']['overall_rating'] . "/10\n";
        echo "🎮 Total Games: " . $result['games']['total_games'] . "\n";
        echo "💎 Welcome Bonus: " . $result['bonuses']['welcome_bonus'] . "\n";
        echo "🏆 License: " . $result['licensing']['primary_license'] . "\n";
    }
    
    echo "\n💾 Saving test results...\n";
    $testResults = [$result];
    $filepath = $researchService->saveResearchResults($testResults);
    echo "📁 Results saved to: " . $filepath . "\n";
    
    echo "\n🎉 Test completed successfully!\n";
    echo "🔗 Access research dashboard at: http://localhost/casino-research\n\n";
    
    // Show summary
    echo "📊 System Summary:\n";
    echo "=================\n";
    echo "Total affiliate casinos: " . count($database['casinos']) . "\n";
    echo "Unique casino brands: " . $database['database_info']['unique_casinos'] . "\n";
    echo "Geographic markets: " . $database['database_info']['total_geos'] . "\n";
    echo "OpenAI API: ✅ Configured\n";
    echo "Research service: ✅ Operational\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " (line " . $e->getLine() . ")\n";
    exit(1);
}
