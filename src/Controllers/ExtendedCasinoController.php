<?php

namespace App\Controllers;

use App\Services\ExtendedCasinoService;
use Exception;

class ExtendedCasinoController
{
    private $extendedCasinoService;

    public function __construct()
    {
        $this->extendedCasinoService = new ExtendedCasinoService();
    }

    public function getExtendedTopCasinos()
    {
        try {
            $casinos = $this->extendedCasinoService->getExtendedTopCasinos(15);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $casinos,
                'count' => count($casinos),
                'timestamp' => date('c')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch extended top casinos',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getCasinoDetails($id)
    {
        try {
            $casino = $this->extendedCasinoService->getCasinoById($id);
            
            if (!$casino) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'error' => 'Casino not found'
                ]);
                return;
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $casino,
                'timestamp' => date('c')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch casino details',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getFilteredCasinos()
    {
        try {
            $filters = [];
            
            if (isset($_GET['min_rating'])) {
                $filters['min_rating'] = (float)$_GET['min_rating'];
            }
            
            if (isset($_GET['min_games'])) {
                $filters['min_games'] = (int)$_GET['min_games'];
            }
            
            if (isset($_GET['fast_payout']) && $_GET['fast_payout'] === 'true') {
                $filters['fast_payout'] = true;
            }

            $casinos = $this->extendedCasinoService->getFilteredCasinos($filters);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $casinos,
                'count' => count($casinos),
                'filters_applied' => $filters,
                'timestamp' => date('c')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to filter casinos',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getCasinoStatistics()
    {
        try {
            $stats = $this->extendedCasinoService->getCasinoStatistics();
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $stats,
                'timestamp' => date('c')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch casino statistics',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function renderSection()
    {
        try {
            $casinos = $this->extendedCasinoService->getExtendedTopCasinos(15);
            $stats = $this->extendedCasinoService->getCasinoStatistics();
            
            // Load the view template
            ob_start();
            include __DIR__ . '/../Views/extended-top-casinos/section.php';
            $html = ob_get_clean();
            
            return $html;
        } catch (Exception $e) {
            return '<div class="error">Error loading extended casino section: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}
