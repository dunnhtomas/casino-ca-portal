<?php

namespace App\Controllers;

use App\Services\LiveDealerGamesService;

/**
 * Live Dealer Games Controller
 * Handles live casino games display, filtering, and provider information
 */
class LiveDealerGamesController 
{
    private $liveDealerService;

    public function __construct() 
    {
        $this->liveDealerService = new LiveDealerGamesService();
    }

    /**
     * Display main live dealer games page
     */
    public function index() 
    {
        $games = $this->liveDealerService->getAllLiveGames();
        $providers = $this->liveDealerService->getAllProviders();
        $categories = $this->liveDealerService->getGameCategories();
        $statistics = $this->liveDealerService->getLiveDealerStatistics();

        return [
            'page_title' => 'Live Dealer Casino Games - Real Dealers, Real Time | BestCasinoPortal.com',
            'meta_description' => 'Experience authentic casino gaming with live dealers. Play live blackjack, roulette, baccarat & more with professional dealers in HD quality.',
            'games' => $games,
            'providers' => $providers,
            'categories' => $categories,
            'statistics' => $statistics,
            'current_filters' => [],
            'view' => 'live-dealer-games'
        ];
    }

    /**
     * Filter live games based on criteria
     */
    public function filterGames() 
    {
        $filters = [
            'category' => $_GET['category'] ?? '',
            'provider' => $_GET['provider'] ?? '',
            'min_bet' => $_GET['min_bet'] ?? '',
            'max_bet' => $_GET['max_bet'] ?? '',
            'language' => $_GET['language'] ?? ''
        ];

        $filteredGames = $this->liveDealerService->filterLiveGames($filters);
        $providers = $this->liveDealerService->getAllProviders();
        $categories = $this->liveDealerService->getGameCategories();
        $statistics = $this->liveDealerService->getLiveDealerStatistics();

        // AJAX response for dynamic filtering
        if (isset($_GET['ajax']) && $_GET['ajax'] === '1') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'games' => $filteredGames,
                'total_results' => count($filteredGames),
                'filters_applied' => array_filter($filters)
            ]);
            exit;
        }

        return [
            'page_title' => 'Filtered Live Dealer Games | BestCasinoPortal.com',
            'meta_description' => 'Browse live dealer games by category, provider, table limits and language. Find your perfect live casino experience.',
            'games' => $filteredGames,
            'providers' => $providers,
            'categories' => $categories,
            'statistics' => $statistics,
            'current_filters' => $filters,
            'view' => 'live-dealer-games'
        ];
    }

    /**
     * Display individual live game detail page
     */
    public function showGame($id) 
    {
        $game = $this->liveDealerService->getGameById($id);
        
        if (!$game) {
            http_response_code(404);
            return [
                'error' => 'Live game not found',
                'view' => 'error-404'
            ];
        }

        $provider = $this->liveDealerService->getProviderInfo($game['provider_slug']);
        $relatedGames = $this->liveDealerService->getGamesByCategory($game['category']);
        $relatedGames = array_filter($relatedGames, function($g) use ($id) {
            return $g['id'] !== $id;
        });
        $relatedGames = array_slice($relatedGames, 0, 4);

        return [
            'page_title' => "Play {$game['name']} Live | {$game['provider']} Live Casino",
            'meta_description' => "Experience {$game['name']} with professional dealers. Table limits: \${$game['table_limits']['min_bet']} - \${$game['table_limits']['max_bet']}. RTP: {$game['rtp']}",
            'game' => $game,
            'provider' => $provider,
            'related_games' => $relatedGames,
            'view' => 'live-game-detail'
        ];
    }

    /**
     * Get games by category for AJAX
     */
    public function getGamesByCategory($category) 
    {
        $games = $this->liveDealerService->getGamesByCategory($category);
        $categoryInfo = $this->liveDealerService->getGameCategories()[$category] ?? null;

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'category' => $category,
            'category_info' => $categoryInfo,
            'games' => $games,
            'total_games' => count($games)
        ]);
        exit;
    }

    /**
     * Get games by provider for AJAX
     */
    public function getGamesByProvider($providerSlug) 
    {
        $games = $this->liveDealerService->getGamesByProvider($providerSlug);
        $provider = $this->liveDealerService->getProviderInfo($providerSlug);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'provider' => $provider,
            'games' => $games,
            'total_games' => count($games)
        ]);
        exit;
    }

    /**
     * Get live dealer statistics for AJAX
     */
    public function getStatistics() 
    {
        $statistics = $this->liveDealerService->getLiveDealerStatistics();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'statistics' => $statistics
        ]);
        exit;
    }

    /**
     * Get popular live games for homepage section
     */
    public function getPopularGamesForHomepage($limit = 8) 
    {
        return $this->liveDealerService->getHomepageLiveDealerData($limit);
    }

    /**
     * Get all providers for navigation
     */
    public function getProviders() 
    {
        $providers = $this->liveDealerService->getAllProviders();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'providers' => $providers
        ]);
        exit;
    }

    /**
     * Get all categories for filtering
     */
    public function getCategories() 
    {
        $categories = $this->liveDealerService->getGameCategories();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'categories' => $categories
        ]);
        exit;
    }

    /**
     * Get provider comparison data
     */
    public function compareProviders() 
    {
        $providers = $this->liveDealerService->getAllProviders();
        $comparison = [];

        foreach ($providers as $slug => $provider) {
            $providerGames = $this->liveDealerService->getGamesByProvider($slug);
            $comparison[$slug] = [
                'info' => $provider,
                'games_count' => count($providerGames),
                'popular_games' => array_slice($providerGames, 0, 3),
                'avg_table_limits' => $this->calculateAverageTableLimits($providerGames)
            ];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'provider_comparison' => $comparison
        ]);
        exit;
    }

    /**
     * Get live gaming technology information
     */
    public function getTechnologyInfo() 
    {
        $providers = $this->liveDealerService->getAllProviders();
        $technologyInfo = [];

        foreach ($providers as $slug => $provider) {
            $technologyInfo[$slug] = [
                'name' => $provider['name'],
                'technology' => $provider['technology'],
                'studio_locations' => $provider['studio_locations'],
                'languages_supported' => $provider['languages_supported'],
                'certifications' => $provider['certifications'],
                'quality_rating' => $provider['quality_rating']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'technology_info' => $technologyInfo,
            'streaming_standards' => [
                'hd_quality' => '1080p minimum',
                'fps' => '30-60 FPS',
                'technology' => 'WebRTC, HTML5',
                'mobile_support' => 'iOS, Android optimized',
                'latency' => 'Under 500ms'
            ]
        ]);
        exit;
    }

    /**
     * Get live dealer availability schedule
     */
    public function getDealerSchedule() 
    {
        $games = $this->liveDealerService->getAllLiveGames();
        $schedule = [];

        foreach ($games as $game) {
            $schedule[$game['category']][] = [
                'game_name' => $game['name'],
                'provider' => $game['provider'],
                'availability' => $game['dealer_info']['availability'],
                'languages' => $game['dealer_info']['languages'],
                'studio_location' => $game['dealer_info']['studio_location']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'dealer_schedule' => $schedule,
            'timezone_note' => 'All times in GMT. Local times may vary.'
        ]);
        exit;
    }

    /**
     * Calculate average table limits for a provider
     */
    private function calculateAverageTableLimits($games) 
    {
        if (empty($games)) {
            return ['min_bet' => 0, 'max_bet' => 0];
        }

        $totalMinBet = 0;
        $totalMaxBet = 0;
        $gameCount = count($games);

        foreach ($games as $game) {
            $totalMinBet += $game['table_limits']['min_bet'];
            $totalMaxBet += $game['table_limits']['max_bet'];
        }

        return [
            'min_bet' => round($totalMinBet / $gameCount, 2),
            'max_bet' => round($totalMaxBet / $gameCount, 2),
            'currency' => 'CAD'
        ];
    }

    /**
     * Render live dealer homepage section
     */
    public function renderHomepageSection() 
    {
        $liveDealerData = $this->getPopularGamesForHomepage(8);
        
        return $this->renderLiveDealerSection($liveDealerData);
    }

    /**
     * Render the live dealer section HTML
     */
    private function renderLiveDealerSection($data) 
    {
        $html = '';
        
        // This would normally be in a template file
        // For now, returning the data structure for integration
        return $data;
    }
}
