<?php

namespace App\Controllers;

use App\Services\ReviewMethodologyService;

class ReviewMethodologyController {
    private $methodologyService;
    
    public function __construct() {
        $this->methodologyService = new ReviewMethodologyService();
    }
    
    public function index() {
        $methodology = $this->methodologyService->getReviewMethodology();
        $recentReviews = []; // Simplified for now
        
        $pageData = [
            'title' => 'How We Review Online Casinos - Our Expert Methodology',
            'description' => 'Discover our comprehensive 7-point casino review methodology. Learn how our expert team tests security, bonuses, games, and more to bring you unbiased casino reviews.',
            'keywords' => 'casino review methodology, how we test casinos, unbiased casino reviews, casino rating system, expert casino evaluation',
            'canonical' => 'https://bestcasinoportal.com/review-methodology',
            'methodology' => $methodology,
            'recent_reviews' => $recentReviews
        ];
        
        // Read and include the view file
        extract($pageData);
        ob_start();
        include __DIR__ . '/../Views/methodology/index.php';
        echo ob_get_clean();
    }
    
    public function criteria() {
        // Extract criteria slug from URL
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pathParts = explode('/', trim($path, '/'));
        $criteriaSlug = $pathParts[1] ?? null; // /methodology/{slug}
        
        if (!$criteriaSlug) {
            http_response_code(404);
            echo "Criteria not found";
            return;
        }
        
        $criteria = $this->methodologyService->getCriteriaBySlug($criteriaSlug);
        
        if (!$criteria) {
            http_response_code(404);
            echo "Criteria not found";
            return;
        }
        
        $methodology = $this->methodologyService->getReviewMethodology();
        
        $pageData = [
            'title' => $criteria['name'] . ' - Casino Review Criteria',
            'description' => 'Learn how we evaluate ' . strtolower($criteria['name']) . ' in our casino reviews. ' . $criteria['description'],
            'keywords' => 'casino ' . strtolower(str_replace(' & ', ' ', $criteria['name'])) . ', casino review criteria, casino testing methodology',
            'canonical' => 'https://bestcasinoportal.com/methodology/' . $criteriaSlug,
            'criteria' => $criteria,
            'criteria_slug' => $criteriaSlug,
            'all_criteria' => $methodology['scoring_criteria']
        ];
        
        // Read and include the view file
        extract($pageData);
        ob_start();
        include __DIR__ . '/../Views/methodology/criteria.php';
        echo ob_get_clean();
    }
    
    public function expertTeam() {
        $expertTeam = $this->methodologyService->getExpertTeam();
        $methodology = $this->methodologyService->getReviewMethodology();
        
        echo "<h1>Expert Team</h1>";
        echo "<pre>" . print_r($expertTeam, true) . "</pre>";
    }
    
    public function testingProcess() {
        $testingProcess = $this->methodologyService->getTestingProcess();
        $methodology = $this->methodologyService->getReviewMethodology();
        
        echo "<h1>Testing Process</h1>";
        echo "<pre>" . print_r($testingProcess, true) . "</pre>";
    }
    
    // API endpoint for methodology data
    public function apiMethodology() {
        header('Content-Type: application/json');
        $methodology = $this->methodologyService->getReviewMethodology();
        echo json_encode($methodology);
    }
    
    // API endpoint for scoring criteria
    public function apiCriteria() {
        header('Content-Type: application/json');
        $criteria = $this->methodologyService->getScoringCriteria();
        echo json_encode($criteria);
    }
    
    // API endpoint for expert team
    public function apiExpertTeam() {
        header('Content-Type: application/json');
        $expertTeam = $this->methodologyService->getExpertTeam();
        echo json_encode($expertTeam);
    }
}
