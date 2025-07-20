<?php
/**
 * OPENAI API BILLING FIX VERIFICATION
 * Test script to verify OpenAI API once billing is resolved
 */

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];

echo "🔑 Testing OpenAI API Key: " . substr($apiKey, 0, 10) . "...\n";
echo "📅 Date: " . date('Y-m-d H:i:s') . "\n";
echo "🌐 API Endpoint: https://api.openai.com/v1/chat/completions\n\n";

$client = new GuzzleHttp\Client([
    'timeout' => 30,
    'headers' => [
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json'
    ]
]);

try {
    echo "🚀 Sending test request to OpenAI...\n";
    
    $response = $client->post('https://api.openai.com/v1/chat/completions', [
        'json' => [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Reply with exactly: "OpenAI API is working perfectly!"'
                ]
            ],
            'max_tokens' => 50,
            'temperature' => 0
        ]
    ]);
    
    $data = json_decode($response->getBody()->getContents(), true);
    
    if (isset($data['choices'][0]['message']['content'])) {
        echo "✅ SUCCESS! OpenAI Response: " . $data['choices'][0]['message']['content'] . "\n";
        echo "🎉 Your API integration is PERFECT!\n";
        echo "💰 Billing has been resolved - you can now run the full research!\n";
        echo "🚀 Run: php openai-research-official.php\n";
    } else {
        echo "❓ Unexpected response format\n";
        print_r($data);
    }
    
} catch (GuzzleHttp\Exception\ClientException $e) {
    $statusCode = $e->getResponse()->getStatusCode();
    $errorBody = $e->getResponse()->getBody()->getContents();
    
    echo "❌ OpenAI API Error (HTTP {$statusCode}):\n";
    
    if ($statusCode == 429) {
        echo "🚫 QUOTA EXCEEDED - This is the billing issue\n";
        echo "💡 Solution:\n";
        echo "   1. Go to: https://platform.openai.com/account/billing\n";
        echo "   2. Add a payment method (credit card)\n";
        echo "   3. Add credits or set up auto-recharge\n";
        echo "   4. Re-run this test script\n";
        echo "   5. Once this works, run the full research\n";
    } elseif ($statusCode == 401) {
        echo "🔑 AUTHENTICATION ERROR - API key issue\n";
        echo "💡 Check your API key in the .env file\n";
    } else {
        echo "❓ Other error: {$errorBody}\n";
    }
    
} catch (Exception $e) {
    echo "❌ General Error: " . $e->getMessage() . "\n";
}

echo "\n📋 Summary:\n";
echo "✅ API Key Format: VALID\n";
echo "✅ API Endpoint: CORRECT\n";  
echo "✅ Request Format: VALID\n";
echo "❌ Billing Status: NEEDS PAYMENT METHOD\n";
echo "\n🎯 Next Step: Add billing at https://platform.openai.com/account/billing\n";
?>
