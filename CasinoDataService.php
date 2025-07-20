<?php
namespace App\Services;

/**
 * Unified Casino Data Service
 * Serves all casino data from OpenAI research results
 */
class CasinoDataService 
{
    private static $casinos = null;
    private static $casinoDatabase = null;
    
    public function __construct()
    {
        $this->loadCasinoDB();
    }
    
    /**
     * Load casino database from OpenAI research
     */
    private function loadCasinoDB(): void
    {
        if (self::$casinoDatabase !== null) {
            return;
        }
        
        $dbPath = __DIR__ . '/../../casino-research-openai-complete.json';
        if (!file_exists($dbPath)) {
            throw new \Exception('Casino database not found: ' . $dbPath);
        }
        
        $content = file_get_contents($dbPath);
        self::$casinoDatabase = json_decode($content, true);
        
        if (!self::$casinoDatabase || !isset(self::$casinoDatabase['casinos'])) {
            throw new \Exception('Invalid casino database format');
        }
    }
    
    /**
     * Get all casinos formatted for website use
     */
    public function getAllCasinos(): array
    {
        if (self::$casinos !== null) {
            return self::$casinos;
        }
        
        $this->loadCasinoDB();
        self::$casinos = [];
        
        foreach (self::$casinoDatabase['casinos'] as $index => $casino) {
            self::$casinos[] = $this->formatCasinoData($casino, $index + 1);
        }
        
        return self::$casinos;
    }
    
    /**
     * Get casino by ID
     */
    public function getCasinoById($id): ?array
    {
        $casinos = $this->getAllCasinos();
        foreach ($casinos as $casino) {
            if ($casino['id'] == $id) {
                return $casino;
            }
        }
        return null;
    }
    
    /**
     * Get casino by slug
     */
    public function getCasinoBySlug(string $slug): ?array
    {
        $casinos = $this->getAllCasinos();
        foreach ($casinos as $casino) {
            if ($casino['slug'] === $slug) {
                return $casino;
            }
        }
        return null;
    }
    
    /**
     * Get casinos by IDs
     */
    public function getCasinosByIds(array $ids): array
    {
        $casinos = $this->getAllCasinos();
        return array_filter($casinos, function($casino) use ($ids) {
            return in_array($casino['id'], $ids);
        });
    }
    
    /**
     * Filter casinos by criteria
     */
    public function filterCasinos(array $filters): array
    {
        $casinos = $this->getAllCasinos();
        
        foreach ($filters as $key => $value) {
            if (empty($value) || $key === 'page' || $key === 'limit' || $key === 'sort' || $key === 'order') {
                continue;
            }
            
            switch ($key) {
                case 'category':
                    if ($value !== 'all') {
                        $casinos = array_filter($casinos, function($casino) use ($value) {
                            return in_array($value, $casino['categories']);
                        });
                    }
                    break;
                    
                case 'rating':
                    $minRating = floatval($value);
                    $casinos = array_filter($casinos, function($casino) use ($minRating) {
                        return $casino['rating'] >= $minRating;
                    });
                    break;
                    
                case 'search':
                    $search = strtolower($value);
                    $casinos = array_filter($casinos, function($casino) use ($search) {
                        return strpos(strtolower($casino['name']), $search) !== false ||
                               strpos(strtolower($casino['bonus']), $search) !== false ||
                               strpos(strtolower($casino['license']), $search) !== false;
                    });
                    break;
            }
        }
        
        return $casinos;
    }
    
    /**
     * Sort casinos
     */
    public function sortCasinos(array $casinos, string $sortBy = 'rating', string $order = 'desc'): array
    {
        usort($casinos, function($a, $b) use ($sortBy, $order) {
            $valueA = $this->getSortValue($a, $sortBy);
            $valueB = $this->getSortValue($b, $sortBy);
            
            if ($order === 'asc') {
                return $valueA <=> $valueB;
            } else {
                return $valueB <=> $valueA;
            }
        });
        
        return $casinos;
    }
    
    /**
     * Paginate casinos
     */
    public function paginateCasinos(array $casinos, int $page = 1, int $perPage = 20): array
    {
        $totalItems = count($casinos);
        $totalPages = ceil($totalItems / $perPage);
        $offset = ($page - 1) * $perPage;
        
        return [
            'items' => array_slice($casinos, $offset, $perPage),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
            'perPage' => $perPage
        ];
    }
    
    /**
     * Format casino data from research to website format
     */
    private function formatCasinoData(array $casino, int $index): array
    {
        $slug = $this->generateSlug($casino['name']);
        
        return [
            'id' => $index,
            'original_id' => $casino['id'],
            'name' => $casino['name'],
            'slug' => $slug,
            'logo' => $this->generateLogo($casino['name']),
            'rating' => floatval($casino['rating'] ?? 7.0),
            'established' => $this->extractEstablishedYear($casino),
            'rtp' => $this->generateRTP($casino['rating']),
            'games' => number_format($casino['games_count'] ?? 1000) . '+',
            'games_count' => intval($casino['games_count'] ?? 1000),
            'bonus' => $casino['welcome_bonus'] ?? '100% up to $500',
            'payout' => $this->generatePayout($casino),
            'categories' => $this->generateCategories($casino),
            'featured' => $casino['rating'] >= 8.2,
            'license' => $casino['license'] ?? 'Licensed',
            'website_url' => $casino['website_url'] ?? '#',
            'play_url' => $casino['website_url'] ?? '#',
            'mobile_optimized' => $casino['mobile_optimized'] ?? true,
            'description' => $casino['description'] ?? '',
            'pros' => $casino['pros'] ?? [],
            'cons' => $casino['cons'] ?? [],
            'payment_methods' => $casino['payment_methods'] ?? ['Visa', 'Mastercard', 'Interac'],
            'software_providers' => $casino['software_providers'] ?? ['NetEnt', 'Microgaming'],
            'features' => $this->generateFeatures($casino),
            'commission_model' => $casino['commission_model'] ?? 'CPA',
            'priority' => $casino['priority'] ?? 'medium',
            'target_markets' => $casino['target_markets'] ?? ['CA'],
            'research_method' => $casino['research_method'] ?? 'openai'
        ];
    }
    
    /**
     * Generate slug from casino name
     */
    private function generateSlug(string $name): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    }
    
    /**
     * Generate logo placeholder
     */
    private function generateLogo(string $name): string
    {
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }
    
    /**
     * Extract established year
     */
    private function extractEstablishedYear(array $casino): int
    {
        if (isset($casino['founded']) && is_numeric($casino['founded'])) {
            return intval($casino['founded']);
        }
        
        if (isset($casino['established']) && is_numeric($casino['established'])) {
            return intval($casino['established']);
        }
        
        // Default based on casino tier
        $tier = $casino['tier'] ?? 'standard';
        return $tier === 'premium' ? 2015 : 2018;
    }
    
    /**
     * Generate RTP percentage
     */
    private function generateRTP(float $rating): string
    {
        $baseRTP = 95.5;
        $rtp = $baseRTP + ($rating - 7.0) * 0.5; // Higher rating = higher RTP
        return number_format($rtp, 2) . '%';
    }
    
    /**
     * Generate payout timeframe
     */
    private function generatePayout(array $casino): string
    {
        $rating = floatval($casino['rating'] ?? 7.0);
        
        if ($rating >= 8.5) return '1-3 hours';
        if ($rating >= 8.0) return '1-3 days';
        if ($rating >= 7.5) return '1-5 days';
        return '3-7 days';
    }
    
    /**
     * Generate casino categories
     */
    private function generateCategories(array $casino): array
    {
        $categories = [];
        $rating = floatval($casino['rating'] ?? 7.0);
        
        if ($rating >= 8.2) $categories[] = 'top-rated';
        if ($casino['mobile_optimized'] ?? true) $categories[] = 'mobile';
        if (in_array('CA', $casino['target_markets'] ?? [])) $categories[] = 'canadian';
        
        $categories[] = 'slots'; // All casinos have slots
        
        if (isset($casino['software_providers'])) {
            foreach ($casino['software_providers'] as $provider) {
                if (stripos($provider, 'evolution') !== false) {
                    $categories[] = 'live-casino';
                    break;
                }
            }
        }
        
        return array_unique($categories);
    }
    
    /**
     * Generate features list
     */
    private function generateFeatures(array $casino): array
    {
        $features = [];
        
        if ($casino['mobile_optimized'] ?? true) $features[] = 'Mobile Optimized';
        if (isset($casino['software_providers']) && count($casino['software_providers']) > 3) $features[] = 'Multi-Provider';
        if (strpos($casino['welcome_bonus'] ?? '', 'Free Spins') !== false) $features[] = 'Free Spins';
        if (floatval($casino['rating'] ?? 7.0) >= 8.0) $features[] = 'Top Rated';
        
        // Add provider-based features
        if (isset($casino['software_providers'])) {
            foreach ($casino['software_providers'] as $provider) {
                if (stripos($provider, 'evolution') !== false) $features[] = 'Live Casino';
                if (stripos($provider, 'netent') !== false) $features[] = 'NetEnt Games';
                if (stripos($provider, 'pragmatic') !== false) $features[] = 'Pragmatic Play';
            }
        }
        
        return array_unique(array_slice($features, 0, 4)); // Limit to 4 features
    }
    
    /**
     * Get sort value for casino
     */
    private function getSortValue(array $casino, string $sortBy)
    {
        switch ($sortBy) {
            case 'name':
                return $casino['name'];
            case 'rating':
                return $casino['rating'];
            case 'established':
                return $casino['established'];
            case 'games':
                return $casino['games_count'];
            case 'bonus':
                return $this->extractBonusAmount($casino['bonus']);
            default:
                return $casino['rating'];
        }
    }
    
    /**
     * Extract numeric amount from bonus string
     */
    private function extractBonusAmount(string $bonus): int
    {
        preg_match('/\$([0-9,]+)/', $bonus, $matches);
        return isset($matches[1]) ? intval(str_replace(',', '', $matches[1])) : 0;
    }
    
    /**
     * Get casino statistics
     */
    public function getStats(): array
    {
        $casinos = $this->getAllCasinos();
        
        $totalGames = 0;
        $totalRating = 0;
        $mobileOptimized = 0;
        
        foreach ($casinos as $casino) {
            $totalRating += $casino['rating'];
            $totalGames += intval($casino['games_count'] ?? 0);
            if ($casino['mobile_optimized'] ?? false) {
                $mobileOptimized++;
            }
        }
        
        return [
            'total_casinos' => count($casinos),
            'average_rating' => count($casinos) > 0 ? round($totalRating / count($casinos), 1) : 0,
            'total_games' => $totalGames,
            'mobile_optimized' => $mobileOptimized
        ];
    }
}
