<?php
require_once 'vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "🔑 OpenAI Account Billing & Quota Status Check\n";
echo "==============================================\n";

$apiKey = $_ENV['OPENAI_API_KEY'] ?? '';
echo "API Key: " . substr($apiKey, 0, 20) . "...\n";

// Check models availability
echo "\n📋 Checking available models...\n";
$modelsCh = curl_init();
curl_setopt_array($modelsCh, [
    CURLOPT_URL => 'https://api.openai.com/v1/models',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $apiKey,
    ],
    CURLOPT_TIMEOUT => 30,
]);

$modelsResponse = curl_exec($modelsCh);
$modelsCode = curl_getinfo($modelsCh, CURLINFO_HTTP_CODE);
curl_close($modelsCh);

echo "Models API Code: $modelsCode\n";

if ($modelsCode === 200) {
    $modelsData = json_decode($modelsResponse, true);
    $availableModels = array_filter($modelsData['data'], function($model) {
        return in_array($model['id'], ['gpt-3.5-turbo', 'gpt-4o-mini', 'gpt-4o', 'gpt-4']);
    });
    echo "Available models: " . count($availableModels) . "\n";
    foreach ($availableModels as $model) {
        echo "  - " . $model['id'] . " (owner: " . $model['owned_by'] . ")\n";
    }
} else {
    echo "❌ Models API failed: $modelsResponse\n";
}

// Check usage for today
echo "\n📊 Checking today's usage...\n";
$usageCh = curl_init();
curl_setopt_array($usageCh, [
    CURLOPT_URL => 'https://api.openai.com/v1/usage?date=' . date('Y-m-d'),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $apiKey,
    ],
    CURLOPT_TIMEOUT => 30,
]);

$usageResponse = curl_exec($usageCh);
$usageCode = curl_getinfo($usageCh, CURLINFO_HTTP_CODE);
curl_close($usageCh);

echo "Usage API Code: $usageCode\n";
echo "Usage Response: $usageResponse\n";

// Try to check account/subscription info (this might not work with project keys)
echo "\n🏢 Checking account organization...\n";
$orgCh = curl_init();
curl_setopt_array($orgCh, [
    CURLOPT_URL => 'https://api.openai.com/v1/organizations',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $apiKey,
    ],
    CURLOPT_TIMEOUT => 30,
]);

$orgResponse = curl_exec($orgCh);
$orgCode = curl_getinfo($orgCh, CURLINFO_HTTP_CODE);
curl_close($orgCh);

echo "Organization API Code: $orgCode\n";
echo "Organization Response: $orgResponse\n";

echo "\n🏥 DIAGNOSIS:\n";
if ($modelsCode === 401 || $orgCode === 401) {
    echo "❌ API Key authentication failed - key might be invalid or revoked\n";
} elseif ($modelsCode === 429) {
    echo "⚠️ Rate limited on models endpoint - severe quota restriction\n";
} elseif ($modelsCode === 200) {
    echo "✅ API Key is valid and can access models\n";
    echo "💰 The 'insufficient_quota' error suggests billing/payment issue:\n";
    echo "   1. Check if you have an active payment method in OpenAI dashboard\n";
    echo "   2. Check if you've exceeded your monthly spending limit\n";
    echo "   3. Check if you've reached your usage tier limit\n";
    echo "   4. Contact OpenAI support if payment method is active\n";
} else {
    echo "❓ Unexpected response from models endpoint\n";
}

echo "\n🔗 Next Steps:\n";
echo "1. Visit https://platform.openai.com/usage to check current usage\n";
echo "2. Visit https://platform.openai.com/account/billing to check payment method\n";
echo "3. Visit https://platform.openai.com/account/limits to check rate limits\n";
echo "4. Try making a request in the OpenAI Playground to test your account\n";
