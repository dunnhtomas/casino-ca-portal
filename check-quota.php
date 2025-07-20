<?php
/**
 * Check OpenAI Account Status and Quota
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

echo "💰 Checking OpenAI Account Status\n";
echo "=================================\n";

$apiKey = $_ENV['OPENAI_API_KEY'] ?? null;
if (!$apiKey) {
    echo "❌ No OpenAI API key found\n";
    exit(1);
}

echo "✅ API Key: " . substr($apiKey, 0, 20) . "...\n\n";

// Check billing/usage endpoint
try {
    echo "🔍 Checking account usage...\n";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.openai.com/v1/usage',
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

    echo "📊 Usage Endpoint Response: HTTP {$httpCode}\n";
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        echo "✅ Usage data retrieved:\n";
        echo json_encode($data, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "❌ Could not retrieve usage data\n";
        echo "Response: " . substr($response, 0, 500) . "\n";
    }
    
    echo "\n";
    
    // Check organization endpoint (if available)
    echo "🏢 Checking organization...\n";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.openai.com/v1/organizations',
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

    echo "📊 Organization Endpoint Response: HTTP {$httpCode}\n";
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        echo "✅ Organization data:\n";
        echo json_encode($data, JSON_PRETTY_PRINT) . "\n";
    }
    
    echo "\n";
    
    // Try a very minimal request to see exact error
    echo "🧪 Testing minimal completion request...\n";
    
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
            'model' => 'gpt-3.5-turbo', // Try the cheapest model
            'messages' => [['role' => 'user', 'content' => 'Hi']],
            'max_tokens' => 1 // Minimal tokens
        ])
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "📊 Minimal Request Response: HTTP {$httpCode}\n";
    
    if ($httpCode !== 200) {
        $data = json_decode($response, true);
        echo "❌ Error details:\n";
        echo json_encode($data, JSON_PRETTY_PRINT) . "\n";
        
        // Provide specific guidance
        if (isset($data['error']['code'])) {
            echo "\n💡 Troubleshooting:\n";
            switch ($data['error']['code']) {
                case 'insufficient_quota':
                    echo "1. Go to https://platform.openai.com/usage\n";
                    echo "2. Check your current usage and limits\n";
                    echo "3. Go to https://platform.openai.com/account/billing\n";
                    echo "4. Add a payment method if not already added\n";
                    echo "5. Add credits to your account\n";
                    echo "6. Wait a few minutes for activation\n";
                    break;
                case 'invalid_api_key':
                    echo "1. Check if API key is correct\n";
                    echo "2. Generate a new API key\n";
                    echo "3. Make sure it's from the correct organization\n";
                    break;
                default:
                    echo "Check OpenAI documentation for error code: " . $data['error']['code'] . "\n";
            }
        }
    } else {
        echo "✅ Minimal request succeeded! Quota issue might be model-specific.\n";
    }

} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}
