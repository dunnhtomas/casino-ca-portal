<?php
/**
 * Check Available OpenAI Models
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

echo "🔧 Checking Available OpenAI Models\n";
echo "===================================\n";

$apiKey = $_ENV['OPENAI_API_KEY'] ?? null;
if (!$apiKey) {
    echo "❌ No OpenAI API key found\n";
    exit(1);
}

echo "✅ API Key: " . substr($apiKey, 0, 20) . "...\n\n";

try {
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

    echo "🌐 HTTP Code: {$httpCode}\n";
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        
        if (isset($data['data'])) {
            echo "📋 Available Models:\n";
            echo "==================\n";
            
            $gptModels = [];
            $otherModels = [];
            
            foreach ($data['data'] as $model) {
                $modelId = $model['id'];
                if (strpos($modelId, 'gpt') !== false || strpos($modelId, 'o1') !== false || strpos($modelId, 'o4') !== false) {
                    $gptModels[] = $modelId;
                } else {
                    $otherModels[] = $modelId;
                }
            }
            
            echo "🎯 GPT/Chat Models:\n";
            foreach ($gptModels as $model) {
                echo "  • {$model}\n";
            }
            
            echo "\n🔧 Other Models:\n";
            $displayCount = 0;
            foreach ($otherModels as $model) {
                if ($displayCount < 10) { // Show first 10 other models
                    echo "  • {$model}\n";
                    $displayCount++;
                }
            }
            if (count($otherModels) > 10) {
                echo "  • ... and " . (count($otherModels) - 10) . " more models\n";
            }
            
            echo "\n📊 Total Models: " . count($data['data']) . "\n";
        }
        
    } else {
        echo "❌ HTTP Error {$httpCode}\n";
        echo "Response: " . substr($response, 0, 500) . "\n";
    }

} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}
