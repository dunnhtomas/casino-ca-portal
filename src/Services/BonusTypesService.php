<?php

namespace App\Services;

/**
 * BonusTypesService
 * 
 * Comprehensive service for managing casino bonus types, calculations,
 * and educational content for Canadian players.
 * 
 * @package App\Services
 * @version 2.0.0
 * @since 2025-01-20
 */
class BonusTypesService
{
    /**
     * Get all bonus types with comprehensive details
     * 
     * @return array Array of bonus types with details, pros, cons, and examples
     */
    public function getBonusTypes(): array
    {
        return [
            'welcome_bonus' => [
                'id' => 1,
                'name' => 'Welcome Bonus',
                'description' => 'A match bonus offered to new players on their first deposit, typically ranging from 50% to 200% of the deposit amount.',
                'typical_percentage' => 100,
                'average_wagering' => 35,
                'risk_level' => 'medium',
                'icon' => 'welcome-bonus.svg',
                'pros' => [
                    'Doubles your initial bankroll',
                    'Extended playtime and entertainment',
                    'Great value for first-time players',
                    'Usually includes free spins'
                ],
                'cons' => [
                    'Higher wagering requirements',
                    'Limited time to clear bonus',
                    'Maximum bet restrictions apply',
                    'Some games may be excluded'
                ],
                'strategy_tips' => 'Best for new players who plan to play regularly. Calculate the total wagering requirement before claiming. Focus on high RTP slots to maximize clearing potential.',
                'example_offers' => [
                    'LeoVegas: 100% up to $1,000 + 200 free spins',
                    'Spin Casino: 100% up to $400 + 200 free spins',
                    'Royal Vegas: 100% up to $1,200 + 120 free spins'
                ],
                'player_type_suitability' => [
                    'beginner' => 9,
                    'casual' => 8,
                    'strategic' => 7,
                    'high_roller' => 6
                ],
                'canadian_specifics' => [
                    'Must verify Canadian residency',
                    'Some provinces may have restrictions',
                    'CAD currency typically supported'
                ]
            ],
            'no_deposit_bonus' => [
                'id' => 2,
                'name' => 'No Deposit Bonus',
                'description' => 'Free money or spins given to new players without requiring a deposit, typically $10-$50 in value.',
                'typical_percentage' => 0,
                'average_wagering' => 50,
                'risk_level' => 'low',
                'icon' => 'no-deposit-bonus.svg',
                'pros' => [
                    'No financial risk required',
                    'Try casino games for free',
                    'Keep winnings if you clear wagering',
                    'Perfect for testing new casinos'
                ],
                'cons' => [
                    'Very high wagering requirements',
                    'Low maximum cashout limits',
                    'Limited game selection',
                    'Strict terms and conditions'
                ],
                'strategy_tips' => 'Ideal for testing new casinos without risk. Read maximum cashout limits carefully. Use on high RTP games only. Don\'t deposit until you\'ve tried the free bonus.',
                'example_offers' => [
                    'Jackpot City: $25 no deposit bonus',
                    '888 Casino: $20 no deposit + 20 free spins',
                    'Ruby Fortune: $30 no deposit bonus'
                ],
                'player_type_suitability' => [
                    'beginner' => 10,
                    'casual' => 9,
                    'strategic' => 6,
                    'high_roller' => 3
                ],
                'canadian_specifics' => [
                    'Verification required before cashout',
                    'Maximum win limits often apply',
                    'May require promo code'
                ]
            ],
            'free_spins' => [
                'id' => 3,
                'name' => 'Free Spins Bonus',
                'description' => 'Complimentary spins on specific slot games, typically 20-200 spins with predetermined bet values.',
                'typical_percentage' => 0,
                'average_wagering' => 35,
                'risk_level' => 'low',
                'icon' => 'free-spins-bonus.svg',
                'pros' => [
                    'Try popular slot games for free',
                    'No deposit usually required',
                    'Winnings can be substantial',
                    'Low risk entertainment'
                ],
                'cons' => [
                    'Limited to specific games',
                    'Low spin values typically',
                    'Wagering on winnings required',
                    'Time limits for usage'
                ],
                'strategy_tips' => 'Use immediately to avoid expiration. Check which games offer the best RTP. Calculate potential winnings vs. wagering requirements. Save high-value spins for peak playing times.',
                'example_offers' => [
                    'Casumo: 200 free spins on Starburst',
                    'Mr Green: 100 free spins on Book of Dead',
                    'PlayOJO: 80 free spins no wagering'
                ],
                'player_type_suitability' => [
                    'beginner' => 9,
                    'casual' => 10,
                    'strategic' => 7,
                    'high_roller' => 5
                ],
                'canadian_specifics' => [
                    'Popular Canadian slot themes',
                    'CAD currency for winnings',
                    'Province-specific game availability'
                ]
            ],
            'cashback_bonus' => [
                'id' => 4,
                'name' => 'Cashback Bonus',
                'description' => 'Percentage of losses returned to players, typically 5-25% of net losses over a specific period.',
                'typical_percentage' => 10,
                'average_wagering' => 10,
                'risk_level' => 'low',
                'icon' => 'cashback-bonus.svg',
                'pros' => [
                    'Reduces overall gambling losses',
                    'Usually low wagering requirements',
                    'Ongoing protection for regular players',
                    'No maximum bet restrictions typically'
                ],
                'cons' => [
                    'Only applies to net losses',
                    'Lower percentage than other bonuses',
                    'May have minimum loss thresholds',
                    'Weekly or monthly calculation periods'
                ],
                'strategy_tips' => 'Perfect for high-volume players. Combine with other promotions for maximum value. Track your losses to ensure accurate calculations. Ideal for table game players.',
                'example_offers' => [
                    'Betway: 10% weekly cashback up to $300',
                    'Unibet: 15% weekend cashback',
                    'William Hill: 25% live casino cashback'
                ],
                'player_type_suitability' => [
                    'beginner' => 6,
                    'casual' => 7,
                    'strategic' => 9,
                    'high_roller' => 10
                ],
                'canadian_specifics' => [
                    'Calculated in Canadian dollars',
                    'Weekly payment schedules common',
                    'VIP programs often included'
                ]
            ],
            'reload_bonus' => [
                'id' => 5,
                'name' => 'Reload Bonus',
                'description' => 'Ongoing deposit bonuses for existing players, typically 25-75% match bonuses on subsequent deposits.',
                'typical_percentage' => 50,
                'average_wagering' => 30,
                'risk_level' => 'medium',
                'icon' => 'reload-bonus.svg',
                'pros' => [
                    'Regular bonus opportunities',
                    'Keeps your bankroll topped up',
                    'Often combined with free spins',
                    'Loyalty reward for regular players'
                ],
                'cons' => [
                    'Lower percentages than welcome bonuses',
                    'Minimum deposit requirements',
                    'Standard wagering requirements',
                    'Limited frequency (weekly/monthly)'
                ],
                'strategy_tips' => 'Time your deposits with reload offers. Calculate if the bonus value exceeds the wagering cost. Best for players who deposit regularly anyway.',
                'example_offers' => [
                    'Spin Palace: 50% Tuesday reload up to $250',
                    'Casino Classic: 25% weekend reload',
                    'Gaming Club: 75% Friday reload up to $150'
                ],
                'player_type_suitability' => [
                    'beginner' => 6,
                    'casual' => 8,
                    'strategic' => 9,
                    'high_roller' => 8
                ],
                'canadian_specifics' => [
                    'Often linked to Canadian holidays',
                    'Email notification systems',
                    'Promo codes frequently required'
                ]
            ],
            'vip_loyalty' => [
                'id' => 6,
                'name' => 'VIP & Loyalty Bonus',
                'description' => 'Tier-based rewards system offering exclusive bonuses, higher limits, and personalized service for high-value players.',
                'typical_percentage' => 75,
                'average_wagering' => 25,
                'risk_level' => 'low',
                'icon' => 'vip-loyalty-bonus.svg',
                'pros' => [
                    'Exclusive bonus offers',
                    'Personal account managers',
                    'Higher withdrawal limits',
                    'Priority customer support',
                    'Special event invitations'
                ],
                'cons' => [
                    'High deposit requirements to qualify',
                    'Complex tier progression systems',
                    'Benefits may not justify spending',
                    'Terms can change without notice'
                ],
                'strategy_tips' => 'Calculate total spending vs. benefits received. Focus on casinos with transparent VIP terms. Negotiate better terms once you reach higher tiers.',
                'example_offers' => [
                    'Royal Vegas VIP: Up to 100% bonuses + exclusive tournaments',
                    'Luxury Casino Elite: Personal host + custom bonuses',
                    'Captain Cooks Platinum: 75% bonuses + monthly cashback'
                ],
                'player_type_suitability' => [
                    'beginner' => 2,
                    'casual' => 4,
                    'strategic' => 8,
                    'high_roller' => 10
                ],
                'canadian_specifics' => [
                    'Canadian-hosted VIP events',
                    'CAD-optimized payment methods',
                    'Dedicated Canadian support'
                ]
            ]
        ];
    }

    /**
     * Calculate real bonus value with comprehensive metrics
     * 
     * @param float $deposit Deposit amount
     * @param array $terms Bonus terms (percentage, wagering, max_bet, time_limit)
     * @return array Calculated bonus metrics
     */
    public function calculateBonusValue(float $deposit, array $terms): array
    {
        // Input validation
        if ($deposit <= 0) {
            throw new \InvalidArgumentException('Deposit amount must be positive');
        }

        $percentage = $terms['percentage'] ?? 100;
        $wagering = $terms['wagering'] ?? 35;
        $maxBet = $terms['max_bet'] ?? 5.0;
        $timeLimit = $terms['time_limit'] ?? 30; // days
        $gameContribution = $terms['game_contribution'] ?? 100; // percentage
        $maxCashout = $terms['max_cashout'] ?? null;

        // Calculate bonus amount
        $bonusAmount = ($deposit * $percentage) / 100;
        $totalFunds = $deposit + $bonusAmount;

        // Calculate wagering requirement
        $wageringRequired = $bonusAmount * $wagering;
        $effectiveWagering = $wageringRequired / ($gameContribution / 100);

        // Estimate time to clear bonus (assuming $maxBet per spin, 3 seconds per spin)
        $spinsRequired = $effectiveWagering / $maxBet;
        $timeRequired = ($spinsRequired * 3) / 3600; // hours
        $daysRequired = ceil($timeRequired / 4); // 4 hours playing per day

        // Calculate expected value (assuming 96% RTP)
        $expectedLoss = $effectiveWagering * 0.04; // 4% house edge
        $realValue = $bonusAmount - $expectedLoss;
        $valuePercentage = ($realValue / $bonusAmount) * 100;

        // Risk assessment
        $riskFactors = [];
        $riskScore = 0;

        if ($wagering > 40) {
            $riskFactors[] = 'High wagering requirement';
            $riskScore += 3;
        }
        if ($timeLimit < 14) {
            $riskFactors[] = 'Short time limit';
            $riskScore += 2;
        }
        if ($maxBet < 2) {
            $riskFactors[] = 'Low maximum bet';
            $riskScore += 1;
        }
        if ($gameContribution < 100) {
            $riskFactors[] = 'Limited game contribution';
            $riskScore += 2;
        }

        $riskLevel = $riskScore <= 2 ? 'Low' : ($riskScore <= 5 ? 'Medium' : 'High');

        return [
            'deposit_amount' => $deposit,
            'bonus_amount' => round($bonusAmount, 2),
            'total_funds' => round($totalFunds, 2),
            'wagering_required' => round($wageringRequired, 2),
            'effective_wagering' => round($effectiveWagering, 2),
            'spins_required' => round($spinsRequired),
            'estimated_hours' => round($timeRequired, 1),
            'estimated_days' => $daysRequired,
            'expected_loss' => round($expectedLoss, 2),
            'real_value' => round($realValue, 2),
            'value_percentage' => round($valuePercentage, 1),
            'risk_level' => $riskLevel,
            'risk_score' => $riskScore,
            'risk_factors' => $riskFactors,
            'max_cashout' => $maxCashout,
            'recommendation' => $this->getRecommendation($valuePercentage, $riskScore, $daysRequired)
        ];
    }

    /**
     * Get strategic recommendations for different player types
     * 
     * @return array Player type recommendations
     */
    public function getBonusStrategies(): array
    {
        return [
            'beginner' => [
                'title' => 'New Player Strategy',
                'description' => 'Focus on learning and safe bonus value',
                'recommended_bonuses' => ['no_deposit_bonus', 'free_spins', 'welcome_bonus'],
                'tips' => [
                    'Start with no deposit bonuses to learn without risk',
                    'Choose bonuses with wagering requirements under 35x',
                    'Avoid high-risk bonuses until you understand the games',
                    'Read all terms and conditions carefully',
                    'Set strict loss limits before playing'
                ],
                'avoid' => [
                    'Complex VIP bonuses',
                    'High wagering requirement offers (50x+)',
                    'Table game specific bonuses',
                    'Time-pressured promotions'
                ]
            ],
            'casual' => [
                'title' => 'Casual Player Strategy',
                'description' => 'Balance entertainment value with reasonable terms',
                'recommended_bonuses' => ['welcome_bonus', 'free_spins', 'reload_bonus'],
                'tips' => [
                    'Look for bonuses with 30-40x wagering requirements',
                    'Combine welcome bonus with free spins offers',
                    'Use reload bonuses to extend entertainment time',
                    'Choose games you enjoy, not just high RTP',
                    'Take advantage of weekend promotions'
                ],
                'avoid' => [
                    'Daily bonus hunting',
                    'Extremely high value bonuses with strict terms',
                    'Bonuses requiring large deposits',
                    'Competition-based promotions'
                ]
            ],
            'strategic' => [
                'title' => 'Strategic Player Approach',
                'description' => 'Maximize expected value through careful calculation',
                'recommended_bonuses' => ['cashback_bonus', 'reload_bonus', 'vip_loyalty'],
                'tips' => [
                    'Calculate expected value before claiming any bonus',
                    'Focus on high RTP games (97%+ for slots)',
                    'Track your bonus clearing success rate',
                    'Use cashback bonuses to minimize losses',
                    'Negotiate better VIP terms once qualified'
                ],
                'avoid' => [
                    'Bonuses with negative expected value',
                    'Time-pressured clearing requirements',
                    'Bonuses restricted to low RTP games',
                    'Promotional bonuses without clear terms'
                ]
            ],
            'high_roller' => [
                'title' => 'High Roller Optimization',
                'description' => 'Focus on VIP treatment and substantial bonus amounts',
                'recommended_bonuses' => ['vip_loyalty', 'cashback_bonus', 'welcome_bonus'],
                'tips' => [
                    'Negotiate custom bonus terms with VIP hosts',
                    'Focus on cashback for loss protection',
                    'Leverage high deposit amounts for better percentages',
                    'Demand faster withdrawal processing',
                    'Seek exclusive tournament invitations'
                ],
                'avoid' => [
                    'Standard promotional offers',
                    'Bonuses with low maximum amounts',
                    'Restricted withdrawal limits',
                    'Casinos without dedicated VIP support'
                ]
            ]
        ];
    }

    /**
     * Get comprehensive terms and conditions explanations
     * 
     * @return array Terms explanations in simple language
     */
    public function getTermsExplanations(): array
    {
        return [
            'wagering_requirements' => [
                'term' => 'Wagering Requirements',
                'technical_definition' => 'The amount you must wager before bonus funds become withdrawable, expressed as a multiplier (e.g., 35x)',
                'simple_explanation' => 'How much you need to bet before you can cash out your bonus winnings',
                'example_scenario' => 'With a $100 bonus and 35x wagering, you must bet $3,500 total before cashing out',
                'impact_rating' => 5,
                'warning_level' => 'high',
                'what_this_means' => 'Higher numbers mean it\'s harder to keep your winnings'
            ],
            'game_contribution' => [
                'term' => 'Game Contribution Rates',
                'technical_definition' => 'The percentage of each bet that counts toward wagering requirements, varying by game type',
                'simple_explanation' => 'Not all games count equally toward clearing your bonus',
                'example_scenario' => 'Slots count 100%, but blackjack might only count 10% of each bet',
                'impact_rating' => 4,
                'warning_level' => 'medium',
                'what_this_means' => 'Stick to slots if you want to clear bonuses faster'
            ],
            'maximum_bet' => [
                'term' => 'Maximum Bet Restrictions',
                'technical_definition' => 'The highest amount you can bet per spin or hand while playing with bonus funds',
                'simple_explanation' => 'You can\'t bet more than a certain amount while using bonus money',
                'example_scenario' => 'With a $5 max bet rule, you can\'t spin for more than $5 even if you want to',
                'impact_rating' => 3,
                'warning_level' => 'medium',
                'what_this_means' => 'Limits your ability to make big bets and win big quickly'
            ],
            'time_limits' => [
                'term' => 'Time Limits',
                'technical_definition' => 'The period within which you must use your bonus and complete wagering requirements',
                'simple_explanation' => 'How long you have to use your bonus before it expires',
                'example_scenario' => 'A 7-day limit means you lose the bonus if you don\'t clear it within a week',
                'impact_rating' => 4,
                'warning_level' => 'high',
                'what_this_means' => 'You need to play regularly to avoid losing your bonus'
            ],
            'withdrawal_restrictions' => [
                'term' => 'Withdrawal Restrictions',
                'technical_definition' => 'Limitations on when and how much you can withdraw from bonus-related winnings',
                'simple_explanation' => 'Rules about taking your money out after using a bonus',
                'example_scenario' => 'Maximum cashout of $500 means you can\'t withdraw more than $500 from bonus winnings',
                'impact_rating' => 4,
                'warning_level' => 'high',
                'what_this_means' => 'Your potential winnings might be capped regardless of how much you win'
            ],
            'excluded_games' => [
                'term' => 'Excluded Games',
                'technical_definition' => 'Games that cannot be played with bonus funds or don\'t contribute to wagering requirements',
                'simple_explanation' => 'Some games are off-limits when you have bonus money',
                'example_scenario' => 'Live dealer games might be excluded, so you can only play slots and certain table games',
                'impact_rating' => 3,
                'warning_level' => 'medium',
                'what_this_means' => 'Your game choices are limited while clearing the bonus'
            ],
            'minimum_deposit' => [
                'term' => 'Minimum Deposit',
                'technical_definition' => 'The smallest amount you must deposit to qualify for a bonus offer',
                'simple_explanation' => 'How much you need to deposit to get the bonus',
                'example_scenario' => 'A $20 minimum deposit means you need to put in at least $20 to get the welcome bonus',
                'impact_rating' => 2,
                'warning_level' => 'low',
                'what_this_means' => 'Sets the entry cost for accessing the bonus offer'
            ],
            'sticky_vs_non_sticky' => [
                'term' => 'Sticky vs Non-Sticky Bonuses',
                'technical_definition' => 'Whether the bonus amount is removed (sticky) or retained (non-sticky) when you cash out',
                'simple_explanation' => 'Whether you keep the bonus money when you withdraw',
                'example_scenario' => 'With a sticky $100 bonus, you lose the $100 when cashing out; non-sticky lets you keep it',
                'impact_rating' => 4,
                'warning_level' => 'medium',
                'what_this_means' => 'Non-sticky bonuses are much more valuable than sticky ones'
            ]
        ];
    }

    /**
     * Get personalized recommendation based on calculated values
     * 
     * @param float $valuePercentage Expected value percentage
     * @param int $riskScore Risk assessment score
     * @param int $daysRequired Days needed to clear bonus
     * @return string Recommendation text
     */
    private function getRecommendation(float $valuePercentage, int $riskScore, int $daysRequired): string
    {
        if ($valuePercentage > 70 && $riskScore <= 2) {
            return "Excellent bonus! High value with low risk. Highly recommended.";
        } elseif ($valuePercentage > 50 && $riskScore <= 4) {
            return "Good bonus offer. Reasonable value with manageable risk.";
        } elseif ($valuePercentage > 30 && $daysRequired <= 14) {
            return "Fair bonus. Consider if you have time to clear requirements.";
        } elseif ($riskScore >= 6) {
            return "High-risk bonus. Only for experienced players who understand the terms.";
        } elseif ($daysRequired > 21) {
            return "Time-intensive bonus. Ensure you can play regularly before claiming.";
        } else {
            return "Below-average bonus. Consider other offers or skip this one.";
        }
    }

    /**
     * Get bonus comparison data for multiple offers
     * 
     * @param array $bonuses Array of bonus offers to compare
     * @return array Comparison results with rankings
     */
    public function compareBonuses(array $bonuses): array
    {
        $comparisons = [];
        
        foreach ($bonuses as $index => $bonus) {
            $calculation = $this->calculateBonusValue($bonus['deposit'], $bonus['terms']);
            $comparisons[$index] = array_merge($bonus, $calculation);
        }

        // Sort by real value descending
        usort($comparisons, function($a, $b) {
            return $b['real_value'] <=> $a['real_value'];
        });

        // Add rankings
        foreach ($comparisons as $index => &$comparison) {
            $comparison['rank'] = $index + 1;
            $comparison['value_rank'] = $index + 1;
        }

        return $comparisons;
    }

    /**
     * Get recommendations by player type
     * 
     * @param string $playerType Player type (beginner, casual, strategic, high_roller)
     * @return array Tailored recommendations
     */
    public function getRecommendationsByPlayerType(string $playerType): array
    {
        $strategies = $this->getBonusStrategies();
        $bonusTypes = $this->getBonusTypes();
        
        if (!isset($strategies[$playerType])) {
            throw new \InvalidArgumentException("Invalid player type: {$playerType}");
        }

        $strategy = $strategies[$playerType];
        $recommendedBonuses = [];

        foreach ($strategy['recommended_bonuses'] as $bonusKey) {
            if (isset($bonusTypes[$bonusKey])) {
                $bonus = $bonusTypes[$bonusKey];
                $bonus['suitability_score'] = $bonus['player_type_suitability'][$playerType] ?? 5;
                $recommendedBonuses[] = $bonus;
            }
        }

        // Sort by suitability score
        usort($recommendedBonuses, function($a, $b) {
            return $b['suitability_score'] <=> $a['suitability_score'];
        });

        return [
            'player_type' => $playerType,
            'strategy' => $strategy,
            'recommended_bonuses' => $recommendedBonuses,
            'top_bonus' => $recommendedBonuses[0] ?? null
        ];
    }
}
