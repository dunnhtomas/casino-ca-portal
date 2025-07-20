<?php

namespace App\Services;

class CategoryComparisonService
{
    private array $categoryLeaders = [
        'real-money' => [
            'id' => 'real-money',
            'title' => 'Best Real Money Casino',
            'icon' => '💸',
            'casino' => [
                'name' => 'BonRush',
                'slug' => 'bonrush',
                'logo' => 'BR',
                'rating' => 4.7,
                'rtp' => 97.39,
                'games' => 1350,
                'highlight' => 'Highest payout percentages',
                'bonus' => '100% up to $1,600',
                'payout_time' => '1-3 days',
                'license' => 'MGA',
                'established' => 1998
            ],
            'expert_note' => 'BonRush consistently delivers the highest RTP percentages in the Canadian market, making it our top choice for serious real money players.',
            'key_features' => [
                'Industry-leading 97.39% average RTP',
                'Over 1,350 certified games',
                'Fast 1-3 day payouts',
                'MGA licensed and regulated'
            ]
        ],
        'slots' => [
            'id' => 'slots',
            'title' => 'Best for Online Slots',
            'icon' => '🎰',
            'casino' => [
                'name' => 'SLOTSVIL',
                'slug' => 'slotsvil',
                'logo' => 'SV',
                'rating' => 4.7,
                'rtp' => 97.45,
                'games' => 1000,
                'highlight' => 'Premium slot selection',
                'bonus' => '100% up to $1,000',
                'payout_time' => '1-3 days',
                'license' => 'MGA',
                'established' => 2001
            ],
            'expert_note' => 'SLOTSVIL offers the most comprehensive slot library with exclusive titles and progressive jackpots exceeding $10 million.',
            'key_features' => [
                'Over 1,000 premium slot games',
                'Exclusive Microgaming titles',
                'Progressive jackpots up to $15M+',
                '24/7 slot tournaments'
            ]
        ],
        'bonus' => [
            'id' => 'bonus',
            'title' => 'Best Welcome Bonus',
            'icon' => '💰',
            'casino' => [
                'name' => 'Lucky Ones',
                'slug' => 'lucky-ones',
                'logo' => 'LO',
                'rating' => 4.4,
                'rtp' => 98.27,
                'games' => 8000,
                'highlight' => '$5,000+ bonus packages',
                'bonus' => '300% up to $5,000',
                'payout_time' => '1-2 days',
                'license' => 'Curacao',
                'established' => 2023
            ],
            'expert_note' => 'Lucky Ones provides the most generous welcome package in Canada with reasonable 25x wagering requirements and no maximum cashout.',
            'key_features' => [
                'Massive $5,000 welcome package',
                'Low 25x wagering requirements',
                'No maximum cashout limits',
                'Weekly reload bonuses up to 50%'
            ]
        ],
        'payments' => [
            'id' => 'payments',
            'title' => 'Best Payment Options',
            'icon' => '💳',
            'casino' => [
                'name' => 'Pistolo',
                'slug' => 'pistolo',
                'logo' => 'PI',
                'rating' => 4.6,
                'rtp' => 97.21,
                'games' => 11000,
                'highlight' => '20+ payment methods',
                'bonus' => '100% up to $1,500',
                'payout_time' => 'Instant - 24 hours',
                'license' => 'MGA',
                'established' => 2020
            ],
            'expert_note' => 'Pistolo supports every major payment method including crypto, e-wallets, and traditional banking with the fastest withdrawal times.',
            'key_features' => [
                '20+ payment methods supported',
                'Instant crypto withdrawals',
                'No deposit/withdrawal fees',
                'CAD currency native support'
            ]
        ],
        'live-casino' => [
            'id' => 'live-casino',
            'title' => 'Best Live Casino',
            'icon' => '🎲',
            'casino' => [
                'name' => 'Magius',
                'slug' => 'magius',
                'logo' => 'MG',
                'rating' => 4.6,
                'rtp' => 98.13,
                'games' => 7400,
                'highlight' => '100+ live tables',
                'bonus' => '200% up to $2,000',
                'payout_time' => '1-3 days',
                'license' => 'MGA',
                'established' => 2019
            ],
            'expert_note' => 'Magius offers the most immersive live casino experience with professional dealers and 24/7 VIP tables in multiple languages.',
            'key_features' => [
                '100+ live dealer tables',
                'Professional multilingual dealers',
                'VIP tables with high limits',
                'Multiple Evolution Gaming studios'
            ]
        ]
    ];

    /**
     * Get all category leaders data
     */
    public function getCategoryLeaders(): array
    {
        return $this->categoryLeaders;
    }

    /**
     * Get specific category details
     */
    public function getCategoryDetails(string $categorySlug): ?array
    {
        return $this->categoryLeaders[$categorySlug] ?? null;
    }

    /**
     * Get category comparison data for display
     */
    public function getCategoryComparisonData(): array
    {
        $comparisonData = [];
        
        foreach ($this->categoryLeaders as $category) {
            $comparisonData[] = [
                'category' => $category['title'],
                'icon' => $category['icon'],
                'casino_name' => $category['casino']['name'],
                'casino_slug' => $category['casino']['slug'],
                'casino_logo' => $category['casino']['logo'],
                'rating' => $category['casino']['rating'],
                'rtp' => $category['casino']['rtp'],
                'games' => $category['casino']['games'],
                'highlight' => $category['casino']['highlight'],
                'bonus' => $category['casino']['bonus'],
                'expert_note' => $category['expert_note'],
                'key_features' => $category['key_features']
            ];
        }
        
        return $comparisonData;
    }

    /**
     * Get formatted statistics for categories
     */
    public function getCategoryStatistics(): array
    {
        $stats = [
            'total_categories' => count($this->categoryLeaders),
            'average_rating' => 0,
            'total_games' => 0,
            'highest_rtp' => 0,
            'best_bonus_amount' => 0
        ];
        
        $totalRating = 0;
        
        foreach ($this->categoryLeaders as $category) {
            $casino = $category['casino'];
            $totalRating += $casino['rating'];
            $stats['total_games'] += $casino['games'];
            
            if ($casino['rtp'] > $stats['highest_rtp']) {
                $stats['highest_rtp'] = $casino['rtp'];
            }
            
            // Extract bonus amount (simple parsing)
            preg_match('/\$([0-9,]+)/', $casino['bonus'], $matches);
            if (isset($matches[1])) {
                $bonusAmount = (int)str_replace(',', '', $matches[1]);
                if ($bonusAmount > $stats['best_bonus_amount']) {
                    $stats['best_bonus_amount'] = $bonusAmount;
                }
            }
        }
        
        $stats['average_rating'] = round($totalRating / count($this->categoryLeaders), 1);
        
        return $stats;
    }

    /**
     * Update category metrics (for future real-time integration)
     */
    public function updateCategoryMetrics(): bool
    {
        // Future implementation for real-time data updates
        // This would integrate with casino APIs to update metrics
        return true;
    }

    /**
     * Validate category data integrity
     */
    public function validateCategoryData(): bool
    {
        foreach ($this->categoryLeaders as $categoryId => $category) {
            // Check required fields
            $requiredFields = ['title', 'icon', 'casino', 'expert_note', 'key_features'];
            foreach ($requiredFields as $field) {
                if (!isset($category[$field])) {
                    return false;
                }
            }
            
            // Check casino required fields
            $requiredCasinoFields = ['name', 'slug', 'rating', 'rtp', 'games'];
            foreach ($requiredCasinoFields as $field) {
                if (!isset($category['casino'][$field])) {
                    return false;
                }
            }
            
            // Validate data types and ranges
            if ($category['casino']['rating'] < 1 || $category['casino']['rating'] > 5) {
                return false;
            }
            
            if ($category['casino']['rtp'] < 80 || $category['casino']['rtp'] > 100) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get category by casino name
     */
    public function getCategoryByCasino(string $casinoName): ?array
    {
        foreach ($this->categoryLeaders as $category) {
            if (strtolower($category['casino']['name']) === strtolower($casinoName)) {
                return $category;
            }
        }
        return null;
    }

    /**
     * Get all categories sorted by rating
     */
    public function getCategoriesByRating(): array
    {
        $categories = $this->categoryLeaders;
        
        uasort($categories, function($a, $b) {
            return $b['casino']['rating'] <=> $a['casino']['rating'];
        });
        
        return $categories;
    }

    /**
     * Get all categories sorted by RTP
     */
    public function getCategoriesByRTP(): array
    {
        $categories = $this->categoryLeaders;
        
        uasort($categories, function($a, $b) {
            return $b['casino']['rtp'] <=> $a['casino']['rtp'];
        });
        
        return $categories;
    }
}
