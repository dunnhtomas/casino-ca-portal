<?php
namespace App\Services;

/**
 * Casino Grid Service - Updated to use CasinoDataService
 * Now serves data from our 28 researched casinos with full pagination support
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
     * Sort casinos by specified field
     */
    public function sortCasinos(array $casinos, string $sortBy, string $direction = 'desc'): array 
    {
        usort($casinos, function($a, $b) use ($sortBy, $direction) {
            $aValue = $a[$sortBy] ?? 0;
            $bValue = $b[$sortBy] ?? 0;
            
            // Handle different data types
            if ($sortBy === 'rating') {
                $comparison = $aValue <=> $bValue;
            } elseif ($sortBy === 'established') {
                $comparison = $aValue <=> $bValue;
            } elseif ($sortBy === 'name') {
                $comparison = strcmp($aValue, $bValue);
            } else {
                $comparison = $aValue <=> $bValue;
            }
            
            return $direction === 'desc' ? -$comparison : $comparison;
        });
        
        return $casinos;
    }
    
    /**
     * Get paginated casino results - REQUIRED by CasinoGridController
     */
    public function paginateCasinos(array $casinos, int $page = 1, int $perPage = 20): array 
    {
        $total = count($casinos);
        $offset = ($page - 1) * $perPage;
        $items = array_slice($casinos, $offset, $perPage);
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage),
            'hasMore' => $page * $perPage < $total
        ];
    }

    /**
     * Get available filter options
     */
    public function getFilterOptions()
    {
        return [
            'rating' => [
                'min' => 1.0,
                'max' => 5.0,
                'step' => 0.1,
                'default_min' => 3.5
            ],
            'categories' => $this->getCategories()
        ];
    }

    /**
     * Get casino by ID or slug
     */
    public function getCasinoById($id)
    {
        return $this->casinoDataService->getCasinoById($id);
    }

    /**
     * Get statistics about all casinos
     */
    public function getStatistics()
    {
        $casinos = $this->getAllCasinos();
        
        return [
            'total_casinos' => count($casinos),
            'average_rating' => count($casinos) > 0 ? round(array_sum(array_column($casinos, 'rating')) / count($casinos), 1) : 0,
            'featured_casinos' => count(array_filter($casinos, function($casino) {
                return isset($casino['featured']) && $casino['featured'];
            })),
            'crypto_casinos' => count(array_filter($casinos, function($casino) {
                return isset($casino['categories']) && is_array($casino['categories']) && in_array('crypto', $casino['categories']);
            })),
            'mobile_casinos' => count(array_filter($casinos, function($casino) {
                return isset($casino['categories']) && is_array($casino['categories']) && in_array('mobile', $casino['categories']);
            }))
        ];
    }
}
?>
