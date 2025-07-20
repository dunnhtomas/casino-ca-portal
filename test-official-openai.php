<?php
// Test OpenAI Official PHP Client
require __DIR__ . '/vendor/autoload.php';

use OpenAI\Client;
use Dotenv\Dotenv;

echo "🔑 Testing Official OpenAI PHP Client\n";
echo "====================================\n";

try {
    // Load environment variables
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Get API key
    $apiKey = $_ENV['OPENAI_API_KEY'] ?? getenv('OPENAI_API_KEY');
    if (!$apiKey) {
        throw new RuntimeException('OPENAI_API_KEY not set in .env');
    }

    echo "API Key: " . substr($apiKey, 0, 20) . "...\n";

    // Create OpenAI client
    $openai = Client::factory([
        'api_key' => $apiKey,
    ]);

    echo "✅ OpenAI client created successfully\n";

    // Test simple chat completion
    echo "\n📡 Testing chat completion...\n";
    $response = $openai->chat->completions->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => 'Say hello in exactly 5 words.'],
        ],
        'max_tokens' => 20,
        'temperature' => 0.1,
    ]);

    echo "✅ Chat completion successful!\n";
    echo "Response: " . trim($response->choices[0]->message->content) . "\n";
    echo "Tokens used: " . ($response->usage->totalTokens ?? 0) . "\n";
    echo "Model: " . ($response->model ?? 'unknown') . "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✅ All tests passed! OpenAI PHP Client is working correctly.\n";
?>
