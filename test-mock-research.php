<?php
/**
 * Mock Casino Research Service
 * Generates realistic casino data without API calls
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

class MockCasinoResearch {
    
    public function researchCasino(array $casinoData): array {
        // Simulate research time
        sleep(1);
        
        $casinoName = $casinoData['name'];
        $casinoId = $casinoData['id'];
        
        // Generate realistic ratings based on casino tier
        $baseRating = $this->getBaseRating($casinoData);
        
        return [
            'casino_id' => $casinoId,
            'research_date' => date('Y-m-d H:i:s'),
            'research_method' => 'mock_generation',
            'basic_info' => [
                'name' => $casinoName,
                'website' => $casinoData['website_url'] ?? "https://{$casinoId}.com",
                'license' => $this->generateLicense($casinoData),
                'founded' => $this->generateFoundedYear(),
                'owner' => $this->generateOwner($casinoName),
                'jurisdiction' => $this->generateJurisdiction($casinoData)
            ],
            'ratings' => [
                'overall_rating' => $baseRating,
                'games_rating' => $baseRating + mt_rand(-5, 10) / 10,
                'bonuses_rating' => $baseRating + mt_rand(-8, 12) / 10,
                'support_rating' => $baseRating + mt_rand(-6, 8) / 10,
                'security_rating' => $baseRating + mt_rand(-3, 7) / 10,
                'mobile_rating' => $baseRating + mt_rand(-4, 9) / 10
            ],
            'games' => [
                'total_games' => $this->generateGameCount($baseRating),
                'slots' => $this->generateSlotCount($baseRating),
                'table_games' => mt_rand(80, 300),
                'live_dealer' => mt_rand(20, 150),
                'jackpot_games' => mt_rand(10, 80),
                'providers' => $this->generateProviders($baseRating)
            ],
            'bonuses' => [
                'welcome_bonus' => $this->generateWelcomeBonus($casinoData),
                'no_deposit_bonus' => $this->generateNoDepositBonus(),
                'free_spins' => $this->generateFreeSpins(),
                'wagering_requirement' => mt_rand(25, 50) . 'x',
                'bonus_types' => ['Welcome', 'Reload', 'Cashback', 'VIP', 'Tournament']
            ],
            'payments' => [
                'deposit_methods' => ['Visa', 'Mastercard', 'PayPal', 'Skrill', 'Neteller', 'Interac', 'Bitcoin'],
                'withdrawal_methods' => ['Bank Transfer', 'PayPal', 'Skrill', 'Neteller', 'Bitcoin'],
                'min_deposit' => '$' . mt_rand(10, 25),
                'max_withdrawal' => '$' . mt_rand(5000, 50000) . '/month',
                'withdrawal_time' => mt_rand(1, 5) . '-' . mt_rand(5, 14) . ' days'
            ],
            'features' => [
                'mobile_optimized' => true,
                'live_chat' => mt_rand(0, 1) == 1,
                'phone_support' => mt_rand(0, 1) == 1,
                'email_support' => true,
                'vip_program' => mt_rand(0, 1) == 1,
                'tournaments' => mt_rand(0, 1) == 1,
                'crypto_supported' => mt_rand(0, 1) == 1
            ],
            'target_markets' => $casinoData['target_markets'] ?? ['CA', 'UK', 'AU'],
            'languages' => $this->generateLanguages($casinoData),
            'currencies' => ['CAD', 'USD', 'EUR', 'GBP'],
            'research_notes' => "Mock research generated for {$casinoName}. Based on tier: " . ($casinoData['tier'] ?? 'standard'),
            'last_updated' => date('Y-m-d H:i:s')
        ];
    }
    
    private function getBaseRating($casinoData): float {
        $tier = $casinoData['tier'] ?? 'standard';
        $baseRating = $casinoData['rating'] ?? 7.5;
        
        // Adjust based on tier
        switch ($tier) {
            case 'premium':
                return min(9.5, $baseRating + mt_rand(0, 10) / 10);
            case 'global':
                return min(9.2, $baseRating + mt_rand(0, 8) / 10);
            default:
                return min(9.0, max(6.0, $baseRating + mt_rand(-5, 5) / 10));
        }
    }
    
    private function generateLicense($casinoData): string {
        $licenses = [
            'Malta Gaming Authority (MGA)',
            'UK Gambling Commission (UKGC)',
            'Curacao eGaming',
            'Kahnawake Gaming Commission',
            'Gibraltar Gambling Commission',
            'Alderney Gambling Control Commission'
        ];
        
        return $licenses[array_rand($licenses)] . ' #' . strtoupper(substr(md5($casinoData['id']), 0, 8));
    }
    
    private function generateFoundedYear(): string {
        return (string) mt_rand(2010, 2023);
    }
    
    private function generateOwner($casinoName): string {
        $owners = [
            'Evolution Gaming Group',
            'Playtech Holdings',
            'NetEnt Group',
            'Microgaming Ltd',
            'White Hat Gaming',
            'ProgressPlay Limited',
            'Aspire Global International'
        ];
        
        return $owners[array_rand($owners)];
    }
    
    private function generateJurisdiction($casinoData): string {
        $markets = $casinoData['target_markets'] ?? ['CA'];
        
        if (in_array('CA', $markets)) return 'Canada';
        if (in_array('UK', $markets)) return 'United Kingdom';
        if (in_array('AU', $markets)) return 'Australia';
        
        return 'Malta';
    }
    
    private function generateGameCount($rating): int {
        $base = ($rating >= 8.5) ? 3000 : (($rating >= 7.5) ? 2000 : 1000);
        return $base + mt_rand(-500, 1000);
    }
    
    private function generateSlotCount($rating): int {
        $totalGames = $this->generateGameCount($rating);
        return (int)($totalGames * 0.8) + mt_rand(-200, 300);
    }
    
    private function generateProviders($rating): array {
        $allProviders = [
            'NetEnt', 'Microgaming', 'Playtech', 'Evolution Gaming',
            'Pragmatic Play', 'Red Tiger', 'Big Time Gaming', 'Blueprint Gaming',
            'Yggdrasil', 'Push Gaming', 'Play\'n GO', 'Quickspin',
            'Thunderkick', 'ELK Studios', 'NoLimit City', 'Relax Gaming'
        ];
        
        $count = ($rating >= 8.5) ? mt_rand(12, 16) : (($rating >= 7.5) ? mt_rand(8, 12) : mt_rand(5, 8));
        
        shuffle($allProviders);
        return array_slice($allProviders, 0, $count);
    }
    
    private function generateWelcomeBonus($casinoData): string {
        $amounts = [100, 200, 300, 500, 1000, 1500, 2000];
        $percentages = [100, 150, 200, 250, 300];
        
        $amount = $amounts[array_rand($amounts)];
        $percentage = $percentages[array_rand($percentages)];
        
        return "{$percentage}% up to \${$amount} + Free Spins";
    }
    
    private function generateNoDepositBonus(): string {
        if (mt_rand(0, 1) == 0) {
            return '$' . mt_rand(10, 50) . ' No Deposit Bonus';
        }
        return mt_rand(10, 100) . ' Free Spins No Deposit';
    }
    
    private function generateFreeSpins(): string {
        return mt_rand(50, 500) . ' Free Spins on selected slots';
    }
    
    private function generateLanguages($casinoData): array {
        $languages = ['English'];
        
        $markets = $casinoData['target_markets'] ?? ['CA'];
        
        if (in_array('CA', $markets)) $languages[] = 'French';
        if (in_array('DE', $markets)) $languages[] = 'German';
        if (in_array('NO', $markets)) $languages[] = 'Norwegian';
        if (in_array('FI', $markets)) $languages[] = 'Finnish';
        
        return array_unique($languages);
    }
}

// Get casino ID from command line
$casinoId = $argv[1] ?? 'bonrush_001';

echo "🎯 Mock Casino Research Test\n";
echo "============================\n";
echo "Casino ID: {$casinoId}\n";
echo "Timestamp: " . date('Y-m-d H:i:s') . "\n";
echo "⚠️  Using MOCK data (no API calls)\n\n";

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
    
    echo "🏛️  Found casino: {$targetCasino['name']}\n";
    echo "🌐 Website: " . ($targetCasino['website_url'] ?? 'N/A') . "\n";
    echo "⭐ Base rating: {$targetCasino['rating']}\n";
    echo "🎯 Tier: " . ($targetCasino['tier'] ?? 'standard') . "\n\n";
    
    echo "🔬 Generating mock research data...\n";
    echo "===================================\n";
    
    $startTime = microtime(true);
    
    // Generate mock research
    $mockResearch = new MockCasinoResearch();
    $result = $mockResearch->researchCasino($targetCasino);
    
    $duration = round(microtime(true) - $startTime, 2);
    
    echo "\n✅ Mock research completed in {$duration} seconds!\n";
    echo "================================================\n\n";
    
    // Display results
    echo "📋 BASIC INFO:\n";
    echo "• Name: {$result['basic_info']['name']}\n";
    echo "• Website: {$result['basic_info']['website']}\n";
    echo "• License: {$result['basic_info']['license']}\n";
    echo "• Founded: {$result['basic_info']['founded']}\n";
    echo "• Owner: {$result['basic_info']['owner']}\n\n";
    
    echo "⭐ RATINGS:\n";
    echo "• Overall: {$result['ratings']['overall_rating']}/10\n";
    echo "• Games: {$result['ratings']['games_rating']}/10\n";
    echo "• Bonuses: {$result['ratings']['bonuses_rating']}/10\n";
    echo "• Support: {$result['ratings']['support_rating']}/10\n";
    echo "• Security: {$result['ratings']['security_rating']}/10\n\n";
    
    echo "🎮 GAMES:\n";
    echo "• Total games: " . number_format($result['games']['total_games']) . "\n";
    echo "• Slots: " . number_format($result['games']['slots']) . "\n";
    echo "• Table games: " . number_format($result['games']['table_games']) . "\n";
    echo "• Live dealer: " . number_format($result['games']['live_dealer']) . "\n";
    echo "• Providers: " . implode(', ', array_slice($result['games']['providers'], 0, 5)) . "...\n\n";
    
    echo "💎 BONUSES:\n";
    echo "• Welcome: {$result['bonuses']['welcome_bonus']}\n";
    echo "• No deposit: {$result['bonuses']['no_deposit_bonus']}\n";
    echo "• Free spins: {$result['bonuses']['free_spins']}\n";
    echo "• Wagering: {$result['bonuses']['wagering_requirement']}\n\n";
    
    echo "💳 PAYMENTS:\n";
    echo "• Min deposit: {$result['payments']['min_deposit']}\n";
    echo "• Max withdrawal: {$result['payments']['max_withdrawal']}\n";
    echo "• Withdrawal time: {$result['payments']['withdrawal_time']}\n\n";
    
    // Save result
    $resultFile = "mock-research-{$casinoId}-" . date('Y-m-d-H-i-s') . ".json";
    file_put_contents($resultFile, json_encode($result, JSON_PRETTY_PRINT));
    
    echo "💾 Results saved to: {$resultFile}\n";
    echo "🎭 Mock research completed successfully!\n";
    echo "\n💡 To use real OpenAI: Fix quota issue at https://platform.openai.com/usage\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " (line " . $e->getLine() . ")\n";
    exit(1);
}
