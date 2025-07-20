<?php
/**
 * Advanced OpenAI API Diagnostics
 * Test different aspects of the OpenAI connection
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

echo "🔧 Advanced OpenAI API Diagnostics\n";
echo "==================================\n";

$apiKey = $_ENV['OPENAI_API_KEY'] ?? null;
if (!$apiKey) {
    echo "❌ No OpenAI API key found\n";
    exit(1);
}

echo "✅ API Key: " . substr($apiKey, 0, 20) . "..." . substr($apiKey, -10) . "\n\n";

// Test 1: Check account/organization info
echo "📊 Test 1: Account Information\n";
echo "------------------------------\n";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.openai.com/v1/organization',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "✅ Organization access: OK\n";
    if (isset($data['title'])) echo "Organization: {$data['title']}\n";
} else {
    echo "Response: " . substr($response, 0, 200) . "\n";
}

// Test 2: Check usage/billing
echo "\n📊 Test 2: Usage Information\n";
echo "----------------------------\n";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.openai.com/v1/usage?date=' . date('Y-m-d'),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
echo "Response: " . substr($response, 0, 300) . "\n";

// Test 3: List available models
echo "\n📊 Test 3: Available Models\n";
echo "---------------------------\n";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.openai.com/v1/models',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
if ($httpCode === 200) {
    $data = json_decode($response, true);
    if (isset($data['data']) && is_array($data['data'])) {
        echo "✅ Available models: " . count($data['data']) . "\n";
        $gptModels = array_filter($data['data'], function($model) {
            return strpos($model['id'], 'gpt-') === 0;
        });
        echo "GPT models available:\n";
        foreach (array_slice($gptModels, 0, 5) as $model) {
            echo "  • " . $model['id'] . "\n";
        }
    }
} else {
    echo "Response: " . substr($response, 0, 200) . "\n";
}

// Test 4: Simple chat completion with minimal request
echo "\n📊 Test 4: Minimal Chat Completion\n";
echo "----------------------------------\n";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'model' => 'gpt-4o-mini',
        'messages' => [
            ['role' => 'user', 'content' => 'Say "Test successful" exactly.']
        ],
        'max_tokens' => 5,
        'temperature' => 0
    ])
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
if ($curlError) {
    echo "cURL Error: {$curlError}\n";
}

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if (isset($data['choices'][0]['message']['content'])) {
        echo "✅ Chat completion successful!\n";
        echo "Response: " . $data['choices'][0]['message']['content'] . "\n";
        echo "Tokens used: " . ($data['usage']['total_tokens'] ?? 'N/A') . "\n";
    }
} elseif ($httpCode === 429) {
    echo "⚠️ Rate limit hit (429)\n";
    $data = json_decode($response, true);
    if (isset($data['error'])) {
        echo "Error type: " . $data['error']['type'] . "\n";
        echo "Error message: " . $data['error']['message'] . "\n";
        echo "Error code: " . ($data['error']['code'] ?? 'N/A') . "\n";
        
        // Check if it's actually rate limiting vs quota
        if (isset($data['error']['type']) && $data['error']['type'] === 'insufficient_quota') {
            echo "🚨 This is a QUOTA issue, not rate limiting\n";
            echo "🚨 Check your billing at: https://platform.openai.com/usage\n";
        } elseif (isset($data['error']['type']) && $data['error']['type'] === 'requests') {
            echo "⏱️ This is RATE LIMITING (too many requests)\n";
            echo "⏱️ Wait and try again, or upgrade tier\n";
        }
    }
} else {
    echo "Full response: " . $response . "\n";
}

echo "\n📋 Summary\n";
echo "==========\n";
echo "If you see 'insufficient_quota' - add credits to your OpenAI account\n";
echo "If you see rate limiting - wait or upgrade your usage tier\n";
echo "Check: https://platform.openai.com/usage\n";
echo "Check: https://platform.openai.com/account/billing\n";
