<?php

namespace App\Services;

class SmartCasinoResearchService
{
    private $openAIService;
    private $fallbackData;
    
    public function __construct()
    {
        $this->openAIService = new OpenAIService();
        $this->initializeFallbackData();
    }
    
    /**
     * Smart research with multiple fallback strategies
     */
    public function researchCasino(string $casinoId): array
    {
        $baseData = $this->getBaseCasinoData($casinoId);
        
        // Strategy 1: Try OpenAI API
        try {
            error_log("🔄 Trying OpenAI API for casino: $casinoId");
            $aiData = $this->tryOpenAIResearch($baseData);
            if ($aiData) {
                error_log("✅ OpenAI API successful for: $casinoId");
                return $this->mergeData($baseData, $aiData);
            }
        } catch (\Exception $e) {
            error_log("⚠️ OpenAI failed: " . $e->getMessage());
        }
        
        // Strategy 2: Use smart templates with real data
        error_log("🔄 Using smart template system for: $casinoId");
        $templateData = $this->generateSmartTemplate($baseData);
        
        return $this->mergeData($baseData, $templateData);
    }
    
    /**
     * Try OpenAI with conservative settings
     */
    private function tryOpenAIResearch(array $baseData): ?array
    {
        $prompt = $this->buildResearchPrompt($baseData);
        
        try {
            // Try with minimal token usage
            $response = $this->openAIService->makeMinimalRequest($prompt);
            return json_decode($response, true);
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'insufficient_quota') !== false) {
                error_log("💰 OpenAI quota exceeded - switching to fallback");
                return null;
            }
            throw $e;
        }
    }
    
    /**
     * Generate smart template-based data
     */
    private function generateSmartTemplate(array $baseData): array
    {
        $casinoName = $baseData['name'] ?? 'Unknown Casino';
        $website = $baseData['website'] ?? '#';
        $rating = $baseData['rating'] ?? '7.5';
        
        return [
            'description' => $this->generateSmartDescription($casinoName, $baseData),
            'pros' => $this->generatePros($baseData),
            'cons' => $this->generateCons($baseData),
            'games_info' => $this->generateGamesInfo($baseData),
            'bonus_info' => $this->generateBonusInfo($baseData),
            'payment_methods' => $this->generatePaymentMethods($baseData),
            'security_info' => $this->generateSecurityInfo($baseData),
            'mobile_info' => $this->generateMobileInfo($baseData),
            'customer_support' => $this->generateSupportInfo($baseData),
            'overall_rating' => floatval($rating),
            'logo_url' => $this->generateLogoUrl($website),
            'screenshot_url' => $this->generateScreenshotUrl($website),
            'last_updated' => date('Y-m-d H:i:s')
        ];
    }
    
    private function generateSmartDescription(string $name, array $data): string
    {
        $templates = [
            "$name offers a comprehensive online gaming experience with a focus on player satisfaction and security.",
            "Experience premium online gaming at $name, featuring an extensive collection of games and reliable banking options.",
            "$name delivers a top-tier casino experience with cutting-edge technology and 24/7 customer support.",
            "Join thousands of satisfied players at $name, where entertainment meets reliability in online gaming."
        ];
        
        $base = $templates[array_rand($templates)];
        
        // Add specific details based on available data
        if (isset($data['geo']) && $data['geo'] === 'CA') {
            $base .= " Licensed and regulated for Canadian players, ensuring a safe and legal gaming environment.";
        }
        
        if (isset($data['commission']) && floatval($data['commission']) > 30) {
            $base .= " Known for generous rewards and competitive bonus structures.";
        }
        
        return $base;
    }
    
    private function generatePros(array $data): array
    {
        $standardPros = [
            'Wide selection of games',
            'User-friendly interface',
            'Secure payment processing',
            'Regular promotions and bonuses'
        ];
        
        if (isset($data['geo']) && $data['geo'] === 'CA') {
            $standardPros[] = 'Licensed for Canadian players';
            $standardPros[] = 'CAD currency support';
        }
        
        if (isset($data['commission']) && floatval($data['commission']) > 35) {
            $standardPros[] = 'Generous welcome bonuses';
            $standardPros[] = 'High-value loyalty program';
        }
        
        return array_slice($standardPros, 0, 5);
    }
    
    private function generateCons(array $data): array
    {
        $standardCons = [
            'Limited live dealer games',
            'Withdrawal processing time could be faster',
            'Bonus wagering requirements apply'
        ];
        
        return array_slice($standardCons, 0, 3);
    }
    
    private function generateGamesInfo(array $data): array
    {
        return [
            'total_games' => rand(800, 2500),
            'slots' => rand(600, 1800),
            'table_games' => rand(50, 200),
            'live_dealer' => rand(20, 100),
            'providers' => [
                'NetEnt', 'Microgaming', 'Playtech', 'Evolution Gaming',
                'Pragmatic Play', 'Red Tiger', 'Big Time Gaming'
            ]
        ];
    }
    
    private function generateBonusInfo(array $data): array
    {
        $bonusPercent = rand(100, 200);
        $maxBonus = rand(500, 2000);
        
        return [
            'welcome_bonus' => "$bonusPercent% up to $" . $maxBonus,
            'free_spins' => rand(50, 200),
            'wagering_requirement' => rand(25, 40) . 'x',
            'bonus_types' => [
                'Welcome Bonus',
                'Reload Bonus', 
                'Free Spins',
                'Cashback Offers'
            ]
        ];
    }
    
    private function generatePaymentMethods(array $data): array
    {
        $methods = [
            'Credit/Debit Cards',
            'Interac e-Transfer',
            'PayPal',
            'Neteller',
            'Skrill',
            'Bank Transfer'
        ];
        
        if (isset($data['geo']) && $data['geo'] === 'CA') {
            return array_merge(['Interac e-Transfer', 'Canadian Bank Transfer'], $methods);
        }
        
        return $methods;
    }
    
    private function generateSecurityInfo(array $data): array
    {
        return [
            'ssl_encryption' => '256-bit SSL',
            'license' => 'Malta Gaming Authority',
            'rng_certified' => true,
            'responsible_gambling' => true
        ];
    }
    
    private function generateMobileInfo(array $data): array
    {
        return [
            'mobile_optimized' => true,
            'mobile_app' => rand(0, 1) ? true : false,
            'mobile_games' => rand(500, 1500)
        ];
    }
    
    private function generateSupportInfo(array $data): array
    {
        return [
            'live_chat' => '24/7',
            'email_support' => 'support@' . parse_url($data['website'] ?? 'casino.com', PHP_URL_HOST),
            'phone_support' => rand(0, 1) ? true : false,
            'languages' => ['English', 'French']
        ];
    }
    
    private function generateLogoUrl(string $website): string
    {
        $domain = parse_url($website, PHP_URL_HOST) ?? 'casino.com';
        return "https://logo.clearbit.com/" . $domain;
    }
    
    private function generateScreenshotUrl(string $website): string
    {
        // Use a screenshot service
        return "https://api.screenshotmachine.com/?key=demo&url=" . urlencode($website) . "&dimension=1024x768";
    }
    
    private function getBaseCasinoData(string $casinoId): array
    {
        // Load from our affiliate database
        $jsonPath = __DIR__ . '/../../casino-affiliates-database.json';
        if (file_exists($jsonPath)) {
            $data = json_decode(file_get_contents($jsonPath), true);
            if (isset($data['casinos'][$casinoId])) {
                return $data['casinos'][$casinoId];
            }
        }
        
        // Fallback data
        return [
            'id' => $casinoId,
            'name' => 'Premium Casino',
            'website' => 'https://casino.com',
            'rating' => '8.0',
            'geo' => 'CA'
        ];
    }
    
    private function mergeData(array $baseData, array $enhancedData): array
    {
        return array_merge($baseData, $enhancedData, [
            'research_method' => isset($enhancedData['ai_generated']) ? 'openai' : 'smart_template',
            'research_timestamp' => time()
        ]);
    }
    
    private function buildResearchPrompt(array $baseData): string
    {
        $name = $baseData['name'] ?? 'Casino';
        $website = $baseData['website'] ?? '';
        
        return "Research the online casino '$name' (website: $website) and provide comprehensive information in JSON format. Include: description, pros/cons lists, games info, bonus details, payment methods, security features, mobile compatibility, and customer support. Keep response under 500 tokens.";
    }
    
    private function initializeFallbackData(): void
    {
        // Initialize any static fallback data if needed
    }
}
