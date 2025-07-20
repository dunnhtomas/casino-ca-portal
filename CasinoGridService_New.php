<?php
namespace App\Services;

/**
 * Casino Grid Service - Updated to use CasinoDataService
 * Now serves data from our 28 researched casinos
 */
class CasinoGridService 
{
    private $casinoDataService;
    
    public function __construct()
    {
        $this->casinoDataService = new CasinoDataService();
    }

    /**
     * Get all casinos - now from researched data
     */
    public function getAllCasinos(): array 
    {
        return $this->casinoDataService->getAllCasinos();
    }
    
    /**
     * Get available casino categories
     */
    public function getCategories(): array 
    {
        return [
            'all' => 'All Casinos',
            'top-rated' => 'Top Rated',
            'mobile' => 'Mobile Optimized',
            'canadian' => 'Canadian Friendly',
            'live-casino' => 'Live Casino',
            'slots' => 'Best Slots',
            'crypto' => 'Crypto Casinos'
        ];
    }
    
    /**
     * Filter casinos by various criteria
     */
    public function filterCasinos($filters = [])
    {
        return $this->casinoDataService->filterCasinos($filters);
    }
    
    /**
     * Get available filter options
     */
    public function getFilterOptions()
    {
        $casinos = $this->getAllCasinos();
        
        // Extract unique values for filters
        $licenses = array_unique(array_column($casinos, 'license'));
        $categories = [];
        foreach ($casinos as $casino) {
            $categories = array_merge($categories, $casino['categories']);
        }
        $categories = array_unique($categories);
        
        return [
            'categories' => $categories,
            'licenses' => $licenses,
            'rating_ranges' => [
                '4.5+' => '4.5+',
                '4.0+' => '4.0+',
                '3.5+' => '3.5+',
                '3.0+' => '3.0+'
            ],
            'established_ranges' => [
                '2020+' => '2020+',
                '2015+' => '2015+',
                '2010+' => '2010+',
                'Before 2010' => 'Before 2010'
            ]
        ];
    }
    
    /**
     * Check if established year matches range
     */
    private function matchesEstablishedRange($established, $range)
    {
        switch ($range) {
            case '2020+':
                return $established >= 2020;
            case '2015+':
                return $established >= 2015;
            case '2010+':
                return $established >= 2010;
            case 'Before 2010':
                return $established < 2010;
            default:
                return true;
        }
    }
    
    /**
     * Get casino by ID
     */
    public function getCasinoById($id)
    {
        return $this->casinoDataService->getCasinoById($id);
    }
    
    /**
     * Get multiple casinos by IDs
     */
    public function getCasinosByIds($ids)
    {
        return $this->casinoDataService->getCasinosByIds($ids);
    }
    
    /**
     * Get casino statistics
     */
    public function getStatistics()
    {
        $casinos = $this->getAllCasinos();
        
        return [
            'total_casinos' => count($casinos),
            'top_rated' => count(array_filter($casinos, function($casino) {
                return in_array('top-rated', $casino['categories']);
            })),
            'mobile_casinos' => count(array_filter($casinos, function($casino) {
                return in_array('mobile', $casino['categories']);
            })),
            'live_casinos' => count(array_filter($casinos, function($casino) {
                return in_array('live-casino', $casino['categories']);
            })),
            'canadian_casinos' => count(array_filter($casinos, function($casino) {
                return in_array('canadian', $casino['categories']);
            })),
            'avg_rating' => $this->casinoDataService->getStats()['average_rating'],
            'total_games' => $this->casinoDataService->getStats()['total_games']
        ];
    }

    /**
     * Sort casinos by specified field
     */
    public function sortCasinos(array $casinos, string $sortBy, string $direction = 'desc'): array 
    {
        return $this->casinoDataService->sortCasinos($casinos, $sortBy, $direction);
    }

    /**
     * Get paginated casino results
     */
    public function paginateCasinos(array $casinos, int $page = 1, int $perPage = 20): array 
    {
        return $this->casinoDataService->paginateCasinos($casinos, $page, $perPage);
    }
}
