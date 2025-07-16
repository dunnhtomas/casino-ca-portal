<?php
namespace App\Services;

class FeaturedCasinoService {
    
    /**
     * Get featured casinos for the spotlight carousel
     * These are the premium, top-performing casinos
     */
    public function getFeaturedCasinos(): array {
        return [
            [
                'id' => 1,
                'name' => 'Jackpot City Casino',
                'slug' => 'jackpot-city',
                'logo' => 'JC',
                'rating' => 4.8,
                'rating_text' => 'Excellent',
                'established' => 1998,
                'rtp' => '97.39%',
                'games' => '1,350+',
                'bonus' => '100% up to $4,000 + 210 Free Spins',
                'bonus_code' => 'WELCOME4000',
                'payout' => '1-3 days',
                'website_url' => 'https://www.jackpotcitycasino.com',
                'featured_reason' => 'Highest RTP & Longest Operating',
                'featured_description' => 'The gold standard for Canadian online casinos with 25+ years of excellence, featuring the highest RTPs and most comprehensive game selection.',
                'key_features' => [
                    '1,350+ Premium Games',
                    '97.39% Average RTP',
                    '24/7 Live Support',
                    'Fast 1-3 Day Payouts',
                    'Mobile Casino App'
                ],
                'pros' => [
                    'Industry-leading RTP rates',
                    'Massive game selection',
                    'Trusted 25+ year reputation',
                    'Excellent mobile experience'
                ],
                'license' => 'Malta Gaming Authority',
                'featured' => true,
                'featured_order' => 1,
                'affiliate_priority' => 'premium'
            ],
            [
                'id' => 2,
                'name' => 'Spin Palace',
                'slug' => 'spin-palace',
                'logo' => 'SP',
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'established' => 2001,
                'rtp' => '97.45%',
                'games' => '1,000+',
                'bonus' => '100% up to $1,000 + 345 Free Spins',
                'bonus_code' => 'SPIN1000',
                'payout' => '1-3 days',
                'website_url' => 'https://www.spincasino.com',
                'featured_reason' => 'Best Mobile Experience',
                'featured_description' => 'Award-winning mobile casino with seamless gameplay, premium live dealers, and the most user-friendly interface in Canada.',
                'key_features' => [
                    'Award-Winning Mobile App',
                    'Live Dealer Excellence',
                    'Instant Play Technology',
                    'VIP Loyalty Program',
                    'Weekly Tournaments'
                ],
                'pros' => [
                    'Superior mobile optimization',
                    'Live dealer variety',
                    'User-friendly interface',
                    'Strong loyalty rewards'
                ],
                'license' => 'Malta Gaming Authority',
                'featured' => true,
                'featured_order' => 2,
                'affiliate_priority' => 'premium'
            ],
            [
                'id' => 15,
                'name' => 'Lucky Ones',
                'slug' => 'lucky-ones',
                'logo' => 'LO',
                'rating' => 4.6,
                'rating_text' => 'Excellent',
                'established' => 2023,
                'rtp' => '98.27%',
                'games' => '8,000+',
                'bonus' => '100% up to $20,000 + 500 Free Spins',
                'bonus_code' => 'LUCKY20K',
                'payout' => '0-2 days',
                'website_url' => 'https://www.luckyones.com',
                'featured_reason' => 'Highest Bonus & Newest Innovation',
                'featured_description' => 'Canada\'s newest premium casino featuring revolutionary gaming technology, the highest welcome bonus, and lightning-fast crypto payouts.',
                'key_features' => [
                    'Massive $20,000 Welcome Bonus',
                    '8,000+ Games Library',
                    'Crypto & Instant Payouts',
                    'Next-Gen Gaming Tech',
                    'Exclusive Canadian Focus'
                ],
                'pros' => [
                    'Highest welcome bonus available',
                    'Massive game selection',
                    'Lightning-fast payouts',
                    'Cutting-edge technology'
                ],
                'license' => 'Curacao Gaming Authority',
                'featured' => true,
                'featured_order' => 3,
                'affiliate_priority' => 'premium'
            ],
            [
                'id' => 4,
                'name' => 'Royal Vegas Casino',
                'slug' => 'royal-vegas',
                'logo' => 'RV',
                'rating' => 4.5,
                'rating_text' => 'Excellent',
                'established' => 2000,
                'rtp' => '96.95%',
                'games' => '800+',
                'bonus' => '100% up to $1,200 + 120 Free Spins',
                'bonus_code' => 'ROYAL1200',
                'payout' => '1-4 days',
                'website_url' => 'https://www.royalvegas.com',
                'featured_reason' => 'VIP Excellence & Premium Service',
                'featured_description' => 'The royal treatment for Canadian players with exclusive VIP perks, premium customer service, and sophisticated gaming environment.',
                'key_features' => [
                    'Exclusive VIP Treatment',
                    'Premium Customer Service',
                    'High-Limit Gaming',
                    'Sophisticated Interface',
                    'Regular Player Rewards'
                ],
                'pros' => [
                    'Outstanding VIP program',
                    'Premium service quality',
                    'High-limit gaming options',
                    'Elegant gaming environment'
                ],
                'license' => 'Malta Gaming Authority',
                'featured' => true,
                'featured_order' => 4,
                'affiliate_priority' => 'premium'
            ]
        ];
    }
    
    /**
     * Get a specific featured casino by slug
     */
    public function getFeaturedCasino(string $slug): ?array {
        $featured = $this->getFeaturedCasinos();
        foreach ($featured as $casino) {
            if ($casino['slug'] === $slug) {
                return $casino;
            }
        }
        return null;
    }
    
    /**
     * Get carousel configuration
     */
    public function getCarouselConfig(): array {
        return [
            'auto_rotate' => true,
            'rotation_speed' => 6000, // 6 seconds
            'transition_duration' => 500, // 0.5 seconds
            'pause_on_hover' => true,
            'show_navigation' => true,
            'show_indicators' => true,
            'touch_enabled' => true
        ];
    }
    
    /**
     * Get featured casino statistics for analytics
     */
    public function getFeaturedStats(): array {
        $casinos = $this->getFeaturedCasinos();
        
        return [
            'total_featured' => count($casinos),
            'avg_rating' => round(array_sum(array_column($casinos, 'rating')) / count($casinos), 2),
            'avg_rtp' => $this->calculateAverageRTP($casinos),
            'total_games' => $this->calculateTotalGames($casinos),
            'bonus_range' => $this->getBonusRange($casinos)
        ];
    }
    
    /**
     * Calculate average RTP across featured casinos
     */
    private function calculateAverageRTP(array $casinos): string {
        $rtps = [];
        foreach ($casinos as $casino) {
            $rtp = (float) str_replace('%', '', $casino['rtp']);
            $rtps[] = $rtp;
        }
        $avg = array_sum($rtps) / count($rtps);
        return round($avg, 2) . '%';
    }
    
    /**
     * Calculate total games across featured casinos
     */
    private function calculateTotalGames(array $casinos): string {
        $total = 0;
        foreach ($casinos as $casino) {
            $games = (int) str_replace(['+', ','], '', $casino['games']);
            $total += $games;
        }
        return number_format($total) . '+';
    }
    
    /**
     * Get bonus amount range
     */
    private function getBonusRange(array $casinos): array {
        $amounts = [];
        foreach ($casinos as $casino) {
            // Extract bonus amount (rough parsing)
            preg_match('/\$([0-9,]+)/', $casino['bonus'], $matches);
            if (isset($matches[1])) {
                $amounts[] = (int) str_replace(',', '', $matches[1]);
            }
        }
        
        if (empty($amounts)) {
            return ['min' => '$0', 'max' => '$0'];
        }
        
        return [
            'min' => '$' . number_format(min($amounts)),
            'max' => '$' . number_format(max($amounts))
        ];
    }
}
