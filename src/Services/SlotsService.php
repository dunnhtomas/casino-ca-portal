<?php

namespace CasinoPortal\Services;

use Illuminate\Database\Capsule\Manager as DB;

class SlotsService
{
    /**
     * Get popular slots for homepage display
     * 
     * @param int $limit Number of slots to return
     * @return array Popular slots with full details
     */
    public function getPopularSlots(int $limit = 16): array
    {
        // For initial implementation, return comprehensive mock data
        // This will be replaced with database queries in production
        
        $slots = [
            [
                'id' => 1,
                'name' => 'Starburst',
                'provider' => 'NetEnt',
                'provider_id' => 1,
                'theme_category' => 'Space & Gems',
                'rtp_percentage' => 96.09,
                'volatility' => 'Low',
                'max_win_multiplier' => 50000,
                'paylines_count' => 10,
                'min_bet_cents' => 10,
                'max_bet_dollars' => 100,
                'bonus_features' => [
                    'Expanding Wilds',
                    'Re-spins',
                    'Both Ways Pay'
                ],
                'demo_url' => 'https://demo.slots.com/starburst',
                'thumbnail_image' => '/images/slots/starburst.jpg',
                'release_date' => '2012-11-01',
                'popularity_score' => 95,
                'description' => 'The iconic NetEnt slot featuring expanding wilds and both-ways-pay mechanism.',
                'key_features' => 'Expanding Wilds, Re-spins, 243 Ways to Win',
                'hit_frequency' => '22.7%',
                'game_review_url' => '/slots/starburst-review'
            ],
            [
                'id' => 2,
                'name' => 'Book of Dead',
                'provider' => 'Play\'n GO',
                'provider_id' => 2,
                'theme_category' => 'Adventure & Mythology',
                'rtp_percentage' => 96.21,
                'volatility' => 'High',
                'max_win_multiplier' => 250000,
                'paylines_count' => 10,
                'min_bet_cents' => 1,
                'max_bet_dollars' => 100,
                'bonus_features' => [
                    'Free Spins',
                    'Expanding Symbols',
                    'Gamble Feature'
                ],
                'demo_url' => 'https://demo.slots.com/book-of-dead',
                'thumbnail_image' => '/images/slots/book-of-dead.jpg',
                'release_date' => '2016-01-01',
                'popularity_score' => 92,
                'description' => 'Egyptian-themed adventure with Rich Wilde and explosive free spins.',
                'key_features' => 'Free Spins with Expanding Symbols, High Volatility',
                'hit_frequency' => '23.8%',
                'game_review_url' => '/slots/book-of-dead-review'
            ],
            [
                'id' => 3,
                'name' => 'Gonzo\'s Quest',
                'provider' => 'NetEnt',
                'provider_id' => 1,
                'theme_category' => 'Adventure',
                'rtp_percentage' => 95.97,
                'volatility' => 'Medium',
                'max_win_multiplier' => 187500,
                'paylines_count' => 20,
                'min_bet_cents' => 20,
                'max_bet_dollars' => 50,
                'bonus_features' => [
                    'Avalanche Feature',
                    'Multiplier Trail',
                    'Free Falls'
                ],
                'demo_url' => 'https://demo.slots.com/gonzos-quest',
                'thumbnail_image' => '/images/slots/gonzos-quest.jpg',
                'release_date' => '2010-05-21',
                'popularity_score' => 90,
                'description' => 'Revolutionary avalanche gameplay with increasing multipliers.',
                'key_features' => 'Avalanche Reels, Multiplier Trail up to 15x',
                'hit_frequency' => '41%',
                'game_review_url' => '/slots/gonzos-quest-review'
            ],
            [
                'id' => 4,
                'name' => 'Mega Moolah',
                'provider' => 'Microgaming',
                'provider_id' => 3,
                'theme_category' => 'Safari & Animals',
                'rtp_percentage' => 88.12,
                'volatility' => 'Medium',
                'max_win_multiplier' => 999999999, // Progressive jackpot
                'paylines_count' => 25,
                'min_bet_cents' => 25,
                'max_bet_dollars' => 6.25,
                'bonus_features' => [
                    'Progressive Jackpot',
                    'Free Spins',
                    'Jackpot Wheel'
                ],
                'demo_url' => 'https://demo.slots.com/mega-moolah',
                'thumbnail_image' => '/images/slots/mega-moolah.jpg',
                'release_date' => '2006-11-01',
                'popularity_score' => 88,
                'description' => 'The world\'s most famous progressive jackpot slot.',
                'key_features' => 'Progressive Jackpot, Free Spins with 3x Multiplier',
                'hit_frequency' => '32.2%',
                'game_review_url' => '/slots/mega-moolah-review'
            ],
            [
                'id' => 5,
                'name' => 'Immortal Romance',
                'provider' => 'Microgaming',
                'provider_id' => 3,
                'theme_category' => 'Gothic & Romance',
                'rtp_percentage' => 96.86,
                'volatility' => 'Medium',
                'max_win_multiplier' => 36300,
                'paylines_count' => 243,
                'min_bet_cents' => 30,
                'max_bet_dollars' => 30,
                'bonus_features' => [
                    'Chamber of Spins',
                    'Wild Desire',
                    'Multiple Free Spin Features'
                ],
                'demo_url' => 'https://demo.slots.com/immortal-romance',
                'thumbnail_image' => '/images/slots/immortal-romance.jpg',
                'release_date' => '2011-12-07',
                'popularity_score' => 89,
                'description' => 'Gothic romance with evolving storyline and multiple free spin features.',
                'key_features' => '4 Different Free Spin Features, 243 Ways to Win',
                'hit_frequency' => '28.5%',
                'game_review_url' => '/slots/immortal-romance-review'
            ],
            [
                'id' => 6,
                'name' => 'Buffalo Blitz',
                'provider' => 'Playtech',
                'provider_id' => 4,
                'theme_category' => 'Animals & Nature',
                'rtp_percentage' => 95.96,
                'volatility' => 'High',
                'max_win_multiplier' => 300000,
                'paylines_count' => 4096,
                'min_bet_cents' => 40,
                'max_bet_dollars' => 200,
                'bonus_features' => [
                    'Free Games',
                    'Multiplier Wilds',
                    '4096 Ways to Win'
                ],
                'demo_url' => 'https://demo.slots.com/buffalo-blitz',
                'thumbnail_image' => '/images/slots/buffalo-blitz.jpg',
                'release_date' => '2016-03-15',
                'popularity_score' => 87,
                'description' => 'American prairie adventure with massive 4096 ways to win.',
                'key_features' => '4096 Ways to Win, Free Games with Multipliers',
                'hit_frequency' => '26.8%',
                'game_review_url' => '/slots/buffalo-blitz-review'
            ],
            [
                'id' => 7,
                'name' => 'Reactoonz',
                'provider' => 'Play\'n GO',
                'provider_id' => 2,
                'theme_category' => 'Aliens & Space',
                'rtp_percentage' => 96.51,
                'volatility' => 'High',
                'max_win_multiplier' => 480000,
                'paylines_count' => 0, // Cluster pays
                'min_bet_cents' => 20,
                'max_bet_dollars' => 100,
                'bonus_features' => [
                    'Cluster Pays',
                    'Quantum Features',
                    'Gargantoon Wilds'
                ],
                'demo_url' => 'https://demo.slots.com/reactoonz',
                'thumbnail_image' => '/images/slots/reactoonz.jpg',
                'release_date' => '2017-10-18',
                'popularity_score' => 85,
                'description' => 'Unique cluster-pays slot with cascading wins and quantum features.',
                'key_features' => 'Cluster Pays, Quantum Leap Features, Gargantoon',
                'hit_frequency' => '25.7%',
                'game_review_url' => '/slots/reactoonz-review'
            ],
            [
                'id' => 8,
                'name' => 'Great Rhino Megaways',
                'provider' => 'Pragmatic Play',
                'provider_id' => 5,
                'theme_category' => 'Animals & Safari',
                'rtp_percentage' => 96.58,
                'volatility' => 'High',
                'max_win_multiplier' => 200000,
                'paylines_count' => 200704, // Megaways
                'min_bet_cents' => 20,
                'max_bet_dollars' => 100,
                'bonus_features' => [
                    'Megaways Engine',
                    'Free Spins',
                    'Tumble Feature'
                ],
                'demo_url' => 'https://demo.slots.com/great-rhino-megaways',
                'thumbnail_image' => '/images/slots/great-rhino-megaways.jpg',
                'release_date' => '2020-02-06',
                'popularity_score' => 86,
                'description' => 'African safari with Megaways engine and up to 200,704 ways to win.',
                'key_features' => 'Megaways Engine, Free Spins with Multipliers',
                'hit_frequency' => '28.1%',
                'game_review_url' => '/slots/great-rhino-megaways-review'
            ],
            [
                'id' => 9,
                'name' => 'Bonanza',
                'provider' => 'Big Time Gaming',
                'provider_id' => 6,
                'theme_category' => 'Mining & Gold',
                'rtp_percentage' => 96.00,
                'volatility' => 'High',
                'max_win_multiplier' => 1200000,
                'paylines_count' => 117649, // Megaways
                'min_bet_cents' => 20,
                'max_bet_dollars' => 20,
                'bonus_features' => [
                    'Megaways',
                    'Unlimited Multiplier',
                    'Reaction Feature'
                ],
                'demo_url' => 'https://demo.slots.com/bonanza',
                'thumbnail_image' => '/images/slots/bonanza.jpg',
                'release_date' => '2016-12-07',
                'popularity_score' => 91,
                'description' => 'The original Megaways slot with mining theme and unlimited multipliers.',
                'key_features' => 'Original Megaways, Unlimited Free Spin Multipliers',
                'hit_frequency' => '27.8%',
                'game_review_url' => '/slots/bonanza-review'
            ],
            [
                'id' => 10,
                'name' => 'Dead or Alive 2',
                'provider' => 'NetEnt',
                'provider_id' => 1,
                'theme_category' => 'Western',
                'rtp_percentage' => 96.82,
                'volatility' => 'High',
                'max_win_multiplier' => 111300,
                'paylines_count' => 9,
                'min_bet_cents' => 9,
                'max_bet_dollars' => 18,
                'bonus_features' => [
                    'Three Free Spin Features',
                    'Sticky Wilds',
                    'High Volatility'
                ],
                'demo_url' => 'https://demo.slots.com/dead-or-alive-2',
                'thumbnail_image' => '/images/slots/dead-or-alive-2.jpg',
                'release_date' => '2019-05-09',
                'popularity_score' => 84,
                'description' => 'Wild West sequel with three different free spin features.',
                'key_features' => '3 Free Spin Modes, Sticky Wilds, Extreme Volatility',
                'hit_frequency' => '19.4%',
                'game_review_url' => '/slots/dead-or-alive-2-review'
            ],
            [
                'id' => 11,
                'name' => 'Sweet Bonanza',
                'provider' => 'Pragmatic Play',
                'provider_id' => 5,
                'theme_category' => 'Candy & Sweets',
                'rtp_percentage' => 96.51,
                'volatility' => 'High',
                'max_win_multiplier' => 210000,
                'paylines_count' => 0, // All ways
                'min_bet_cents' => 20,
                'max_bet_dollars' => 125,
                'bonus_features' => [
                    'Tumble Feature',
                    'Ante Bet',
                    'Multiplier Bombs'
                ],
                'demo_url' => 'https://demo.slots.com/sweet-bonanza',
                'thumbnail_image' => '/images/slots/sweet-bonanza.jpg',
                'release_date' => '2019-06-27',
                'popularity_score' => 88,
                'description' => 'Colorful candy-themed slot with tumbling reels and multiplier bombs.',
                'key_features' => 'Tumble Feature, Multiplier Bombs up to 100x',
                'hit_frequency' => '45.5%',
                'game_review_url' => '/slots/sweet-bonanza-review'
            ],
            [
                'id' => 12,
                'name' => 'The Dog House',
                'provider' => 'Pragmatic Play',
                'provider_id' => 5,
                'theme_category' => 'Animals & Pets',
                'rtp_percentage' => 96.51,
                'volatility' => 'High',
                'max_win_multiplier' => 625000,
                'paylines_count' => 20,
                'min_bet_cents' => 20,
                'max_bet_dollars' => 100,
                'bonus_features' => [
                    'Sticky Wilds',
                    'Free Spins',
                    'Multiplier Wilds'
                ],
                'demo_url' => 'https://demo.slots.com/the-dog-house',
                'thumbnail_image' => '/images/slots/the-dog-house.jpg',
                'release_date' => '2019-04-23',
                'popularity_score' => 83,
                'description' => 'Adorable dog-themed slot with sticky wilds and free spins.',
                'key_features' => 'Sticky Wilds with Multipliers, Free Spins',
                'hit_frequency' => '22.7%',
                'game_review_url' => '/slots/the-dog-house-review'
            ],
            [
                'id' => 13,
                'name' => 'Thunderstruck II',
                'provider' => 'Microgaming',
                'provider_id' => 3,
                'theme_category' => 'Mythology & Gods',
                'rtp_percentage' => 96.65,
                'volatility' => 'Medium',
                'max_win_multiplier' => 24300,
                'paylines_count' => 243,
                'min_bet_cents' => 30,
                'max_bet_dollars' => 15,
                'bonus_features' => [
                    'Great Hall of Spins',
                    'Wildstorm Feature',
                    'Multiple Free Spin Features'
                ],
                'demo_url' => 'https://demo.slots.com/thunderstruck-ii',
                'thumbnail_image' => '/images/slots/thunderstruck-ii.jpg',
                'release_date' => '2010-05-05',
                'popularity_score' => 86,
                'description' => 'Norse mythology themed slot with progressive free spin features.',
                'key_features' => 'Great Hall of Spins, 4 Free Spin Features',
                'hit_frequency' => '30.1%',
                'game_review_url' => '/slots/thunderstruck-ii-review'
            ],
            [
                'id' => 14,
                'name' => 'Big Bass Bonanza',
                'provider' => 'Pragmatic Play',
                'provider_id' => 5,
                'theme_category' => 'Fishing & Water',
                'rtp_percentage' => 96.71,
                'volatility' => 'High',
                'max_win_multiplier' => 210000,
                'paylines_count' => 10,
                'min_bet_cents' => 10,
                'max_bet_dollars' => 250,
                'bonus_features' => [
                    'Money Collect',
                    'Free Spins',
                    'Retrigger Feature'
                ],
                'demo_url' => 'https://demo.slots.com/big-bass-bonanza',
                'thumbnail_image' => '/images/slots/big-bass-bonanza.jpg',
                'release_date' => '2020-12-14',
                'popularity_score' => 87,
                'description' => 'Fishing-themed slot with money collect feature and free spins.',
                'key_features' => 'Money Collect Feature, Free Spins with Retriggers',
                'hit_frequency' => '23.8%',
                'game_review_url' => '/slots/big-bass-bonanza-review'
            ],
            [
                'id' => 15,
                'name' => 'Vikings Go Berzerk',
                'provider' => 'Yggdrasil',
                'provider_id' => 7,
                'theme_category' => 'Vikings & Norse',
                'rtp_percentage' => 96.10,
                'volatility' => 'High',
                'max_win_multiplier' => 262500,
                'paylines_count' => 25,
                'min_bet_cents' => 25,
                'max_bet_dollars' => 125,
                'bonus_features' => [
                    'Berzerk Mode',
                    'Free Spins',
                    'Sticky Wilds'
                ],
                'demo_url' => 'https://demo.slots.com/vikings-go-berzerk',
                'thumbnail_image' => '/images/slots/vikings-go-berzerk.jpg',
                'release_date' => '2016-11-24',
                'popularity_score' => 82,
                'description' => 'Viking adventure with berzerk mode and expanding wilds.',
                'key_features' => 'Berzerk Mode, Free Spins with Sticky Wilds',
                'hit_frequency' => '25.3%',
                'game_review_url' => '/slots/vikings-go-berzerk-review'
            ],
            [
                'id' => 16,
                'name' => 'Gates of Olympus',
                'provider' => 'Pragmatic Play',
                'provider_id' => 5,
                'theme_category' => 'Mythology & Gods',
                'rtp_percentage' => 96.50,
                'volatility' => 'High',
                'max_win_multiplier' => 500000,
                'paylines_count' => 0, // All ways
                'min_bet_cents' => 20,
                'max_bet_dollars' => 125,
                'bonus_features' => [
                    'Tumble Feature',
                    'Multiplier Symbols',
                    'Free Spins'
                ],
                'demo_url' => 'https://demo.slots.com/gates-of-olympus',
                'thumbnail_image' => '/images/slots/gates-of-olympus.jpg',
                'release_date' => '2021-02-13',
                'popularity_score' => 89,
                'description' => 'Zeus-powered slot with cascading wins and multiplier symbols.',
                'key_features' => 'Tumble Feature, Multiplier Symbols up to 500x',
                'hit_frequency' => '46.5%',
                'game_review_url' => '/slots/gates-of-olympus-review'
            ]
        ];

        // Sort by popularity score and return requested limit
        usort($slots, function($a, $b) {
            return $b['popularity_score'] <=> $a['popularity_score'];
        });

        return array_slice($slots, 0, $limit);
    }

    /**
     * Get slots filtered by provider
     * 
     * @param string $provider Provider name
     * @return array Filtered slots
     */
    public function getSlotsByProvider(string $provider): array
    {
        $allSlots = $this->getPopularSlots(100);
        
        return array_filter($allSlots, function($slot) use ($provider) {
            return strtolower($slot['provider']) === strtolower($provider);
        });
    }

    /**
     * Get slots filtered by theme
     * 
     * @param string $theme Theme category
     * @return array Filtered slots
     */
    public function getSlotsByTheme(string $theme): array
    {
        $allSlots = $this->getPopularSlots(100);
        
        return array_filter($allSlots, function($slot) use ($theme) {
            return strtolower($slot['theme_category']) === strtolower($theme);
        });
    }

    /**
     * Get detailed analytics for a specific slot
     * 
     * @param int $slotId Slot ID
     * @return array Slot analytics data
     */
    public function getSlotAnalytics(int $slotId): array
    {
        $slots = $this->getPopularSlots(100);
        $slot = array_values(array_filter($slots, function($s) use ($slotId) {
            return $s['id'] === $slotId;
        }));

        if (empty($slot)) {
            return [];
        }

        $slot = $slot[0];

        return [
            'basic_info' => [
                'name' => $slot['name'],
                'provider' => $slot['provider'],
                'release_date' => $slot['release_date'],
                'theme' => $slot['theme_category']
            ],
            'mathematics' => [
                'rtp_percentage' => $slot['rtp_percentage'],
                'volatility' => $slot['volatility'],
                'hit_frequency' => $slot['hit_frequency'],
                'max_win' => $slot['max_win_multiplier']
            ],
            'gameplay' => [
                'paylines' => $slot['paylines_count'],
                'min_bet' => $slot['min_bet_cents'] / 100,
                'max_bet' => $slot['max_bet_dollars'],
                'bonus_features' => $slot['bonus_features']
            ],
            'performance' => [
                'popularity_score' => $slot['popularity_score'],
                'player_rating' => round($slot['popularity_score'] / 10, 1),
                'traffic_rank' => $this->calculateTrafficRank($slot['popularity_score'])
            ]
        ];
    }

    /**
     * Get demo game URL for a slot
     * 
     * @param int $slotId Slot ID
     * @return string Demo URL
     */
    public function getDemoGameUrl(int $slotId): string
    {
        $slots = $this->getPopularSlots(100);
        $slot = array_values(array_filter($slots, function($s) use ($slotId) {
            return $s['id'] === $slotId;
        }));

        return $slot[0]['demo_url'] ?? '';
    }

    /**
     * Get all slot categories
     * 
     * @return array Available themes and providers
     */
    public function getSlotCategories(): array
    {
        return [
            'themes' => [
                'Space & Gems',
                'Adventure & Mythology', 
                'Adventure',
                'Safari & Animals',
                'Gothic & Romance',
                'Animals & Nature',
                'Aliens & Space',
                'Animals & Safari',
                'Mining & Gold',
                'Western',
                'Candy & Sweets',
                'Animals & Pets',
                'Mythology & Gods',
                'Fishing & Water',
                'Vikings & Norse'
            ],
            'providers' => [
                'NetEnt',
                'Play\'n GO',
                'Microgaming',
                'Playtech',
                'Pragmatic Play',
                'Big Time Gaming',
                'Yggdrasil'
            ],
            'volatility_levels' => [
                'Low',
                'Medium', 
                'High'
            ],
            'rtp_ranges' => [
                'Below 95%',
                '95% - 96%',
                '96% - 97%',
                'Above 97%'
            ]
        ];
    }

    /**
     * Get slots with RTP analysis
     * 
     * @return array RTP statistics and recommendations
     */
    public function getRTPAnalysis(): array
    {
        $slots = $this->getPopularSlots(100);
        
        $rtpData = array_column($slots, 'rtp_percentage');
        
        return [
            'average_rtp' => round(array_sum($rtpData) / count($rtpData), 2),
            'highest_rtp' => max($rtpData),
            'lowest_rtp' => min($rtpData),
            'high_rtp_slots' => array_filter($slots, function($slot) {
                return $slot['rtp_percentage'] >= 96.5;
            }),
            'rtp_distribution' => [
                'below_95' => count(array_filter($rtpData, fn($rtp) => $rtp < 95)),
                '95_to_96' => count(array_filter($rtpData, fn($rtp) => $rtp >= 95 && $rtp < 96)),
                '96_to_97' => count(array_filter($rtpData, fn($rtp) => $rtp >= 96 && $rtp < 97)),
                'above_97' => count(array_filter($rtpData, fn($rtp) => $rtp >= 97))
            ]
        ];
    }

    /**
     * Get volatility analysis
     * 
     * @return array Volatility statistics
     */
    public function getVolatilityAnalysis(): array
    {
        $slots = $this->getPopularSlots(100);
        
        $volatilityData = array_column($slots, 'volatility');
        $volatilityCounts = array_count_values($volatilityData);
        
        return [
            'distribution' => $volatilityCounts,
            'recommendations' => [
                'low' => array_filter($slots, fn($slot) => $slot['volatility'] === 'Low'),
                'medium' => array_filter($slots, fn($slot) => $slot['volatility'] === 'Medium'),
                'high' => array_filter($slots, fn($slot) => $slot['volatility'] === 'High')
            ]
        ];
    }

    /**
     * Filter slots by multiple criteria
     * 
     * @param array $filters Filter criteria
     * @return array Filtered slots
     */
    public function filterSlots(array $filters): array
    {
        $slots = $this->getPopularSlots(100);
        
        foreach ($filters as $key => $value) {
            if (empty($value)) continue;
            
            switch ($key) {
                case 'provider':
                    $slots = array_filter($slots, fn($slot) => $slot['provider'] === $value);
                    break;
                case 'theme':
                    $slots = array_filter($slots, fn($slot) => $slot['theme_category'] === $value);
                    break;
                case 'volatility':
                    $slots = array_filter($slots, fn($slot) => $slot['volatility'] === $value);
                    break;
                case 'min_rtp':
                    $slots = array_filter($slots, fn($slot) => $slot['rtp_percentage'] >= (float)$value);
                    break;
                case 'max_rtp':
                    $slots = array_filter($slots, fn($slot) => $slot['rtp_percentage'] <= (float)$value);
                    break;
            }
        }
        
        return array_values($slots);
    }

    /**
     * Calculate traffic rank based on popularity score
     * 
     * @param int $popularityScore Popularity score
     * @return string Traffic rank
     */
    private function calculateTrafficRank(int $popularityScore): string
    {
        if ($popularityScore >= 90) return 'Top 10';
        if ($popularityScore >= 85) return 'Top 25';
        if ($popularityScore >= 80) return 'Top 50';
        return 'Popular';
    }
}
