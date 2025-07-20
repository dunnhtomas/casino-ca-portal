<?php
/**
 * OpenAI API Usage Monitor
 * Tracks usage, costs, and performance metrics for pro-level optimization
 */

namespace App\Services;

class OpenAIMonitorService {
    private $logFile;
    private $metricsFile;
    
    public function __construct() {
        $this->logFile = __DIR__ . '/../../storage/logs/openai-usage.log';
        $this->metricsFile = __DIR__ . '/../../storage/metrics/openai-metrics.json';
        $this->ensureDirectoriesExist();
    }
    
    /**
     * Log API request for monitoring
     */
    public function logRequest(array $requestData): void {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'model' => $requestData['model'],
            'tokens_used' => $requestData['tokens_used'] ?? 0,
            'cost_usd' => $requestData['cost_usd'] ?? 0,
            'response_time_ms' => $requestData['response_time_ms'] ?? 0,
            'status' => $requestData['status'] ?? 'success',
            'error' => $requestData['error'] ?? null,
            'use_case' => $requestData['use_case'] ?? 'general'
        ];
        
        file_put_contents($this->logFile, json_encode($logEntry) . "\n", FILE_APPEND | LOCK_EX);
        $this->updateMetrics($logEntry);
    }
    
    /**
     * Update aggregated metrics
     */
    private function updateMetrics(array $logEntry): void {
        $metrics = $this->getCurrentMetrics();
        $today = date('Y-m-d');
        $hour = date('Y-m-d H:00');
        
        // Daily metrics
        if (!isset($metrics['daily'][$today])) {
            $metrics['daily'][$today] = $this->getEmptyDayMetrics();
        }
        
        // Hourly metrics
        if (!isset($metrics['hourly'][$hour])) {
            $metrics['hourly'][$hour] = $this->getEmptyHourMetrics();
        }
        
        // Update counters
        $metrics['daily'][$today]['requests']++;
        $metrics['daily'][$today]['tokens'] += $logEntry['tokens_used'];
        $metrics['daily'][$today]['cost'] += $logEntry['cost_usd'];
        
        $metrics['hourly'][$hour]['requests']++;
        $metrics['hourly'][$hour]['tokens'] += $logEntry['tokens_used'];
        
        // Update response time stats
        $metrics['daily'][$today]['response_times'][] = $logEntry['response_time_ms'];
        $metrics['hourly'][$hour]['response_times'][] = $logEntry['response_time_ms'];
        
        // Model-specific metrics
        $model = $logEntry['model'];
        if (!isset($metrics['by_model'][$model])) {
            $metrics['by_model'][$model] = ['requests' => 0, 'tokens' => 0, 'cost' => 0];
        }
        $metrics['by_model'][$model]['requests']++;
        $metrics['by_model'][$model]['tokens'] += $logEntry['tokens_used'];
        $metrics['by_model'][$model]['cost'] += $logEntry['cost_usd'];
        
        // Error tracking
        if ($logEntry['status'] !== 'success') {
            $metrics['daily'][$today]['errors']++;
            $metrics['errors'][] = [
                'timestamp' => $logEntry['timestamp'],
                'error' => $logEntry['error'],
                'model' => $logEntry['model']
            ];
        }
        
        // Keep only last 30 days of daily metrics and 24 hours of hourly metrics
        $metrics['daily'] = array_slice($metrics['daily'], -30, null, true);
        $metrics['hourly'] = array_slice($metrics['hourly'], -24, null, true);
        $metrics['errors'] = array_slice($metrics['errors'], -100); // Keep last 100 errors
        
        file_put_contents($this->metricsFile, json_encode($metrics, JSON_PRETTY_PRINT), LOCK_EX);
    }
    
    /**
     * Get current usage metrics
     */
    public function getCurrentMetrics(): array {
        if (!file_exists($this->metricsFile)) {
            return [
                'daily' => [],
                'hourly' => [],
                'by_model' => [],
                'errors' => []
            ];
        }
        
        return json_decode(file_get_contents($this->metricsFile), true) ?: [];
    }
    
    /**
     * Get today's usage summary
     */
    public function getTodaysSummary(): array {
        $metrics = $this->getCurrentMetrics();
        $today = date('Y-m-d');
        $todayMetrics = $metrics['daily'][$today] ?? $this->getEmptyDayMetrics();
        
        return [
            'date' => $today,
            'requests_made' => $todayMetrics['requests'],
            'tokens_used' => $todayMetrics['tokens'],
            'estimated_cost_usd' => round($todayMetrics['cost'], 4),
            'error_count' => $todayMetrics['errors'],
            'error_rate' => $todayMetrics['requests'] > 0 ? round($todayMetrics['errors'] / $todayMetrics['requests'], 4) : 0,
            'avg_response_time_ms' => count($todayMetrics['response_times']) > 0 ? round(array_sum($todayMetrics['response_times']) / count($todayMetrics['response_times'])) : 0,
            'rate_limit_usage' => [
                'rpm_used' => $this->getCurrentRPM(),
                'tpm_used' => $this->getCurrentTPM(),
                'rpm_limit' => (int)($_ENV['OPENAI_REQUESTS_PER_MINUTE'] ?? 500),
                'tpm_limit' => (int)($_ENV['OPENAI_TOKENS_PER_MINUTE'] ?? 200000)
            ]
        ];
    }
    
    /**
     * Check if we're approaching rate limits
     */
    public function checkRateLimitStatus(): array {
        $currentRpm = $this->getCurrentRPM();
        $currentTpm = $this->getCurrentTPM();
        $rpmLimit = (int)($_ENV['OPENAI_REQUESTS_PER_MINUTE'] ?? 500);
        $tpmLimit = (int)($_ENV['OPENAI_TOKENS_PER_MINUTE'] ?? 200000);
        
        $rpmUsage = $rpmLimit > 0 ? ($currentRpm / $rpmLimit) : 0;
        $tpmUsage = $tpmLimit > 0 ? ($currentTpm / $tpmLimit) : 0;
        
        return [
            'rpm_status' => $this->getRateLimitStatus($rpmUsage),
            'tpm_status' => $this->getRateLimitStatus($tpmUsage),
            'rpm_percentage' => round($rpmUsage * 100, 1),
            'tpm_percentage' => round($tpmUsage * 100, 1),
            'should_throttle' => max($rpmUsage, $tpmUsage) > 0.8,
            'recommended_delay_seconds' => $this->getRecommendedDelay($rpmUsage, $tpmUsage)
        ];
    }
    
    private function getCurrentRPM(): int {
        $metrics = $this->getCurrentMetrics();
        $currentHour = date('Y-m-d H:00');
        return $metrics['hourly'][$currentHour]['requests'] ?? 0;
    }
    
    private function getCurrentTPM(): int {
        $metrics = $this->getCurrentMetrics();
        $currentHour = date('Y-m-d H:00');
        return $metrics['hourly'][$currentHour]['tokens'] ?? 0;
    }
    
    private function getRateLimitStatus(float $usage): string {
        if ($usage > 0.9) return 'critical';
        if ($usage > 0.7) return 'warning';
        if ($usage > 0.5) return 'moderate';
        return 'ok';
    }
    
    private function getRecommendedDelay(float $rpmUsage, float $tpmUsage): float {
        $maxUsage = max($rpmUsage, $tpmUsage);
        if ($maxUsage > 0.9) return 10.0; // 10 second delay
        if ($maxUsage > 0.8) return 5.0;  // 5 second delay
        if ($maxUsage > 0.7) return 2.0;  // 2 second delay
        return 0.1; // Minimal delay
    }
    
    private function getEmptyDayMetrics(): array {
        return [
            'requests' => 0,
            'tokens' => 0,
            'cost' => 0.0,
            'errors' => 0,
            'response_times' => []
        ];
    }
    
    private function getEmptyHourMetrics(): array {
        return [
            'requests' => 0,
            'tokens' => 0,
            'response_times' => []
        ];
    }
    
    private function ensureDirectoriesExist(): void {
        $dirs = [
            dirname($this->logFile),
            dirname($this->metricsFile)
        ];
        
        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }
}
