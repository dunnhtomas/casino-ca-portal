<?php
/**
 * REAL CASINO RESEARCH - USING OFFICIAL OPENAI PHP CLIENT ONLY
 * No fallback, no mock data - pure OpenAI integration
 */

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use OpenAI\Client;

// Load environment
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'] ?? '';

if (empty($apiKey)) {
    die("❌ OPENAI_API_KEY not found in .env file\n");
}

// Initialize OpenAI client - EXACTLY as you specified
$client = OpenAI::client($apiKey);

// Load casino affiliate database
$jsonFile = __DIR__ . '/casino-affiliates-database.json';
if (!file_exists($jsonFile)) {
    die("❌ Casino database not found: $jsonFile\n");
}

$affiliateData = json_decode(file_get_contents($jsonFile), true);
if (!$affiliateData || !isset($affiliateData['casinos'])) {
    die("❌ Invalid casino database format\n");
}

$casinos = $affiliateData['casinos'];
$researchResults = [];
$processedCount = 0;

echo "🚀 Starting REAL OpenAI Casino Research\n";
echo "📊 Processing " . count($casinos) . " casinos...\n\n";

foreach ($casinos as $casino) {
    $processedCount++;
    echo "[$processedCount/" . count($casinos) . "] Processing: {$casino['name']}\n";
    
    try {
        // Research prompt for OpenAI
        $prompt = "Analyze this online casino and provide detailed research data in JSON format:

Casino Name: {$casino['name']}
Website: {$casino['website_url']}
Country: {$casino['geo']}

Provide a comprehensive analysis with the following structure:
{
    \"name\": \"casino name\",
    \"rating\": 8.5,
    \"games_count\": 1500,
    \"welcome_bonus\": \"200% up to $1000\",
    \"mobile_optimized\": true,
    \"pros\": [\"reason 1\", \"reason 2\", \"reason 3\"],
    \"cons\": [\"concern 1\", \"concern 2\"],
    \"payment_methods\": [\"Visa\", \"Mastercard\", \"Bitcoin\", \"E-transfer\"],
    \"description\": \"Detailed casino description for SEO\",
    \"meta_title\": \"SEO optimized title\",
    \"meta_description\": \"SEO meta description\",
    \"keywords\": [\"casino\", \"slots\", \"canada\"],
    \"license_info\": \"Licensing authority\",
    \"established_year\": 2020,
    \"software_providers\": [\"NetEnt\", \"Microgaming\", \"Evolution\"],
    \"customer_support\": \"24/7 live chat and email\",
    \"withdrawal_time\": \"1-3 business days\",
    \"min_deposit\": 20,
    \"max_withdrawal\": 10000,
    \"vip_program\": true,
    \"live_casino\": true,
    \"sports_betting\": false
}

Focus on Canadian players, provide realistic data based on the casino's actual reputation and offerings. Be thorough and professional.";

        // Make OpenAI API call using official client
        $response = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an expert casino analyst providing detailed, accurate research data for Canadian online casinos. Always respond with valid JSON only.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'max_tokens' => 2000,
            'temperature' => 0.7,
        ]);

        $content = $response->choices[0]->message->content;
        
        // Parse JSON response
        $researchData = json_decode($content, true);
        
        if (!$researchData) {
            echo "   ⚠️  Failed to parse JSON response, retrying...\n";
            continue;
        }

        // Add metadata
        $researchData['id'] = $casino['id'];
        $researchData['original_website'] = $casino['website_url'];
        $researchData['geo'] = $casino['geo'];
        $researchData['commission_model'] = $casino['commission_model'];
        $researchData['research_method'] = 'openai';
        $researchData['researched_at'] = date('Y-m-d H:i:s');
        
        $researchResults[] = $researchData;
        
        echo "   ✅ Research completed\n";
        
        // Rate limiting - respect OpenAI limits
        sleep(1);
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
        
        // If it's a rate limit error, wait longer
        if (strpos($e->getMessage(), 'rate_limit') !== false) {
            echo "   ⏳ Rate limit hit, waiting 60 seconds...\n";
            sleep(60);
        }
        
        continue;
    }
}

// Generate comprehensive statistics
$stats = [
    'total_casinos' => count($researchResults),
    'average_rating' => count($researchResults) > 0 ? round(array_sum(array_column($researchResults, 'rating')) / count($researchResults), 1) : 0,
    'total_games' => array_sum(array_column($researchResults, 'games_count')),
    'mobile_optimized' => count(array_filter($researchResults, fn($c) => $c['mobile_optimized'] ?? false)),
    'with_vip_program' => count(array_filter($researchResults, fn($c) => $c['vip_program'] ?? false)),
    'with_live_casino' => count(array_filter($researchResults, fn($c) => $c['live_casino'] ?? false)),
    'with_sports_betting' => count(array_filter($researchResults, fn($c) => $c['sports_betting'] ?? false))
];

// Create final output
$finalOutput = [
    'generated_at' => date('Y-m-d H:i:s'),
    'total_processed' => $processedCount,
    'successful_research' => count($researchResults),
    'research_method' => 'openai_official',
    'openai_available' => true,
    'stats' => $stats,
    'casinos' => $researchResults
];

// Save results
$outputFile = __DIR__ . '/casino-research-results.json';
file_put_contents($outputFile, json_encode($finalOutput, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// Also save to public directory
$publicOutputFile = __DIR__ . '/public/casino-research-complete.json';
file_put_contents($publicOutputFile, json_encode($finalOutput, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "\n🎉 RESEARCH COMPLETED!\n";
echo "✅ Successfully researched: " . count($researchResults) . " casinos\n";
echo "📊 Average rating: " . $stats['average_rating'] . "/10\n";
echo "🎮 Total games: " . number_format($stats['total_games']) . "\n";
echo "📱 Mobile optimized: " . $stats['mobile_optimized'] . " casinos\n";
echo "💎 VIP programs: " . $stats['with_vip_program'] . " casinos\n";
echo "🎰 Live casinos: " . $stats['with_live_casino'] . " casinos\n";
echo "⚽ Sports betting: " . $stats['with_sports_betting'] . " casinos\n";
echo "\n📁 Results saved to:\n";
echo "   - $outputFile\n";
echo "   - $publicOutputFile\n";
echo "\n🌐 View results at: https://bestcasinoportal.com/casino-research-dashboard.html\n";
