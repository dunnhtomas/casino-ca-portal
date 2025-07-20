<?php
/**
 * Test OpenAI API Connection
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

echo "🔧 Testing OpenAI API Connection\n";
echo "===============================\n";

// Check environment
$apiKey = $_ENV['OPENAI_API_KEY'] ?? null;
if (!$apiKey) {
    echo "❌ No OpenAI API key found in environment\n";
    exit(1);
}

echo "✅ API Key found: " . substr($apiKey, 0, 20) . "...\n";

// Test direct API call
try {
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
                ['role' => 'user', 'content' => 'Say "Hello World" exactly.']
            ],
            'max_tokens' => 10
        ])
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    echo "🌐 HTTP Code: {$httpCode}\n";
    
    if ($error) {
        echo "❌ cURL Error: {$error}\n";
        exit(1);
    }

    if ($httpCode === 200) {
        echo "✅ OpenAI API connection successful!\n";
        $data = json_decode($response, true);
        if (isset($data['choices'][0]['message']['content'])) {
            echo "🎉 Response: " . $data['choices'][0]['message']['content'] . "\n";
        }
    } else {
        echo "❌ HTTP Error {$httpCode}\n";
        echo "Response: " . substr($response, 0, 500) . "\n";
    }

} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}
