<?php

namespace App\Controllers;

use App\Services\FreeGamesLibraryService;

/**
 * Free Games Library Controller
 * Handles free slot games display, filtering, and demo play functionality
 */
class FreeGamesLibraryController 
{
    private $freeGamesService;

    public function __construct() 
    {
        $this->freeGamesService = new FreeGamesLibraryService();
    }

    /**
     * Display main free games library page
     */
    public function index() 
    {
        $games = $this->freeGamesService->getPopularGames(50);
        $providers = $this->freeGamesService->getAllProviders();
        $categories = $this->freeGamesService->getGameCategories();
        $statistics = $this->freeGamesService->getLibraryStatistics();

        return [
            'page_title' => 'Free Casino Games - Play 50+ Slots for Free | BestCasinoPortal.com',
            'meta_description' => 'Play 50+ free slot games from top providers like NetEnt, Microgaming & Playtech. No download, no registration. Try Starburst, Book of Dead & more!',
            'games' => $games,
            'providers' => $providers,
            'categories' => $categories,
            'statistics' => $statistics,
            'current_filters' => [],
            'view' => 'free-games-library'
        ];
    }

    /**
     * Filter free games based on criteria
     */
    public function filterGames() 
    {
        $filters = [
            'provider' => $_GET['provider'] ?? '',
            'category' => $_GET['category'] ?? '',
            'volatility' => $_GET['volatility'] ?? '',
            'theme' => $_GET['theme'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        $filteredGames = $this->freeGamesService->filterGames($filters);
        $providers = $this->freeGamesService->getAllProviders();
        $categories = $this->freeGamesService->getGameCategories();
        $statistics = $this->freeGamesService->getLibraryStatistics();

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
            'page_title' => 'Filtered Free Casino Games | BestCasinoPortal.com',
            'meta_description' => 'Browse free casino games by provider, category, volatility and theme. Find your perfect slot game to play for free.',
            'games' => $filteredGames,
            'providers' => $providers,
            'categories' => $categories,
            'statistics' => $statistics,
            'current_filters' => $filters,
            'view' => 'free-games-library'
        ];
    }

    /**
     * Display individual game detail page
     */
    public function showGame($id) 
    {
        $game = $this->freeGamesService->getGameById($id);
        
        if (!$game) {
            http_response_code(404);
            return [
                'error' => 'Game not found',
                'view' => 'error-404'
            ];
        }

        $provider = $this->freeGamesService->getProviderInfo($game['provider_slug']);
        $relatedGames = $this->freeGamesService->getGamesByProvider($game['provider_slug']);
        $relatedGames = array_filter($relatedGames, function($g) use ($id) {
            return $g['id'] !== $id;
        });
        $relatedGames = array_slice($relatedGames, 0, 6);

        return [
            'page_title' => "Play {$game['name']} Free Demo | {$game['provider']} Slot Review",
            'meta_description' => "Play {$game['name']} by {$game['provider']} for free. RTP: {$game['rtp']}, Volatility: {$game['volatility']}, Max Win: {$game['max_win']}. No download required!",
            'game' => $game,
            'provider' => $provider,
            'related_games' => $relatedGames,
            'view' => 'game-detail'
        ];
    }

    /**
     * Get games by provider for AJAX
     */
    public function getGamesByProvider($providerSlug) 
    {
        $games = $this->freeGamesService->getGamesByProvider($providerSlug);
        $provider = $this->freeGamesService->getProviderInfo($providerSlug);

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
     * Get games by category for AJAX
     */
    public function getGamesByCategory($category) 
    {
        $games = $this->freeGamesService->getGamesByCategory($category);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'category' => $category,
            'games' => $games,
            'total_games' => count($games)
        ]);
        exit;
    }

    /**
     * Search games endpoint
     */
    public function searchGames() 
    {
        $query = $_GET['q'] ?? '';
        
        if (strlen($query) < 2) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'Search query must be at least 2 characters'
            ]);
            exit;
        }

        $results = $this->freeGamesService->filterGames(['search' => $query]);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'query' => $query,
            'results' => $results,
            'total_results' => count($results)
        ]);
        exit;
    }

    /**
     * Get library statistics for AJAX
     */
    public function getStatistics() 
    {
        $statistics = $this->freeGamesService->getLibraryStatistics();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'statistics' => $statistics
        ]);
        exit;
    }

    /**
     * Get popular games for homepage section
     */
    public function getPopularGamesForHomepage($limit = 12) 
    {
        $popularGames = $this->freeGamesService->getPopularGames($limit);
        $statistics = $this->freeGamesService->getLibraryStatistics();

        return [
            'games' => $popularGames,
            'statistics' => $statistics,
            'total_available' => $statistics['total_games']
        ];
    }

    /**
     * Handle demo play redirect
     */
    public function playDemo($gameId) 
    {
        $game = $this->freeGamesService->getGameById($gameId);
        
        if (!$game) {
            http_response_code(404);
            return [
                'error' => 'Game not found',
                'view' => 'error-404'
            ];
        }

        // In a real implementation, this would redirect to the actual demo
        // For now, we'll show a demo placeholder page
        return [
            'page_title' => "Play {$game['name']} Free Demo",
            'meta_description' => "Play {$game['name']} by {$game['provider']} for free. No download or registration required.",
            'game' => $game,
            'demo_mode' => true,
            'view' => 'demo-player'
        ];
    }

    /**
     * Get all providers for navigation
     */
    public function getProviders() 
    {
        $providers = $this->freeGamesService->getAllProviders();

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
        $categories = $this->freeGamesService->getGameCategories();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'categories' => $categories
        ]);
        exit;
    }

    /**
     * Featured games for special promotions
     */
    public function getFeaturedGames() 
    {
        // Get top games from different categories
        $featured = [];
        $categories = $this->freeGamesService->getGameCategories();
        
        foreach ($categories as $category) {
            $categoryGames = $this->freeGamesService->getGamesByCategory($category);
            if (!empty($categoryGames)) {
                // Sort by popularity and take the top game from each category
                usort($categoryGames, function($a, $b) {
                    return $b['popularity_score'] <=> $a['popularity_score'];
                });
                $featured[] = $categoryGames[0];
            }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'featured_games' => $featured,
            'total_featured' => count($featured)
        ]);
        exit;
    }
}
