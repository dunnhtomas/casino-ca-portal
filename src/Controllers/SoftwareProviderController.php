<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\SoftwareProviderService;

class SoftwareProviderController extends Controller
{
    private $providerService;

    public function __construct()
    {
        $this->providerService = new SoftwareProviderService();
    }

    public function index()
    {
        $data = [
            'providers' => $this->providerService->getAllProviders(),
            'categories' => $this->providerService->getProviderCategories(),
            'statistics' => $this->providerService->getProviderStatistics()
        ];
        
        return $this->render('providers/index', $data);
    }

    public function show($providerSlug)
    {
        $providers = $this->providerService->getAllProviders();
        
        if (!isset($providers[$providerSlug])) {
            return $this->render('errors/404');
        }
        
        $provider = $providers[$providerSlug];
        
        // Add additional data for detail page
        $provider['tagline'] = 'Leading Gaming Software Provider';
        $provider['full_description'] = $provider['description'] . ' With years of experience in the gaming industry, they continue to innovate and deliver exceptional gaming experiences.';
        
        $data = [
            'provider' => $provider,
            'featured_casinos' => $this->getFeaturedCasinos($providerSlug)
        ];
        
        return $this->render('providers/show', $data);
    }

    public function api()
    {
        header('Content-Type: application/json');
        
        $data = [
            'providers' => $this->providerService->getAllProviders(),
            'statistics' => $this->providerService->getProviderStatistics(),
            'categories' => $this->providerService->getProviderCategories()
        ];
        
        echo json_encode($data);
    }

    private function getFeaturedCasinos($providerSlug)
    {
        return [
            [
                'name' => 'LeoVegas Casino',
                'rating' => 4.5,
                'bonus' => 'Up to $1000 + 200 Free Spins',
                'affiliate_url' => 'https://leovegas.com'
            ],
            [
                'name' => 'Jackpot City',
                'rating' => 4.3,
                'bonus' => 'Up to $1600 Welcome Bonus',
                'affiliate_url' => 'https://jackpotcity.com'
            ]
        ];
    }

    private function render($template, $data = [])
    {
        extract($data);
        
        ob_start();
        include __DIR__ . '/../../src/Views/' . $template . '.php';
        $content = ob_get_clean();
        
        echo $content;
    }
}