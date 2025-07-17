<?php

namespace App\Controllers;

use App\Services\SoftwareProviderService;

class SoftwareProviderController
{
    private $providerService;

    public function __construct()
    {
        $this->providerService = new SoftwareProviderService();
    }

    public function index()
    {
        $providers = $this->providerService->getAllProviders();
        $categories = $this->providerService->getProviderCategories();
        $statistics = $this->providerService->getProviderStatistics();
        
        $data = [
            'providers' => $providers,
            'categories' => $categories,
            'statistics' => $statistics,
            'pageTitle' => 'Top Casino Software Providers | Canadian Online Gaming 2025',
            'metaDescription' => 'Discover the best casino software providers for Canadian players. NetEnt, Microgaming, Evolution Gaming, and more top gaming companies with ratings and casino recommendations.'
        ];

        return $this->render('providers/index', $data);
    }

    public function show($providerSlug)
    {
        $provider = $this->providerService->getProvider($providerSlug);
        
        if (!$provider) {
            http_response_code(404);
            return $this->render('errors/404');
        }
        
        // Create basic casino data for casinos featuring this provider
        $featuredCasinos = [];
        $casinoCount = $provider['canadian_casinos'];
        
        // Generate sample casinos based on provider
        $sampleCasinos = [
            'Jackpot City Casino', 'Spin Palace Casino', 'Ruby Fortune Casino',
            'Royal Vegas Casino', 'LeoVegas Casino', 'Betway Casino',
            'Spin Casino', 'Zodiac Casino'
        ];
        
        for ($i = 0; $i < min($casinoCount, 6); $i++) {
            $featuredCasinos[] = [
                'name' => $sampleCasinos[$i % count($sampleCasinos)],
                'rating' => round(4.2 + (rand(0, 8) / 10), 1),
                'bonus' => '100% up to $' . (rand(500, 2000)) . ' + ' . rand(50, 200) . ' Free Spins',
                'games_count' => rand(50, 200),
                'slug' => strtolower(str_replace(' ', '-', $sampleCasinos[$i % count($sampleCasinos)]))
            ];
        }
        
        $data = [
            'provider' => $provider,
            'providerSlug' => $providerSlug,
            'featuredCasinos' => $featuredCasinos,
            'pageTitle' => $provider['name'] . ' Casinos Canada | Best ' . $provider['name'] . ' Casino Sites 2025',
            'metaDescription' => 'Top Canadian casinos featuring ' . $provider['name'] . ' games. ' . $provider['game_count'] . '+ games, ' . $provider['quality_rating'] . '/5 rating. Find the best ' . $provider['name'] . ' casino bonuses and reviews.'
        ];

        return $this->render('providers/show', $data);
    }

    public function category($categorySlug)
    {
        $categories = $this->providerService->getProviderCategories();
        
        if (!isset($categories[$categorySlug])) {
            http_response_code(404);
            return $this->render('errors/404');
        }
        
        $providers = $this->providerService->getProvidersByCategory($categorySlug);
        $categoryName = $categories[$categorySlug];
        
        $data = [
            'providers' => $providers,
            'categories' => $categories,
            'currentCategory' => $categorySlug,
            'categoryName' => $categoryName,
            'pageTitle' => $categoryName . ' Casino Software Providers | Top Gaming Companies',
            'metaDescription' => 'Best ' . strtolower($categoryName) . ' software providers for Canadian online casinos. Compare ratings, game counts, and find top casino recommendations.'
        ];

        return $this->render('providers/category', $data);
    }

    public function api()
    {
        header('Content-Type: application/json');
        echo json_encode([
            'providers' => $this->providerService->getAllProviders(),
            'categories' => $this->providerService->getProviderCategories(),
            'statistics' => $this->providerService->getProviderStatistics()
        ]);
        exit;
    }

    public function apiProvider($providerSlug)
    {
        header('Content-Type: application/json');
        $provider = $this->providerService->getProvider($providerSlug);
        
        if (!$provider) {
            http_response_code(404);
            echo json_encode(['error' => 'Provider not found']);
            exit;
        }
        
        echo json_encode($provider);
        exit;
    }

    public function apiTopProviders()
    {
        header('Content-Type: application/json');
        $topProviders = $this->providerService->getTopProviders(6);
        echo json_encode($topProviders);
        exit;
    }

    private function render($template, $data = [])
    {
        extract($data);
        
        ob_start();
        include __DIR__ . '/../../src/Views/' . $template . '.php';
        $content = ob_get_clean();
        
        echo $content;
        return $content;
    }
}
