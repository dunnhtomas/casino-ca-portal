<?php

namespace App\Controllers;

use App\Services\ProvinceService;

class ProvinceController
{
    private $provinceService;

    public function __construct()
    {
        $this->provinceService = new ProvinceService();
    }

    public function index()
    {
        $provinces = $this->provinceService->getAllProvinces();
        $provincesByRegion = $this->provinceService->getProvincesByRegion();
        
        // Calculate totals for overview
        $totalCasinos = array_sum(array_column($provinces, 'local_casinos'));
        $totalPopulation = array_sum(array_map(function($p) {
            return floatval(str_replace(['M', 'K'], ['', ''], $p['population']));
        }, $provinces));
        
        $data = [
            'provinces' => $provinces,
            'provincesByRegion' => $provincesByRegion,
            'totalCasinos' => $totalCasinos,
            'totalPopulation' => $totalPopulation,
            'pageTitle' => 'Canadian Provinces Casino Guide | Best Online Casinos by Province',
            'metaDescription' => 'Complete guide to online casinos across all 13 Canadian provinces and territories. Find legal gambling age, local casinos, and recommended sites for your region.'
        ];

        return $this->render('provinces/index', $data);
    }

    public function show($provinceCode)
    {
        $province = $this->provinceService->getProvince($provinceCode);
        
        if (!$province) {
            http_response_code(404);
            return $this->render('errors/404');
        }
        
        // Create basic casino data for recommended casinos
        $recommendedCasinos = [];
        foreach ($province['recommended_casinos'] as $casinoSlug) {
            $recommendedCasinos[] = [
                'name' => ucwords(str_replace(['-', '_'], ' ', $casinoSlug)),
                'slug' => $casinoSlug,
                'description' => 'Top-rated online casino for Canadian players',
                'affiliate_url' => '#'
            ];
        }
        
        $data = [
            'province' => $province,
            'provinceCode' => strtoupper($provinceCode),
            'recommendedCasinos' => $recommendedCasinos,
            'pageTitle' => $province['name'] . ' Online Casinos | Legal Gambling Guide',
            'metaDescription' => 'Complete guide to online casinos in ' . $province['name'] . '. Age ' . $province['gambling_age'] . '+, ' . $province['local_casinos'] . ' local casinos, legal status, and top recommendations.'
        ];

        return $this->render('provinces/show', $data);
    }

    public function api()
    {
        header('Content-Type: application/json');
        echo json_encode([
            'provinces' => $this->provinceService->getAllProvinces(),
            'regions' => $this->provinceService->getProvincesByRegion()
        ]);
        exit;
    }

    public function apiProvince($provinceCode)
    {
        header('Content-Type: application/json');
        $province = $this->provinceService->getProvince($provinceCode);
        
        if (!$province) {
            http_response_code(404);
            echo json_encode(['error' => 'Province not found']);
            exit;
        }
        
        echo json_encode($province);
        exit;
    }

    private function render($template, $data = [])
    {
        extract($data);
        
        ob_start();
        include __DIR__ . '/../../views/' . $template . '.php';
        $content = ob_get_clean();
        
        echo $content;
        return $content;
    }
}
