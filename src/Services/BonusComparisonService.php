<?php

namespace App\Services;

/**
 * Bonus Comparison Service
 * 
 * Comprehensive bonus comparison engine matching casino.ca functionality
 * Handles bonus analysis, filtering, calculations, and recommendations
 * 
 * @author Dr. Emily Rodriguez, Casino Bonus Analysis Expert
 */
class BonusComparisonService
{
    private $bonuses;
    private $comparisonCriteria;

    public function __construct()
    {
        $this->initializeBonuses();
        $this->initializeComparisonCriteria();
    }

    /**
     * Get all bonuses with detailed comparison data
     */
    public function getAllBonuses($filters = [], $sort = 'bonus_value')
    {
        $bonuses = $this->bonuses;

        // Apply filters
        if (!empty($filters)) {
            $bonuses = $this->applyFilters($bonuses, $filters);
        }

        // Sort bonuses
        $bonuses = $this->sortBonuses($bonuses, $sort);

        // Enrich with calculated values
        return array_map([$this, 'enrichBonusData'], $bonuses);
    }

    /**
     * Get top bonuses by specific criteria
     */
    public function getTopBonuses($limit = 5, $criteria = 'overall_value')
    {
        $bonuses = $this->getAllBonuses();
        
        switch ($criteria) {
            case 'highest_amount':
                usort($bonuses, function($a, $b) {
                    return $b['welcome_amount'] <=> $a['welcome_amount'];
                });
                break;
            case 'lowest_wagering':
                usort($bonuses, function($a, $b) {
                    return $a['wagering_requirement'] <=> $b['wagering_requirement'];
                });
                break;
            case 'most_free_spins':
                usort($bonuses, function($a, $b) {
                    return $b['free_spins'] <=> $a['free_spins'];
                });
                break;
            case 'overall_value':
            default:
                usort($bonuses, function($a, $b) {
                    return $b['bonus_score'] <=> $a['bonus_score'];
                });
                break;
        }

        return array_slice($bonuses, 0, $limit);
    }

    /**
     * Calculate bonus value score
     */
    public function calculateBonusScore($bonus)
    {
        $score = 0;
        
        // Welcome amount score (max 30 points)
        $score += min(30, ($bonus['welcome_amount'] / 2000) * 30);
        
        // Free spins score (max 25 points)
        $score += min(25, ($bonus['free_spins'] / 300) * 25);
        
        // Wagering requirement score (max 25 points, inverse)
        $wageringScore = max(0, 25 - (($bonus['wagering_requirement'] - 20) / 2));
        $score += min(25, $wageringScore);
        
        // Time limit score (max 10 points)
        $timeLimitDays = $this->parseTimeLimitDays($bonus['time_limit']);
        $score += min(10, ($timeLimitDays / 30) * 10);
        
        // Game restrictions score (max 10 points)
        if ($bonus['game_restrictions'] === 'All games') {
            $score += 10;
        } elseif ($bonus['game_restrictions'] === 'Slots only') {
            $score += 5;
        }

        return round($score, 1);
    }

    /**
     * Get detailed bonus analysis for specific casino
     */
    public function getBonusAnalysis($casinoId)
    {
        $bonus = null;
        foreach ($this->bonuses as $b) {
            if ($b['casino_id'] === $casinoId) {
                $bonus = $b;
                break;
            }
        }

        if (!$bonus) {
            return null;
        }

        $enriched = $this->enrichBonusData($bonus);
        
        return [
            'bonus' => $enriched,
            'analysis' => [
                'strengths' => $this->analyzeBonusStrengths($enriched),
                'weaknesses' => $this->analyzeBonusWeaknesses($enriched),
                'best_for' => $this->determineBestFor($enriched),
                'value_calculation' => $this->calculateTrueValue($enriched),
                'recommendation' => $this->generateRecommendation($enriched)
            ]
        ];
    }

    /**
     * Get bonus comparison table data
     */
    public function getBonusComparisonTable($casinoIds = null)
    {
        $bonuses = $this->bonuses;
        
        if ($casinoIds) {
            $bonuses = array_filter($bonuses, function($bonus) use ($casinoIds) {
                return in_array($bonus['casino_id'], $casinoIds);
            });
        }

        $table = [
            'headers' => [
                'Casino',
                'Welcome Bonus',
                'Free Spins',
                'Wagering Req.',
                'Game Restrictions',
                'Time Limit',
                'Min Deposit',
                'Bonus Score',
                'Action'
            ],
            'rows' => []
        ];

        foreach ($bonuses as $bonus) {
            $enriched = $this->enrichBonusData($bonus);
            $table['rows'][] = [
                'casino_name' => $bonus['casino_name'],
                'casino_id' => $bonus['casino_id'],
                'welcome_bonus' => $this->formatWelcomeBonus($bonus),
                'free_spins' => $bonus['free_spins'] > 0 ? $bonus['free_spins'] . ' spins' : 'No',
                'wagering_requirement' => $bonus['wagering_requirement'] . 'x',
                'game_restrictions' => $bonus['game_restrictions'],
                'time_limit' => $bonus['time_limit'],
                'min_deposit' => '$' . $bonus['min_deposit'],
                'bonus_score' => $enriched['bonus_score'],
                'bonus_rank' => $enriched['bonus_rank'],
                'cta_text' => 'Claim Bonus',
                'affiliate_link' => $bonus['affiliate_link'] ?? '#'
            ];
        }

        // Sort by bonus score
        usort($table['rows'], function($a, $b) {
            return $b['bonus_score'] <=> $a['bonus_score'];
        });

        return $table;
    }

    /**
     * Get available filter options
     */
    public function getFilterOptions()
    {
        return [
            'bonus_amount' => [
                'label' => 'Bonus Amount',
                'options' => [
                    '500-1000' => '$500 - $1,000',
                    '1000-1500' => '$1,000 - $1,500',
                    '1500-2000' => '$1,500 - $2,000',
                    '2000+' => '$2,000+'
                ]
            ],
            'wagering_requirement' => [
                'label' => 'Wagering Requirement',
                'options' => [
                    '20x-below' => '20x or below',
                    '20x-35x' => '20x - 35x',
                    '35x-50x' => '35x - 50x',
                    '50x-above' => '50x or above'
                ]
            ],
            'free_spins' => [
                'label' => 'Free Spins',
                'options' => [
                    'no-spins' => 'No Free Spins',
                    '1-100' => '1 - 100 spins',
                    '100-200' => '100 - 200 spins',
                    '200+' => '200+ spins'
                ]
            ],
            'game_restrictions' => [
                'label' => 'Game Restrictions',
                'options' => [
                    'all-games' => 'All Games',
                    'slots-only' => 'Slots Only',
                    'table-games' => 'Table Games Included',
                    'live-casino' => 'Live Casino Included'
                ]
            ],
            'time_limit' => [
                'label' => 'Time Limit',
                'options' => [
                    '7-days' => '7 days or less',
                    '14-days' => '8 - 14 days',
                    '30-days' => '15 - 30 days',
                    '30-plus' => 'More than 30 days'
                ]
            ]
        ];
    }

    /**
     * Initialize bonus database
     */
    private function initializeBonuses()
    {
        $this->bonuses = [
            [
                'casino_id' => 1,
                'casino_name' => 'Spin Casino',
                'welcome_amount' => 1000,
                'welcome_percentage' => 100,
                'free_spins' => 150,
                'wagering_requirement' => 35,
                'game_restrictions' => 'Slots and scratch cards',
                'time_limit' => '30 days',
                'min_deposit' => 10,
                'max_cashout' => null,
                'bonus_code' => 'WELCOME100',
                'terms_highlights' => [
                    'Welcome bonus split across first 3 deposits',
                    'Free spins on Starburst and Book of Dead',
                    '18+ only, T&Cs apply'
                ],
                'affiliate_link' => 'https://example.com/spin-casino'
            ],
            [
                'casino_id' => 2,
                'casino_name' => 'Royal Vegas',
                'welcome_amount' => 1200,
                'welcome_percentage' => 100,
                'free_spins' => 120,
                'wagering_requirement' => 30,
                'game_restrictions' => 'All games',
                'time_limit' => '21 days',
                'min_deposit' => 20,
                'max_cashout' => null,
                'bonus_code' => 'ROYAL120',
                'terms_highlights' => [
                    'Bonus available on all games',
                    'Lower wagering requirement',
                    'Established brand with excellent reputation'
                ],
                'affiliate_link' => 'https://example.com/royal-vegas'
            ],
            [
                'casino_id' => 3,
                'casino_name' => 'BitStarz',
                'welcome_amount' => 5000,
                'welcome_percentage' => 100,
                'free_spins' => 180,
                'wagering_requirement' => 40,
                'game_restrictions' => 'Slots only',
                'time_limit' => '14 days',
                'min_deposit' => 20,
                'max_cashout' => null,
                'bonus_code' => 'BITSTARZ',
                'terms_highlights' => [
                    'Massive welcome package',
                    'Crypto payments accepted',
                    'Instant withdrawals with crypto'
                ],
                'affiliate_link' => 'https://example.com/bitstarz'
            ],
            [
                'casino_id' => 4,
                'casino_name' => 'Jackpot City',
                'welcome_amount' => 1600,
                'welcome_percentage' => 100,
                'free_spins' => 100,
                'wagering_requirement' => 35,
                'game_restrictions' => 'Slots and parlour games',
                'time_limit' => '30 days',
                'min_deposit' => 10,
                'max_cashout' => null,
                'bonus_code' => 'JACKPOT',
                'terms_highlights' => [
                    'Welcome package up to $1,600',
                    'Trusted brand since 1998',
                    'Excellent customer support'
                ],
                'affiliate_link' => 'https://example.com/jackpot-city'
            ],
            [
                'casino_id' => 5,
                'casino_name' => 'PlayOJO',
                'welcome_amount' => 0,
                'welcome_percentage' => 0,
                'free_spins' => 50,
                'wagering_requirement' => 0,
                'game_restrictions' => 'Selected slots',
                'time_limit' => 'No limit',
                'min_deposit' => 10,
                'max_cashout' => null,
                'bonus_code' => 'OJOWELCOME',
                'terms_highlights' => [
                    'No wagering requirements on free spins',
                    'Fair and transparent bonuses',
                    'OJOplus rewards on every spin'
                ],
                'affiliate_link' => 'https://example.com/playojo'
            ],
            [
                'casino_id' => 6,
                'casino_name' => 'FortuneJack',
                'welcome_amount' => 6000,
                'welcome_percentage' => 110,
                'free_spins' => 250,
                'wagering_requirement' => 40,
                'game_restrictions' => 'All games',
                'time_limit' => '21 days',
                'min_deposit' => 20,
                'max_cashout' => null,
                'bonus_code' => 'FORTUNE110',
                'terms_highlights' => [
                    'Highest percentage bonus at 110%',
                    'Bitcoin and crypto friendly',
                    'Generous welcome package'
                ],
                'affiliate_link' => 'https://example.com/fortunejack'
            ],
            [
                'casino_id' => 7,
                'casino_name' => 'Casino Gods',
                'welcome_amount' => 1500,
                'welcome_percentage' => 100,
                'free_spins' => 300,
                'wagering_requirement' => 35,
                'game_restrictions' => 'Slots only',
                'time_limit' => '30 days',
                'min_deposit' => 20,
                'max_cashout' => null,
                'bonus_code' => 'GODS300',
                'terms_highlights' => [
                    'Massive 300 free spins',
                    'New casino with modern features',
                    'Mobile optimized platform'
                ],
                'affiliate_link' => 'https://example.com/casino-gods'
            ],
            [
                'casino_id' => 8,
                'casino_name' => 'LeoVegas',
                'welcome_amount' => 1000,
                'welcome_percentage' => 100,
                'free_spins' => 200,
                'wagering_requirement' => 35,
                'game_restrictions' => 'Slots only',
                'time_limit' => '30 days',
                'min_deposit' => 10,
                'max_cashout' => null,
                'bonus_code' => 'LEO200',
                'terms_highlights' => [
                    'Award-winning mobile casino',
                    'Fast payouts and excellent support',
                    'Huge selection of games'
                ],
                'affiliate_link' => 'https://example.com/leovegas'
            ],
            [
                'casino_id' => 9,
                'casino_name' => 'Casumo',
                'welcome_amount' => 1200,
                'welcome_percentage' => 100,
                'free_spins' => 200,
                'wagering_requirement' => 30,
                'game_restrictions' => 'Slots only',
                'time_limit' => '30 days',
                'min_deposit' => 20,
                'max_cashout' => null,
                'bonus_code' => 'CASUMO200',
                'terms_highlights' => [
                    'Gamified casino experience',
                    'Regular promotions and rewards',
                    'Innovative adventure concept'
                ],
                'affiliate_link' => 'https://example.com/casumo'
            ],
            [
                'casino_id' => 10,
                'casino_name' => 'Cloudbet',
                'welcome_amount' => 5000,
                'welcome_percentage' => 100,
                'free_spins' => 0,
                'wagering_requirement' => 40,
                'game_restrictions' => 'All games',
                'time_limit' => '14 days',
                'min_deposit' => 20,
                'max_cashout' => null,
                'bonus_code' => 'CLOUDBET',
                'terms_highlights' => [
                    'Bitcoin and crypto specialist',
                    'Anonymous gaming available',
                    'Sportsbook and casino combined'
                ],
                'affiliate_link' => 'https://example.com/cloudbet'
            ]
        ];
    }

    /**
     * Initialize comparison criteria
     */
    private function initializeComparisonCriteria()
    {
        $this->comparisonCriteria = [
            'bonus_value' => 'Overall Bonus Value',
            'welcome_amount' => 'Welcome Amount',
            'free_spins' => 'Free Spins',
            'wagering_requirement' => 'Wagering Requirement',
            'time_limit' => 'Time Limit',
            'game_restrictions' => 'Game Restrictions'
        ];
    }

    /**
     * Apply filters to bonus list
     */
    private function applyFilters($bonuses, $filters)
    {
        foreach ($filters as $filterType => $filterValue) {
            switch ($filterType) {
                case 'bonus_amount':
                    $bonuses = array_filter($bonuses, function($bonus) use ($filterValue) {
                        return $this->matchesBonusAmountFilter($bonus, $filterValue);
                    });
                    break;
                case 'wagering_requirement':
                    $bonuses = array_filter($bonuses, function($bonus) use ($filterValue) {
                        return $this->matchesWageringFilter($bonus, $filterValue);
                    });
                    break;
                case 'free_spins':
                    $bonuses = array_filter($bonuses, function($bonus) use ($filterValue) {
                        return $this->matchesFreeSpinsFilter($bonus, $filterValue);
                    });
                    break;
                case 'game_restrictions':
                    $bonuses = array_filter($bonuses, function($bonus) use ($filterValue) {
                        return $this->matchesGameRestrictionsFilter($bonus, $filterValue);
                    });
                    break;
            }
        }
        
        return $bonuses;
    }

    /**
     * Sort bonuses by criteria
     */
    private function sortBonuses($bonuses, $sort)
    {
        switch ($sort) {
            case 'bonus_value':
                usort($bonuses, function($a, $b) {
                    $scoreA = $this->calculateBonusScore($a);
                    $scoreB = $this->calculateBonusScore($b);
                    return $scoreB <=> $scoreA;
                });
                break;
            case 'welcome_amount':
                usort($bonuses, function($a, $b) {
                    return $b['welcome_amount'] <=> $a['welcome_amount'];
                });
                break;
            case 'wagering_requirement':
                usort($bonuses, function($a, $b) {
                    return $a['wagering_requirement'] <=> $b['wagering_requirement'];
                });
                break;
            case 'free_spins':
                usort($bonuses, function($a, $b) {
                    return $b['free_spins'] <=> $a['free_spins'];
                });
                break;
        }
        
        return $bonuses;
    }

    /**
     * Enrich bonus data with calculated values
     */
    private function enrichBonusData($bonus)
    {
        $enriched = $bonus;
        $enriched['bonus_score'] = $this->calculateBonusScore($bonus);
        $enriched['bonus_rank'] = $this->getBonusRank($enriched['bonus_score']);
        $enriched['true_value'] = $this->calculateTrueValue($bonus);
        $enriched['formatted_welcome'] = $this->formatWelcomeBonus($bonus);
        
        return $enriched;
    }

    /**
     * Get bonus rank based on score
     */
    private function getBonusRank($score)
    {
        if ($score >= 80) return 'Excellent';
        if ($score >= 70) return 'Very Good';
        if ($score >= 60) return 'Good';
        if ($score >= 50) return 'Fair';
        return 'Poor';
    }

    /**
     * Calculate true bonus value considering wagering
     */
    private function calculateTrueValue($bonus)
    {
        $baseValue = $bonus['welcome_amount'];
        $wageringPenalty = ($bonus['wagering_requirement'] - 20) * 0.02;
        $trueValue = $baseValue * (1 - $wageringPenalty);
        
        return max(0, round($trueValue, 2));
    }

    /**
     * Format welcome bonus display
     */
    private function formatWelcomeBonus($bonus)
    {
        if ($bonus['welcome_amount'] > 0) {
            return $bonus['welcome_percentage'] . '% up to $' . number_format($bonus['welcome_amount']);
        }
        return 'No deposit bonus';
    }

    /**
     * Parse time limit to days
     */
    private function parseTimeLimitDays($timeLimit)
    {
        if (stripos($timeLimit, 'no limit') !== false) {
            return 365; // Treat as 1 year
        }
        
        preg_match('/(\d+)/', $timeLimit, $matches);
        return isset($matches[1]) ? (int)$matches[1] : 30;
    }

    /**
     * Analyze bonus strengths
     */
    private function analyzeBonusStrengths($bonus)
    {
        $strengths = [];
        
        if ($bonus['welcome_amount'] >= 1500) {
            $strengths[] = 'High welcome bonus amount';
        }
        
        if ($bonus['wagering_requirement'] <= 30) {
            $strengths[] = 'Low wagering requirements';
        }
        
        if ($bonus['free_spins'] >= 150) {
            $strengths[] = 'Generous free spins offer';
        }
        
        if (stripos($bonus['game_restrictions'], 'all games') !== false) {
            $strengths[] = 'Bonus valid on all games';
        }
        
        return $strengths;
    }

    /**
     * Analyze bonus weaknesses
     */
    private function analyzeBonusWeaknesses($bonus)
    {
        $weaknesses = [];
        
        if ($bonus['wagering_requirement'] >= 40) {
            $weaknesses[] = 'High wagering requirements';
        }
        
        if ($this->parseTimeLimitDays($bonus['time_limit']) <= 14) {
            $weaknesses[] = 'Short time limit to complete';
        }
        
        if (stripos($bonus['game_restrictions'], 'slots only') !== false) {
            $weaknesses[] = 'Limited to slots games only';
        }
        
        return $weaknesses;
    }

    /**
     * Determine what player type bonus is best for
     */
    private function determineBestFor($bonus)
    {
        $bestFor = [];
        
        if ($bonus['welcome_amount'] >= 2000) {
            $bestFor[] = 'High roller players';
        }
        
        if ($bonus['wagering_requirement'] <= 30) {
            $bestFor[] = 'Casual players';
        }
        
        if ($bonus['free_spins'] >= 200) {
            $bestFor[] = 'Slot enthusiasts';
        }
        
        if (stripos($bonus['game_restrictions'], 'all games') !== false) {
            $bestFor[] = 'Table game players';
        }
        
        return $bestFor;
    }

    /**
     * Generate bonus recommendation
     */
    private function generateRecommendation($bonus)
    {
        $score = $bonus['bonus_score'];
        
        if ($score >= 80) {
            return 'Highly recommended - Excellent overall value with favorable terms.';
        } elseif ($score >= 70) {
            return 'Recommended - Very good bonus with reasonable terms.';
        } elseif ($score >= 60) {
            return 'Worth considering - Good bonus with some restrictions.';
        } elseif ($score >= 50) {
            return 'Average bonus - Compare carefully with alternatives.';
        } else {
            return 'Not recommended - Better bonuses available elsewhere.';
        }
    }

    /**
     * Filter matching methods
     */
    private function matchesBonusAmountFilter($bonus, $filter)
    {
        $amount = $bonus['welcome_amount'];
        switch ($filter) {
            case '500-1000': return $amount >= 500 && $amount <= 1000;
            case '1000-1500': return $amount >= 1000 && $amount <= 1500;
            case '1500-2000': return $amount >= 1500 && $amount <= 2000;
            case '2000+': return $amount >= 2000;
            default: return true;
        }
    }

    private function matchesWageringFilter($bonus, $filter)
    {
        $wagering = $bonus['wagering_requirement'];
        switch ($filter) {
            case '20x-below': return $wagering <= 20;
            case '20x-35x': return $wagering >= 20 && $wagering <= 35;
            case '35x-50x': return $wagering >= 35 && $wagering <= 50;
            case '50x-above': return $wagering >= 50;
            default: return true;
        }
    }

    private function matchesFreeSpinsFilter($bonus, $filter)
    {
        $spins = $bonus['free_spins'];
        switch ($filter) {
            case 'no-spins': return $spins == 0;
            case '1-100': return $spins >= 1 && $spins <= 100;
            case '100-200': return $spins >= 100 && $spins <= 200;
            case '200+': return $spins >= 200;
            default: return true;
        }
    }

    private function matchesGameRestrictionsFilter($bonus, $filter)
    {
        $restrictions = strtolower($bonus['game_restrictions']);
        switch ($filter) {
            case 'all-games': return stripos($restrictions, 'all games') !== false;
            case 'slots-only': return stripos($restrictions, 'slots only') !== false;
            case 'table-games': return stripos($restrictions, 'table') !== false;
            case 'live-casino': return stripos($restrictions, 'live') !== false;
            default: return true;
        }
    }
}
