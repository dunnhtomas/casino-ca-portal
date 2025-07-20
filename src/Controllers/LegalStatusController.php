<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\LegalStatusService;

class LegalStatusController extends Controller 
{
    private $legalService;

    public function __construct() 
    {
        $this->legalService = new LegalStatusService();
    }

    public function index() 
    {
        $legalData = $this->legalService->getLegalStatusData();
        $gameStatistics = $this->legalService->getGameStatistics();
        $summary = $this->legalService->getLegalSummaryForHomepage();
        
        $data = [
            'legal_data' => $legalData,
            'game_statistics' => $gameStatistics,
            'legal_summary' => $summary,
            'authorities' => $this->legalService->getAllAuthorities(),
            'provinces' => $this->legalService->getAllProvinces(),
            'payment_methods' => $this->legalService->getPaymentRegulations()
        ];

        return $this->render('legal/index', $data);
    }

    public function province($provinceCode) 
    {
        $province = $this->legalService->getProvinceRegulation($provinceCode);
        
        if (!$province) {
            return $this->render('errors/404');
        }

        $data = [
            'province' => $province,
            'province_code' => $provinceCode,
            'all_provinces' => $this->legalService->getAllProvinces()
        ];

        return $this->render('legal/province', $data);
    }

    public function authority($authorityCode)
    {
        $authorities = $this->legalService->getAllAuthorities();
        $authority = $authorities[$authorityCode] ?? null;
        
        if (!$authority) {
            return $this->render('errors/404');
        }

        $data = [
            'authority' => $authority,
            'authority_code' => $authorityCode,
            'all_authorities' => $authorities
        ];

        return $this->render('legal/authority', $data);
    }

    // API endpoints
    public function api()
    {
        header('Content-Type: application/json');
        
        $response = [
            'legal_status' => $this->legalService->getLegalSummaryForHomepage(),
            'statistics' => $this->legalService->getGameStatistics(),
            'authorities' => array_keys($this->legalService->getAllAuthorities()),
            'provinces' => array_keys($this->legalService->getAllProvinces())
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    public function apiAuthority($authorityCode)
    {
        header('Content-Type: application/json');
        
        $authorities = $this->legalService->getAllAuthorities();
        $authority = $authorities[$authorityCode] ?? null;
        
        if (!$authority) {
            http_response_code(404);
            echo json_encode(['error' => 'Authority not found']);
            return;
        }

        echo json_encode([
            'authority' => $authority,
            'code' => $authorityCode
        ], JSON_PRETTY_PRINT);
    }

    public function apiProvince($provinceCode)
    {
        header('Content-Type: application/json');
        
        $province = $this->legalService->getProvinceRegulation($provinceCode);
        
        if (!$province) {
            http_response_code(404);
            echo json_encode(['error' => 'Province not found']);
            return;
        }

        echo json_encode([
            'province' => $province,
            'code' => $provinceCode
        ], JSON_PRETTY_PRINT);
    }

    public function apiPaymentMethods()
    {
        header('Content-Type: application/json');
        
        $paymentMethods = $this->legalService->getPaymentRegulations();
        
        echo json_encode([
            'payment_methods' => $paymentMethods,
            'total_methods' => count($paymentMethods)
        ], JSON_PRETTY_PRINT);
    }
}
