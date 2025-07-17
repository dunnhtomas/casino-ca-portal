<?php

namespace App\Services;

/**
 * Live Dealer Games Service
 * Manages live casino games data, providers, and streaming technology information
 */
class LiveDealerGamesService 
{
    private $liveGames;
    private $liveProviders;
    private $gameCategories;

    public function __construct() 
    {
        $this->initializeLiveGames();
        $this->initializeLiveProviders();
        $this->initializeGameCategories();
    }

    private function initializeLiveGames() 
    {
        $this->liveGames = [
            // Live Blackjack Variants
            [
                'id' => 'live-blackjack-classic',
                'name' => 'Live Blackjack Classic',
                'category' => 'Blackjack',
                'provider' => 'Evolution Gaming',
                'provider_slug' => 'evolution-gaming',
                'description' => 'Classic live blackjack with professional dealers in a luxurious studio setting.',
                'dealer_info' => [
                    'studio_location' => 'Riga, Latvia',
                    'languages' => ['English', 'French', 'German'],
                    'dealer_count' => 50,
                    'availability' => '24/7'
                ],
                'table_limits' => [
                    'min_bet' => 1,
                    'max_bet' => 10000,
                    'currency' => 'CAD'
                ],
                'features' => [
                    'Multi-hand play',
                    'Side bets available',
                    'Perfect Pairs',
                    '21+3 side bet',
                    'Insurance option'
                ],
                'streaming_quality' => [
                    'resolution' => '1080p HD',
                    'fps' => 60,
                    'technology' => 'WebRTC',
                    'mobile_optimized' => true
                ],
                'variants' => [
                    'Blackjack Party',
                    'Speed Blackjack',
                    'Infinite Blackjack',
                    'Blackjack VIP'
                ],
                'image' => '/images/live-games/live-blackjack.jpg',
                'popularity_score' => 98,
                'rtp' => '99.28%',
                'game_type' => 'table_game',
                'available_casinos' => ['Spin Casino', 'Betway Casino', 'Royal Vegas']
            ],
            [
                'id' => 'live-roulette-european',
                'name' => 'Live European Roulette',
                'category' => 'Roulette',
                'provider' => 'Evolution Gaming',
                'provider_slug' => 'evolution-gaming',
                'description' => 'Authentic European roulette with single zero for better odds and elegant studio atmosphere.',
                'dealer_info' => [
                    'studio_location' => 'Malta',
                    'languages' => ['English', 'French', 'Italian'],
                    'dealer_count' => 40,
                    'availability' => '24/7'
                ],
                'table_limits' => [
                    'min_bet' => 0.5,
                    'max_bet' => 50000,
                    'currency' => 'CAD'
                ],
                'features' => [
                    'Single zero wheel',
                    'En Prison rule',
                    'Multiple camera angles',
                    'Statistics tracking',
                    'Favorite bets'
                ],
                'streaming_quality' => [
                    'resolution' => '4K Ultra HD',
                    'fps' => 60,
                    'technology' => 'WebRTC',
                    'mobile_optimized' => true
                ],
                'variants' => [
                    'Speed Roulette',
                    'Immersive Roulette',
                    'Lightning Roulette',
                    'Auto Roulette'
                ],
                'image' => '/images/live-games/live-roulette.jpg',
                'popularity_score' => 96,
                'rtp' => '97.30%',
                'game_type' => 'table_game',
                'available_casinos' => ['Jackpot City', 'Spin Casino', 'William Hill']
            ],
            [
                'id' => 'live-baccarat-squeeze',
                'name' => 'Live Baccarat Squeeze',
                'category' => 'Baccarat',
                'provider' => 'Playtech',
                'provider_slug' => 'playtech',
                'description' => 'Premium baccarat with dramatic card squeeze for authentic VIP casino experience.',
                'dealer_info' => [
                    'studio_location' => 'Bucharest, Romania',
                    'languages' => ['English', 'Mandarin', 'Spanish'],
                    'dealer_count' => 25,
                    'availability' => '20 hours daily'
                ],
                'table_limits' => [
                    'min_bet' => 5,
                    'max_bet' => 25000,
                    'currency' => 'CAD'
                ],
                'features' => [
                    'Card squeeze animation',
                    'VIP table access',
                    'Side bets available',
                    'Roadmap statistics',
                    'Banker/Player trends'
                ],
                'streaming_quality' => [
                    'resolution' => '1080p HD',
                    'fps' => 30,
                    'technology' => 'Flash/HTML5',
                    'mobile_optimized' => true
                ],
                'variants' => [
                    'Speed Baccarat',
                    'No Commission Baccarat',
                    'Dragon Tiger',
                    'Baccarat Control Squeeze'
                ],
                'image' => '/images/live-games/live-baccarat.jpg',
                'popularity_score' => 94,
                'rtp' => '98.94%',
                'game_type' => 'table_game',
                'available_casinos' => ['Mansion Casino', 'William Hill', 'Betway Casino']
            ],
            [
                'id' => 'live-poker-caribbean',
                'name' => 'Live Caribbean Stud Poker',
                'category' => 'Poker',
                'provider' => 'Evolution Gaming',
                'provider_slug' => 'evolution-gaming',
                'description' => 'Classic Caribbean Stud Poker with progressive jackpot and professional dealers.',
                'dealer_info' => [
                    'studio_location' => 'Riga, Latvia',
                    'languages' => ['English', 'German'],
                    'dealer_count' => 15,
                    'availability' => '18 hours daily'
                ],
                'table_limits' => [
                    'min_bet' => 2,
                    'max_bet' => 5000,
                    'currency' => 'CAD'
                ],
                'features' => [
                    'Progressive jackpot',
                    '5+1 bonus bet',
                    'Hand rankings display',
                    'Strategy tips',
                    'Auto-play option'
                ],
                'streaming_quality' => [
                    'resolution' => '1080p HD',
                    'fps' => 60,
                    'technology' => 'WebRTC',
                    'mobile_optimized' => true
                ],
                'variants' => [
                    'Texas Hold\'em Bonus',
                    'Three Card Poker',
                    'Casino Hold\'em',
                    'Ultimate Texas Hold\'em'
                ],
                'image' => '/images/live-games/live-poker.jpg',
                'popularity_score' => 88,
                'rtp' => '97.74%',
                'game_type' => 'poker_variant',
                'available_casinos' => ['Spin Casino', 'Royal Vegas', 'Ruby Fortune']
            ],
            [
                'id' => 'live-wheel-of-fortune',
                'name' => 'Dream Catcher',
                'category' => 'Game Shows',
                'provider' => 'Evolution Gaming',
                'provider_slug' => 'evolution-gaming',
                'description' => 'Exciting money wheel game show with multipliers and bonus rounds.',
                'dealer_info' => [
                    'studio_location' => 'Malta',
                    'languages' => ['English', 'French'],
                    'dealer_count' => 10,
                    'availability' => '16 hours daily'
                ],
                'table_limits' => [
                    'min_bet' => 0.1,
                    'max_bet' => 2500,
                    'currency' => 'CAD'
                ],
                'features' => [
                    'Money wheel gameplay',
                    '2x and 7x multipliers',
                    'Interactive host',
                    'Multiple betting options',
                    'Statistics tracking'
                ],
                'streaming_quality' => [
                    'resolution' => '4K Ultra HD',
                    'fps' => 60,
                    'technology' => 'WebRTC',
                    'mobile_optimized' => true
                ],
                'variants' => [
                    'Monopoly Live',
                    'Crazy Time',
                    'Mega Ball',
                    'Deal or No Deal'
                ],
                'image' => '/images/live-games/dream-catcher.jpg',
                'popularity_score' => 92,
                'rtp' => '96.58%',
                'game_type' => 'game_show',
                'available_casinos' => ['Jackpot City', 'Spin Casino', 'Betway Casino']
            ],
            [
                'id' => 'live-sic-bo',
                'name' => 'Live Sic Bo',
                'category' => 'Dice Games',
                'provider' => 'Playtech',
                'provider_slug' => 'playtech',
                'description' => 'Traditional Chinese dice game with live dealers and multiple betting options.',
                'dealer_info' => [
                    'studio_location' => 'Manila, Philippines',
                    'languages' => ['English', 'Mandarin'],
                    'dealer_count' => 8,
                    'availability' => '20 hours daily'
                ],
                'table_limits' => [
                    'min_bet' => 1,
                    'max_bet' => 1000,
                    'currency' => 'CAD'
                ],
                'features' => [
                    'Three dice gameplay',
                    'Multiple bet types',
                    'High payout odds',
                    'Statistics display',
                    'Quick betting interface'
                ],
                'streaming_quality' => [
                    'resolution' => '1080p HD',
                    'fps' => 30,
                    'technology' => 'Flash/HTML5',
                    'mobile_optimized' => true
                ],
                'variants' => [
                    'Super Sic Bo',
                    'Lightning Dice',
                    'Mega Sic Bo'
                ],
                'image' => '/images/live-games/live-sic-bo.jpg',
                'popularity_score' => 85,
                'rtp' => '97.22%',
                'game_type' => 'dice_game',
                'available_casinos' => ['William Hill', 'Mansion Casino', 'Ruby Fortune']
            ],
            [
                'id' => 'live-craps',
                'name' => 'Live Craps',
                'category' => 'Dice Games',
                'provider' => 'Evolution Gaming',
                'provider_slug' => 'evolution-gaming',
                'description' => 'Authentic craps experience with live dealers and full betting layout.',
                'dealer_info' => [
                    'studio_location' => 'New Jersey, USA',
                    'languages' => ['English'],
                    'dealer_count' => 6,
                    'availability' => '12 hours daily'
                ],
                'table_limits' => [
                    'min_bet' => 5,
                    'max_bet' => 5000,
                    'currency' => 'CAD'
                ],
                'features' => [
                    'Full craps layout',
                    'Pass/Don\'t Pass bets',
                    'Odds betting',
                    'Field bets',
                    'Proposition bets'
                ],
                'streaming_quality' => [
                    'resolution' => '1080p HD',
                    'fps' => 60,
                    'technology' => 'WebRTC',
                    'mobile_optimized' => true
                ],
                'variants' => [
                    'Lightning Dice',
                    'Craps Classic'
                ],
                'image' => '/images/live-games/live-craps.jpg',
                'popularity_score' => 82,
                'rtp' => '98.64%',
                'game_type' => 'dice_game',
                'available_casinos' => ['Spin Casino', 'Betway Casino', 'Royal Vegas']
            ],
            [
                'id' => 'live-dragon-tiger',
                'name' => 'Live Dragon Tiger',
                'category' => 'Card Games',
                'provider' => 'Asia Gaming',
                'provider_slug' => 'asia-gaming',
                'description' => 'Simple and fast-paced Asian card game with live dealers.',
                'dealer_info' => [
                    'studio_location' => 'Macau',
                    'languages' => ['English', 'Mandarin', 'Cantonese'],
                    'dealer_count' => 12,
                    'availability' => '24/7'
                ],
                'table_limits' => [
                    'min_bet' => 1,
                    'max_bet' => 10000,
                    'currency' => 'CAD'
                ],
                'features' => [
                    'Simple Dragon vs Tiger',
                    'Tie bets available',
                    'Side bets',
                    'Fast gameplay',
                    'Statistics tracking'
                ],
                'streaming_quality' => [
                    'resolution' => '1080p HD',
                    'fps' => 30,
                    'technology' => 'WebRTC',
                    'mobile_optimized' => true
                ],
                'variants' => [
                    'Dragon Tiger Luck',
                    'Super Dragon Tiger'
                ],
                'image' => '/images/live-games/dragon-tiger.jpg',
                'popularity_score' => 87,
                'rtp' => '96.27%',
                'game_type' => 'card_game',
                'available_casinos' => ['Royal Vegas', 'Ruby Fortune', 'Captain Cooks']
            ]
        ];
    }

    private function initializeLiveProviders() 
    {
        $this->liveProviders = [
            'evolution-gaming' => [
                'name' => 'Evolution Gaming',
                'founded' => 2006,
                'headquarters' => 'Stockholm, Sweden',
                'specialties' => ['Live Casino', 'Game Shows', 'Mobile Gaming'],
                'studio_locations' => ['Latvia', 'Malta', 'Georgia', 'Spain', 'Canada'],
                'languages_supported' => 40,
                'technology' => 'WebRTC, HTML5',
                'certifications' => ['eCOGRA', 'GLI', 'iTech Labs'],
                'logo' => '/images/providers/evolution-gaming.png',
                'description' => 'World leader in live casino solutions with award-winning streaming technology.',
                'games_count' => 12,
                'quality_rating' => 98
            ],
            'playtech' => [
                'name' => 'Playtech',
                'founded' => 1999,
                'headquarters' => 'London, UK',
                'specialties' => ['Live Casino', 'Table Games', 'VIP Gaming'],
                'studio_locations' => ['Romania', 'Philippines', 'Latvia'],
                'languages_supported' => 25,
                'technology' => 'Flash, HTML5',
                'certifications' => ['GLI', 'BMM Testlabs', 'TST'],
                'logo' => '/images/providers/playtech.png',
                'description' => 'Established live casino provider with premium VIP gaming experiences.',
                'games_count' => 8,
                'quality_rating' => 94
            ],
            'asia-gaming' => [
                'name' => 'Asia Gaming',
                'founded' => 2012,
                'headquarters' => 'Manila, Philippines',
                'specialties' => ['Asian Games', 'Baccarat', 'Dragon Tiger'],
                'studio_locations' => ['Philippines', 'Cambodia', 'Macau'],
                'languages_supported' => 15,
                'technology' => 'HTML5, WebRTC',
                'certifications' => ['GLI', 'BMM Testlabs'],
                'logo' => '/images/providers/asia-gaming.png',
                'description' => 'Leading Asian live casino provider specializing in regional game preferences.',
                'games_count' => 4,
                'quality_rating' => 89
            ]
        ];
    }

    private function initializeGameCategories() 
    {
        $this->gameCategories = [
            'Blackjack' => [
                'description' => 'Classic 21 card game with professional dealers',
                'popularity' => 98,
                'avg_rtp' => '99.28%',
                'game_count' => 12
            ],
            'Roulette' => [
                'description' => 'European and American roulette variants',
                'popularity' => 96,
                'avg_rtp' => '97.30%',
                'game_count' => 8
            ],
            'Baccarat' => [
                'description' => 'High-stakes baccarat with squeeze features',
                'popularity' => 94,
                'avg_rtp' => '98.94%',
                'game_count' => 6
            ],
            'Poker' => [
                'description' => 'Poker variants with progressive jackpots',
                'popularity' => 88,
                'avg_rtp' => '97.74%',
                'game_count' => 4
            ],
            'Game Shows' => [
                'description' => 'Interactive game shows with live hosts',
                'popularity' => 92,
                'avg_rtp' => '96.58%',
                'game_count' => 5
            ],
            'Dice Games' => [
                'description' => 'Craps, Sic Bo and other dice-based games',
                'popularity' => 85,
                'avg_rtp' => '97.22%',
                'game_count' => 3
            ],
            'Card Games' => [
                'description' => 'Dragon Tiger and other card-based games',
                'popularity' => 87,
                'avg_rtp' => '96.27%',
                'game_count' => 2
            ]
        ];
    }

    public function getAllLiveGames() 
    {
        return $this->liveGames;
    }

    public function getPopularLiveGames($limit = 8) 
    {
        $sorted = $this->liveGames;
        usort($sorted, function($a, $b) {
            return $b['popularity_score'] <=> $a['popularity_score'];
        });
        
        return array_slice($sorted, 0, $limit);
    }

    public function getGamesByCategory($category) 
    {
        return array_filter($this->liveGames, function($game) use ($category) {
            return $game['category'] === $category;
        });
    }

    public function getGamesByProvider($providerSlug) 
    {
        return array_filter($this->liveGames, function($game) use ($providerSlug) {
            return $game['provider_slug'] === $providerSlug;
        });
    }

    public function getGameById($id) 
    {
        foreach ($this->liveGames as $game) {
            if ($game['id'] === $id) {
                return $game;
            }
        }
        return null;
    }

    public function getAllProviders() 
    {
        return $this->liveProviders;
    }

    public function getProviderInfo($providerSlug) 
    {
        return $this->liveProviders[$providerSlug] ?? null;
    }

    public function getGameCategories() 
    {
        return $this->gameCategories;
    }

    public function getLiveDealerStatistics() 
    {
        $totalGames = count($this->liveGames);
        $totalProviders = count($this->liveProviders);
        $totalCategories = count($this->gameCategories);
        
        $avgRtp = 0;
        foreach ($this->liveGames as $game) {
            $rtp = (float) str_replace('%', '', $game['rtp']);
            $avgRtp += $rtp;
        }
        $avgRtp = round($avgRtp / $totalGames, 2);

        $totalStudios = 0;
        foreach ($this->liveProviders as $provider) {
            $totalStudios += count($provider['studio_locations']);
        }

        return [
            'total_games' => $totalGames,
            'providers' => $totalProviders,
            'categories' => $totalCategories,
            'average_rtp' => $avgRtp . '%',
            'studio_locations' => $totalStudios,
            'last_updated' => date('Y-m-d H:i:s')
        ];
    }

    public function filterLiveGames($filters = []) 
    {
        $filtered = $this->liveGames;

        if (isset($filters['category']) && $filters['category']) {
            $filtered = array_filter($filtered, function($game) use ($filters) {
                return $game['category'] === $filters['category'];
            });
        }

        if (isset($filters['provider']) && $filters['provider']) {
            $filtered = array_filter($filtered, function($game) use ($filters) {
                return $game['provider_slug'] === $filters['provider'];
            });
        }

        if (isset($filters['min_bet']) && $filters['min_bet']) {
            $minBet = (float) $filters['min_bet'];
            $filtered = array_filter($filtered, function($game) use ($minBet) {
                return $game['table_limits']['min_bet'] <= $minBet;
            });
        }

        if (isset($filters['max_bet']) && $filters['max_bet']) {
            $maxBet = (float) $filters['max_bet'];
            $filtered = array_filter($filtered, function($game) use ($maxBet) {
                return $game['table_limits']['max_bet'] >= $maxBet;
            });
        }

        if (isset($filters['language']) && $filters['language']) {
            $filtered = array_filter($filtered, function($game) use ($filters) {
                return in_array($filters['language'], $game['dealer_info']['languages']);
            });
        }

        return array_values($filtered);
    }

    public function getHomepageLiveDealerData($limit = 8) 
    {
        $popularGames = $this->getPopularLiveGames($limit);
        $statistics = $this->getLiveDealerStatistics();
        $topProviders = array_slice($this->liveProviders, 0, 3, true);

        return [
            'games' => $popularGames,
            'statistics' => $statistics,
            'providers' => $topProviders,
            'categories' => $this->gameCategories
        ];
    }
}
