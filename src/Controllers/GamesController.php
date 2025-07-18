<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\GamesService;

/**
 * Casino Games Controller
 * Handles casino game categories, display, and API endpoints
 * 
 * @author Best Casino Portal Team
 * @version 1.0
 * @since 2025-07-18
 */
class GamesController extends Controller
{
    private GamesService $gamesService;

    public function __construct()
    {
        $this->gamesService = new GamesService();
    }

    /**
     * Display games section for homepage integration
     */
    public function section(): string
    {
        try {
            $games = $this->gamesService->getGamesForHomepage();
            $stats = $this->gamesService->getGamesStatistics();
            $canadianData = $this->gamesService->getCanadianGamingData();
            
            ob_start();
            include __DIR__ . '/../Views/games/section.php';
            return ob_get_clean();
            
        } catch (\Exception $e) {
            error_log("GamesController::section error: " . $e->getMessage());
            return $this->renderError('Games section temporarily unavailable');
        }
    }

    /**
     * Display dedicated games page with full grid and details
     */
    public function index(): string
    {
        try {
            $games = $this->gamesService->getPopularGameCategories();
            $stats = $this->gamesService->getGamesStatistics();
            $canadianData = $this->gamesService->getCanadianGamingData();
            $highRtpGames = $this->gamesService->getHighestRtpGames();
            $schema = $this->gamesService->getGamesWithSchema();
            
            $pageTitle = "Popular Casino Games Guide - Slots, Blackjack, Roulette | Best Casino Portal";
            $metaDescription = "Discover the 9 most popular casino games in Canada. Learn about slots, blackjack, roulette, poker, and more with RTP rates, strategies, and best casinos to play.";
            
            ob_start();
            include __DIR__ . '/../Views/games/index.php';
            return ob_get_clean();
            
        } catch (\Exception $e) {
            error_log("GamesController::index error: " . $e->getMessage());
            return $this->renderError('Games page temporarily unavailable');
        }
    }

    /**
     * Display specific game category details
     */
    public function category(string $slug): string
    {
        try {
            $category = $this->gamesService->getGameCategoryDetails($slug);
            
            if (!$category) {
                header('HTTP/1.0 404 Not Found');
                return $this->renderError('Game category not found');
            }
            
            $featuredGames = $this->gamesService->getFeaturedGamesByCategory($category['id']);
            $relatedCategories = $this->gamesService->getGamesByPopularity(4);
            
            $pageTitle = "{$category['name']} Games Guide - RTP {$category['average_rtp']}% | Best Casino Portal";
            $metaDescription = "{$category['description']} Learn about {$category['name']} with {$category['game_count']}+ games, {$category['average_rtp']}% RTP, and best Canadian casinos.";
            
            ob_start();
            include __DIR__ . '/../Views/games/category.php';
            return ob_get_clean();
            
        } catch (\Exception $e) {
            error_log("GamesController::category error: " . $e->getMessage());
            return $this->renderError('Game category temporarily unavailable');
        }
    }

    /**
     * API endpoint - Get all game categories as JSON
     */
    public function api(): string
    {
        try {
            header('Content-Type: application/json');
            
            $response = [
                'success' => true,
                'data' => [
                    'categories' => $this->gamesService->getPopularGameCategories(),
                    'statistics' => $this->gamesService->getGamesStatistics(),
                    'canadian_data' => $this->gamesService->getCanadianGamingData(),
                    'navigation' => $this->gamesService->getGamesNavigation()
                ],
                'meta' => [
                    'total_categories' => 9,
                    'canadian_focused' => true,
                    'generated_at' => date('Y-m-d H:i:s'),
                    'cache_duration' => 3600 // 1 hour
                ]
            ];
            
            return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            error_log("GamesController::api error: " . $e->getMessage());
            
            header('Content-Type: application/json', true, 500);
            return json_encode([
                'success' => false,
                'error' => 'Failed to load games data',
                'message' => 'Please try again later'
            ]);
        }
    }

    /**
     * API endpoint - Get specific category details as JSON
     */
    public function apiCategory(string $slug): string
    {
        try {
            header('Content-Type: application/json');
            
            $category = $this->gamesService->getGameCategoryDetails($slug);
            
            if (!$category) {
                header('Content-Type: application/json', true, 404);
                return json_encode([
                    'success' => false,
                    'error' => 'Category not found',
                    'message' => 'The requested game category does not exist'
                ]);
            }
            
            $featuredGames = $this->gamesService->getFeaturedGamesByCategory($category['id']);
            
            $response = [
                'success' => true,
                'data' => [
                    'category' => $category,
                    'featured_games' => $featuredGames,
                    'statistics' => [
                        'total_games' => $category['game_count'],
                        'average_rtp' => $category['average_rtp'],
                        'popularity_rank' => $category['popularity_score']
                    ]
                ],
                'meta' => [
                    'category_slug' => $slug,
                    'generated_at' => date('Y-m-d H:i:s')
                ]
            ];
            
            return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            error_log("GamesController::apiCategory error: " . $e->getMessage());
            
            header('Content-Type: application/json', true, 500);
            return json_encode([
                'success' => false,
                'error' => 'Failed to load category details',
                'message' => 'Please try again later'
            ]);
        }
    }

    /**
     * API endpoint - Get games statistics
     */
    public function apiStats(): string
    {
        try {
            header('Content-Type: application/json');
            
            $response = [
                'success' => true,
                'data' => [
                    'statistics' => $this->gamesService->getGamesStatistics(),
                    'canadian_preferences' => $this->gamesService->getCanadianGamingData(),
                    'highest_rtp' => $this->gamesService->getHighestRtpGames(),
                    'most_popular' => $this->gamesService->getGamesByPopularity(5)
                ],
                'meta' => [
                    'generated_at' => date('Y-m-d H:i:s'),
                    'region' => 'Canada',
                    'data_source' => 'aggregated_casino_data'
                ]
            ];
            
            return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            error_log("GamesController::apiStats error: " . $e->getMessage());
            
            header('Content-Type: application/json', true, 500);
            return json_encode([
                'success' => false,
                'error' => 'Failed to load statistics',
                'message' => 'Please try again later'
            ]);
        }
    }

    /**
     * API endpoint - Search games by query
     */
    public function apiSearch(): string
    {
        try {
            header('Content-Type: application/json');
            
            $query = $_GET['q'] ?? '';
            
            if (empty($query)) {
                return json_encode([
                    'success' => false,
                    'error' => 'Query parameter required',
                    'message' => 'Please provide a search query'
                ]);
            }
            
            $results = $this->gamesService->searchGames($query);
            
            $response = [
                'success' => true,
                'data' => [
                    'query' => $query,
                    'results' => $results,
                    'total_results' => count($results)
                ],
                'meta' => [
                    'searched_at' => date('Y-m-d H:i:s'),
                    'search_type' => 'games'
                ]
            ];
            
            return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            error_log("GamesController::apiSearch error: " . $e->getMessage());
            
            header('Content-Type: application/json', true, 500);
            return json_encode([
                'success' => false,
                'error' => 'Search failed',
                'message' => 'Please try again later'
            ]);
        }
    }

    /**
     * Render error message with consistent styling
     */
    private function renderError(string $message): string
    {
        return "
        <div class='games-error alert alert-warning' role='alert'>
            <div class='container'>
                <h3>🎮 Section Temporarily Unavailable</h3>
                <p>{$message}</p>
                <p><small>Please refresh the page or try again in a few moments.</small></p>
            </div>
        </div>";
    }

    /**
     * Get games data for homepage integration (used by HomeController)
     */
    public function getGamesData(): array
    {
        return [
            'games' => $this->gamesService->getGamesForHomepage(),
            'stats' => $this->gamesService->getGamesStatistics(),
            'canadian_data' => $this->gamesService->getCanadianGamingData()
        ];
    }

    /**
     * Get games navigation data for menu integration
     */
    public function getGamesNavigation(): array
    {
        return $this->gamesService->getGamesNavigation();
    }
}
