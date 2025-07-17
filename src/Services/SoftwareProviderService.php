<?php

namespace App\Services;

class SoftwareProviderService
{
    public function getAllProviders()
    {
        return [
            'netent' => [
                'name' => 'NetEnt',
                'full_name' => 'Net Entertainment',
                'founded' => 1996,
                'headquarters' => 'Stockholm, Sweden',
                'specialties' => ['Video Slots', 'Progressive Jackpots', 'Mobile Games'],
                'game_count' => 200,
                'quality_rating' => 4.8,
                'canadian_casinos' => 15,
                'popular_games' => ['Starburst', 'Gonzo\'s Quest', 'Dead or Alive 2'],
                'features' => [
                    'HTML5 Technology',
                    'Mobile-First Design',
                    'Branded Content',
                    'Tournament Tools'
                ],
                'certifications' => ['MGA', 'UKGC', 'AGCO'],
                'description' => 'NetEnt is a premium provider of digitally distributed gaming systems used by some of the world\'s most successful online casino operators. Known for high-quality graphics, innovative features, and mobile-optimized games.',
                'logo_url' => '/images/providers/netent-logo.png'
            ],
            'microgaming' => [
                'name' => 'Microgaming',
                'full_name' => 'Microgaming Systems Ltd',
                'founded' => 1994,
                'headquarters' => 'Isle of Man',
                'specialties' => ['Progressive Jackpots', 'Branded Slots', 'Table Games'],
                'game_count' => 800,
                'quality_rating' => 4.7,
                'canadian_casinos' => 18,
                'popular_games' => ['Mega Moolah', 'Immortal Romance', 'Thunderstruck II'],
                'features' => [
                    'Mega Moolah Network',
                    'Quickfire Platform',
                    'VR Gaming',
                    'Cryptocurrency Support'
                ],
                'certifications' => ['MGA', 'UKGC', 'eCOGRA'],
                'description' => 'Microgaming is the world\'s leading supplier of online gaming software, holding the Guinness World Record for the largest jackpot payout in an online slot machine game.',
                'logo_url' => '/images/providers/microgaming-logo.png'
            ],
            'evolution' => [
                'name' => 'Evolution Gaming',
                'full_name' => 'Evolution Gaming Group AB',
                'founded' => 2006,
                'headquarters' => 'Stockholm, Sweden',
                'specialties' => ['Live Dealer Games', 'Game Shows', 'Live Casino'],
                'game_count' => 500,
                'quality_rating' => 4.9,
                'canadian_casinos' => 12,
                'popular_games' => ['Lightning Roulette', 'Dream Catcher', 'Crazy Time'],
                'features' => [
                    'Live HD Streaming',
                    'Multi-Camera Setup',
                    'Game Show Innovation',
                    'Mobile Live Gaming'
                ],
                'certifications' => ['MGA', 'UKGC', 'AGCO', 'BCLC'],
                'description' => 'Evolution Gaming is the leading provider of Live Casino solutions, delivering unparalleled live gaming experiences with professional dealers and cutting-edge technology.',
                'logo_url' => '/images/providers/evolution-logo.png'
            ],
            'playtech' => [
                'name' => 'Playtech',
                'full_name' => 'Playtech PLC',
                'founded' => 1999,
                'headquarters' => 'London, UK',
                'specialties' => ['Marvel Slots', 'Live Casino', 'Sports Betting'],
                'game_count' => 400,
                'quality_rating' => 4.6,
                'canadian_casinos' => 14,
                'popular_games' => ['Age of the Gods', 'Gladiator', 'Buffalo Blitz'],
                'features' => [
                    'Omni-Channel Platform',
                    'Marvel Partnership',
                    'Live Casino Studios',
                    'Sports Integration'
                ],
                'certifications' => ['MGA', 'UKGC', 'AGCO'],
                'description' => 'Playtech is a leading gaming software company that provides cutting-edge gaming, sports betting, and financial trading solutions to the world\'s leading operators.',
                'logo_url' => '/images/providers/playtech-logo.png'
            ],
            'play-n-go' => [
                'name' => 'Play\'n GO',
                'full_name' => 'Play\'n GO AB',
                'founded' => 1997,
                'headquarters' => 'Stockholm, Sweden',
                'specialties' => ['Mobile Slots', 'Classic Slots', 'Table Games'],
                'game_count' => 300,
                'quality_rating' => 4.5,
                'canadian_casinos' => 16,
                'popular_games' => ['Book of Dead', 'Reactoonz', 'Rise of Olympus'],
                'features' => [
                    'Mobile-First Approach',
                    'High Volatility Games',
                    'Mythology Themes',
                    'Cluster Pay Mechanics'
                ],
                'certifications' => ['MGA', 'UKGC', 'AGCO'],
                'description' => 'Play\'n GO is a Swedish casino software developer known for creating engaging mobile-first slot games with innovative features and stunning graphics.',
                'logo_url' => '/images/providers/play-n-go-logo.png'
            ],
            'pragmatic-play' => [
                'name' => 'Pragmatic Play',
                'full_name' => 'Pragmatic Play Ltd',
                'founded' => 2015,
                'headquarters' => 'Malta',
                'specialties' => ['Video Slots', 'Live Casino', 'Bingo'],
                'game_count' => 250,
                'quality_rating' => 4.4,
                'canadian_casinos' => 13,
                'popular_games' => ['Sweet Bonanza', 'The Dog House', 'Gates of Olympus'],
                'features' => [
                    'Buy Feature Slots',
                    'Megaways Mechanics',
                    'Live Casino Games',
                    'Bingo Products'
                ],
                'certifications' => ['MGA', 'UKGC', 'AGCO'],
                'description' => 'Pragmatic Play is a world-leading game developer providing player-favorites to the most successful global brands in the iGaming industry.',
                'logo_url' => '/images/providers/pragmatic-play-logo.png'
            ],
            'red-tiger' => [
                'name' => 'Red Tiger Gaming',
                'full_name' => 'Red Tiger Gaming Ltd',
                'founded' => 2014,
                'headquarters' => 'Isle of Man',
                'specialties' => ['Asian-Themed Slots', 'Daily Jackpots', 'Table Games'],
                'game_count' => 150,
                'quality_rating' => 4.3,
                'canadian_casinos' => 11,
                'popular_games' => ['Dragon\'s Luck', 'Pirates\' Plenty', 'Mystery Reels'],
                'features' => [
                    'Daily Jackpot Network',
                    'Asian Market Focus',
                    'High-Quality Graphics',
                    'Mathematical Models'
                ],
                'certifications' => ['MGA', 'UKGC', 'AGCO'],
                'description' => 'Red Tiger Gaming creates innovative slot games with a focus on Asian markets and daily jackpot mechanics, now part of the NetEnt family.',
                'logo_url' => '/images/providers/red-tiger-logo.png'
            ],
            'big-time-gaming' => [
                'name' => 'Big Time Gaming',
                'full_name' => 'Big Time Gaming Pty Ltd',
                'founded' => 2011,
                'headquarters' => 'Sydney, Australia',
                'specialties' => ['Megaways Slots', 'High Volatility', 'Feature Buy'],
                'game_count' => 100,
                'quality_rating' => 4.2,
                'canadian_casinos' => 9,
                'popular_games' => ['Bonanza', 'Extra Chilli', 'Who Wants to Be a Millionaire'],
                'features' => [
                    'Megaways Mechanic',
                    'Feature Buy Options',
                    'High Volatility Design',
                    'Innovative Mathematics'
                ],
                'certifications' => ['MGA', 'UKGC'],
                'description' => 'Big Time Gaming is the creator of the revolutionary Megaways mechanic, developing high-volatility slots with innovative features and massive win potential.',
                'logo_url' => '/images/providers/big-time-gaming-logo.png'
            ]
        ];
    }

    public function getProvider($slug)
    {
        $providers = $this->getAllProviders();
        return $providers[$slug] ?? null;
    }

    public function getProviderCategories()
    {
        return [
            'all' => 'All Providers',
            'slots' => 'Video Slots',
            'live' => 'Live Casino',
            'table' => 'Table Games',
            'jackpots' => 'Progressive Jackpots',
            'mobile' => 'Mobile Gaming'
        ];
    }

    public function getProvidersByCategory($category)
    {
        $providers = $this->getAllProviders();
        
        if ($category === 'all') {
            return $providers;
        }
        
        $filtered = [];
        foreach ($providers as $slug => $provider) {
            $specialties = array_map('strtolower', $provider['specialties']);
            
            switch ($category) {
                case 'slots':
                    if (in_array('video slots', $specialties) || in_array('branded slots', $specialties)) {
                        $filtered[$slug] = $provider;
                    }
                    break;
                case 'live':
                    if (in_array('live dealer games', $specialties) || in_array('live casino', $specialties)) {
                        $filtered[$slug] = $provider;
                    }
                    break;
                case 'table':
                    if (in_array('table games', $specialties)) {
                        $filtered[$slug] = $provider;
                    }
                    break;
                case 'jackpots':
                    if (in_array('progressive jackpots', $specialties)) {
                        $filtered[$slug] = $provider;
                    }
                    break;
                case 'mobile':
                    if (in_array('mobile games', $specialties) || in_array('mobile slots', $specialties)) {
                        $filtered[$slug] = $provider;
                    }
                    break;
            }
        }
        
        return $filtered;
    }

    public function getTopProviders($limit = 6)
    {
        $providers = $this->getAllProviders();
        
        // Sort by quality rating
        uasort($providers, function($a, $b) {
            return $b['quality_rating'] <=> $a['quality_rating'];
        });
        
        return array_slice($providers, 0, $limit, true);
    }

    public function getProviderStatistics()
    {
        $providers = $this->getAllProviders();
        
        return [
            'total_providers' => count($providers),
            'total_games' => array_sum(array_column($providers, 'game_count')),
            'avg_rating' => round(array_sum(array_column($providers, 'quality_rating')) / count($providers), 1),
            'total_casinos' => array_sum(array_column($providers, 'canadian_casinos')),
            'casino_partnerships' => array_sum(array_column($providers, 'canadian_casinos'))
        ];
    }
}
