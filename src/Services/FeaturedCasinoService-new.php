<?php
namespace App\Services;

class FeaturedCasinoService {

    /**
     * Get featured casinos for the spotlight carousel  
     * These are the premium, top-performing casinos from our researched data
     */
    public function getFeaturedCasinos(): array {       
        // Use our researched casino data
        $casinoDataService = new CasinoDataService();
        $allCasinos = $casinoDataService->getAllCasinos();
        
        // Get top 4 casinos sorted by rating for featured section
        usort($allCasinos, function($a, $b) {
            return ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0);
        });
        
        $topCasinos = array_slice($allCasinos, 0, 4);
        
        // Convert to expected format for the featured carousel
        $featured = [];
        foreach ($topCasinos as $index => $casino) {
            $featured[] = [
                'id' => $casino['id'] ?? ($index + 1),
                'name' => $casino['name'] ?? 'Unknown Casino',
                'slug' => $casino['slug'] ?? strtolower(str_replace(' ', '-', $casino['name'] ?? 'casino')),
                'logo' => $this->generateLogo($casino['name'] ?? 'Casino'),
                'rating' => $casino['rating'] ?? 0,
                'rating_text' => $this->getRatingText($casino['rating'] ?? 0),
                'established' => $casino['established_year'] ?? null,
                'rtp' => ($casino['rtp'] ?? '96') . '%',
                'games' => ($casino['total_games'] ?? '1000') . '+',
                'bonus' => $casino['bonus_offer'] ?? 'Welcome Bonus Available',
                'bonus_code' => 'WELCOME',
                'payout' => $casino['payout_time'] ?? '1-3 days',
                'website_url' => $casino['affiliate_url'] ?? '#',
                'featured_reason' => $this->getFeaturedReason($casino),
                'featured_description' => $casino['description'] ?? 'A top-rated online casino offering excellent games and bonuses.',
                'key_features' => $this->getKeyFeatures($casino),
                'pros' => $this->getPros($casino),
                'license' => $casino['license'] ?? 'Licensed',
                'featured' => true,
                'featured_order' => $index + 1,
                'affiliate_priority' => 'premium'
            ];
        }
        
        return $featured;
    }
    
    /**
     * Get carousel configuration for the featured casino slider
     */
    public function getCarouselConfig(): array {
        return [
            'autoplay' => true,
            'autoplaySpeed' => 5000,
            'slidesToShow' => 3,
            'slidesToScroll' => 1,
            'responsive' => [
                [
                    'breakpoint' => 1024,
                    'settings' => [
                        'slidesToShow' => 2
                    ]
                ],
                [
                    'breakpoint' => 768,
                    'settings' => [
                        'slidesToShow' => 1
                    ]
                ]
            ]
        ];
    }
    
    private function generateLogo($name): string {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }
    
    private function getRatingText($rating): string {
        if ($rating >= 8.5) return 'Outstanding';
        if ($rating >= 8.0) return 'Excellent';
        if ($rating >= 7.5) return 'Very Good';
        if ($rating >= 7.0) return 'Good';
        if ($rating >= 6.0) return 'Fair';
        return 'Average';
    }
    
    private function getFeaturedReason($casino): string {
        $rating = $casino['rating'] ?? 0;
        if ($rating >= 8.5) return 'Highest Rated Casino';
        if ($rating >= 8.0) return 'Premium Gaming Experience';
        return 'Top Rated Casino';
    }
    
    private function getKeyFeatures($casino): array {
        return [
            ($casino['total_games'] ?? '1000') . '+ Premium Games',
            ($casino['rtp'] ?? '96') . '% Average RTP',
            '24/7 Live Support',
            'Fast ' . ($casino['payout_time'] ?? '1-3 day') . ' Payouts',
            'Mobile Optimized'
        ];
    }
    
    private function getPros($casino): array {
        return [
            'Excellent game selection',
            'Top-rated by players',
            'Secure and licensed',
            'Great bonus offers'
        ];
    }
}
?>
