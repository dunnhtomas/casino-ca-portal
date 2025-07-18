<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\FeaturesService;

class FeaturesController extends Controller
{
    private FeaturesService $featuresService;

    public function __construct()
    {
        $this->featuresService = new FeaturesService();
    }

    /**
     * Display features section for homepage integration
     */
    public function section(): string
    {
        try {
            $features = $this->featuresService->getFeaturesForHomepage();
            $stats = $this->featuresService->getFeatureStats();
            
            ob_start();
            include __DIR__ . '/../Views/features/section.php';
            return ob_get_clean();
            
        } catch (\Exception $e) {
            error_log("FeaturesController::section error: " . $e->getMessage());
            return $this->renderError('Features section temporarily unavailable');
        }
    }

    /**
     * Display dedicated features page
     */
    public function index(): string
    {
        try {
            $features = $this->featuresService->getFiveKeyFeatures();
            $stats = $this->featuresService->getFeatureStats();
            $schema = $this->featuresService->getFeaturesWithSchema();
            $canadianFocus = $this->featuresService->getCanadianFocusPoints();
            
            $pageTitle = "5 Key Features - Why Choose Our Casino Reviews | Best Casino Portal";
            $metaDescription = "Discover the 5 key features that make our casino review platform the best choice for Canadian players: premium games, CAD bonuses, local payments, mobile gaming, and bank-level security.";
            
            // Include the view file directly like other controllers
            ob_start();
            include __DIR__ . '/../Views/features/index.php';
            return ob_get_clean();
            
        } catch (\Exception $e) {
            error_log("FeaturesController::index error: " . $e->getMessage());
            return $this->renderError('Features page temporarily unavailable');
        }
    }

    /**
     * API endpoint - Get all features as JSON
     */
    public function api(): string
    {
        try {
            header('Content-Type: application/json');
            
            $response = [
                'success' => true,
                'data' => [
                    'features' => $this->featuresService->getFiveKeyFeatures(),
                    'stats' => $this->featuresService->getFeatureStats(),
                    'schema' => $this->featuresService->getFeaturesWithSchema(),
                    'categories' => $this->featuresService->getFeaturesByCategory()
                ],
                'meta' => [
                    'total_features' => 5,
                    'canadian_focused' => true,
                    'generated_at' => date('Y-m-d H:i:s'),
                    'cache_duration' => 3600 // 1 hour
                ]
            ];
            
            return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            error_log("FeaturesController::api error: " . $e->getMessage());
            
            header('Content-Type: application/json', true, 500);
            return json_encode([
                'success' => false,
                'error' => 'Failed to load features data',
                'message' => 'Please try again later'
            ]);
        }
    }

    /**
     * API endpoint - Get specific feature by ID
     */
    public function apiShow(int $id): string
    {
        try {
            header('Content-Type: application/json');
            
            $feature = $this->featuresService->getFeatureDetails($id);
            
            if (!$feature) {
                header('Content-Type: application/json', true, 404);
                return json_encode([
                    'success' => false,
                    'error' => 'Feature not found',
                    'message' => 'The requested feature does not exist'
                ]);
            }
            
            $response = [
                'success' => true,
                'data' => $feature,
                'meta' => [
                    'feature_id' => $id,
                    'generated_at' => date('Y-m-d H:i:s')
                ]
            ];
            
            return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            error_log("FeaturesController::apiShow error: " . $e->getMessage());
            
            header('Content-Type: application/json', true, 500);
            return json_encode([
                'success' => false,
                'error' => 'Failed to load feature details',
                'message' => 'Please try again later'
            ]);
        }
    }

    /**
     * API endpoint - Get features statistics
     */
    public function apiStats(): string
    {
        try {
            header('Content-Type: application/json');
            
            $response = [
                'success' => true,
                'data' => [
                    'stats' => $this->featuresService->getFeatureStats(),
                    'canadian_focus' => $this->featuresService->getCanadianFocusPoints()
                ],
                'meta' => [
                    'generated_at' => date('Y-m-d H:i:s'),
                    'region' => 'Canada'
                ]
            ];
            
            return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        } catch (\Exception $e) {
            error_log("FeaturesController::apiStats error: " . $e->getMessage());
            
            header('Content-Type: application/json', true, 500);
            return json_encode([
                'success' => false,
                'error' => 'Failed to load feature statistics',
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
        <div class='features-error alert alert-warning' role='alert'>
            <div class='container'>
                <h3>🔧 Section Temporarily Unavailable</h3>
                <p>{$message}</p>
                <p><small>Please refresh the page or try again in a few moments.</small></p>
            </div>
        </div>";
    }

    /**
     * Get feature data for homepage integration (used by HomeController)
     */
    public function getFeaturesData(): array
    {
        return [
            'features' => $this->featuresService->getFeaturesForHomepage(),
            'stats' => $this->featuresService->getFeatureStats()
        ];
    }
}
