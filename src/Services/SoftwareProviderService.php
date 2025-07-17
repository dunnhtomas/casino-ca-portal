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
                'description' => 'NetEnt is a premium provider of digitally distributed gaming systems used by some of the world\'s most successful online casino operators.',
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
                'certifications' => ['MGA', 'UKGC', 'eCOGRA'],
                'description' => 'Microgaming is the world\'s leading supplier of online gaming software.',
            ],
            'evolution' => [
                'name' => 'Evolution Gaming',
                'founded' => 2006,
                'game_count' => 500,
                'quality_rating' => 4.9,
                'canadian_casinos' => 12,
                'specialties' => ['Live Dealer Games', 'Game Shows', 'Live Casino'],
                'description' => 'Evolution Gaming is the leading provider of Live Casino solutions.',
            ]
        ];
    }

    public function getProviderCategories()
    {
        return [
            'Video Slots',
            'Live Dealer',
            'Table Games',
            'Progressive Jackpots',
            'Mobile Games'
        ];
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