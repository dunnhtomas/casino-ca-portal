<?php
require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "🔑 Testing Conservative OpenAI API Call\n";
echo "=======================================\n";

$apiKey = $_ENV['OPENAI_API_KEY'] ?? '';
echo "API Key: " . substr($apiKey, 0, 20) . "...\n";

// Wait 30 seconds before making the call to avoid rate limits
echo "⏱️  Waiting 30 seconds to avoid rate limits...\n";
sleep(30);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        "model" => "gpt-3.5-turbo",  // Using cheaper model
        "messages" => [
            ["role" => "user", "content" => "Hi"]
        ],
        "max_tokens" => 10,  // Very small response
        "temperature" => 0.1
    ]),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $apiKey,
        "Content-Type: application/json",
    ],
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => true,
]);

echo "📡 Making minimal API call...\n";

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "HTTP Code: $httpCode\n";

if ($curlError) {
    echo "❌ CURL Error: $curlError\n";
    exit(1);
}

if ($httpCode !== 200) {
    echo "❌ HTTP Error $httpCode:\n";
    echo $response . "\n";
    exit(1);
}

$data = json_decode($response, true);

if (!$data || !isset($data['choices'][0]['message']['content'])) {
    echo "❌ Invalid response format:\n";
    echo $response . "\n";
    exit(1);
}

echo "✅ Success! Response:\n";
echo $data['choices'][0]['message']['content'] . "\n";

if (isset($data['usage'])) {
    echo "\n📊 Token usage:\n";
    echo "  Prompt: " . $data['usage']['prompt_tokens'] . "\n";
    echo "  Completion: " . $data['usage']['completion_tokens'] . "\n";
    echo "  Total: " . $data['usage']['total_tokens'] . "\n";
}

echo "\n✅ Conservative OpenAI API call successful!\n";
