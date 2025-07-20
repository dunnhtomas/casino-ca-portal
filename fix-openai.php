<?php
/**
 * Fix OpenAI API Calls - 2025 Format
 * Comprehensive debugging and fixing
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

function testOpenAIConnection() {
    $apiKey = $_ENV['OPENAI_API_KEY'] ?? null;
    
    echo "🔧 Testing OpenAI API Connection - 2025\n";
    echo "========================================\n";
    echo "API Key: " . substr($apiKey, 0, 20) . "...\n\n";
    
    // Method 1: Try with project key format (2024+ keys)
    if (strpos($apiKey, 'sk-proj-') === 0) {
        echo "🔍 Project-based API key detected\n";
        echo "💡 Testing with organization headers...\n";
        
        $result = makeAPICall($apiKey, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'OpenAI-Organization: ' . ($_ENV['OPENAI_ORG_ID'] ?? ''),
            'OpenAI-Project: ' . ($_ENV['OPENAI_PROJECT_ID'] ?? '')
        ]);
        
        if ($result['success']) {
            return $result;
        }
    }
    
    // Method 2: Try standard format
    echo "🔍 Testing standard format...\n";
    $result = makeAPICall($apiKey, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    
    if ($result['success']) {
        return $result;
    }
    
    // Method 3: Try with different models
    echo "🔍 Testing different models...\n";
    $models = ['gpt-3.5-turbo', 'gpt-4o-mini', 'gpt-4'];
    
    foreach ($models as $model) {
        echo "  Testing {$model}...\n";
        $result = makeAPICall($apiKey, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ], $model);
        
        if ($result['success']) {
            echo "  ✅ {$model} works!\n";
            return $result;
        } else {
            echo "  ❌ {$model} failed: " . $result['error'] . "\n";
        }
    }
    
    return ['success' => false, 'error' => 'All methods failed'];
}

function makeAPICall($apiKey, $headers, $model = 'gpt-3.5-turbo') {
    try {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode([
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => 'Say "API working" exactly.']
                ],
                'max_tokens' => 5,
                'temperature' => 0
            ])
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return ['success' => false, 'error' => "cURL Error: {$curlError}"];
        }

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if (isset($data['choices'][0]['message']['content'])) {
                return [
                    'success' => true,
                    'response' => $data['choices'][0]['message']['content'],
                    'model' => $model,
                    'usage' => $data['usage'] ?? []
                ];
            }
        }

        // Handle errors
        $data = json_decode($response, true);
        $errorMsg = $data['error']['message'] ?? "HTTP {$httpCode}";
        
        return ['success' => false, 'error' => $errorMsg, 'http_code' => $httpCode];
        
    } catch (Exception $e) {
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

// Test the connection
$result = testOpenAIConnection();

if ($result['success']) {
    echo "\n✅ SUCCESS! OpenAI API is working!\n";
    echo "🎉 Response: " . $result['response'] . "\n";
    echo "📊 Model: " . $result['model'] . "\n";
    
    if (isset($result['usage']['total_tokens'])) {
        echo "🔢 Tokens used: " . $result['usage']['total_tokens'] . "\n";
    }
    
    echo "\n🚀 Now testing casino research...\n";
    echo "=================================\n";
    
    // Now test actual casino research
    testCasinoResearch($result['model']);
    
} else {
    echo "\n❌ FAILED: " . $result['error'] . "\n";
    
    // If quota issue, provide specific guidance
    if (strpos($result['error'], 'quota') !== false) {
        echo "\n💰 QUOTA ISSUE DETECTED\n";
        echo "======================\n";
        echo "1. Go to: https://platform.openai.com/account/billing\n";
        echo "2. Add a payment method (credit card)\n";
        echo "3. Purchase credits (minimum $5 recommended)\n";
        echo "4. Wait 2-3 minutes for activation\n";
        echo "5. Run this script again\n\n";
        echo "Note: Even with $18 budget mentioned, the account may need\n";
        echo "a payment method attached and credits purchased.\n";
    }
}

function testCasinoResearch($workingModel) {
    // Test with actual casino research prompt
    $apiKey = $_ENV['OPENAI_API_KEY'];
    
    $prompt = "Research this casino and return JSON data:\n\nCasino: BonRush\nWebsite: https://bonrush.com\nTier: Premium\n\nReturn JSON with: basic_info (name, license, founded), ratings (overall_rating out of 10), games (total_games count), bonuses (welcome_bonus text).";
    
    try {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'model' => $workingModel,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a casino research expert. Return only valid JSON data.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 500,
                'temperature' => 0.1
            ])
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            $content = $data['choices'][0]['message']['content'] ?? '';
            
            echo "✅ Casino research test successful!\n";
            echo "📊 Tokens used: " . ($data['usage']['total_tokens'] ?? 'unknown') . "\n";
            echo "🎯 Research result:\n";
            echo $content . "\n\n";
            echo "🚀 Your OpenAI API is ready for casino research!\n";
            
        } else {
            echo "❌ Casino research test failed: HTTP {$httpCode}\n";
            $errorData = json_decode($response, true);
            echo "Error: " . ($errorData['error']['message'] ?? 'Unknown') . "\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Exception in casino research test: " . $e->getMessage() . "\n";
    }
}
