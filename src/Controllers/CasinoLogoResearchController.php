<?php
/**
 * Casino Logo Research Controller
 * 
 * Manages the casino logo and data enhancement process
 * Provides dashboard and execution endpoints for systematic enhancement
 */

namespace App\Controllers;

use App\Services\CasinoLogoResearchService;
use App\Services\CasinoDataService;

class CasinoLogoResearchController 
{
    private $logoResearchService;
    private $casinoDataService;
    
    public function __construct()
    {
        $this->logoResearchService = new CasinoLogoResearchService();
        $this->casinoDataService = new CasinoDataService();
    }
    
    /**
     * Show casino logo research dashboard
     */
    public function dashboard()
    {
        $auditResults = $this->logoResearchService->getAuditResults();
        
        if (!$auditResults) {
            // No audit exists yet, redirect to start audit
            header('Location: /casino-logo-research/start-audit');
            exit;
        }
        
        $data = [
            'title' => 'Casino Logo & Data Enhancement Dashboard',
            'audit' => $auditResults,
            'total_casinos' => $auditResults['total_casinos'] ?? 0,
            'missing_logos' => count($auditResults['missing_logos'] ?? []),
            'placeholder_logos' => count($auditResults['placeholder_logos'] ?? []),
            'incomplete_data' => count($auditResults['incomplete_data'] ?? []),
            'priority_list' => $auditResults['priority_list'] ?? [],
            'phases' => $auditResults['enhancement_plan']['phases'] ?? []
        ];
        
        return $this->render('casino-logo-research/dashboard', $data);
    }
    
    /**
     * Start comprehensive audit (Phase 1)
     */
    public function startAudit()
    {
        try {
            $auditResults = $this->logoResearchService->performComprehensiveAudit();
            
            return $this->json([
                'success' => true,
                'message' => 'Casino audit completed successfully',
                'data' => [
                    'total_casinos' => $auditResults['total_casinos'],
                    'missing_logos' => count($auditResults['missing_logos']),
                    'placeholder_logos' => count($auditResults['placeholder_logos']),
                    'incomplete_data' => count($auditResults['incomplete_data']),
                    'enhancement_needed' => count($auditResults['priority_list']),
                    'phases_required' => 18
                ]
            ]);
            
        } catch (Exception $e) {
            return $this->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Execute single casino enhancement phase
     */
    public function enhanceCasino($casinoName = null)
    {
        if (!$casinoName) {
            return $this->json([
                'success' => false,
                'error' => 'Casino name required'
            ], 400);
        }
        
        $casino = $this->casinoDataService->getCasinoByName($casinoName);
        if (!$casino) {
            return $this->json([
                'success' => false,
                'error' => 'Casino not found'
            ], 404);
        }
        
        try {
            // Step 1: Research authentic logo
            $logoResearch = $this->logoResearchService->researchCasinoLogo(
                $casino['name'], 
                $casino['website']
            );
            
            if (!$logoResearch['success']) {
                throw new Exception('Logo research failed: ' . $logoResearch['error']);
            }
            
            // Step 2: Research missing data
            $dataResearch = $this->researchCasinoData($casino);
            
            // Step 3: Validate and update
            $updateResult = $this->updateCasinoEntry($casino, $logoResearch, $dataResearch);
            
            return $this->json([
                'success' => true,
                'message' => "Successfully enhanced {$casinoName}",
                'data' => [
                    'casino' => $casinoName,
                    'logo_research' => $logoResearch,
                    'data_updates' => $updateResult,
                    'phase_completed' => true
                ]
            ]);
            
        } catch (Exception $e) {
            return $this->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Research missing casino data using OpenAI
     */
    private function researchCasinoData($casino)
    {
        $prompt = "Research comprehensive data for '{$casino['name']}' casino (website: {$casino['website']}). Please provide accurate, current information for:

        1. Establishment year
        2. License authority and license number
        3. Owner/parent company
        4. Headquarters location
        5. Support email and phone
        6. Welcome bonus details (current offer)
        7. Total game count
        8. Minimum deposit amount
        9. Average withdrawal processing time
        10. Supported currencies
        11. Mobile app availability (iOS/Android)
        12. Live chat availability
        13. Main payment methods accepted
        14. Restricted countries
        15. Supported languages
        16. Primary software providers

        Format the response as structured data that can be easily parsed. Verify all information is current and accurate as of 2025.";
        
        try {
            $openAIService = new \App\Services\OpenAIService();
            $response = $openAIService->sendRequest([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 2000
            ]);
            
            return [
                'success' => true,
                'research_data' => $response['choices'][0]['message']['content'] ?? '',
                'timestamp' => time()
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => time()
            ];
        }
    }
    
    /**
     * Update casino entry with researched data
     */
    private function updateCasinoEntry($casino, $logoResearch, $dataResearch)
    {
        $updates = [];
        
        // Parse and apply data updates
        if ($dataResearch['success']) {
            $researchContent = $dataResearch['research_data'];
            
            // Here you would parse the OpenAI response and extract structured data
            // For now, we'll log the research for manual review
            $updates['data_research'] = $researchContent;
            $updates['research_timestamp'] = time();
        }
        
        // Log logo research for manual download and implementation
        if ($logoResearch['success']) {
            $updates['logo_research'] = $logoResearch['research_data'];
            $updates['logo_research_timestamp'] = time();
        }
        
        // Save updates to a processing queue for manual review
        $this->saveEnhancementQueue($casino['name'], $updates);
        
        return $updates;
    }
    
    /**
     * Save enhancement data to processing queue
     */
    private function saveEnhancementQueue($casinoName, $updates)
    {
        $queueFile = __DIR__ . "/../../public/casino-enhancement-queue.json";
        
        $queue = [];
        if (file_exists($queueFile)) {
            $queue = json_decode(file_get_contents($queueFile), true) ?? [];
        }
        
        $queue[$casinoName] = [
            'casino' => $casinoName,
            'updates' => $updates,
            'status' => 'pending_review',
            'created' => time()
        ];
        
        file_put_contents($queueFile, json_encode($queue, JSON_PRETTY_PRINT));
    }
    
    /**
     * Get enhancement queue for manual processing
     */
    public function getEnhancementQueue()
    {
        $queueFile = __DIR__ . "/../../public/casino-enhancement-queue.json";
        
        if (!file_exists($queueFile)) {
            return $this->json([
                'success' => true,
                'queue' => [],
                'count' => 0
            ]);
        }
        
        $queue = json_decode(file_get_contents($queueFile), true) ?? [];
        
        return $this->json([
            'success' => true,
            'queue' => $queue,
            'count' => count($queue)
        ]);
    }
    
    /**
     * Mark casino enhancement as completed
     */
    public function markEnhancementComplete($casinoName)
    {
        $queueFile = __DIR__ . "/../../public/casino-enhancement-queue.json";
        
        if (!file_exists($queueFile)) {
            return $this->json([
                'success' => false,
                'error' => 'Enhancement queue not found'
            ], 404);
        }
        
        $queue = json_decode(file_get_contents($queueFile), true) ?? [];
        
        if (!isset($queue[$casinoName])) {
            return $this->json([
                'success' => false,
                'error' => 'Casino not found in enhancement queue'
            ], 404);
        }
        
        $queue[$casinoName]['status'] = 'completed';
        $queue[$casinoName]['completed'] = time();
        
        file_put_contents($queueFile, json_encode($queue, JSON_PRETTY_PRINT));
        
        return $this->json([
            'success' => true,
            'message' => "Marked {$casinoName} enhancement as completed"
        ]);
    }
    
    /**
     * Get progress statistics
     */
    public function getProgressStats()
    {
        $auditResults = $this->logoResearchService->getAuditResults();
        $queueFile = __DIR__ . "/../../public/casino-enhancement-queue.json";
        
        $queue = [];
        if (file_exists($queueFile)) {
            $queue = json_decode(file_get_contents($queueFile), true) ?? [];
        }
        
        $completed = array_filter($queue, function($item) {
            return $item['status'] === 'completed';
        });
        
        $pending = array_filter($queue, function($item) {
            return $item['status'] === 'pending_review';
        });
        
        return $this->json([
            'success' => true,
            'stats' => [
                'total_casinos' => $auditResults['total_casinos'] ?? 0,
                'enhancement_needed' => count($auditResults['priority_list'] ?? []),
                'in_queue' => count($queue),
                'completed' => count($completed),
                'pending_review' => count($pending),
                'progress_percentage' => count($auditResults['priority_list'] ?? []) > 0 
                    ? round((count($completed) / count($auditResults['priority_list'])) * 100, 1)
                    : 0
            ]
        ]);
    }
    
    /**
     * Batch process multiple casinos
     */
    public function batchProcessCasinos()
    {
        $auditResults = $this->logoResearchService->getAuditResults();
        
        if (!$auditResults) {
            return $this->json([
                'success' => false,
                'error' => 'No audit results found. Please run audit first.'
            ], 400);
        }
        
        // Process remaining casinos (after first 15)
        $remainingCasinos = array_slice($auditResults['priority_list'], 15);
        $batchResults = [];
        
        foreach ($remainingCasinos as $casino) {
            try {
                $result = $this->enhanceCasino($casino['name']);
                $batchResults[] = [
                    'casino' => $casino['name'],
                    'success' => true,
                    'message' => 'Queued for enhancement'
                ];
            } catch (Exception $e) {
                $batchResults[] = [
                    'casino' => $casino['name'],
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }
        
        return $this->json([
            'success' => true,
            'message' => 'Batch processing completed',
            'results' => $batchResults,
            'processed_count' => count($batchResults)
        ]);
    }
    
    /**
     * Helper method to render views
     */
    private function render($template, $data = [])
    {
        // Extract data variables
        extract($data);
        
        // Include template
        ob_start();
        include __DIR__ . "/../Views/{$template}.php";
        $content = ob_get_clean();
        
        return $content;
    }
    
    /**
     * Helper method to return JSON responses
     */
    private function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        return json_encode($data);
    }
}
