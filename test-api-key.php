<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'] ?? '';

echo "🔑 Testing OpenAI API Key: " . substr($apiKey, 0, 20) . "...\n";

// Test with a simple curl request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/models');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "📊 HTTP Response Code: $httpCode\n";

$data = json_decode($response, true);

if ($httpCode === 200 && isset($data['data'])) {
    echo "✅ API Key is VALID!\n";
    echo "🎯 Available Models: " . count($data['data']) . "\n";
    
    // List some key models
    $models = array_column($data['data'], 'id');
    $gptModels = array_filter($models, fn($m) => strpos($m, 'gpt') !== false);
    echo "🤖 GPT Models Available: " . implode(', ', array_slice($gptModels, 0, 5)) . "\n";
    
} else {
    echo "❌ API Key Error:\n";
    if (isset($data['error'])) {
        echo "Error: " . $data['error']['message'] . "\n";
        echo "Type: " . $data['error']['type'] . "\n";
        
        if (strpos($data['error']['message'], 'quota') !== false) {
            echo "\n💳 BILLING ISSUE DETECTED!\n";
            echo "🔧 Fix: Go to https://platform.openai.com/account/billing\n";
            echo "💰 Add a payment method (credit card)\n";
            echo "📊 Check usage limits at https://platform.openai.com/account/limits\n";
        }
    } else {
        echo "Unknown error. Response: $response\n";
    }
}
