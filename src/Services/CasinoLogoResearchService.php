<?php
/**
 * Casino Logo Research Service
 * 
 * Phase 1: Comprehensive audit of casino logos and data
 * Uses OpenAI to research authentic casino logos and validate data
 */

namespace App\Services;

use App\Services\OpenAIService;
use App\Services\CasinoDataService;

class CasinoLogoResearchService 
{
    private $openAIService;
    private $casinoDataService;
    private $auditResults = [];
    
    public function __construct()
    {
        $this->openAIService = new OpenAIService();
        $this->casinoDataService = new CasinoDataService();
    }
    
    /**
     * Phase 1: Complete audit of all casino logos and data
     */
    public function performComprehensiveAudit()
    {
        $casinos = $this->casinoDataService->getAllCasinos();
        $auditResults = [
            'total_casinos' => count($casinos),
            'missing_logos' => [],
            'placeholder_logos' => [],
            'incomplete_data' => [],
            'priority_list' => [],
            'enhancement_plan' => []
        ];
        
        foreach ($casinos as $casino) {
            $casinoAudit = $this->auditSingleCasino($casino);
            $auditResults['casino_audits'][$casino['name']] = $casinoAudit;
            
            // Categorize issues
            if ($casinoAudit['logo_status'] === 'missing') {
                $auditResults['missing_logos'][] = $casino['name'];
            }
            
            if ($casinoAudit['logo_status'] === 'placeholder') {
                $auditResults['placeholder_logos'][] = $casino['name'];
            }
            
            if (!empty($casinoAudit['missing_data'])) {
                $auditResults['incomplete_data'][$casino['name']] = $casinoAudit['missing_data'];
            }
        }
        
        // Generate priority list
        $auditResults['priority_list'] = $this->generatePriorityList($auditResults);
        
        // Create enhancement plan
        $auditResults['enhancement_plan'] = $this->createEnhancementPlan($auditResults);
        
        // Save audit results
        $this->saveAuditResults($auditResults);
        
        return $auditResults;
    }
    
    /**
     * Audit individual casino for missing logos and data
     */
    private function auditSingleCasino($casino)
    {
        $audit = [
            'name' => $casino['name'],
            'logo_status' => $this->checkLogoStatus($casino),
            'data_completeness' => $this->checkDataCompleteness($casino),
            'missing_data' => [],
            'priority_score' => 0,
            'enhancement_needed' => false
        ];
        
        // Check required data fields
        $requiredFields = [
            'establishment_year',
            'license_authority', 
            'license_number',
            'owner_company',
            'headquarters',
            'support_email',
            'support_phone',
            'welcome_bonus',
            'game_count',
            'min_deposit',
            'withdrawal_time',
            'currency_support'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($casino[$field]) || $casino[$field] === 'N/A' || $casino[$field] === 'Unknown') {
                $audit['missing_data'][] = $field;
            }
        }
        
        // Calculate priority score
        $audit['priority_score'] = $this->calculatePriorityScore($casino, $audit);
        
        // Determine if enhancement needed
        $audit['enhancement_needed'] = (
            $audit['logo_status'] !== 'authentic' || 
            !empty($audit['missing_data']) ||
            $audit['data_completeness'] < 0.8
        );
        
        return $audit;
    }
    
    /**
     * Check logo status for casino
     */
    private function checkLogoStatus($casino)
    {
        $logoPath = "/var/www/casino-portal/public/images/casinos/" . strtolower(str_replace(' ', '-', $casino['name'])) . "-logo.png";
        
        if (!file_exists($logoPath)) {
            return 'missing';
        }
        
        // Check if it's a placeholder/generic image
        $fileSize = filesize($logoPath);
        if ($fileSize < 1000) { // Very small file likely placeholder
            return 'placeholder';
        }
        
        // Use OpenAI to verify authenticity
        return $this->verifyLogoAuthenticity($casino, $logoPath);
    }
    
    /**
     * Verify logo authenticity using OpenAI
     */
    private function verifyLogoAuthenticity($casino, $logoPath)
    {
        $prompt = "I need to verify if a casino logo is authentic. The casino is '{$casino['name']}' with website '{$casino['website']}'. Please research:
        
        1. What should the authentic logo look like?
        2. What are the current brand colors and design elements?
        3. Has the logo changed recently?
        4. Are there any trademark or branding guidelines?
        
        Provide a detailed description of the authentic logo that I can use to verify our current image.";
        
        try {
            $response = $this->openAIService->sendRequest([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 1000
            ]);
            
            // For now, assume needs verification if we can't confirm
            return 'needs_verification';
            
        } catch (Exception $e) {
            error_log("Logo verification failed for {$casino['name']}: " . $e->getMessage());
            return 'unknown';
        }
    }
    
    /**
     * Check data completeness percentage
     */
    private function checkDataCompleteness($casino)
    {
        $totalFields = 20; // Total expected fields
        $completedFields = 0;
        
        $fields = [
            'name', 'website', 'establishment_year', 'license_authority', 
            'license_number', 'owner_company', 'headquarters', 'support_email',
            'support_phone', 'welcome_bonus', 'game_count', 'min_deposit',
            'withdrawal_time', 'currency_support', 'mobile_app', 'live_chat',
            'payment_methods', 'restricted_countries', 'languages', 'software_providers'
        ];
        
        foreach ($fields as $field) {
            if (!empty($casino[$field]) && $casino[$field] !== 'N/A' && $casino[$field] !== 'Unknown') {
                $completedFields++;
            }
        }
        
        return round($completedFields / $totalFields, 2);
    }
    
    /**
     * Calculate priority score for enhancement
     */
    private function calculatePriorityScore($casino, $audit)
    {
        $score = 0;
        
        // Logo issues add major points
        if ($audit['logo_status'] === 'missing') {
            $score += 50;
        } elseif ($audit['logo_status'] === 'placeholder') {
            $score += 30;
        } elseif ($audit['logo_status'] === 'needs_verification') {
            $score += 20;
        }
        
        // Data completeness factor
        $score += (1 - $audit['data_completeness']) * 30;
        
        // Casino importance (based on our affiliate priority)
        if (in_array($casino['name'], ['BonRush', 'SLOTSVIL', 'CASINOJOY'])) {
            $score += 20; // Top 3 casinos get priority
        }
        
        // Missing critical data
        $criticalFields = ['license_authority', 'establishment_year', 'welcome_bonus'];
        foreach ($criticalFields as $field) {
            if (in_array($field, $audit['missing_data'])) {
                $score += 10;
            }
        }
        
        return min($score, 100); // Cap at 100
    }
    
    /**
     * Generate priority list for enhancement phases
     */
    private function generatePriorityList($auditResults)
    {
        $priorities = [];
        
        foreach ($auditResults['casino_audits'] as $casinoName => $audit) {
            if ($audit['enhancement_needed']) {
                $priorities[] = [
                    'name' => $casinoName,
                    'priority_score' => $audit['priority_score'],
                    'logo_status' => $audit['logo_status'],
                    'data_completeness' => $audit['data_completeness'],
                    'missing_data_count' => count($audit['missing_data'])
                ];
            }
        }
        
        // Sort by priority score (highest first)
        usort($priorities, function($a, $b) {
            return $b['priority_score'] <=> $a['priority_score'];
        });
        
        return $priorities;
    }
    
    /**
     * Create enhancement plan with phases
     */
    private function createEnhancementPlan($auditResults)
    {
        $plan = [
            'total_phases' => 18,
            'high_priority_casinos' => 15,
            'batch_processing_casinos' => count($auditResults['priority_list']) - 15,
            'estimated_timeline' => '3-4 weeks',
            'phases' => []
        ];
        
        // Phase 1: Current audit
        $plan['phases'][1] = [
            'phase' => 1,
            'title' => 'Casino Data Audit & Planning',
            'status' => 'completed',
            'deliverables' => [
                'Comprehensive audit report',
                'Priority enhancement list',
                'Quality control framework',
                'Phase execution plan'
            ]
        ];
        
        // Phases 2-16: Individual casino enhancement
        $highPriorityCasinos = array_slice($auditResults['priority_list'], 0, 15);
        foreach ($highPriorityCasinos as $index => $casino) {
            $phaseNumber = $index + 2;
            $plan['phases'][$phaseNumber] = [
                'phase' => $phaseNumber,
                'title' => "Enhance {$casino['name']}",
                'casino' => $casino['name'],
                'priority_score' => $casino['priority_score'],
                'status' => 'pending',
                'tasks' => [
                    'Research authentic logo',
                    'Gather missing data',
                    'Validate information',
                    'Deploy enhancements',
                    'Test implementation'
                ]
            ];
        }
        
        // Phase 17: Batch processing
        $batchCasinos = array_slice($auditResults['priority_list'], 15);
        $plan['phases'][17] = [
            'phase' => 17,
            'title' => 'Batch Process Remaining Casinos',
            'casinos' => array_column($batchCasinos, 'name'),
            'count' => count($batchCasinos),
            'status' => 'pending'
        ];
        
        // Phase 18: Final validation
        $plan['phases'][18] = [
            'phase' => 18,
            'title' => 'Site-Wide Validation & Optimization',
            'status' => 'pending',
            'deliverables' => [
                'Complete logo audit',
                'Performance optimization',
                'Final validation report'
            ]
        ];
        
        return $plan;
    }
    
    /**
     * Save audit results to file
     */
    private function saveAuditResults($results)
    {
        $timestamp = date('Y-m-d_H-i-s');
        $filename = "/var/www/casino-portal/public/casino-logo-audit-{$timestamp}.json";
        
        file_put_contents($filename, json_encode($results, JSON_PRETTY_PRINT));
        
        // Also save to local working directory
        $localFilename = __DIR__ . "/../../public/casino-logo-audit-{$timestamp}.json";
        file_put_contents($localFilename, json_encode($results, JSON_PRETTY_PRINT));
        
        return $filename;
    }
    
    /**
     * Research authentic casino logo using OpenAI
     */
    public function researchCasinoLogo($casinoName, $website)
    {
        $prompt = "Research the authentic logo for '{$casinoName}' casino (website: {$website}). Please provide:
        
        1. Direct URL to the current official logo image
        2. Description of the logo design and colors
        3. Preferred logo format (SVG, PNG, etc.)
        4. Logo usage guidelines if available
        5. Any recent rebranding information
        6. Alternative logo variations (horizontal, vertical, icon)
        
        Focus on finding the most current, authentic logo that represents the casino's official branding. Provide specific download links where possible.";
        
        try {
            $response = $this->openAIService->sendRequest([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 1500
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
     * Get current audit results
     */
    public function getAuditResults()
    {
        // Look for most recent audit file
        $pattern = __DIR__ . "/../../public/casino-logo-audit-*.json";
        $files = glob($pattern);
        
        if (empty($files)) {
            return null;
        }
        
        // Get most recent file
        usort($files, function($a, $b) {
            return filemtime($b) <=> filemtime($a);
        });
        
        $latestFile = $files[0];
        $content = file_get_contents($latestFile);
        
        return json_decode($content, true);
    }
}
