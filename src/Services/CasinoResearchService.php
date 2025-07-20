<?php
namespace App\Services;

use App\Services\OpenAIService;
use App\Services\OpenAIMonitorService;
use Exception;

class CasinoResearchService
{
    private $openAI;
    private $monitor;
    private $affiliateDatabase;
    
    public function __construct()
    {
        $this->openAI = new OpenAIService();
        $this->monitor = new OpenAIMonitorService();
        
        // Load affiliate database
        $databasePath = __DIR__ . '/../../casino-affiliates-database.json';
        if (!file_exists($databasePath)) {
            throw new Exception("Casino affiliates database not found at: " . $databasePath);
        }
        
        $this->affiliateDatabase = json_decode(file_get_contents($databasePath), true);
        if (!$this->affiliateDatabase) {
            throw new Exception("Failed to parse casino affiliates database");
        }
    }
    
    /**
     * Research all casinos from the affiliate database
     */
    public function researchAllCasinos(): array
    {
        $results = [];
        $casinos = $this->affiliateDatabase['casinos'];
        
        foreach ($casinos as $casino) {
            try {
                $research = $this->researchCasino($casino);
                $results[] = $research;
                
                // Add delay to respect API rate limits
                sleep(2);
                
            } catch (Exception $e) {
                error_log("Failed to research casino {$casino['name']}: " . $e->getMessage());
                $results[] = [
                    'casino_id' => $casino['id'],
                    'name' => $casino['name'],
                    'error' => $e->getMessage(),
                    'research_status' => 'failed'
                ];
            }
        }
        
        return $results;
    }
    
    /**
     * Estimate API request cost based on response length
     */
    private function estimateRequestCost(int $responseLength): float
    {
        // Rough estimation: response length / 4 = tokens, GPT-4o pricing
        $estimatedTokens = $responseLength / 4;
        $inputTokens = $estimatedTokens * 0.3; // Estimate 30% input
        $outputTokens = $estimatedTokens * 0.7; // Estimate 70% output
        
        // GPT-4o pricing (July 2025)
        $inputCost = ($inputTokens / 1000) * 0.005;
        $outputCost = ($outputTokens / 1000) * 0.015;
        
        return $inputCost + $outputCost;
    }
    
    /**
     * Research individual casino with comprehensive data gathering
     */
    public function researchCasino(array $affiliateData): array
    {
        $casinoName = $affiliateData['name'];
        
        // Create comprehensive research prompt
        $prompt = $this->buildResearchPrompt($casinoName, $affiliateData);
        
        try {
            $response = $this->openAI->researchCasino($prompt);
            
            $researchData = json_decode($response, true);
            
            if (!$researchData) {
                throw new Exception("Failed to parse OpenAI response as JSON");
            }
            
            // Merge with affiliate data
            $researchData['affiliate_info'] = $affiliateData;
            $researchData['research_date'] = date('Y-m-d H:i:s');
            $researchData['research_status'] = 'completed';
            
            return $researchData;
            
        } catch (Exception $e) {
            error_log("OpenAI research failed for {$casinoName}: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Build comprehensive research prompt for casino
     */
    private function buildResearchPrompt(string $casinoName, array $affiliateData): string
    {
        $geoList = implode(', ', $affiliateData['geographic_coverage']);
        
        return "
        Research the online casino '{$casinoName}' and provide comprehensive data in JSON format.

        REQUIRED RESEARCH AREAS:
        1. Basic Information
        2. Licensing & Regulation
        3. Game Library
        4. Bonuses & Promotions
        5. Payment Methods
        6. Mobile Experience
        7. Customer Support
        8. Security Features
        9. User Experience
        10. Market Reputation

        AFFILIATE CONTEXT:
        - Geographic Coverage: {$geoList}
        - Commission Model: {$affiliateData['commission_model']}
        - Target Markets: " . implode(', ', $affiliateData['target_markets']) . "

        Return data in this exact JSON structure:
        {
            \"basic_info\": {
                \"name\": \"Casino Name\",
                \"brand_name\": \"Official Brand Name\",
                \"website_url\": \"https://example.com\",
                \"logo_url\": \"https://example.com/logo.png\",
                \"established_year\": 2020,
                \"owner_company\": \"Company Name\",
                \"description\": \"Brief casino description\",
                \"tagline\": \"Casino tagline or slogan\"
            },
            \"licensing\": {
                \"primary_license\": \"Malta Gaming Authority\",
                \"license_number\": \"MGA/B2C/XXX/XXXX\",
                \"additional_licenses\": [\"UK Gambling Commission\"],
                \"regulatory_compliance\": \"Excellent\",
                \"trust_score\": 9.2
            },
            \"games\": {
                \"total_games\": 2500,
                \"slots_count\": 2000,
                \"table_games_count\": 300,
                \"live_dealer_count\": 150,
                \"software_providers\": [\"NetEnt\", \"Microgaming\", \"Pragmatic Play\"],
                \"popular_games\": [\"Starburst\", \"Book of Dead\", \"Sweet Bonanza\"],
                \"exclusive_games\": true,
                \"jackpot_games\": 50
            },
            \"bonuses\": {
                \"welcome_bonus\": \"100% up to $500 + 200 Free Spins\",
                \"welcome_bonus_value\": 500,
                \"wagering_requirement\": \"35x\",
                \"no_deposit_bonus\": \"20 Free Spins\",
                \"ongoing_promotions\": [\"Weekly Cashback\", \"Reload Bonus\"],
                \"vip_program\": true,
                \"bonus_terms_fair\": true
            },
            \"payments\": {
                \"deposit_methods\": [\"Visa\", \"Mastercard\", \"Interac\", \"Bitcoin\"],
                \"withdrawal_methods\": [\"Bank Transfer\", \"E-wallets\", \"Crypto\"],
                \"min_deposit\": 10,
                \"min_withdrawal\": 20,
                \"withdrawal_timeframe\": \"24-48 hours\",
                \"fees\": \"No fees\",
                \"currencies\": [\"CAD\", \"USD\", \"EUR\"]
            },
            \"mobile\": {
                \"mobile_optimized\": true,
                \"mobile_app\": false,
                \"app_store_rating\": null,
                \"play_store_rating\": null,
                \"mobile_games_count\": 2000,
                \"mobile_experience_rating\": 8.5
            },
            \"support\": {
                \"live_chat\": true,
                \"email_support\": true,
                \"phone_support\": false,
                \"support_hours\": \"24/7\",
                \"languages\": [\"English\", \"French\"],
                \"response_time\": \"2 minutes\",
                \"support_quality_rating\": 8.8
            },
            \"security\": {
                \"ssl_encryption\": true,
                \"two_factor_auth\": true,
                \"responsible_gambling\": true,
                \"data_protection\": \"GDPR Compliant\",
                \"fair_play_certified\": true,
                \"security_rating\": 9.5
            },
            \"ratings\": {
                \"overall_rating\": 8.9,
                \"game_variety\": 9.2,
                \"bonus_value\": 8.5,
                \"user_experience\": 8.8,
                \"customer_service\": 8.7,
                \"payment_speed\": 8.3,
                \"mobile_experience\": 8.5,
                \"trustworthiness\": 9.1
            },
            \"pros\": [
                \"Huge game selection\",
                \"Fast withdrawals\",
                \"Excellent mobile experience\",
                \"24/7 customer support\"
            ],
            \"cons\": [
                \"High wagering requirements\",
                \"Limited phone support\"
            ],
            \"specialties\": [\"Slots\", \"Live Casino\", \"Crypto Payments\"],
            \"target_audience\": \"Canadian players, High rollers, Slots enthusiasts\",
            \"market_position\": \"Premium online casino\",
            \"recent_awards\": [\"Best Mobile Casino 2024\"],
            \"social_media\": {
                \"facebook\": \"https://facebook.com/casino\",
                \"twitter\": \"https://twitter.com/casino\",
                \"instagram\": \"https://instagram.com/casino\"
            }
        }

        IMPORTANT GUIDELINES:
        - Provide realistic, industry-standard data
        - Focus on Canadian market relevance where applicable
        - Use current 2025 industry standards
        - Ensure all ratings are on 1-10 scale
        - Include Canadian-specific payment methods (Interac)
        - Consider geographic restrictions from affiliate data
        - Make data consistent and professional
        - If exact data unavailable, provide reasonable estimates based on industry standards
        ";
    }
    
    /**
     * Generate casino logo URL (placeholder or research-based)
     */
    public function generateCasinoLogo(string $casinoName): string
    {
        // For now, create a placeholder SVG logo
        $initial = strtoupper(substr($casinoName, 0, 1));
        $colors = ['#d63384', '#28a745', '#007bff', '#fd7e14', '#6f42c1', '#20c997'];
        $color = $colors[array_rand($colors)];
        
        $svg = "data:image/svg+xml;base64," . base64_encode("
        <svg width='120' height='120' xmlns='http://www.w3.org/2000/svg'>
            <circle cx='60' cy='60' r='60' fill='{$color}'/>
            <text x='60' y='75' font-family='Arial' font-size='48' font-weight='bold' fill='white' text-anchor='middle'>{$initial}</text>
            <text x='60' y='35' font-family='Arial' font-size='12' fill='white' text-anchor='middle' opacity='0.8'>CASINO</text>
        </svg>
        ");
        
        return $svg;
    }
    
    /**
     * Save research results to JSON file
     */
    public function saveResearchResults(array $results): string
    {
        $filename = 'casino-research-results-' . date('Y-m-d-H-i-s') . '.json';
        $filepath = __DIR__ . '/../../' . $filename;
        
        $dataToSave = [
            'research_info' => [
                'total_casinos' => count($results),
                'research_date' => date('Y-m-d H:i:s'),
                'successful_research' => count(array_filter($results, fn($r) => $r['research_status'] === 'completed')),
                'failed_research' => count(array_filter($results, fn($r) => $r['research_status'] === 'failed'))
            ],
            'casinos' => $results
        ];
        
        $success = file_put_contents($filepath, json_encode($dataToSave, JSON_PRETTY_PRINT));
        
        if (!$success) {
            throw new Exception("Failed to save research results to: " . $filepath);
        }
        
        return $filepath;
    }
    
    /**
     * Generate website integration code for researched casinos
     */
    public function generateIntegrationCode(array $researchResults): string
    {
        $phpCode = "<?php\n\n";
        $phpCode .= "/**\n * Auto-generated casino data from research results\n */\n\n";
        $phpCode .= "class ResearchedCasinoData {\n";
        $phpCode .= "    public static function getAllCasinos(): array {\n";
        $phpCode .= "        return [\n";
        
        foreach ($researchResults as $casino) {
            if ($casino['research_status'] !== 'completed') continue;
            
            $phpCode .= "            [\n";
            $phpCode .= "                'id' => '{$casino['basic_info']['name']}',\n";
            $phpCode .= "                'name' => '{$casino['basic_info']['name']}',\n";
            $phpCode .= "                'logo_url' => '{$this->generateCasinoLogo($casino['basic_info']['name'])}',\n";
            $phpCode .= "                'rating' => {$casino['ratings']['overall_rating']},\n";
            $phpCode .= "                'bonus' => '{$casino['bonuses']['welcome_bonus']}',\n";
            $phpCode .= "                'games_count' => {$casino['games']['total_games']},\n";
            $phpCode .= "                'license' => '{$casino['licensing']['primary_license']}',\n";
            $phpCode .= "                'affiliate_id' => '{$casino['affiliate_info']['id']}',\n";
            $phpCode .= "                'target_markets' => " . var_export($casino['affiliate_info']['geographic_coverage'], true) . ",\n";
            $phpCode .= "            ],\n";
        }
        
        $phpCode .= "        ];\n";
        $phpCode .= "    }\n";
        $phpCode .= "}\n";
        
        return $phpCode;
    }
}
