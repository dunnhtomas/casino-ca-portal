<?php
/**
 * OPENAI RESEARCH TEST - First 5 casinos only for testing
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class OpenAITestRun {
    private $apiKey;
    private $httpClient;
    
    public function __construct() {
        $this->apiKey = $_ENV['OPENAI_API_KEY'];
        $this->httpClient = new GuzzleHttp\Client([
            'timeout' => 60,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ]
        ]);
    }
    
    public function testFirst5Casinos() {
        echo "🧪 Testing OpenAI Research - First 5 Casinos\n";
        
        // Load casino database
        $casinoDatabase = json_decode(file_get_contents(__DIR__ . '/casino-affiliates-database.json'), true);
        
        if (!$casinoDatabase || !isset($casinoDatabase['casinos'])) {
            throw new Exception('Failed to load casino database');
        }
        
        $casinos = array_slice($casinoDatabase['casinos'], 0, 5); // Only first 5
        $results = [];
        
        foreach ($casinos as $index => $casino) {
            $casinoNum = $index + 1;
            echo "\n🎰 Testing Casino {$casinoNum}/5: {$casino['name']}\n";
            
            try {
                $result = $this->researchCasino($casino);
                $results[] = $result;
                echo "✅ SUCCESS: {$casino['name']} researched\n";
                
                // Show sample data
                echo "   Rating: {$result['rating']}\n";
                echo "   Games: {$result['games_count']}\n";
                echo "   Bonus: {$result['welcome_bonus']}\n";
                
            } catch (Exception $e) {
                echo "❌ ERROR: {$casino['name']} - {$e->getMessage()}\n";
                break;
            }
            
            if ($casinoNum < 5) {
                echo "⏳ Waiting 1 second...\n";
                sleep(1);
            }
        }
        
        // Save test results
        $output = [
            'casinos' => $results,
            'stats' => $this->calculateStats($results),
            'generated_at' => date('Y-m-d H:i:s'),
            'openai_available' => true,
            'total_processed' => count($results),
            'research_methods' => ['openai' => count($results)],
            'test_run' => true
        ];
        
        file_put_contents(__DIR__ . '/casino-research-openai-test.json', json_encode($output, JSON_PRETTY_PRINT));
        
        echo "\n🎉 Test Complete! Results saved to casino-research-openai-test.json\n";
        echo "📊 Processed: " . count($results) . "/5 casinos\n";
        
        return $output;
    }
    
    private function researchCasino($casinoData) {
        $websiteUrl = $casinoData['website_url'] ?? 'Not available';
        $prompt = "Research this Canadian online casino: {$casinoData['name']} (Website: {$websiteUrl})

Return a JSON object with this exact structure:

{
    \"rating\": 8.5,
    \"games_count\": 1200,
    \"welcome_bonus\": \"100% up to $500\",
    \"mobile_optimized\": true,
    \"pros\": [
        \"Wide game selection\",
        \"Fast withdrawals\", 
        \"24/7 customer support\"
    ],
    \"cons\": [
        \"Limited payment methods\",
        \"High wagering requirements\"
    ],
    \"payment_methods\": [\"Visa\", \"Mastercard\", \"Interac\", \"Bitcoin\"],
    \"description\": \"Professional casino description for Canadian players.\",
    \"software_providers\": [\"NetEnt\", \"Microgaming\", \"Evolution Gaming\"],
    \"license\": \"Malta Gaming Authority\",
    \"established_year\": 2018,
    \"withdrawal_time\": \"24-48 hours\",
    \"min_deposit\": 20,
    \"max_withdrawal\": 10000,
    \"customer_support\": \"24/7 Live Chat, Email\",
    \"languages\": [\"English\", \"French\"],
    \"currencies\": [\"CAD\", \"USD\"],
    \"bonus_features\": \"Free spins, loyalty program, VIP rewards\"
}

IMPORTANT: Return ONLY the JSON object. No explanations, no markdown, no additional text.";
        
        $response = $this->httpClient->post('https://api.openai.com/v1/chat/completions', [
            'json' => [
                'model' => 'gpt-4.1-mini', // Best model for your tier
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
                'temperature' => 0.8,
                'max_tokens' => 2500,
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
            throw new Exception('Failed to parse OpenAI JSON response: ' . $content);
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
        
        return $result;
    }
    
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

// Execute test
try {
    $test = new OpenAITestRun();
    $results = $test->testFirst5Casinos();
    echo "\n🎯 Test run successful - ready for full research!\n";
} catch (Exception $e) {
    echo "\n❌ Test failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>
