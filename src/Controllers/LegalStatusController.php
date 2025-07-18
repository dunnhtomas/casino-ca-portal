<?php

namespace App\Controllers;

use App\Services\LegalStatusService;
use Exception;

class LegalStatusController
{
    private $legalStatusService;

    public function __construct()
    {
        $this->legalStatusService = new LegalStatusService();
    }

    public function getLegalStatus()
    {
        try {
            $legalData = $this->legalStatusService->getLegalStatusData();
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $legalData,
                'timestamp' => date('c')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch legal status data',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getProvinceRegulations($province = null)
    {
        try {
            $regulations = $this->legalStatusService->getProvinceRegulations($province);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $regulations,
                'province' => $province,
                'timestamp' => date('c')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch province regulations',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getLegalSummary()
    {
        try {
            $summary = $this->legalStatusService->getLegalSummary();
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $summary,
                'timestamp' => date('c')
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to fetch legal summary',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function renderSection()
    {
        try {
            $legalData = $this->legalStatusService->getLegalStatusData();
            $summary = $this->legalStatusService->getLegalSummary();
            
            // Load the view template
            ob_start();
            include __DIR__ . '/../Views/legal-status/section.php';
            $html = ob_get_clean();
            
            return $html;
        } catch (Exception $e) {
            return '<div class="error">Error loading legal status section: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}
