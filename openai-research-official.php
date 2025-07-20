<?php
/**
 * OFFICIAL OPENAI CASINO RESEARCH - EXACT API IMPLEMENTATION
 * Using official OpenAI API documentation standards
 * https://platform.openai.com/docs/api-reference/introduction
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class OfficialOpenAIResearch {
    private $apiKey;
    private $baseUrl = 'https://api.openai.com/v1';
    private $httpClient;
    
    public function __construct() {
        $this->apiKey = $_ENV['OPENAI_API_KEY'];
        $this->httpClient = new GuzzleHttp\Client([
            'timeout' => 60,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'User-Agent' => 'CasinoPortal/1.0'
            ]
        ]);
    }
    
    /**
     * Research a single casino using OpenAI API
     */
    public function researchCasino($casinoData) {
        echo "🎰 Researching: {$casinoData['name']}\n";
        
        $prompt = $this->buildResearchPrompt($casinoData);
        
        try {
            $response = $this->httpClient->post('https://api.openai.com/v1/chat/completions', [
                'json' => [
                    'model' => 'gpt-4.1-mini', // Best model for your tier - 200K TPM, 500 RPM
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a professional casino analyst. You MUST respond with valid JSON only. No explanations, no markdown, no additional text - just pure JSON.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'response_format' => ['type' => 'json_object'],
                    'temperature' => 0.8, // Higher creativity for diverse content
                    'max_tokens' => 2500, // More tokens for detailed analysis
                    'top_p' => 0.95,
                    'frequency_penalty' => 0.1,
                    'presence_penalty' => 0.1
                ]
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($data['choices'][0]['message']['content'])) {
                throw new Exception('Invalid OpenAI response format');
            }
            
            $content = $data['choices'][0]['message']['content'];
            $researchData = json_decode($content, true);
            
            if (!$researchData) {
                throw new Exception('Failed to parse OpenAI JSON response');
            }
            
            // Merge with original casino data
            $result = array_merge($casinoData, $researchData);
            $result['research_method'] = 'openai';
            $result['researched_at'] = date('Y-m-d H:i:s');
            
            // Ensure website_url is set
            if (!isset($result['website_url']) && isset($casinoData['website_url'])) {
                $result['website_url'] = $casinoData['website_url'];
            } elseif (!isset($result['website_url'])) {
                $result['website_url'] = 'https://' . strtolower(str_replace(' ', '', $casinoData['name'])) . '.com';
            }
            
            echo "✅ Research completed for {$casinoData['name']}\n";
            return $result;
            
        } catch (Exception $e) {
            echo "❌ OpenAI Error for {$casinoData['name']}: " . $e->getMessage() . "\n";
            throw $e; // Re-throw - NO FALLBACK
        }
    }
    
    /**
     * Build research prompt for casino
     */
    private function buildResearchPrompt($casino) {
        $websiteUrl = $casino['website_url'] ?? 'Not available';
        return "As a professional casino analyst, research and analyze this Canadian online casino: {$casino['name']} (Website: {$websiteUrl})

Generate comprehensive, realistic data with variety and uniqueness for each casino. Ensure ratings, bonuses, and features are diverse and realistic.

Return a JSON object with this exact structure:

{
    \"rating\": [Use varied ratings: 7.1-9.4 range, with decimals],
    \"games_count\": [Varied: 400-3500 games, realistic numbers],
    \"welcome_bonus\": [Diverse bonuses: \"125% up to $1,200\", \"$50 No Deposit + 100% Match\", \"200 Free Spins + 150% Bonus\" etc],
    \"mobile_optimized\": [Mix of true/false based on modern vs older casinos],
    \"pros\": [
        \"[Unique strength like 'Lightning-fast crypto withdrawals']\",
        \"[Specific feature like '4,000+ slot games']\", 
        \"[Service benefit like 'VIP program with exclusive perks']\"
    ],
    \"cons\": [
        \"[Realistic limitation like 'Higher wagering requirements (45x)']\",
        \"[Specific restriction like 'Limited live dealer selection']\"
    ],
    \"payment_methods\": [\"Visa\", \"Mastercard\", \"Interac\", \"[Add 2-3 varied options like Bitcoin, PayPal, Skrill]\"],
    \"description\": \"[2-3 sentences highlighting unique selling points, target audience, and standout features - make each casino sound distinct]\",
    \"software_providers\": [\"[Mix of major providers: NetEnt, Microgaming, Pragmatic Play, Evolution Gaming, Play'n GO, etc - vary combinations]\"],
    \"license\": \"[Varied licenses: Malta Gaming Authority, Curacao eGaming, UK Gambling Commission, etc]\",
    \"established_year\": [Realistic years: 2015-2023],
    \"withdrawal_time\": \"[Varied: '1-3 hours', '24-48 hours', 'Instant crypto', etc]\",
    \"min_deposit\": [Varied: 10-50],
    \"max_withdrawal\": [Varied: 5000-50000],
    \"customer_support\": \"[Mix: '24/7 Live Chat', 'Email + Phone', 'Live Chat 16h/day' etc]\",
    \"languages\": [\"English\", \"[Add 1-2 relevant languages like French, German, Spanish]\"],
    \"currencies\": [\"CAD\", \"[Add 1-2: USD, EUR, BTC, etc]\"],
    \"bonus_features\": \"[Unique features: 'Daily cashback, tournament prizes, loyalty rewards', etc]\"
}

CRITICAL: Make each casino unique with realistic variations. No identical data. Return ONLY the JSON object.";
    }
    
    /**
     * Process all casinos from the affiliate database
     */
    public function processAllCasinos() {
        echo "🚀 Starting OpenAI Casino Research\n";
        echo "📊 API Key: " . substr($this->apiKey, 0, 10) . "...\n\n";
        
        // Load casino database
        $casinoDatabase = json_decode(file_get_contents(__DIR__ . '/casino-affiliates-database.json'), true);
        
        if (!$casinoDatabase || !isset($casinoDatabase['casinos'])) {
            throw new Exception('Failed to load casino database');
        }
        
        $casinos = $casinoDatabase['casinos'];
        $results = [];
        $processed = 0;
        $total = count($casinos);
        
        echo "📈 Processing {$total} casinos...\n\n";
        
        foreach ($casinos as $casino) {
            try {
                $result = $this->researchCasino($casino);
                $results[] = $result;
                $processed++;
                
                echo "✅ Progress: {$processed}/{$total} casinos completed\n\n";
                
                // Optimal rate limiting for your tier (500 RPM = ~8 requests/minute)
                // Using 2-second delays = 30 requests/minute (well within limits)
                if ($processed < $total) {
                    echo "⏳ Rate limiting: waiting 2 seconds...\n";
                    sleep(2);
                }
                
            } catch (Exception $e) {
                echo "❌ FAILED: {$casino['name']} - {$e->getMessage()}\n";
                echo "🛑 STOPPING - No fallback allowed\n";
                throw $e;
            }
        }
        
        // Save results
        $output = [
            'casinos' => $results,
            'stats' => $this->calculateStats($results),
            'generated_at' => date('Y-m-d H:i:s'),
            'openai_available' => true,
            'total_processed' => $processed,
            'research_methods' => ['openai' => $processed]
        ];
        
        file_put_contents(__DIR__ . '/casino-research-openai-only.json', json_encode($output, JSON_PRETTY_PRINT));
        
        echo "🎉 Research completed! Results saved to casino-research-openai-only.json\n";
        echo "📊 Successfully processed: {$processed}/{$total} casinos\n";
        
        return $output;
    }
    
    /**
     * Calculate statistics from research results
     */
    private function calculateStats($casinos) {
        if (empty($casinos)) return [];
        
        $totalRating = 0;
        $totalGames = 0;
        $mobileOptimized = 0;
        
        foreach ($casinos as $casino) {
            $totalRating += floatval($casino['rating'] ?? 0);
            $totalGames += intval($casino['games_count'] ?? 0);
            if ($casino['mobile_optimized'] ?? false) {
                $mobileOptimized++;
            }
        }
        
        return [
            'total_casinos' => count($casinos),
            'average_rating' => round($totalRating / count($casinos), 1),
            'total_games' => $totalGames,
            'mobile_optimized' => $mobileOptimized
        ];
    }
}

// Execute research
try {
    $research = new OfficialOpenAIResearch();
    $results = $research->processAllCasinos();
    echo "\n🎰 OpenAI Casino Research Complete!\n";
} catch (Exception $e) {
    echo "\n❌ Research Failed: " . $e->getMessage() . "\n";
    echo "💡 Please check your OpenAI API key and billing status\n";
    echo "🔗 Visit: https://platform.openai.com/account/billing\n";
    exit(1);
}
?>
