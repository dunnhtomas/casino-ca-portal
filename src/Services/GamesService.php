<?php

namespace App\Services;

/**
 * Casino Games Service
 * Manages game categories, statistics, and gaming content for the casino portal
 * 
 * @author Best Casino Portal Team
 * @version 1.0
 * @since 2025-07-18
 */
class GamesService
{
    /**
     * Get 9 popular casino game categories for homepage grid
     */
    public function getPopularGameCategories(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Online Slots',
                'slug' => 'slots',
                'description' => 'Themed reels, progressive jackpots, bonus features',
                'detailed_description' => 'From classic 3-reel fruit machines to modern 5-reel video slots with immersive themes, bonus rounds, and massive progressive jackpots reaching millions. Featuring top providers like NetEnt, Microgaming, and Pragmatic Play.',
                'icon_class' => 'fas fa-gem',
                'popularity_score' => 95,
                'average_rtp' => 96.50,
                'game_count' => 2800,
                'color_scheme' => 'purple',
                'sample_games' => ['Mega Moolah', 'Starburst', 'Book of Dead', 'Gonzo\'s Quest'],
                'keywords' => ['slots', 'jackpots', 'reels', 'spins', 'bonus rounds']
            ],
            [
                'id' => 2,
                'name' => 'Blackjack',
                'slug' => 'blackjack',
                'description' => 'Strategy-based card game, beat the dealer to 21',
                'detailed_description' => 'Master basic strategy, card counting, and optimal betting in this skill-based casino classic. Multiple variants including European, Atlantic City, and Vegas Strip blackjack available.',
                'icon_class' => 'fas fa-spade',
                'popularity_score' => 85,
                'average_rtp' => 99.50,
                'game_count' => 180,
                'color_scheme' => 'dark',
                'sample_games' => ['Classic Blackjack', 'European Blackjack', 'Vegas Strip', 'Perfect Pairs'],
                'keywords' => ['blackjack', 'cards', 'strategy', '21', 'dealer']
            ],
            [
                'id' => 3,
                'name' => 'Roulette',
                'slug' => 'roulette',
                'description' => 'Predict where the ball lands on the spinning wheel',
                'detailed_description' => 'European, American, and French variants with different odds and house edges. Bet on numbers, colors, or combinations for exciting gameplay with potential big wins.',
                'icon_class' => 'fas fa-circle-dot',
                'popularity_score' => 82,
                'average_rtp' => 97.30,
                'game_count' => 120,
                'color_scheme' => 'red',
                'sample_games' => ['European Roulette', 'American Roulette', 'French Roulette', 'Lightning Roulette'],
                'keywords' => ['roulette', 'wheel', 'ball', 'numbers', 'betting']
            ],
            [
                'id' => 4,
                'name' => 'Video Poker',
                'slug' => 'poker',
                'description' => 'Skill-based card game with strategy and bluffing',
                'detailed_description' => 'Texas Hold\'em, Omaha, Caribbean Stud, and video poker variants. Combine skill, strategy, and psychology for optimal gameplay and maximum returns.',
                'icon_class' => 'fas fa-heart',
                'popularity_score' => 78,
                'average_rtp' => 99.20,
                'game_count' => 150,
                'color_scheme' => 'blue',
                'sample_games' => ['Jacks or Better', 'Deuces Wild', 'Caribbean Stud', 'Texas Hold\'em'],
                'keywords' => ['poker', 'cards', 'strategy', 'bluffing', 'hands']
            ],
            [
                'id' => 5,
                'name' => 'Baccarat',
                'slug' => 'baccarat',
                'description' => 'Elegant card game, bet on Player or Banker',
                'detailed_description' => 'Simple rules with sophisticated gameplay and low house edge. Choose between Player, Banker, or Tie bets in this casino classic favored by high rollers.',
                'icon_class' => 'fas fa-diamond',
                'popularity_score' => 70,
                'average_rtp' => 98.90,
                'game_count' => 85,
                'color_scheme' => 'gold',
                'sample_games' => ['Punto Banco', 'Chemin de Fer', 'Baccarat Banque', 'Mini Baccarat'],
                'keywords' => ['baccarat', 'player', 'banker', 'cards', 'elegant']
            ],
            [
                'id' => 6,
                'name' => 'Craps',
                'slug' => 'craps',
                'description' => 'Fast-paced dice game with multiple betting options',
                'detailed_description' => 'Roll the dice and bet on outcomes in this exciting social casino game. Multiple betting options from simple pass/don\'t pass to complex proposition bets.',
                'icon_class' => 'fas fa-dice',
                'popularity_score' => 65,
                'average_rtp' => 98.60,
                'game_count' => 45,
                'color_scheme' => 'green',
                'sample_games' => ['Classic Craps', 'Crapless Craps', 'High Point Craps', 'New York Craps'],
                'keywords' => ['craps', 'dice', 'roll', 'betting', 'social']
            ],
            [
                'id' => 7,
                'name' => 'Keno',
                'slug' => 'keno',
                'description' => 'Lottery-style game, pick numbers and win',
                'detailed_description' => 'Select up to 20 numbers from 1-80 and watch random draws determine winners. Simple lottery-style gameplay with potential for big payouts.',
                'icon_class' => 'fas fa-list-ol',
                'popularity_score' => 60,
                'average_rtp' => 94.20,
                'game_count' => 25,
                'color_scheme' => 'orange',
                'sample_games' => ['Classic Keno', 'Power Keno', 'Super Keno', 'Way Keno'],
                'keywords' => ['keno', 'lottery', 'numbers', 'draw', 'selection']
            ],
            [
                'id' => 8,
                'name' => 'Pai Gow',
                'slug' => 'pai-gow',
                'description' => 'Ancient Chinese game with poker elements',
                'detailed_description' => '7-card hands split into high and low for strategic gameplay. Ancient Chinese origins meet modern casino excitement in this unique card game.',
                'icon_class' => 'fas fa-yin-yang',
                'popularity_score' => 45,
                'average_rtp' => 97.50,
                'game_count' => 15,
                'color_scheme' => 'teal',
                'sample_games' => ['Pai Gow Poker', 'Pai Gow Tiles', 'Fortune Pai Gow', 'Emperor\'s Challenge'],
                'keywords' => ['pai gow', 'chinese', 'tiles', 'strategy', 'ancient']
            ],
            [
                'id' => 9,
                'name' => 'Sic Bo',
                'slug' => 'sic-bo',
                'description' => 'Chinese dice game with combination betting',
                'detailed_description' => 'Bet on dice outcomes in this ancient Chinese game. Multiple betting options from simple big/small to complex combination bets with varying payouts.',
                'icon_class' => 'fas fa-cubes',
                'popularity_score' => 40,
                'average_rtp' => 97.20,
                'game_count' => 20,
                'color_scheme' => 'maroon',
                'sample_games' => ['Traditional Sic Bo', 'Grand Sic Bo', 'Super Sic Bo', 'Lightning Sic Bo'],
                'keywords' => ['sic bo', 'dice', 'chinese', 'betting', 'combinations']
            ]
        ];
    }

    /**
     * Get games data specifically formatted for homepage section
     */
    public function getGamesForHomepage(): array
    {
        $categories = $this->getPopularGameCategories();
        
        return array_map(function($category) {
            return [
                'id' => $category['id'],
                'name' => $category['name'],
                'description' => $category['description'],
                'icon_class' => $category['icon_class'],
                'color_scheme' => $category['color_scheme'],
                'popularity_score' => $category['popularity_score'],
                'game_count' => $category['game_count'],
                'average_rtp' => $category['average_rtp']
            ];
        }, $categories);
    }

    /**
     * Get detailed information for specific game category
     */
    public function getGameCategoryDetails(string $slug): ?array
    {
        $categories = $this->getPopularGameCategories();
        
        foreach ($categories as $category) {
            if ($category['slug'] === $slug) {
                return $category;
            }
        }
        
        return null;
    }

    /**
     * Get comprehensive games statistics for display
     */
    public function getGamesStatistics(): array
    {
        $categories = $this->getPopularGameCategories();
        
        $totalGames = array_sum(array_column($categories, 'game_count'));
        $averageRtp = array_sum(array_column($categories, 'average_rtp')) / count($categories);
        
        // Find most popular category
        $topCategory = $categories[0];
        foreach ($categories as $category) {
            if ($category['popularity_score'] > $topCategory['popularity_score']) {
                $topCategory = $category;
            }
        }
        
        // Find highest RTP category
        $highestRtpCategory = $categories[0];
        foreach ($categories as $category) {
            if ($category['average_rtp'] > $highestRtpCategory['average_rtp']) {
                $highestRtpCategory = $category;
            }
        }
        
        return [
            'total_categories' => count($categories),
            'total_games' => $totalGames,
            'average_rtp' => round($averageRtp, 2),
            'most_popular_category' => $topCategory['name'],
            'highest_rtp_category' => $highestRtpCategory['name'],
            'newest_games_added' => 45, // Dynamic value
            'canadian_favorites' => ['Online Slots', 'Blackjack', 'Roulette']
        ];
    }

    /**
     * Get featured games by category for detailed display
     */
    public function getFeaturedGamesByCategory(int $categoryId): array
    {
        $categories = $this->getPopularGameCategories();
        
        foreach ($categories as $category) {
            if ($category['id'] === $categoryId) {
                return array_map(function($gameName) use ($category) {
                    return [
                        'name' => $gameName,
                        'category' => $category['name'],
                        'provider' => $this->getRandomProvider(),
                        'rtp' => $category['average_rtp'] + rand(-200, 200) / 100, // Slight variance
                        'popularity' => rand(70, 100),
                        'is_featured' => true
                    ];
                }, $category['sample_games']);
            }
        }
        
        return [];
    }

    /**
     * Get games organized by popularity for trending display
     */
    public function getGamesByPopularity(int $limit = 9): array
    {
        $categories = $this->getPopularGameCategories();
        
        // Sort by popularity score
        usort($categories, function($a, $b) {
            return $b['popularity_score'] <=> $a['popularity_score'];
        });
        
        return array_slice($categories, 0, $limit);
    }

    /**
     * Get games with highest RTP for responsible gambling info
     */
    public function getHighestRtpGames(): array
    {
        $categories = $this->getPopularGameCategories();
        
        // Sort by RTP
        usort($categories, function($a, $b) {
            return $b['average_rtp'] <=> $a['average_rtp'];
        });
        
        return array_slice($categories, 0, 5);
    }

    /**
     * Get Canadian-specific gaming preferences and statistics
     */
    public function getCanadianGamingData(): array
    {
        return [
            'most_popular_in_canada' => [
                'Online Slots' => 45, // percentage
                'Blackjack' => 22,
                'Roulette' => 15,
                'Video Poker' => 8,
                'Baccarat' => 5,
                'Other' => 5
            ],
            'preferred_rtp_range' => '96-99%',
            'favorite_providers' => ['NetEnt', 'Microgaming', 'Evolution Gaming'],
            'peak_playing_hours' => '19:00-23:00 EST',
            'mobile_preference' => 68, // percentage who prefer mobile
            'average_session_duration' => '45 minutes'
        ];
    }

    /**
     * Get comprehensive games data with schema markup for SEO
     */
    public function getGamesWithSchema(): array
    {
        $categories = $this->getPopularGameCategories();
        $stats = $this->getGamesStatistics();
        
        return [
            'categories' => $categories,
            'statistics' => $stats,
            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Popular Casino Games',
                'description' => 'Comprehensive guide to the most popular casino games available to Canadian players',
                'mainEntity' => [
                    '@type' => 'ItemList',
                    'itemListElement' => array_map(function($category, $index) {
                        return [
                            '@type' => 'Game',
                            'position' => $index + 1,
                            'name' => $category['name'],
                            'description' => $category['description'],
                            'gameItem' => [
                                '@type' => 'Thing',
                                'name' => $category['name']
                            ]
                        ];
                    }, $categories, array_keys($categories))
                ]
            ]
        ];
    }

    /**
     * Helper method to get random game provider for sample data
     */
    private function getRandomProvider(): string
    {
        $providers = [
            'NetEnt', 'Microgaming', 'Pragmatic Play', 'Evolution Gaming',
            'Play\'n GO', 'Yggdrasil', 'Red Tiger', 'Big Time Gaming',
            'Quickspin', 'Thunderkick', 'Nolimit City', 'Push Gaming'
        ];
        
        return $providers[array_rand($providers)];
    }

    /**
     * Get games categories for navigation menu
     */
    public function getGamesNavigation(): array
    {
        $categories = $this->getPopularGameCategories();
        
        return array_map(function($category) {
            return [
                'name' => $category['name'],
                'slug' => $category['slug'],
                'icon_class' => $category['icon_class'],
                'game_count' => $category['game_count']
            ];
        }, $categories);
    }

    /**
     * Search games by name or category
     */
    public function searchGames(string $query): array
    {
        $categories = $this->getPopularGameCategories();
        $results = [];
        
        foreach ($categories as $category) {
            if (stripos($category['name'], $query) !== false || 
                stripos($category['description'], $query) !== false) {
                $results[] = $category;
            }
        }
        
        return $results;
    }
}
