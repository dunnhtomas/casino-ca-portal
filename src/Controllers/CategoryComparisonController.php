<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\CategoryComparisonService;
use App\Services\AuthorService;

class CategoryComparisonController extends Controller
{
    private CategoryComparisonService $categoryComparisonService;
    private AuthorService $authorService;
    
    public function __construct()
    {
        $this->categoryComparisonService = new CategoryComparisonService();
        $this->authorService = new AuthorService();
    }
    
    /**
     * Display the category comparison table
     */
    public function index(): void
    {
        $categories = $this->categoryComparisonService->getCategoryComparisonData();
        $statistics = $this->categoryComparisonService->getCategoryStatistics();
        $author = $this->authorService->getRandomAuthor();
        
        // Include the category comparison view
        include __DIR__ . '/../Views/category-comparison/index.php';
    }
    
    /**
     * Show specific category details
     */
    public function showCategory(): void
    {
        // Get category slug from URL
        $categorySlug = $_GET['category'] ?? '';
        
        if (empty($categorySlug)) {
            http_response_code(404);
            $this->notFound();
            return;
        }
        
        $category = $this->categoryComparisonService->getCategoryDetails($categorySlug);
        
        if (!$category) {
            http_response_code(404);
            $this->notFound();
            return;
        }
        
        $author = $this->authorService->getRandomAuthor();
        
        // Include the category detail view
        include __DIR__ . '/../Views/category-comparison/category.php';
    }
    
    /**
     * API endpoint for category leaders
     */
    public function apiCategoryLeaders(): void
    {
        header('Content-Type: application/json');
        
        $leaders = $this->categoryComparisonService->getCategoryLeaders();
        $statistics = $this->categoryComparisonService->getCategoryStatistics();
        
        echo json_encode([
            'success' => true,
            'categories' => $leaders,
            'statistics' => $statistics,
            'total_categories' => count($leaders)
        ]);
        exit;
    }
    
    /**
     * API endpoint for specific category
     */
    public function apiCategory(): void
    {
        header('Content-Type: application/json');
        
        $categorySlug = $_GET['category'] ?? '';
        
        if (empty($categorySlug)) {
            echo json_encode([
                'success' => false,
                'error' => 'Category parameter is required'
            ]);
            exit;
        }
        
        $category = $this->categoryComparisonService->getCategoryDetails($categorySlug);
        
        if (!$category) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Category not found'
            ]);
            exit;
        }
        
        echo json_encode([
            'success' => true,
            'category' => $category
        ]);
        exit;
    }
    
    /**
     * API endpoint for category comparison data
     */
    public function apiCategoryComparison(): void
    {
        header('Content-Type: application/json');
        
        $comparisonData = $this->categoryComparisonService->getCategoryComparisonData();
        $statistics = $this->categoryComparisonService->getCategoryStatistics();
        
        echo json_encode([
            'success' => true,
            'comparison_data' => $comparisonData,
            'statistics' => $statistics,
            'last_updated' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
    
    /**
     * API endpoint for category statistics
     */
    public function apiStatistics(): void
    {
        header('Content-Type: application/json');
        
        $statistics = $this->categoryComparisonService->getCategoryStatistics();
        
        echo json_encode([
            'success' => true,
            'statistics' => $statistics,
            'generated_at' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
    
    /**
     * Render category comparison section for homepage integration
     */
    public function renderCategorySection(): string
    {
        $categories = $this->categoryComparisonService->getCategoryComparisonData();
        $statistics = $this->categoryComparisonService->getCategoryStatistics();
        
        ob_start();
        include __DIR__ . '/../Views/category-comparison/section.php';
        return ob_get_clean();
    }
}
