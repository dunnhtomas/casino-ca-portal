<?php
/**
 * Mock Casino Research Service
 * Generates realistic casino data without API calls for testing
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

echo "🎯 Mock Casino Research (No API Calls)\n";
echo "=====================================\n";
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
    
    echo "🔄 Generating mock research data...\n";
    echo "===================================\n";
    
    $startTime = microtime(true);
    
    // Generate realistic mock data based on casino info
    $mockData = generateMockCasinoData($targetCasino);
    
    $duration = round(microtime(true) - $startTime, 2);
    
    echo "\n✅ Mock research completed in {$duration} seconds!\n";
    echo "================================================\n\n";
    
    // Display results
    echo "📋 BASIC INFO:\n";
    echo "• Name: {$mockData['basic_info']['name']}\n";
    echo "• Website: {$mockData['basic_info']['website']}\n";
    echo "• License: {$mockData['basic_info']['license']}\n";
    echo "• Founded: {$mockData['basic_info']['founded']}\n\n";
    
    echo "⭐ RATINGS:\n";
    echo "• Overall: {$mockData['ratings']['overall_rating']}/10\n";
    echo "• Games: {$mockData['ratings']['games_rating']}/10\n";
    echo "• Bonuses: {$mockData['ratings']['bonuses_rating']}/10\n";
    echo "• Support: {$mockData['ratings']['support_rating']}/10\n\n";
    
    echo "🎮 GAMES:\n";
    echo "• Total games: " . number_format($mockData['games']['total_games']) . "\n";
    echo "• Slots: " . number_format($mockData['games']['slots']) . "\n";
    echo "• Table games: " . number_format($mockData['games']['table_games']) . "\n";
    echo "• Live dealer: " . number_format($mockData['games']['live_dealer']) . "\n\n";
    
    echo "💎 BONUSES:\n";
    echo "• Welcome bonus: {$mockData['bonuses']['welcome_bonus']}\n";
    echo "• No deposit: {$mockData['bonuses']['no_deposit_bonus']}\n";
    echo "• Free spins: {$mockData['bonuses']['free_spins']}\n\n";
    
    // Save result
    $resultFile = "mock-casino-research-{$casinoId}-" . date('Y-m-d-H-i-s') . ".json";
    file_put_contents($resultFile, json_encode($mockData, JSON_PRETTY_PRINT));
    
    echo "💾 Results saved to: {$resultFile}\n";
    echo "🏆 Mock casino research completed successfully!\n";
    echo "\n🔧 Note: This is MOCK data for testing. Switch to real OpenAI once billing is resolved.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " (line " . $e->getLine() . ")\n";
    exit(1);
}

function generateMockCasinoData($casino) {
    // Generate realistic but fake data based on the casino info
    $baseRating = $casino['rating'] ?? 7.0;
    
    return [
        'casino_id' => $casino['id'],
        'research_status' => 'completed',
        'research_date' => date('Y-m-d H:i:s'),
        'research_method' => 'mock_generation',
        
        'basic_info' => [
            'name' => $casino['name'],
            'website' => $casino['website_url'] ?? 'https://' . strtolower(str_replace(' ', '', $casino['name'])) . '.com',
            'license' => generateMockLicense(),
            'founded' => rand(2010, 2020),
            'owner' => $casino['brand_group'] ?? 'Gaming Group',
            'languages' => ['English', 'French', 'German'],
            'currencies' => ['USD', 'EUR', 'CAD', 'GBP']
        ],
        
        'ratings' => [
            'overall_rating' => round($baseRating + (rand(-10, 10) / 10), 1),
            'games_rating' => round($baseRating + (rand(-5, 15) / 10), 1),
            'bonuses_rating' => round($baseRating + (rand(-15, 5) / 10), 1),
            'support_rating' => round($baseRating + (rand(-10, 10) / 10), 1),
            'security_rating' => round($baseRating + (rand(-5, 15) / 10), 1),
            'withdrawal_rating' => round($baseRating + (rand(-20, 10) / 10), 1)
        ],
        
        'games' => [
            'total_games' => rand(800, 3000),
            'slots' => rand(600, 2500),
            'table_games' => rand(50, 200),
            'live_dealer' => rand(30, 150),
            'jackpot_games' => rand(20, 100),
            'providers' => generateMockProviders()
        ],
        
        'bonuses' => [
            'welcome_bonus' => generateMockWelcomeBonus(),
            'no_deposit_bonus' => rand(0, 1) ? '$' . rand(10, 50) . ' No Deposit' : 'None',
            'free_spins' => rand(50, 200) . ' Free Spins',
            'loyalty_program' => 'VIP Program Available',
            'promotions_count' => rand(5, 20)
        ],
        
        'banking' => [
            'deposit_methods' => ['Credit Cards', 'E-wallets', 'Bank Transfer', 'Crypto'],
            'withdrawal_methods' => ['E-wallets', 'Bank Transfer', 'Check'],
            'min_deposit' => '$' . rand(10, 25),
            'min_withdrawal' => '$' . rand(20, 50),
            'withdrawal_time' => rand(1, 5) . '-' . rand(3, 7) . ' business days'
        ],
        
        'support' => [
            'live_chat' => rand(0, 1) ? '24/7' : 'Limited hours',
            'email' => 'Available',
            'phone' => rand(0, 1) ? 'Available' : 'Not available',
            'languages' => ['English', 'French']
        ],
        
        'pros_cons' => [
            'pros' => generateMockPros(),
            'cons' => generateMockCons()
        ],
        
        'meta' => [
            'last_updated' => date('Y-m-d'),
            'data_source' => 'Mock generation for testing',
            'reliability_score' => 0.7, // Lower since it's mock data
            'api_cost_saved' => '$0.05' // Estimated cost we saved by using mock
        ]
    ];
}

function generateMockLicense() {
    $licenses = [
        'Malta Gaming Authority (MGA)',
        'UK Gambling Commission',
        'Curacao eGaming',
        'Gibraltar Gambling Commission',
        'Kahnawake Gaming Commission'
    ];
    return $licenses[array_rand($licenses)];
}

function generateMockProviders() {
    $providers = ['NetEnt', 'Microgaming', 'Pragmatic Play', 'Evolution Gaming', 'Play\'n GO', 'Yggdrasil'];
    $selected = array_rand($providers, rand(3, 6));
    return is_array($selected) ? array_intersect_key($providers, array_flip($selected)) : [$providers[$selected]];
}

function generateMockWelcomeBonus() {
    $bonusTypes = [
        '100% up to $500 + 100 Free Spins',
        '200% up to $1000 Welcome Package',
        '$300 Welcome Bonus + 50 Free Spins',
        '150% up to $750 First Deposit Bonus',
        'Up to $2000 Welcome Package'
    ];
    return $bonusTypes[array_rand($bonusTypes)];
}

function generateMockPros() {
    $allPros = [
        'Large game selection',
        'Fast withdrawal processing',
        'Excellent customer support',
        'Mobile-friendly platform',
        'Generous welcome bonus',
        'Regular promotions',
        'Live dealer games available',
        'Multiple payment methods'
    ];
    $selected = array_rand($allPros, rand(3, 5));
    return is_array($selected) ? array_intersect_key($allPros, array_flip($selected)) : [$allPros[$selected]];
}

function generateMockCons() {
    $allCons = [
        'Limited customer support hours',
        'High wagering requirements',
        'Restricted in some countries',
        'Limited banking options',
        'Slow verification process',
        'No phone support'
    ];
    $selected = array_rand($allCons, rand(2, 3));
    return is_array($selected) ? array_intersect_key($allCons, array_flip($selected)) : [$allCons[$selected]];
}
