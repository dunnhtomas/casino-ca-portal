<?php
/**
 * 2025 OpenAI API Test - Latest Format
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

echo "🔧 Testing OpenAI API - 2025 Format\n";
echo "====================================\n";

$apiKey = $_ENV['OPENAI_API_KEY'] ?? null;
if (!$apiKey) {
    echo "❌ No OpenAI API key found\n";
    exit(1);
}

echo "✅ API Key: " . substr($apiKey, 0, 20) . "...\n";
echo "🔄 Testing with proper 2025 headers...\n\n";

try {
    // Test 1: Check API key format
    if (!preg_match('/^sk-[A-Za-z0-9\-_]{20,}/', $apiKey)) {
        echo "⚠️  API key format might be incorrect\n";
    } else {
        echo "✅ API key format looks correct\n";
    }
    
    // Test 2: Test with updated headers (2025 format)
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'OpenAI-Beta: assistants=v2', // 2025 beta header
            'User-Agent: CasinoPortal/2.0',
            'Accept: application/json'
        ],
        CURLOPT_POSTFIELDS => json_encode([
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant. Respond briefly.'
                ],
                [
                    'role' => 'user', 
                    'content' => 'Say "API test successful" exactly.'
                ]
            ],
            'max_tokens' => 10,
            'temperature' => 0.1,
            'top_p' => 1.0,
            'frequency_penalty' => 0.0,
            'presence_penalty' => 0.0
        ], JSON_UNESCAPED_SLASHES),
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT => 'CasinoPortal/2.0'
    ]);

    echo "🌐 Making API call...\n";
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    echo "📊 Response Details:\n";
    echo "  • HTTP Code: {$httpCode}\n";
    echo "  • Response Time: " . round($info['total_time'], 2) . "s\n";
    echo "  • SSL Verify: " . ($info['ssl_verify_result'] == 0 ? 'OK' : 'FAILED') . "\n";
    
    if ($curlError) {
        echo "❌ cURL Error: {$curlError}\n";
        exit(1);
    }

    if ($httpCode === 200) {
        echo "✅ API call successful!\n\n";
        $data = json_decode($response, true);
        
        if (isset($data['choices'][0]['message']['content'])) {
            echo "🎉 AI Response: '" . $data['choices'][0]['message']['content'] . "'\n";
            
            // Check token usage
            if (isset($data['usage'])) {
                echo "📈 Token Usage:\n";
                echo "  • Prompt tokens: " . $data['usage']['prompt_tokens'] . "\n";
                echo "  • Completion tokens: " . $data['usage']['completion_tokens'] . "\n";
                echo "  • Total tokens: " . $data['usage']['total_tokens'] . "\n";
            }
        }
        
        echo "\n✅ OpenAI API is working correctly!\n";
        
    } elseif ($httpCode === 401) {
        echo "❌ Authentication Error (401)\n";
        echo "🔍 Possible issues:\n";
        echo "  • Invalid API key\n";
        echo "  • API key expired\n";
        echo "  • Incorrect Bearer token format\n";
        
    } elseif ($httpCode === 429) {
        echo "❌ Rate Limit or Quota Error (429)\n";
        $data = json_decode($response, true);
        if (isset($data['error']['code'])) {
            echo "🔍 Error Code: " . $data['error']['code'] . "\n";
            echo "💡 Error Type: " . ($data['error']['type'] ?? 'unknown') . "\n";
            
            if ($data['error']['code'] === 'insufficient_quota') {
                echo "💰 This means:\n";
                echo "  • Account has no credits/quota remaining\n";
                echo "  • Need to add payment method\n";
                echo "  • Need to add credits to account\n";
                echo "  • Check https://platform.openai.com/usage\n";
            } elseif ($data['error']['code'] === 'rate_limit_exceeded') {
                echo "⏱️  This means:\n";
                echo "  • Too many requests per minute\n";
                echo "  • Wait and retry\n";
                echo "  • Implement exponential backoff\n";
            }
        }
        
    } elseif ($httpCode === 400) {
        echo "❌ Bad Request Error (400)\n";
        $data = json_decode($response, true);
        if (isset($data['error']['message'])) {
            echo "🔍 Error: " . $data['error']['message'] . "\n";
        }
        
    } else {
        echo "❌ HTTP Error {$httpCode}\n";
        echo "Response: " . substr($response, 0, 1000) . "\n";
    }

} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    echo "📍 Stack trace:\n" . $e->getTraceAsString() . "\n";
}
