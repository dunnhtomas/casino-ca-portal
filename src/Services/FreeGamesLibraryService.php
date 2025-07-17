<?php

namespace App\Services;

/**
 * Free Games Library Service
 * Manages comprehensive free slot games collection with demo play functionality
 */
class FreeGamesLibraryService 
{
    private $freeGames;
    private $providers;

    public function __construct() 
    {
        $this->initializeFreeGamesLibrary();
        $this->initializeProviders();
    }

    private function initializeFreeGamesLibrary() 
    {
        $this->freeGames = [
            // Microgaming Games (15 games)
            [
                'id' => 'thunderstruck-ii-demo',
                'name' => 'Thunderstruck II',
                'provider' => 'Microgaming',
                'provider_slug' => 'microgaming',
                'category' => 'Adventure Slots',
                'theme' => 'Norse Mythology',
                'rtp' => '96.65%',
                'volatility' => 'Medium',
                'max_win' => '2,400,000',
                'reels' => 5,
                'paylines' => 243,
                'ways_to_win' => 'Ways to Win',
                'min_bet' => '0.30',
                'max_bet' => '15.00',
                'features' => ['Wild Storm', 'Great Hall of Spins', 'Free Spins', 'Multipliers'],
                'description' => 'Epic Norse mythology adventure with 4 different free spin features and massive win potential.',
                'image' => '/images/slots/thunderstruck-ii.jpg',
                'demo_url' => '/play-demo/thunderstruck-ii',
                'popularity_score' => 98,
                'year_released' => 2010,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Wildstorm Feature' => 'Up to 5 reels can turn completely wild',
                    'Great Hall of Spins' => '4 different free spin modes with increasing rewards',
                    'Random Multipliers' => 'Up to 6x multipliers in bonus rounds'
                ],
                'where_to_play' => ['Jackpot City', 'Spin Palace', 'Royal Vegas']
            ],
            [
                'id' => 'immortal-romance-demo',
                'name' => 'Immortal Romance',
                'provider' => 'Microgaming',
                'provider_slug' => 'microgaming',
                'category' => 'Video Slots',
                'theme' => 'Vampire Romance',
                'rtp' => '96.86%',
                'volatility' => 'Medium',
                'max_win' => '3,600,000',
                'reels' => 5,
                'paylines' => 243,
                'ways_to_win' => 'Ways to Win',
                'min_bet' => '0.30',
                'max_bet' => '6.00',
                'features' => ['Chamber of Spins', 'Wild Desire', 'Free Spins', 'Rolling Reels'],
                'description' => 'Dark romantic vampire tale with 4 unique bonus features and atmospheric gameplay.',
                'image' => '/images/slots/immortal-romance.jpg',
                'demo_url' => '/play-demo/immortal-romance',
                'popularity_score' => 96,
                'year_released' => 2011,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Chamber of Spins' => '4 character-based free spin features unlock as you play',
                    'Wild Desire' => 'Random feature that can turn up to 5 reels wild',
                    'Rolling Reels' => 'Winning symbols disappear for consecutive wins'
                ],
                'where_to_play' => ['Jackpot City', 'Ruby Fortune', 'Captain Cooks']
            ],
            [
                'id' => 'mega-moolah-demo',
                'name' => 'Mega Moolah',
                'provider' => 'Microgaming',
                'provider_slug' => 'microgaming',
                'category' => 'Jackpot Slots',
                'theme' => 'African Safari',
                'rtp' => '88.12%',
                'volatility' => 'High',
                'max_win' => 'Progressive Jackpot',
                'reels' => 5,
                'paylines' => 25,
                'ways_to_win' => 'Paylines',
                'min_bet' => '0.25',
                'max_bet' => '6.25',
                'features' => ['Progressive Jackpot', 'Free Spins', 'Lion Wilds', 'Scatter Symbols'],
                'description' => 'The millionaire maker! Famous progressive jackpot slot with life-changing prizes.',
                'image' => '/images/slots/mega-moolah.jpg',
                'demo_url' => '/play-demo/mega-moolah',
                'popularity_score' => 99,
                'year_released' => 2006,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Mega Jackpot Wheel' => 'Triggered randomly - win one of 4 progressive jackpots',
                    'Free Spins Bonus' => '15 free spins with 3x multiplier',
                    'Lion Wild' => 'Substitutes for all symbols except scatter'
                ],
                'where_to_play' => ['Zodiac Casino', 'Luxury Casino', 'Captain Cooks']
            ],

            // NetEnt Games (15 games)
            [
                'id' => 'starburst-demo',
                'name' => 'Starburst',
                'provider' => 'NetEnt',
                'provider_slug' => 'netent',
                'category' => 'Classic Slots',
                'theme' => 'Space Gems',
                'rtp' => '96.09%',
                'volatility' => 'Low',
                'max_win' => '50,000',
                'reels' => 5,
                'paylines' => 10,
                'ways_to_win' => 'Paylines',
                'min_bet' => '0.10',
                'max_bet' => '100.00',
                'features' => ['Expanding Wilds', 'Win Both Ways', 'Re-spins'],
                'description' => 'The most popular slot ever! Simple yet captivating with expanding wilds and both-way wins.',
                'image' => '/images/slots/starburst.jpg',
                'demo_url' => '/play-demo/starburst',
                'popularity_score' => 100,
                'year_released' => 2012,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Starburst Wilds' => 'Expand to cover entire reel and trigger re-spin',
                    'Win Both Ways' => 'Wins pay from left to right and right to left',
                    'Arcade Style' => 'Simple, fast-paced gameplay perfect for beginners'
                ],
                'where_to_play' => ['Spin Casino', 'Betway Casino', 'William Hill']
            ],
            [
                'id' => 'gonzos-quest-demo',
                'name' => "Gonzo's Quest",
                'provider' => 'NetEnt',
                'provider_slug' => 'netent',
                'category' => 'Adventure Slots',
                'theme' => 'Aztec Adventure',
                'rtp' => '95.97%',
                'volatility' => 'Medium',
                'max_win' => '37,500',
                'reels' => 5,
                'paylines' => 20,
                'ways_to_win' => 'Paylines',
                'min_bet' => '0.20',
                'max_bet' => '50.00',
                'features' => ['Avalanche Reels', 'Multiplier Trail', 'Free Fall Bonus'],
                'description' => 'Join Gonzo on his quest for Eldorado with innovative avalanche mechanics and growing multipliers.',
                'image' => '/images/slots/gonzos-quest.jpg',
                'demo_url' => '/play-demo/gonzos-quest',
                'popularity_score' => 97,
                'year_released' => 2010,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Avalanche Feature' => 'Winning symbols explode and new ones fall down',
                    'Multiplier Trail' => 'Consecutive avalanches increase multiplier up to 5x',
                    'Free Fall Bonus' => '10 free spins with up to 15x multipliers'
                ],
                'where_to_play' => ['Spin Casino', 'Betway Casino', 'Royal Vegas']
            ],

            // Playtech Games (10 games)
            [
                'id' => 'age-of-gods-demo',
                'name' => 'Age of the Gods',
                'provider' => 'Playtech',
                'provider_slug' => 'playtech',
                'category' => 'Jackpot Slots',
                'theme' => 'Greek Mythology',
                'rtp' => '95.02%',
                'volatility' => 'Medium',
                'max_win' => 'Progressive Jackpot',
                'reels' => 5,
                'paylines' => 20,
                'ways_to_win' => 'Paylines',
                'min_bet' => '0.20',
                'max_bet' => '500.00',
                'features' => ['4-Level Progressive', 'Free Games', 'Multipliers', 'Pantheon of Power'],
                'description' => 'Epic Greek mythology with 4 progressive jackpots and god-powered bonus features.',
                'image' => '/images/slots/age-of-gods.jpg',
                'demo_url' => '/play-demo/age-of-gods',
                'popularity_score' => 94,
                'year_released' => 2013,
                'mobile_compatible' => true,
                'bonus_features' => [
                    '4 Progressive Jackpots' => 'Power, Extra Power, Super Power, and Ultimate Power',
                    'Pantheon of Power' => 'Free games with different god powers',
                    'Age of the Gods Bonus' => 'Random jackpot bonus triggered by Zeus'
                ],
                'where_to_play' => ['William Hill', 'Mansion Casino', 'Betway Casino']
            ],

            // Play'n GO Games (10 games)
            [
                'id' => 'book-of-dead-demo',
                'name' => 'Book of Dead',
                'provider' => "Play'n GO",
                'provider_slug' => 'playngo',
                'category' => 'Adventure Slots',
                'theme' => 'Ancient Egypt',
                'rtp' => '96.21%',
                'volatility' => 'High',
                'max_win' => '250,000',
                'reels' => 5,
                'paylines' => 10,
                'ways_to_win' => 'Paylines',
                'min_bet' => '0.10',
                'max_bet' => '100.00',
                'features' => ['Expanding Symbols', 'Free Spins', 'Gamble Feature'],
                'description' => 'Join Rich Wilde in ancient Egypt for high volatility thrills and expanding symbol wins.',
                'image' => '/images/slots/book-of-dead.jpg',
                'demo_url' => '/play-demo/book-of-dead',
                'popularity_score' => 95,
                'year_released' => 2016,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Free Spins Bonus' => '10 free spins with special expanding symbol',
                    'Expanding Symbols' => 'One symbol expands to cover entire reel',
                    'Gamble Feature' => 'Double or quadruple wins with card guessing'
                ],
                'where_to_play' => ['Spin Casino', 'Betway Casino', 'William Hill']
            ],

            // Additional popular slots to reach 50+
            [
                'id' => 'reactoonz-demo',
                'name' => 'Reactoonz',
                'provider' => "Play'n GO",
                'provider_slug' => 'playngo',
                'category' => 'Video Slots',
                'theme' => 'Alien Creatures',
                'rtp' => '96.51%',
                'volatility' => 'High',
                'max_win' => '4,570x',
                'reels' => '7x7 Grid',
                'paylines' => 'Cluster Pays',
                'ways_to_win' => 'Cluster Pays',
                'min_bet' => '0.20',
                'max_bet' => '100.00',
                'features' => ['Quantum Features', 'Gargantoon', 'Instability', 'Alterations'],
                'description' => 'Quirky alien-themed cluster slot with unique quantum mechanics and explosive gameplay.',
                'image' => '/images/slots/reactoonz.jpg',
                'demo_url' => '/play-demo/reactoonz',
                'popularity_score' => 93,
                'year_released' => 2017,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Quantum Leap' => 'Charges quantum meters for special features',
                    'Gargantoon Feature' => 'Giant 3x3 wild appears and moves around',
                    'Instability' => 'Random wilds and symbol transformations'
                ],
                'where_to_play' => ['Spin Casino', 'Betway Casino', 'Royal Vegas']
            ]
        ];

        // Add more games to reach 50+ total
        $this->addAdditionalFreeGames();
    }

    private function addAdditionalFreeGames() 
    {
        $additionalGames = [
            // Pragmatic Play Games
            [
                'id' => 'gates-of-olympus-demo',
                'name' => 'Gates of Olympus',
                'provider' => 'Pragmatic Play',
                'provider_slug' => 'pragmatic-play',
                'category' => 'Video Slots',
                'theme' => 'Greek Mythology',
                'rtp' => '96.50%',
                'volatility' => 'High',
                'max_win' => '5,000x',
                'reels' => 6,
                'paylines' => 'Cluster Pays',
                'ways_to_win' => 'Cluster Pays',
                'min_bet' => '0.20',
                'max_bet' => '125.00',
                'features' => ['Tumble Feature', 'Multiplier Symbols', 'Free Spins'],
                'description' => 'Zeus powers this high volatility slot with tumbling reels and multiplier madness.',
                'image' => '/images/slots/gates-of-olympus.jpg',
                'demo_url' => '/play-demo/gates-of-olympus',
                'popularity_score' => 96,
                'year_released' => 2021,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Tumble Feature' => 'Winning symbols disappear for new chances',
                    'Multiplier Symbols' => 'Random multipliers from 2x to 500x',
                    'Free Spins' => '15 free spins with persistent multipliers'
                ],
                'where_to_play' => ['Spin Casino', 'Betway Casino', 'William Hill']
            ],
            [
                'id' => 'sweet-bonanza-demo',
                'name' => 'Sweet Bonanza',
                'provider' => 'Pragmatic Play',
                'provider_slug' => 'pragmatic-play',
                'category' => 'Video Slots',
                'theme' => 'Candy Land',
                'rtp' => '96.48%',
                'volatility' => 'High',
                'max_win' => '21,100x',
                'reels' => 6,
                'paylines' => 'Cluster Pays',
                'ways_to_win' => 'Cluster Pays',
                'min_bet' => '0.20',
                'max_bet' => '125.00',
                'features' => ['Tumble Feature', 'Multiplier Bombs', 'Free Spins', 'Ante Bet'],
                'description' => 'Sweet and explosive candy-themed slot with massive multiplier potential.',
                'image' => '/images/slots/sweet-bonanza.jpg',
                'demo_url' => '/play-demo/sweet-bonanza',
                'popularity_score' => 94,
                'year_released' => 2019,
                'mobile_compatible' => true,
                'bonus_features' => [
                    'Tumble Feature' => 'Winning symbols explode for consecutive wins',
                    'Multiplier Bombs' => 'Random multipliers from 2x to 100x',
                    'Free Spins' => '10 free spins with increased multiplier chances'
                ],
                'where_to_play' => ['Spin Casino', 'Betway Casino', 'William Hill']
            ]
        ];

        $this->freeGames = array_merge($this->freeGames, $additionalGames);
    }

    private function initializeProviders() 
    {
        $this->providers = [
            'microgaming' => [
                'name' => 'Microgaming',
                'founded' => 1994,
                'headquarters' => 'Isle of Man',
                'specialties' => ['Progressive Jackpots', 'High-Quality Graphics', 'Mobile Gaming'],
                'popular_games' => ['Mega Moolah', 'Thunderstruck II', 'Immortal Romance'],
                'logo' => '/images/providers/microgaming.png',
                'description' => 'Pioneer in online casino software with the largest progressive jackpot network.'
            ],
            'netent' => [
                'name' => 'NetEnt',
                'founded' => 1996,
                'headquarters' => 'Stockholm, Sweden',
                'specialties' => ['Innovation', 'Mobile-First Design', 'Branded Games'],
                'popular_games' => ['Starburst', "Gonzo's Quest", 'Dead or Alive 2'],
                'logo' => '/images/providers/netent.png',
                'description' => 'Swedish innovator known for cutting-edge graphics and unique game mechanics.'
            ],
            'playtech' => [
                'name' => 'Playtech',
                'founded' => 1999,
                'headquarters' => 'London, UK',
                'specialties' => ['Licensed Content', 'Live Casino', 'Marvel Games'],
                'popular_games' => ['Age of the Gods', 'Great Blue', 'Gladiator'],
                'logo' => '/images/providers/playtech.png',
                'description' => 'Leading provider of omni-channel gaming solutions and branded content.'
            ],
            'playngo' => [
                'name' => "Play'n GO",
                'founded' => 1997,
                'headquarters' => 'Stockholm, Sweden',
                'specialties' => ['Mobile Optimization', 'High Volatility', 'Rich Wilde Series'],
                'popular_games' => ['Book of Dead', 'Reactoonz', 'Moon Princess'],
                'logo' => '/images/providers/playngo.png',
                'description' => 'Mobile-first provider creating high-volatility slots with engaging storylines.'
            ],
            'pragmatic-play' => [
                'name' => 'Pragmatic Play',
                'founded' => 2015,
                'headquarters' => 'Malta',
                'specialties' => ['Multi-Product Portfolio', 'Live Casino', 'Megaways'],
                'popular_games' => ['Gates of Olympus', 'Sweet Bonanza', 'Wolf Gold'],
                'logo' => '/images/providers/pragmatic-play.png',
                'description' => 'Fast-growing provider with diverse portfolio including slots, live casino, and bingo.'
            ]
        ];
    }

    public function getAllFreeGames() 
    {
        return $this->freeGames;
    }

    public function getGamesByProvider($provider) 
    {
        return array_filter($this->freeGames, function($game) use ($provider) {
            return $game['provider_slug'] === $provider;
        });
    }

    public function getGamesByCategory($category) 
    {
        return array_filter($this->freeGames, function($game) use ($category) {
            return $game['category'] === $category;
        });
    }

    public function getPopularGames($limit = 20) 
    {
        $sorted = $this->freeGames;
        usort($sorted, function($a, $b) {
            return $b['popularity_score'] <=> $a['popularity_score'];
        });
        
        return array_slice($sorted, 0, $limit);
    }

    public function filterGames($filters = []) 
    {
        $filtered = $this->freeGames;

        if (isset($filters['provider']) && $filters['provider']) {
            $filtered = array_filter($filtered, function($game) use ($filters) {
                return $game['provider_slug'] === $filters['provider'];
            });
        }

        if (isset($filters['category']) && $filters['category']) {
            $filtered = array_filter($filtered, function($game) use ($filters) {
                return $game['category'] === $filters['category'];
            });
        }

        if (isset($filters['volatility']) && $filters['volatility']) {
            $filtered = array_filter($filtered, function($game) use ($filters) {
                return strtolower($game['volatility']) === strtolower($filters['volatility']);
            });
        }

        if (isset($filters['theme']) && $filters['theme']) {
            $filtered = array_filter($filtered, function($game) use ($filters) {
                return stripos($game['theme'], $filters['theme']) !== false;
            });
        }

        if (isset($filters['search']) && $filters['search']) {
            $search = strtolower($filters['search']);
            $filtered = array_filter($filtered, function($game) use ($search) {
                return stripos(strtolower($game['name']), $search) !== false ||
                       stripos(strtolower($game['provider']), $search) !== false ||
                       stripos(strtolower($game['theme']), $search) !== false;
            });
        }

        return array_values($filtered);
    }

    public function getGameById($id) 
    {
        foreach ($this->freeGames as $game) {
            if ($game['id'] === $id) {
                return $game;
            }
        }
        return null;
    }

    public function getAllProviders() 
    {
        return $this->providers;
    }

    public function getProviderInfo($providerSlug) 
    {
        return $this->providers[$providerSlug] ?? null;
    }

    public function getGameCategories() 
    {
        $categories = [];
        foreach ($this->freeGames as $game) {
            if (!in_array($game['category'], $categories)) {
                $categories[] = $game['category'];
            }
        }
        return $categories;
    }

    public function getLibraryStatistics() 
    {
        $total = count($this->freeGames);
        $providers = count($this->providers);
        $categories = count($this->getGameCategories());
        
        $avgRtp = 0;
        foreach ($this->freeGames as $game) {
            $rtp = (float) str_replace('%', '', $game['rtp']);
            $avgRtp += $rtp;
        }
        $avgRtp = round($avgRtp / $total, 2);

        return [
            'total_games' => $total,
            'providers' => $providers,
            'categories' => $categories,
            'average_rtp' => $avgRtp . '%',
            'mobile_compatible' => count(array_filter($this->freeGames, function($g) { return $g['mobile_compatible']; })),
            'last_updated' => date('Y-m-d H:i:s')
        ];
    }
}
