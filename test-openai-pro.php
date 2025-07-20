<?php
/**
 * OpenAI Pro Configuration Test
 * Validates the optimized OpenAI setup with pro-level settings
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load environment
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

use App\Services\OpenAIService;
use App\Services\OpenAIMonitorService;
use App\Config\OpenAIConfig;

try {
    echo "🚀 OpenAI Pro Configuration Test\n";
    echo "===============================\n\n";
    
    // Test configuration loading
    echo "📊 Loading pro-level configuration...\n";
    $modelConfigs = OpenAIConfig::getModelConfigs();
    $tierLimits = OpenAIConfig::getTierLimits();
    $monitoringConfig = OpenAIConfig::getMonitoringConfig();
    
    echo "✅ Model configurations loaded: " . count($modelConfigs) . " models\n";
    echo "✅ Tier 5 limits configured\n";
    echo "✅ Monitoring configuration loaded\n\n";
    
    // Display current limits
    echo "🏆 Current Rate Limits (Pro Tier 5):\n";
    echo "====================================\n";
    $gpt4oLimits = $tierLimits['tier_5']['gpt_4o'];
    $gpt4oMiniLimits = $tierLimits['tier_5']['gpt_4o_mini'];
    
    echo "GPT-4o:\n";
    echo "  • Requests per minute: " . number_format($gpt4oLimits['rpm']) . "\n";
    echo "  • Tokens per minute: " . number_format($gpt4oLimits['tpm']) . "\n";
    echo "  • Requests per day: " . number_format($gpt4oLimits['rpd']) . "\n\n";
    
    echo "GPT-4o Mini:\n";
    echo "  • Requests per minute: " . number_format($gpt4oMiniLimits['rpm']) . "\n";
    echo "  • Tokens per minute: " . number_format($gpt4oMiniLimits['tpm']) . "\n";
    echo "  • Requests per day: " . number_format($gpt4oMiniLimits['rpd']) . "\n\n";
    
    // Test environment variables
    echo "🔧 Environment Configuration:\n";
    echo "============================\n";
    echo "API Key: " . (strlen($_ENV['OPENAI_API_KEY'] ?? '') > 0 ? "✅ Configured" : "❌ Missing") . "\n";
    echo "Requests per minute: " . ($_ENV['OPENAI_REQUESTS_PER_MINUTE'] ?? 'Not set') . "\n";
    echo "Tokens per minute: " . ($_ENV['OPENAI_TOKENS_PER_MINUTE'] ?? 'Not set') . "\n";
    echo "Max retries: " . ($_ENV['OPENAI_MAX_RETRIES'] ?? 'Not set') . "\n";
    echo "Timeout: " . ($_ENV['OPENAI_TIMEOUT'] ?? 'Not set') . " seconds\n";
    echo "Batch size: " . ($_ENV['OPENAI_BATCH_SIZE'] ?? 'Not set') . "\n";
    echo "Concurrent requests: " . ($_ENV['OPENAI_CONCURRENT_REQUESTS'] ?? 'Not set') . "\n\n";
    
    // Test service initialization
    echo "🔄 Testing service initialization...\n";
    $openAI = new OpenAIService();
    $monitor = new OpenAIMonitorService();
    echo "✅ OpenAI service initialized successfully\n";
    echo "✅ Monitor service initialized successfully\n\n";
    
    // Test usage stats
    echo "📈 Current usage statistics:\n";
    echo "===========================\n";
    $stats = $openAI->getUsageStats();
    foreach ($stats as $key => $value) {
        echo sprintf("  • %s: %s\n", ucfirst(str_replace('_', ' ', $key)), is_numeric($value) ? number_format($value) : $value);
    }
    echo "\n";
    
    // Test monitoring
    echo "📊 Today's monitoring summary:\n";
    echo "=============================\n";
    $todaysSummary = $monitor->getTodaysSummary();
    foreach ($todaysSummary as $key => $value) {
        if (is_array($value)) {
            echo sprintf("  • %s:\n", ucfirst(str_replace('_', ' ', $key)));
            foreach ($value as $subKey => $subValue) {
                echo sprintf("    - %s: %s\n", ucfirst(str_replace('_', ' ', $subKey)), is_numeric($subValue) ? number_format($subValue) : $subValue);
            }
        } else {
            echo sprintf("  • %s: %s\n", ucfirst(str_replace('_', ' ', $key)), is_numeric($value) ? number_format($value) : $value);
        }
    }
    echo "\n";
    
    // Test rate limit monitoring
    echo "⚡ Rate limit status check:\n";
    echo "==========================\n";
    $rateLimitStatus = $monitor->checkRateLimitStatus();
    echo "RPM Status: " . $rateLimitStatus['rpm_status'] . " (" . $rateLimitStatus['rpm_percentage'] . "%)\n";
    echo "TPM Status: " . $rateLimitStatus['tpm_status'] . " (" . $rateLimitStatus['tpm_percentage'] . "%)\n";
    echo "Should throttle: " . ($rateLimitStatus['should_throttle'] ? 'Yes' : 'No') . "\n";
    echo "Recommended delay: " . $rateLimitStatus['recommended_delay_seconds'] . " seconds\n\n";
    
    // Test optimal batch configuration
    echo "⚙️  Optimal batch configuration for 100 requests:\n";
    echo "================================================\n";
    $batchConfig = OpenAIConfig::getOptimalBatchConfig(100);
    foreach ($batchConfig as $key => $value) {
        echo sprintf("  • %s: %s\n", ucfirst(str_replace('_', ' ', $key)), is_bool($value) ? ($value ? 'Yes' : 'No') : $value);
    }
    echo "\n";
    
    // Cost estimation test
    echo "💰 Cost estimation example:\n";
    echo "===========================\n";
    $gpt4oConfig = $modelConfigs['gpt-4o'];
    $gpt4oMiniConfig = $modelConfigs['gpt-4o-mini'];
    
    echo "For 1000 research requests (4000 tokens avg):\n";
    echo "GPT-4o cost: $" . number_format((4000 * 0.7 / 1000 * $gpt4oConfig['cost_per_1k_input']) + (4000 * 0.3 / 1000 * $gpt4oConfig['cost_per_1k_output']), 2) . "\n";
    echo "GPT-4o Mini cost: $" . number_format((4000 * 0.7 / 1000 * $gpt4oMiniConfig['cost_per_1k_input']) + (4000 * 0.3 / 1000 * $gpt4oMiniConfig['cost_per_1k_output']), 4) . "\n";
    echo "Savings with Mini: " . round((1 - $gpt4oMiniConfig['cost_per_1k_output'] / $gpt4oConfig['cost_per_1k_output']) * 100, 1) . "%\n\n";
    
    echo "🎉 All pro-level optimizations configured successfully!\n";
    echo "🔗 Ready for high-volume casino research at: https://bestcasinoportal.com/casino-research\n\n";
    
    echo "💡 Pro Tips:\n";
    echo "===========\n";
    echo "• Use GPT-4o for complex research requiring high accuracy\n";
    echo "• Use GPT-4o Mini for bulk content generation (87% cost savings)\n";
    echo "• Batch API available for 50% discount on large jobs\n";
    echo "• Monitor rate limits in real-time with built-in monitoring\n";
    echo "• Tier 5 limits support up to 30,000 RPM for GPT-4o Mini\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " (line " . $e->getLine() . ")\n";
    exit(1);
}
