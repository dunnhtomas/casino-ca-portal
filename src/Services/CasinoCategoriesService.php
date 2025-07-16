<?php

namespace App\Services;

/**
 * Casino Categories Service
 * 
 * Provides comprehensive casino categorization matching casino.ca structure
 * Handles multiple category dimensions: games, bonuses, payment methods, etc.
 * 
 * @author Marcus Thompson, Senior Casino Content Strategist
 */
class CasinoCategoriesService
{
    private $categories;
    private $casinos;

    public function __construct()
    {
        $this->initializeCategories();
        $this->initializeCasinos();
    }

    /**
     * Get all casino categories with counts and descriptions
     */
    public function getAllCategories()
    {
        $categoriesWithCounts = [];
        
        foreach ($this->categories as $categoryId => $category) {
            $casinos = $this->getCasinosByCategory($categoryId);
            $categoriesWithCounts[$categoryId] = [
                'id' => $categoryId,
                'name' => $category['name'],
                'description' => $category['description'],
                'icon' => $category['icon'],
                'color' => $category['color'],
                'priority' => $category['priority'],
                'casino_count' => count($casinos),
                'seo_title' => $category['seo_title'],
                'seo_description' => $category['seo_description']
            ];
        }

        // Sort by priority
        uasort($categoriesWithCounts, function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        return $categoriesWithCounts;
    }

    /**
     * Get casinos by specific category
     */
    public function getCasinosByCategory($categoryId, $filters = [], $sort = 'rating')
    {
        $categoryCasinos = [];
        
        foreach ($this->casinos as $casino) {
            if ($this->casinoMatchesCategory($casino, $categoryId)) {
                $categoryCasinos[] = $this->enrichCasinoForCategory($casino, $categoryId);
            }
        }

        // Apply additional filters
        if (!empty($filters)) {
            $categoryCasinos = $this->applyFilters($categoryCasinos, $filters);
        }

        // Sort casinos
        $categoryCasinos = $this->sortCasinos($categoryCasinos, $sort);

        return $categoryCasinos;
    }

    /**
     * Get casinos matching multiple categories
     */
    public function getCasinosByMultipleCategories($categoryIds, $filters = [], $sort = 'rating')
    {
        $multiCategoryCasinos = [];
        
        foreach ($this->casinos as $casino) {
            $matchCount = 0;
            foreach ($categoryIds as $categoryId) {
                if ($this->casinoMatchesCategory($casino, $categoryId)) {
                    $matchCount++;
                }
            }
            
            // Casino must match ALL selected categories
            if ($matchCount === count($categoryIds)) {
                $multiCategoryCasinos[] = $this->enrichCasinoForMultipleCategories($casino, $categoryIds);
            }
        }

        // Apply additional filters
        if (!empty($filters)) {
            $multiCategoryCasinos = $this->applyFilters($multiCategoryCasinos, $filters);
        }

        // Sort casinos
        $multiCategoryCasinos = $this->sortCasinos($multiCategoryCasinos, $sort);

        return $multiCategoryCasinos;
    }

    /**
     * Get category by ID
     */
    public function getCategory($categoryId)
    {
        if (!isset($this->categories[$categoryId])) {
            return null;
        }

        $category = $this->categories[$categoryId];
        $casinos = $this->getCasinosByCategory($categoryId);
        
        return [
            'id' => $categoryId,
            'name' => $category['name'],
            'description' => $category['description'],
            'long_description' => $category['long_description'],
            'icon' => $category['icon'],
            'color' => $category['color'],
            'casino_count' => count($casinos),
            'seo_title' => $category['seo_title'],
            'seo_description' => $category['seo_description'],
            'featured_criteria' => $category['featured_criteria'],
            'sorting_options' => $category['sorting_options'],
            'filter_options' => $category['filter_options']
        ];
    }

    /**
     * Get category filters for specific category
     */
    public function getCategoryFilters($categoryId)
    {
        if (!isset($this->categories[$categoryId])) {
            return [];
        }

        return $this->categories[$categoryId]['filter_options'];
    }

    /**
     * Get category sorting options
     */
    public function getCategorySortingOptions($categoryId)
    {
        if (!isset($this->categories[$categoryId])) {
            return [];
        }

        return $this->categories[$categoryId]['sorting_options'];
    }

    /**
     * Initialize casino categories matching casino.ca structure
     */
    private function initializeCategories()
    {
        $this->categories = [
            'live-dealer' => [
                'name' => 'Live Dealer Casinos',
                'description' => 'Experience real casino atmosphere with live dealers',
                'long_description' => 'Immerse yourself in authentic casino gaming with live dealer casinos featuring real dealers, real-time interaction, and HD streaming. These casinos offer live blackjack, roulette, baccarat, poker, and game shows with professional dealers broadcasting from studios worldwide.',
                'icon' => 'fas fa-video',
                'color' => '#e74c3c',
                'priority' => 1,
                'seo_title' => 'Best Live Dealer Casinos in Canada 2025 | Real Dealers & HD Streaming',
                'seo_description' => 'Discover top-rated live dealer casinos in Canada. Play live blackjack, roulette, and baccarat with real dealers. HD streaming, interactive gaming, and Canadian-friendly platforms.',
                'featured_criteria' => ['live_dealer_games', 'hd_streaming', 'dealer_interaction'],
                'sorting_options' => [
                    'rating' => 'Highest Rated',
                    'live_games_count' => 'Most Live Games',
                    'bonus_amount' => 'Best Bonuses',
                    'new_date' => 'Newest First'
                ],
                'filter_options' => [
                    'live_game_types' => ['Blackjack', 'Roulette', 'Baccarat', 'Poker', 'Game Shows'],
                    'streaming_quality' => ['HD', '4K', 'Multi-angle'],
                    'dealer_languages' => ['English', 'French', 'Multilingual']
                ]
            ],
            'mobile-casinos' => [
                'name' => 'Mobile Casinos',
                'description' => 'Play anywhere with mobile-optimized casino gaming',
                'long_description' => 'Access premium casino gaming on your smartphone or tablet with mobile-optimized casinos. These platforms offer responsive web apps and native mobile apps with full game libraries, touch-optimized interfaces, and mobile-exclusive bonuses.',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#3498db',
                'priority' => 2,
                'seo_title' => 'Best Mobile Casinos Canada 2025 | iPhone & Android Casino Apps',
                'seo_description' => 'Top mobile casinos for Canadian players. Play on iPhone, Android, and tablets. Mobile-exclusive bonuses, responsive design, and full game libraries on the go.',
                'featured_criteria' => ['mobile_optimized', 'mobile_app', 'mobile_bonuses'],
                'sorting_options' => [
                    'rating' => 'Highest Rated',
                    'mobile_games_count' => 'Most Mobile Games',
                    'app_rating' => 'Best App Rating',
                    'mobile_bonus' => 'Best Mobile Bonuses'
                ],
                'filter_options' => [
                    'platform_support' => ['iOS', 'Android', 'Web App', 'Native App'],
                    'mobile_features' => ['Touch ID', 'Face ID', 'Push Notifications', 'Offline Mode'],
                    'mobile_exclusives' => ['Mobile Bonuses', 'Mobile Tournaments', 'Mobile Games']
                ]
            ],
            'crypto-casinos' => [
                'name' => 'Crypto Casinos',
                'description' => 'Bitcoin and cryptocurrency gambling platforms',
                'long_description' => 'Embrace the future of online gambling with cryptocurrency casinos accepting Bitcoin, Ethereum, and other digital currencies. These platforms offer anonymous gaming, instant transactions, provably fair games, and crypto-exclusive bonuses.',
                'icon' => 'fab fa-bitcoin',
                'color' => '#f39c12',
                'priority' => 3,
                'seo_title' => 'Best Crypto Casinos Canada 2025 | Bitcoin & Ethereum Gambling',
                'seo_description' => 'Top cryptocurrency casinos for Canadian players. Bitcoin, Ethereum, and altcoin gambling. Anonymous gaming, instant withdrawals, and provably fair games.',
                'featured_criteria' => ['crypto_payments', 'provably_fair', 'anonymous_gaming'],
                'sorting_options' => [
                    'rating' => 'Highest Rated',
                    'crypto_count' => 'Most Cryptocurrencies',
                    'crypto_bonus' => 'Best Crypto Bonuses',
                    'withdrawal_speed' => 'Fastest Withdrawals'
                ],
                'filter_options' => [
                    'cryptocurrencies' => ['Bitcoin', 'Ethereum', 'Litecoin', 'Dogecoin', 'Bitcoin Cash'],
                    'crypto_features' => ['Provably Fair', 'Anonymous Gaming', 'Instant Withdrawals', 'DeFi Integration'],
                    'blockchain_support' => ['Bitcoin Network', 'Ethereum Network', 'BSC', 'Polygon']
                ]
            ],
            'new-casinos' => [
                'name' => 'New Casinos',
                'description' => 'Latest casino launches with fresh bonuses',
                'long_description' => 'Discover the newest online casinos launching in Canada with innovative features, generous welcome bonuses, and cutting-edge gaming technology. These fresh platforms often offer the best promotional offers to attract new players.',
                'icon' => 'fas fa-rocket',
                'color' => '#9b59b6',
                'priority' => 4,
                'seo_title' => 'New Online Casinos Canada 2025 | Latest Launches & Fresh Bonuses',
                'seo_description' => 'Discover new online casinos launching in Canada. Fresh bonuses, innovative features, and cutting-edge gaming technology. Get early access to the best new platforms.',
                'featured_criteria' => ['launch_date', 'welcome_bonus', 'innovative_features'],
                'sorting_options' => [
                    'launch_date' => 'Newest First',
                    'rating' => 'Highest Rated',
                    'bonus_amount' => 'Best Welcome Bonuses',
                    'games_count' => 'Most Games'
                ],
                'filter_options' => [
                    'launch_period' => ['Last 30 Days', 'Last 3 Months', 'Last 6 Months', 'This Year'],
                    'innovative_features' => ['VR Games', 'AI Dealers', 'Social Gaming', 'Gamification'],
                    'welcome_bonus_type' => ['No Deposit', 'Match Bonus', 'Free Spins', 'Cashback']
                ]
            ],
            'high-roller' => [
                'name' => 'High Roller Casinos',
                'description' => 'VIP casinos for high-stakes players',
                'long_description' => 'Exclusive high roller casinos catering to VIP players with high betting limits, premium customer service, luxury rewards, and personalized gaming experiences. These platforms offer the ultimate in high-stakes casino gaming.',
                'icon' => 'fas fa-crown',
                'color' => '#8e44ad',
                'priority' => 5,
                'seo_title' => 'Best High Roller Casinos Canada 2025 | VIP Gaming & High Limits',
                'seo_description' => 'Premium high roller casinos for Canadian VIP players. High betting limits, luxury rewards, personalized service, and exclusive gaming experiences.',
                'featured_criteria' => ['high_limits', 'vip_program', 'personal_manager'],
                'sorting_options' => [
                    'rating' => 'Highest Rated',
                    'max_bet_limit' => 'Highest Limits',
                    'vip_benefits' => 'Best VIP Programs',
                    'withdrawal_limit' => 'Highest Withdrawals'
                ],
                'filter_options' => [
                    'betting_limits' => ['$100+', '$500+', '$1000+', '$5000+', 'Unlimited'],
                    'vip_features' => ['Personal Manager', 'Exclusive Games', 'Priority Support', 'Custom Bonuses'],
                    'luxury_perks' => ['Event Invitations', 'Physical Gifts', 'Travel Rewards', 'Concierge Service']
                ]
            ],
            'no-deposit' => [
                'name' => 'No Deposit Casinos',
                'description' => 'Try casinos with free bonus money',
                'long_description' => 'Start playing immediately with no deposit casinos offering free bonus money, free spins, or free play credits without requiring an initial deposit. Perfect for testing casinos risk-free before committing your own funds.',
                'icon' => 'fas fa-gift',
                'color' => '#27ae60',
                'priority' => 6,
                'seo_title' => 'No Deposit Casinos Canada 2025 | Free Bonus Money & Spins',
                'seo_description' => 'Best no deposit casinos in Canada. Get free bonus money, free spins, and play credits without depositing. Risk-free casino testing with real money potential.',
                'featured_criteria' => ['no_deposit_bonus', 'bonus_amount', 'wagering_requirements'],
                'sorting_options' => [
                    'bonus_amount' => 'Highest No Deposit Bonus',
                    'rating' => 'Highest Rated',
                    'wagering_req' => 'Lowest Wagering Requirements',
                    'games_eligible' => 'Most Eligible Games'
                ],
                'filter_options' => [
                    'bonus_type' => ['Bonus Money', 'Free Spins', 'Free Play', 'Cashback'],
                    'bonus_amount' => ['$5-10', '$10-25', '$25-50', '$50+'],
                    'wagering_requirements' => ['20x or less', '20x-35x', '35x-50x', '50x+']
                ]
            ],
            'fast-payout' => [
                'name' => 'Fast Payout Casinos',
                'description' => 'Quick withdrawal and instant payout casinos',
                'long_description' => 'Experience lightning-fast withdrawals with casinos specializing in rapid payouts. These platforms process withdrawals within hours or minutes, offering instant payment methods and streamlined verification processes.',
                'icon' => 'fas fa-bolt',
                'color' => '#e67e22',
                'priority' => 7,
                'seo_title' => 'Fast Payout Casinos Canada 2025 | Instant Withdrawals & Quick Payouts',
                'seo_description' => 'Fastest payout casinos in Canada. Get your winnings in minutes with instant withdrawal casinos. Quick verification and lightning-fast payment processing.',
                'featured_criteria' => ['payout_speed', 'instant_methods', 'verification_time'],
                'sorting_options' => [
                    'payout_speed' => 'Fastest Payouts',
                    'rating' => 'Highest Rated',
                    'instant_methods' => 'Most Instant Methods',
                    'verification_speed' => 'Fastest Verification'
                ],
                'filter_options' => [
                    'payout_timeframe' => ['Instant', 'Under 1 Hour', '1-4 Hours', '4-24 Hours'],
                    'instant_methods' => ['E-wallets', 'Crypto', 'Instant Banking', 'Pay by Phone'],
                    'verification_type' => ['Instant KYC', 'AI Verification', 'Manual Review', 'No Verification']
                ]
            ],
            'bonus-hunter' => [
                'name' => 'Best Bonus Casinos',
                'description' => 'Casinos with the most generous bonuses',
                'long_description' => 'Maximize your casino value with platforms offering the most generous bonuses, including massive welcome packages, regular promotions, loyalty rewards, and reload bonuses. Perfect for players who want maximum bonus value.',
                'icon' => 'fas fa-percentage',
                'color' => '#1abc9c',
                'priority' => 8,
                'seo_title' => 'Best Casino Bonuses Canada 2025 | Highest Welcome Bonuses & Promotions',
                'seo_description' => 'Biggest casino bonuses in Canada. Massive welcome packages, free spins, and ongoing promotions. Compare bonus amounts, wagering requirements, and terms.',
                'featured_criteria' => ['bonus_amount', 'bonus_frequency', 'loyalty_program'],
                'sorting_options' => [
                    'bonus_amount' => 'Highest Bonuses',
                    'rating' => 'Highest Rated',
                    'wagering_req' => 'Lowest Wagering',
                    'bonus_frequency' => 'Most Frequent Bonuses'
                ],
                'filter_options' => [
                    'bonus_amount' => ['$500-1000', '$1000-2000', '$2000-5000', '$5000+'],
                    'bonus_types' => ['Welcome Package', 'Reload Bonuses', 'Cashback', 'Free Spins'],
                    'wagering_requirements' => ['20x or less', '20x-35x', '35x-50x', '50x+']
                ]
            ]
        ];
    }

    /**
     * Initialize casino database with category information
     */
    private function initializeCasinos()
    {
        $this->casinos = [
            [
                'id' => 1,
                'name' => 'Spin Casino',
                'rating' => 4.8,
                'bonus' => '$1000 Welcome Bonus',
                'games_count' => 800,
                'established' => 2019,
                'categories' => ['live-dealer', 'mobile-casinos', 'bonus-hunter'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => false,
                'payout_speed' => '24-48 hours',
                'max_bet_limit' => 5000,
                'no_deposit_bonus' => false,
                'welcome_bonus_amount' => 1000,
                'wagering_requirements' => '35x',
                'instant_methods' => ['PayPal', 'Skrill', 'Neteller'],
                'verification_time' => '24 hours'
            ],
            [
                'id' => 2,
                'name' => 'Royal Vegas',
                'rating' => 4.7,
                'bonus' => '$1200 + 120 Free Spins',
                'games_count' => 700,
                'established' => 2000,
                'categories' => ['live-dealer', 'high-roller', 'bonus-hunter'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => false,
                'payout_speed' => '24-72 hours',
                'max_bet_limit' => 10000,
                'no_deposit_bonus' => false,
                'welcome_bonus_amount' => 1200,
                'wagering_requirements' => '30x',
                'instant_methods' => ['PayPal', 'Skrill'],
                'verification_time' => '48 hours'
            ],
            [
                'id' => 3,
                'name' => 'BitStarz',
                'rating' => 4.9,
                'bonus' => '5 BTC + 180 Free Spins',
                'games_count' => 2800,
                'established' => 2014,
                'categories' => ['crypto-casinos', 'new-casinos', 'fast-payout', 'mobile-casinos'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => true,
                'payout_speed' => 'Instant',
                'max_bet_limit' => 'Unlimited',
                'no_deposit_bonus' => true,
                'welcome_bonus_amount' => 5000,
                'wagering_requirements' => '40x',
                'instant_methods' => ['Bitcoin', 'Ethereum', 'Litecoin'],
                'verification_time' => 'Instant'
            ],
            [
                'id' => 4,
                'name' => 'Jackpot City',
                'rating' => 4.6,
                'bonus' => '$1600 Welcome Package',
                'games_count' => 600,
                'established' => 1998,
                'categories' => ['live-dealer', 'mobile-casinos', 'bonus-hunter'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => false,
                'payout_speed' => '24-48 hours',
                'max_bet_limit' => 3000,
                'no_deposit_bonus' => false,
                'welcome_bonus_amount' => 1600,
                'wagering_requirements' => '35x',
                'instant_methods' => ['PayPal', 'Skrill', 'Neteller'],
                'verification_time' => '24 hours'
            ],
            [
                'id' => 5,
                'name' => 'PlayOJO',
                'rating' => 4.5,
                'bonus' => 'No Wagering 50 Free Spins',
                'games_count' => 3000,
                'established' => 2017,
                'categories' => ['no-deposit', 'mobile-casinos', 'fast-payout'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => false,
                'payout_speed' => '1-3 hours',
                'max_bet_limit' => 2000,
                'no_deposit_bonus' => true,
                'welcome_bonus_amount' => 0,
                'wagering_requirements' => '0x',
                'instant_methods' => ['PayPal', 'Trustly', 'Apple Pay'],
                'verification_time' => '1 hour'
            ],
            [
                'id' => 6,
                'name' => 'FortuneJack',
                'rating' => 4.7,
                'bonus' => '6 BTC + 250 Free Spins',
                'games_count' => 2500,
                'established' => 2014,
                'categories' => ['crypto-casinos', 'high-roller', 'fast-payout'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => true,
                'payout_speed' => 'Instant',
                'max_bet_limit' => 'Unlimited',
                'no_deposit_bonus' => false,
                'welcome_bonus_amount' => 6000,
                'wagering_requirements' => '40x',
                'instant_methods' => ['Bitcoin', 'Ethereum', 'Dogecoin'],
                'verification_time' => 'None required'
            ],
            [
                'id' => 7,
                'name' => 'Casino Gods',
                'rating' => 4.4,
                'bonus' => '$1500 + 300 Free Spins',
                'games_count' => 1500,
                'established' => 2020,
                'categories' => ['new-casinos', 'mobile-casinos', 'bonus-hunter'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => true,
                'payout_speed' => '12-24 hours',
                'max_bet_limit' => 4000,
                'no_deposit_bonus' => true,
                'welcome_bonus_amount' => 1500,
                'wagering_requirements' => '35x',
                'instant_methods' => ['Skrill', 'Neteller', 'Bitcoin'],
                'verification_time' => '12 hours'
            ],
            [
                'id' => 8,
                'name' => 'LeoVegas',
                'rating' => 4.8,
                'bonus' => '$1000 + 200 Free Spins',
                'games_count' => 1800,
                'established' => 2012,
                'categories' => ['mobile-casinos', 'live-dealer', 'fast-payout'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => false,
                'payout_speed' => '0-24 hours',
                'max_bet_limit' => 5000,
                'no_deposit_bonus' => false,
                'welcome_bonus_amount' => 1000,
                'wagering_requirements' => '35x',
                'instant_methods' => ['PayPal', 'Trustly', 'MuchBetter'],
                'verification_time' => '1-2 hours'
            ],
            [
                'id' => 9,
                'name' => 'Casumo',
                'rating' => 4.6,
                'bonus' => '$1200 + 200 Free Spins',
                'games_count' => 2000,
                'established' => 2012,
                'categories' => ['mobile-casinos', 'no-deposit', 'bonus-hunter'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => false,
                'payout_speed' => '24 hours',
                'max_bet_limit' => 3000,
                'no_deposit_bonus' => true,
                'welcome_bonus_amount' => 1200,
                'wagering_requirements' => '30x',
                'instant_methods' => ['PayPal', 'Skrill', 'Neteller'],
                'verification_time' => '24 hours'
            ],
            [
                'id' => 10,
                'name' => 'Cloudbet',
                'rating' => 4.5,
                'bonus' => '5 BTC Welcome Bonus',
                'games_count' => 2200,
                'established' => 2013,
                'categories' => ['crypto-casinos', 'high-roller', 'fast-payout'],
                'live_dealer_games' => true,
                'mobile_optimized' => true,
                'crypto_payments' => true,
                'payout_speed' => 'Instant',
                'max_bet_limit' => 'Unlimited',
                'no_deposit_bonus' => false,
                'welcome_bonus_amount' => 5000,
                'wagering_requirements' => '40x',
                'instant_methods' => ['Bitcoin', 'Ethereum', 'Litecoin'],
                'verification_time' => 'None required'
            ]
        ];
    }

    /**
     * Check if casino matches category criteria
     */
    private function casinoMatchesCategory($casino, $categoryId)
    {
        return in_array($categoryId, $casino['categories']);
    }

    /**
     * Enrich casino data with category-specific information
     */
    private function enrichCasinoForCategory($casino, $categoryId)
    {
        $enriched = $casino;
        
        // Add category-specific highlights
        switch ($categoryId) {
            case 'live-dealer':
                $enriched['category_highlight'] = 'Live dealer games available';
                $enriched['category_features'] = ['HD Streaming', 'Real Dealers', 'Interactive Gaming'];
                break;
            case 'mobile-casinos':
                $enriched['category_highlight'] = 'Mobile optimized';
                $enriched['category_features'] = ['Responsive Design', 'Touch Optimized', 'Mobile App'];
                break;
            case 'crypto-casinos':
                $enriched['category_highlight'] = 'Cryptocurrency accepted';
                $enriched['category_features'] = ['Bitcoin Payments', 'Anonymous Gaming', 'Instant Withdrawals'];
                break;
            case 'fast-payout':
                $enriched['category_highlight'] = $casino['payout_speed'];
                $enriched['category_features'] = ['Quick Withdrawals', 'Fast Verification', 'Instant Methods'];
                break;
            case 'no-deposit':
                $enriched['category_highlight'] = 'No deposit required';
                $enriched['category_features'] = ['Free Bonus', 'Risk-Free Trial', 'No Deposit Needed'];
                break;
        }
        
        return $enriched;
    }

    /**
     * Enrich casino data for multiple categories
     */
    private function enrichCasinoForMultipleCategories($casino, $categoryIds)
    {
        $enriched = $casino;
        $highlights = [];
        $features = [];
        
        foreach ($categoryIds as $categoryId) {
            $categoryEnriched = $this->enrichCasinoForCategory($casino, $categoryId);
            if (isset($categoryEnriched['category_highlight'])) {
                $highlights[] = $categoryEnriched['category_highlight'];
            }
            if (isset($categoryEnriched['category_features'])) {
                $features = array_merge($features, $categoryEnriched['category_features']);
            }
        }
        
        $enriched['category_highlights'] = array_unique($highlights);
        $enriched['category_features'] = array_unique($features);
        
        return $enriched;
    }

    /**
     * Apply filters to casino list
     */
    private function applyFilters($casinos, $filters)
    {
        // Implementation for applying various filters
        // This would filter based on the filter criteria
        return $casinos;
    }

    /**
     * Sort casinos by specified criteria
     */
    private function sortCasinos($casinos, $sort)
    {
        switch ($sort) {
            case 'rating':
                usort($casinos, function($a, $b) {
                    return $b['rating'] <=> $a['rating'];
                });
                break;
            case 'bonus_amount':
                usort($casinos, function($a, $b) {
                    return $b['welcome_bonus_amount'] <=> $a['welcome_bonus_amount'];
                });
                break;
            case 'games_count':
                usort($casinos, function($a, $b) {
                    return $b['games_count'] <=> $a['games_count'];
                });
                break;
            case 'new_date':
                usort($casinos, function($a, $b) {
                    return $b['established'] <=> $a['established'];
                });
                break;
        }
        
        return $casinos;
    }
}
