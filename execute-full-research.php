<?php
/**
 * Full Casino Research Execution
 * Runs comprehensive research on all casinos from the affiliate database
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
use App\Services\OpenAIMonitorService;

try {
    echo "🚀 Starting Full Casino Research Process\n";
    echo "======================================\n";
    echo "Timestamp: " . date('Y-m-d H:i:s') . "\n\n";
    
    // Initialize services
    echo "📊 Initializing research services...\n";
    $researchService = new CasinoResearchService();
    $monitor = new OpenAIMonitorService();
    
    // Load the affiliate database to see what we're working with
    $databasePath = __DIR__ . '/casino-affiliates-database.json';
    $database = json_decode(file_get_contents($databasePath), true);
    $totalCasinos = count($database['casinos']);
    
    echo "✅ Services initialized successfully\n";
    echo "📋 Found {$totalCasinos} casinos to research\n\n";
    
    // Show initial usage stats
    echo "📈 Pre-research usage statistics:\n";
    echo "================================\n";
    $initialStats = $monitor->getTodaysSummary();
    echo "• Requests made today: " . $initialStats['requests_made'] . "\n";
    echo "• Tokens used today: " . number_format($initialStats['tokens_used']) . "\n";
    echo "• Estimated cost today: $" . $initialStats['estimated_cost_usd'] . "\n";
    echo "• Current error rate: " . ($initialStats['error_rate'] * 100) . "%\n\n";
    
    // Calculate expected research metrics
    $estimatedTokensPerCasino = 4000;
    $estimatedTotalTokens = $totalCasinos * $estimatedTokensPerCasino;
    $estimatedCost = ($estimatedTotalTokens * 0.7 / 1000000 * 0.005) + ($estimatedTotalTokens * 0.3 / 1000000 * 0.015);
    $estimatedDuration = ceil($totalCasinos / 20); // 20 requests per minute with buffer
    
    echo "📊 Research Estimates:\n";
    echo "=====================\n";
    echo "• Estimated tokens needed: " . number_format($estimatedTotalTokens) . "\n";
    echo "• Estimated cost: $" . round($estimatedCost, 2) . "\n";
    echo "• Estimated duration: ~{$estimatedDuration} minutes\n";
    echo "• Rate limit buffer: 10% safety margin applied\n\n";
    
    // Confirm execution
    echo "⚠️  WARNING: This will make {$totalCasinos} API calls to OpenAI\n";
    echo "💰 Estimated cost: $" . round($estimatedCost, 2) . "\n\n";
    
    // Auto-proceed for automation
    echo "🔄 Starting research execution...\n";
    echo "================================\n\n";
    
    $startTime = microtime(true);
    $processedCount = 0;
    $successCount = 0;
    $errorCount = 0;
    
    // Execute the research - ONE BY ONE with detailed logging
    echo "🎯 Beginning casino research process (one by one)...\n\n";
    
    $results = [];
    
    // Process each casino individually
    foreach ($database['casinos'] as $index => $casino) {
        $processedCount++;
        $percentage = round(($processedCount / $totalCasinos) * 100, 1);
        
        echo "🔄 [{$percentage}%] Processing: {$casino['name']} (ID: {$casino['id']})\n";
        
        try {
            $startCasinoTime = microtime(true);
            
            // Research individual casino
            $result = $researchService->researchCasino($casino);
            
            $casinoDuration = round(microtime(true) - $startCasinoTime, 2);
            $successCount++;
            
            $results[] = $result;
            
            echo "✅ [{$percentage}%] {$casino['name']} - Completed in {$casinoDuration}s\n";
            
            // Log successful request details
            if (isset($result['basic_info']['name'])) {
                echo "   📋 Casino: {$result['basic_info']['name']}\n";
                echo "   ⭐ Rating: " . ($result['ratings']['overall_rating'] ?? 'N/A') . "/10\n";
                echo "   🎮 Games: " . number_format($result['games']['total_games'] ?? 0) . "\n";
                echo "   💎 Bonus: " . ($result['bonuses']['welcome_bonus'] ?? 'N/A') . "\n";
            }
            
        } catch (Exception $e) {
            $errorCount++;
            $casinoDuration = round(microtime(true) - $startCasinoTime, 2);
            
            echo "❌ [{$percentage}%] {$casino['name']} - FAILED in {$casinoDuration}s\n";
            echo "   🚨 Error: {$e->getMessage()}\n";
            
            $results[] = [
                'casino_id' => $casino['id'],
                'name' => $casino['name'],
                'error' => $e->getMessage(),
                'research_status' => 'failed',
                'research_date' => date('Y-m-d H:i:s')
            ];
        }
        
        // Show detailed progress every casino
        $elapsed = round(microtime(true) - $startTime, 1);
        $remaining = $totalCasinos - $processedCount;
        $avgTimePerCasino = $processedCount > 0 ? $elapsed / $processedCount : 0;
        $estimatedTimeRemaining = $remaining > 0 ? round($remaining * $avgTimePerCasino / 60, 1) : 0;
        
        echo "   ⏱️  Time: {$elapsed}s total | ~{$estimatedTimeRemaining}min remaining\n";
        echo "   📊 Success: {$successCount}/{$processedCount} (" . round(($successCount / $processedCount) * 100, 1) . "%)\n";
        
        // Add delay between requests to respect rate limits
        echo "   ⏳ Rate limit delay...\n";
        sleep(3); // 3 second delay between requests
        
        echo "\n";
    }
    
    $totalDuration = round(microtime(true) - $startTime, 2);
    
    // Final results summary
    echo "\n🎉 Research Process Complete!\n";
    echo "=============================\n";
    echo "• Total casinos processed: {$processedCount}\n";
    echo "• Successful research: {$successCount}\n";
    echo "• Failed research: {$errorCount}\n";
    echo "• Success rate: " . round(($successCount / $processedCount) * 100, 1) . "%\n";
    echo "• Total duration: {$totalDuration} seconds (" . round($totalDuration/60, 1) . " minutes)\n";
    echo "• Average time per casino: " . round($totalDuration / $processedCount, 1) . " seconds\n\n";
    
    // Show final usage stats
    echo "📈 Post-research usage statistics:\n";
    echo "=================================\n";
    $finalStats = $monitor->getTodaysSummary();
    $newRequests = $finalStats['requests_made'] - $initialStats['requests_made'];
    $newTokens = $finalStats['tokens_used'] - $initialStats['tokens_used'];
    $newCost = $finalStats['estimated_cost_usd'] - $initialStats['estimated_cost_usd'];
    
    echo "• New requests made: " . $newRequests . "\n";
    echo "• New tokens used: " . number_format($newTokens) . "\n";
    echo "• New cost incurred: $" . round($newCost, 4) . "\n";
    echo "• Final error rate: " . ($finalStats['error_rate'] * 100) . "%\n\n";
    
    // Save results
    $resultsFile = "casino-research-results-" . date('Y-m-d-H-i-s') . ".json";
    file_put_contents($resultsFile, json_encode([
        'execution_summary' => [
            'timestamp' => date('Y-m-d H:i:s'),
            'total_casinos' => $totalCasinos,
            'processed' => $processedCount,
            'successful' => $successCount,
            'failed' => $errorCount,
            'success_rate' => round(($successCount / $processedCount) * 100, 1),
            'duration_seconds' => $totalDuration,
            'tokens_used' => $newTokens,
            'estimated_cost' => $newCost
        ],
        'results' => $results
    ], JSON_PRETTY_PRINT));
    
    echo "💾 Results saved to: {$resultsFile}\n";
    echo "🔗 View research dashboard: https://bestcasinoportal.com/casino-research\n";
    echo "📊 Monitor usage: Check storage/logs/openai-usage.log\n\n";
    
    echo "🏆 Research execution completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " (line " . $e->getLine() . ")\n";
    echo "🔍 Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
