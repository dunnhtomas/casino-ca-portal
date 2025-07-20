<?php
/**
 * OpenAI Pro Configuration Manager
 * Manages enterprise-level OpenAI API settings and optimization
 */

namespace App\Config;

class OpenAIConfig {
    
    /**
     * Get pro-level model configurations
     */
    public static function getModelConfigs(): array {
        return [
            'gpt-4.1' => [
                'max_tokens' => 4096,
                'cost_per_1k_input' => 2.00,
                'cost_per_1k_output' => 8.00,
                'use_cases' => ['research', 'analysis', 'complex_reasoning'],
                'rate_limit_tier_5' => [
                    'requests_per_minute' => 10000,
                    'tokens_per_minute' => 2000000,
                    'requests_per_day' => 1000000
                ]
            ],
            'gpt-4.1-mini' => [
                'max_tokens' => 16384,
                'cost_per_1k_input' => 0.40,
                'cost_per_1k_output' => 1.60,
                'use_cases' => ['content_generation', 'bulk_processing', 'cost_optimization'],
                'rate_limit_tier_5' => [
                    'requests_per_minute' => 30000,
                    'tokens_per_minute' => 5000000,
                    'requests_per_day' => 10000000
                ]
            ],
            'gpt-4.1-nano' => [
                'max_tokens' => 8192,
                'cost_per_1k_input' => 0.10,
                'cost_per_1k_output' => 0.40,
                'use_cases' => ['fast_processing', 'high_volume', 'cost_sensitive'],
                'rate_limit_tier_5' => [
                    'requests_per_minute' => 50000,
                    'tokens_per_minute' => 10000000,
                    'requests_per_day' => 50000000
                ]
            ]
        ];
    }
    
    /**
     * Get enterprise usage tier limits (Tier 5 - Highest Available)
     */
    public static function getTierLimits(): array {
        return [
            'tier_5' => [
                'qualification' => 'Enterprise customers, $1000+ monthly spend',
                'gpt_4o' => [
                    'rpm' => 10000,    // Requests per minute
                    'tpm' => 2000000,  // Tokens per minute
                    'rpd' => 1000000   // Requests per day
                ],
                'gpt_4o_mini' => [
                    'rpm' => 30000,
                    'tpm' => 5000000,
                    'rpd' => 10000000
                ],
                'batch_api' => [
                    'enabled' => true,
                    'discount' => 0.5, // 50% discount on batch processing
                    'max_batch_size' => 50000
                ]
            ]
        ];
    }
    
    /**
     * Get optimized parameters for different use cases
     */
    public static function getOptimizedParams(string $useCase): array {
        $params = [
            'casino_research' => [
                'model' => 'gpt-4o-mini',
                'temperature' => 0.1,
                'top_p' => 0.9,
                'max_tokens' => 4000,
                'frequency_penalty' => 0.0,
                'presence_penalty' => 0.0,
                'timeout' => 60,
                'retries' => 5
            ],
            'content_generation' => [
                'model' => 'gpt-4o-mini',
                'temperature' => 0.7,
                'top_p' => 0.9,
                'max_tokens' => 3000,
                'frequency_penalty' => 0.3,
                'presence_penalty' => 0.2,
                'timeout' => 45,
                'retries' => 3
            ],
            'bulk_processing' => [
                'model' => 'gpt-4o-mini',
                'temperature' => 0.5,
                'top_p' => 0.8,
                'max_tokens' => 2000,
                'frequency_penalty' => 0.1,
                'presence_penalty' => 0.1,
                'timeout' => 30,
                'retries' => 2,
                'batch_enabled' => true
            ]
        ];
        
        return $params[$useCase] ?? $params['content_generation'];
    }
    
    /**
     * Calculate optimal batch sizes based on rate limits
     */
    public static function getOptimalBatchConfig(int $totalRequests): array {
        $tierLimits = self::getTierLimits()['tier_5'];
        $rpm = $tierLimits['gpt_4o_mini']['rpm'];
        
        // Calculate optimal batch size to maximize throughput
        $optimalBatchSize = min(50, ceil($totalRequests / 10)); // Max 50 per batch
        $estimatedMinutes = ceil($totalRequests / $rpm);
        $recommendedConcurrency = min(20, ceil($rpm / 60)); // Conservative concurrency
        
        return [
            'batch_size' => $optimalBatchSize,
            'max_concurrent' => $recommendedConcurrency,
            'estimated_duration_minutes' => $estimatedMinutes,
            'recommended_delay_seconds' => 0.1, // Minimal delay for Tier 5
            'use_batch_api' => $totalRequests > 1000 // Use Batch API for large jobs
        ];
    }
    
    /**
     * Get monitoring and alerting thresholds
     */
    public static function getMonitoringConfig(): array {
        return [
            'cost_alerts' => [
                'daily_threshold_usd' => 500,
                'monthly_threshold_usd' => 10000,
                'per_request_threshold_usd' => 0.50
            ],
            'performance_alerts' => [
                'max_response_time_seconds' => 30,
                'error_rate_threshold' => 0.05, // 5%
                'rate_limit_buffer' => 0.1 // 10% safety margin
            ],
            'usage_tracking' => [
                'log_all_requests' => true,
                'track_token_usage' => true,
                'monitor_rate_limits' => true,
                'export_metrics' => true
            ]
        ];
    }
}
