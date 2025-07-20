<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ExtendedTopCasinosService;

/**
 * Extended Top Casinos Controller
 * 
 * Handles extended casino list display and API endpoints
 * Manages filtering, sorting, and comparison functionality
 * 
 * @author Casino Expert Team
 * @version 1.0
 * @since 2025-07-20
 */
class ExtendedTopCasinosController extends Controller
{
    private $extendedTopCasinosService;

    public function __construct()
    {
        $this->extendedTopCasinosService = new ExtendedTopCasinosService();
    }

    /**
     * Display full extended top casinos page
     */
    public function index(): void
    {
        $casinos = $this->extendedTopCasinosService->getExtendedTopCasinos();
        $filterOptions = $this->extendedTopCasinosService->getFilterOptions();
        $stats = $this->extendedTopCasinosService->getRankingStats();

        $this->render('extended-top-casinos/index', [
            'title' => 'Top 15 Canadian Online Casinos - Complete Comparison',
            'meta_description' => 'Compare Canada\'s top 15 online casinos with detailed ratings, bonuses, and expert analysis. Find your perfect casino with our comprehensive comparison tool.',
            'casinos' => $casinos,
            'filter_options' => $filterOptions,
            'stats' => $stats,
            'page_type' => 'extended-casino-list'
        ]);
    }

    /**
     * Homepage section display
     */
    public function section(): void
    {
        // Get top 8 casinos for homepage section (preview of full list)
        $allCasinos = $this->extendedTopCasinosService->getExtendedTopCasinos();
        $previewCasinos = array_slice($allCasinos, 0, 8);
        $stats = $this->extendedTopCasinosService->getRankingStats();

        echo $this->renderView('extended-top-casinos/section', [
            'casinos' => $previewCasinos,
            'stats' => $stats,
            'total_casinos' => count($allCasinos)
        ]);
    }

    /**
     * API endpoint for full casino list
     */
    public function api(): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        try {
            $casinos = $this->extendedTopCasinosService->getExtendedTopCasinos();
            
            echo json_encode([
                'success' => true,
                'data' => $casinos,
                'count' => count($casinos),
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch casino data',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * API endpoint for filtered casinos
     */
    public function apiFiltered(): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        try {
            $filters = $this->getFiltersFromRequest();
            $casinos = $this->extendedTopCasinosService->getFilteredCasinos($filters);
            
            echo json_encode([
                'success' => true,
                'data' => $casinos,
                'filters_applied' => $filters,
                'count' => count($casinos),
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to filter casino data',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * API endpoint for casino comparison
     */
    public function apiComparison(): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        try {
            $casinoIds = $this->getCasinoIdsFromRequest();
            
            if (empty($casinoIds)) {
                throw new \Exception('No casino IDs provided for comparison');
            }

            $comparisonData = $this->extendedTopCasinosService->getComparisonData($casinoIds);
            
            echo json_encode([
                'success' => true,
                'data' => $comparisonData,
                'casino_ids' => $casinoIds,
                'count' => count($comparisonData),
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * API endpoint for ranking statistics
     */
    public function apiStats(): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        try {
            $stats = $this->extendedTopCasinosService->getRankingStats();
            
            echo json_encode([
                'success' => true,
                'data' => $stats,
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch statistics',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Individual casino quick view (AJAX endpoint)
     */
    public function quickView(string $casinoId): void
    {
        header('Content-Type: text/html');
        
        try {
            $allCasinos = $this->extendedTopCasinosService->getExtendedTopCasinos();
            $casino = null;
            
            foreach ($allCasinos as $c) {
                if ($c['id'] == $casinoId || $c['name'] == $casinoId) {
                    $casino = $c;
                    break;
                }
            }
            
            if (!$casino) {
                throw new \Exception('Casino not found');
            }
            
            echo $this->renderView('extended-top-casinos/quick-view', [
                'casino' => $casino
            ]);
        } catch (\Exception $e) {
            echo '<div class="error">Casino information not available</div>';
        }
    }

    /**
     * Get filters from request parameters
     */
    private function getFiltersFromRequest(): array
    {
        $filters = [];
        
        if (isset($_GET['min_rating']) && is_numeric($_GET['min_rating'])) {
            $filters['min_rating'] = (float)$_GET['min_rating'];
        }
        
        if (isset($_GET['min_bonus']) && is_numeric($_GET['min_bonus'])) {
            $filters['min_bonus'] = (int)$_GET['min_bonus'];
        }
        
        if (isset($_GET['min_games']) && is_numeric($_GET['min_games'])) {
            $filters['min_games'] = (int)$_GET['min_games'];
        }
        
        if (isset($_GET['licenses']) && is_array($_GET['licenses'])) {
            $filters['licenses'] = $_GET['licenses'];
        }
        
        if (isset($_GET['has_mobile_app'])) {
            $filters['has_mobile_app'] = $_GET['has_mobile_app'] === '1' || $_GET['has_mobile_app'] === 'true';
        }
        
        return $filters;
    }

    /**
     * Get casino IDs from request for comparison
     */
    private function getCasinoIdsFromRequest(): array
    {
        $casinoIds = [];
        
        // Check POST data first
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['casino_ids']) && is_array($input['casino_ids'])) {
                $casinoIds = $input['casino_ids'];
            }
        }
        
        // Fallback to GET parameters
        if (empty($casinoIds) && isset($_GET['ids'])) {
            if (is_array($_GET['ids'])) {
                $casinoIds = $_GET['ids'];
            } else {
                $casinoIds = explode(',', $_GET['ids']);
            }
        }
        
        // Clean and validate IDs
        $casinoIds = array_map('trim', $casinoIds);
        $casinoIds = array_filter($casinoIds);
        
        return array_values($casinoIds);
    }

    /**
     * Render view helper
     */
    private function renderView(string $view, array $data = []): string
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $view . '.php';
        return ob_get_clean();
    }
}
