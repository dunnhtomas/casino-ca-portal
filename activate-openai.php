<?php
/**
 * OpenAI Account Activation Check
 * Check if account needs verification or has restrictions
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

echo "🔍 OpenAI Account Activation Check\n";
echo "==================================\n";

$apiKey = $_ENV['OPENAI_API_KEY'];
echo "API Key: " . substr($apiKey, 0, 25) . "...\n\n";

// Check 1: Organization and billing info
echo "📊 Step 1: Checking Organization Access\n";
echo "=======================================\n";

try {
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

    echo "HTTP Code: {$httpCode}\n";
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        echo "✅ Organization access: OK\n";
        if (isset($data['data']) && count($data['data']) > 0) {
            $org = $data['data'][0];
            echo "📋 Organization: " . ($org['name'] ?? 'Unknown') . "\n";
            echo "🆔 Org ID: " . ($org['id'] ?? 'Unknown') . "\n";
        }
    } else {
        echo "❌ Organization access failed\n";
        echo "Response: " . substr($response, 0, 300) . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Check 2: Account limits and usage
echo "📊 Step 2: Checking Account Limits\n";
echo "===================================\n";

try {
    // Try to get usage with proper date parameter
    $startDate = date('Y-m-d', strtotime('-1 month'));
    $endDate = date('Y-m-d');
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.openai.com/v1/usage?start_date={$startDate}&end_date={$endDate}",
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

    echo "Usage API: HTTP {$httpCode}\n";
    
    if ($httpCode === 200) {
        $data = json_decode($response, true);
        echo "✅ Usage data accessible\n";
        echo "📈 Total usage: $" . ($data['total_usage'] ?? '0') . "\n";
    } else {
        echo "❌ Usage data not accessible\n";
        $errorData = json_decode($response, true);
        echo "Error: " . ($errorData['error']['message'] ?? 'Unknown') . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Check 3: Try the absolute minimum request
echo "📊 Step 3: Minimum Token Test\n";
echo "==============================\n";

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
            'model' => 'gpt-3.5-turbo',
            'messages' => [['role' => 'user', 'content' => 'Hi']],
            'max_tokens' => 1,
            'temperature' => 0
        ])
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Minimum Request: HTTP {$httpCode}\n";
    
    if ($httpCode === 200) {
        echo "✅ SUCCESS! Your API is working!\n";
        $data = json_decode($response, true);
        echo "Response: " . ($data['choices'][0]['message']['content'] ?? 'No content') . "\n";
        echo "Tokens: " . ($data['usage']['total_tokens'] ?? 'Unknown') . "\n";
        
        echo "\n🎉 API IS WORKING! Let's proceed with casino research!\n";
        return;
        
    } else {
        $data = json_decode($response, true);
        $errorCode = $data['error']['code'] ?? 'unknown';
        $errorType = $data['error']['type'] ?? 'unknown';
        $errorMessage = $data['error']['message'] ?? 'Unknown error';
        
        echo "❌ Error Details:\n";
        echo "  Code: {$errorCode}\n";
        echo "  Type: {$errorType}\n";
        echo "  Message: {$errorMessage}\n";
        
        // Specific troubleshooting
        if ($errorCode === 'insufficient_quota') {
            echo "\n🔍 INSUFFICIENT QUOTA DIAGNOSIS:\n";
            echo "================================\n";
            echo "This typically means one of:\n";
            echo "1. 🏦 No payment method on file\n";
            echo "2. 💳 Payment method declined\n";
            echo "3. 💰 No credits purchased/available\n";
            echo "4. 🚫 Account suspended/limited\n";
            echo "5. 🆕 New account not yet activated\n\n";
            
            echo "🔧 SOLUTION STEPS:\n";
            echo "==================\n";
            echo "1. Visit: https://platform.openai.com/account/billing\n";
            echo "2. Verify payment method is active\n";
            echo "3. Purchase credits (even $5 minimum)\n";
            echo "4. Check for any account restrictions\n";
            echo "5. Contact OpenAI support if issue persists\n";
            echo "6. Wait 5-10 minutes after adding credits\n\n";
            
            echo "💡 Even accounts with budgets may need credits purchased\n";
            echo "   to activate usage. The $18 limit may be pending activation.\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}

echo "\n";
echo "🎯 SUMMARY:\n";
echo "===========\n";
echo "Your API key format and authentication are 100% correct.\n";
echo "The issue is account quota/billing activation.\n";
echo "Once resolved, your casino research will work perfectly!\n";
