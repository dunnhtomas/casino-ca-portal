<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ProvincesService;
use Exception;

class ProvincesController extends Controller
{
    private $provincesService;

    public function __construct(?ProvincesService $provincesService = null)
    {
        $this->provincesService = $provincesService ?? new ProvincesService(null);
    }

    /**
     * Display provinces overview page
     * @return string
     */
    public function index(): string
    {
        try {
            $provinces = $this->provincesService->getAllProvinces();
            $statistics = $this->provincesService->getProvinceStatistics();
            $topProvinces = $this->provincesService->getTopProvincesByCasinoCount(5);
            
            $data = [
                'provinces' => $provinces,
                'statistics' => $statistics,
                'top_provinces' => $topProvinces,
                'page_title' => 'Canadian Provinces & Territories - Online Casino Guide',
                'meta_description' => 'Complete guide to online casinos in all 13 Canadian provinces and territories. Find legal gambling information, regulations, and top casino recommendations for your region.'
            ];
            
            return $this->render('provinces/index', $data);
        } catch (Exception $e) {
            error_log('Error in ProvincesController::index: ' . $e->getMessage());
            return '<div class="error">Unable to load provinces data: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }

    /**
     * Display individual province page
     * @param string $code Province code
     * @return string
     */
    public function show(string $code): string
    {
        try {
            $province = $this->provincesService->getProvinceByCode($code);
            
            if (!$province) {
                return '<div class="error">Province not found</div>';
            }
            
            $regulations = $this->provincesService->getProvinceRegulations($province['id']);
            $recommendedCasinos = $this->provincesService->getProvinceRecommendedCasinos($province['id']);
            $legalInfo = $this->provincesService->getProvinceLegalInfo($province['id']);
            
            $data = [
                'province' => $province,
                'regulations' => $regulations,
                'recommended_casinos' => $recommendedCasinos,
                'legal_info' => $legalInfo,
                'page_title' => $province['name'] . ' Online Casinos - Best ' . $province['name'] . ' Casino Sites',
                'meta_description' => 'Best online casinos for ' . $province['name'] . ' players. Legal gambling guide, top casino recommendations, bonuses, and regulations for ' . $province['name'] . ' residents.'
            ];
            
            return $this->render('provinces/show', $data);
        } catch (Exception $e) {
            error_log('Error in ProvincesController::show: ' . $e->getMessage());
            return '<div class="error">Unable to load province data: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }

    /**
     * API endpoint for all provinces
     * @return string JSON response
     */
    public function apiProvinces(): string
    {
        try {
            $provinces = $this->provincesService->getAllProvinces();
            $statistics = $this->provincesService->getProvinceStatistics();
            
            $response = [
                'success' => true,
                'data' => [
                    'provinces' => $provinces,
                    'statistics' => $statistics
                ]
            ];
            
            header('Content-Type: application/json');
            return json_encode($response);
        } catch (Exception $e) {
            error_log('Error in ProvincesController::apiProvinces: ' . $e->getMessage());
            
            $response = [
                'success' => false,
                'error' => 'Unable to fetch provinces data'
            ];
            
            header('Content-Type: application/json');
            return json_encode($response);
        }
    }

    /**
     * API endpoint for specific province
     * @param string $code Province code
     * @return string JSON response
     */
    public function apiProvince(string $code): string
    {
        try {
            $province = $this->provincesService->getProvinceByCode($code);
            
            if (!$province) {
                $response = [
                    'success' => false,
                    'error' => 'Province not found'
                ];
                
                header('Content-Type: application/json');
                return json_encode($response);
            }
            
            $regulations = $this->provincesService->getProvinceRegulations($province['id']);
            $recommendedCasinos = $this->provincesService->getProvinceRecommendedCasinos($province['id']);
            $legalInfo = $this->provincesService->getProvinceLegalInfo($province['id']);
            
            $response = [
                'success' => true,
                'data' => [
                    'province' => $province,
                    'regulations' => $regulations,
                    'recommended_casinos' => $recommendedCasinos,
                    'legal_info' => $legalInfo
                ]
            ];
            
            header('Content-Type: application/json');
            return json_encode($response);
        } catch (Exception $e) {
            error_log('Error in ProvincesController::apiProvince: ' . $e->getMessage());
            
            $response = [
                'success' => false,
                'error' => 'Unable to fetch province data'
            ];
            
            header('Content-Type: application/json');
            return json_encode($response);
        }
    }

    /**
     * API endpoint for province search
     * @return string JSON response
     */
    public function apiSearchProvinces(): string
    {
        try {
            $query = $_GET['q'] ?? '';
            $type = $_GET['type'] ?? null;
            $region = $_GET['region'] ?? null;
            
            $provinces = [];
            
            if (!empty($query)) {
                $provinces = $this->provincesService->searchProvinces($query);
            } elseif (!empty($type)) {
                $provinces = $this->provincesService->getProvincesByType($type);
            } elseif (!empty($region)) {
                $provinces = $this->provincesService->getProvincesByRegion($region);
            } else {
                $provinces = $this->provincesService->getAllProvinces();
            }
            
            $response = [
                'success' => true,
                'data' => [
                    'provinces' => array_values($provinces),
                    'count' => count($provinces)
                ]
            ];
            
            header('Content-Type: application/json');
            return json_encode($response);
        } catch (Exception $e) {
            error_log('Error in ProvincesController::apiSearchProvinces: ' . $e->getMessage());
            
            $response = [
                'success' => false,
                'error' => 'Unable to search provinces'
            ];
            
            header('Content-Type: application/json');
            return json_encode($response);
        }
    }

    /**
     * Homepage section for provinces
     * @return string
     */
    public function homepageSection(): string
    {
        try {
            $topProvinces = $this->provincesService->getTopProvincesByCasinoCount(6);
            $statistics = $this->provincesService->getProvinceStatistics();
            
            $data = [
                'provinces' => $topProvinces,
                'statistics' => $statistics
            ];
            
            return $this->render('provinces/section', $data);
        } catch (Exception $e) {
            error_log('Error in ProvincesController::homepageSection: ' . $e->getMessage());
            return '<div class="error">Unable to load provinces section</div>';
        }
    }

}
