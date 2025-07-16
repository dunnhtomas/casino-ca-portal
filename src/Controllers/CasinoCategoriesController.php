<?php

namespace App\Controllers;

use App\Services\CasinoCategoriesService;

/**
 * Casino Categories Controller
 * 
 * Handles casino category navigation, filtering, and display
 * Provides comprehensive category-based casino discovery
 * 
 * @author Dr. Sarah Chen, Casino Platform Architecture Lead
 */
class CasinoCategoriesController
{
    private $categoriesService;

    public function __construct()
    {
        $this->categoriesService = new CasinoCategoriesService();
    }

    /**
     * Display casino categories overview
     */
    public function index()
    {
        $categories = $this->categoriesService->getAllCategories();
        
        $pageTitle = 'Casino Categories | Find Your Perfect Gaming Experience';
        $metaDescription = 'Explore casino categories: Live Dealer, Mobile, Crypto, New Casinos, High Roller, and more. Find casinos that match your gaming preferences and style.';
        
        $content = $this->renderCategoriesOverview($categories, $pageTitle, $metaDescription);
        
        return $content;
    }

    /**
     * Display casinos in specific category
     */
    public function showCategory($categoryId)
    {
        $category = $this->categoriesService->getCategory($categoryId);
        
        if (!$category) {
            return $this->renderNotFound();
        }

        // Get filters and sorting from query params
        $filters = $_GET['filters'] ?? [];
        $sort = $_GET['sort'] ?? 'rating';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 20;

        $casinos = $this->categoriesService->getCasinosByCategory($categoryId, $filters, $sort);
        
        // Paginate results
        $totalCasinos = count($casinos);
        $totalPages = ceil($totalCasinos / $perPage);
        $offset = ($page - 1) * $perPage;
        $paginatedCasinos = array_slice($casinos, $offset, $perPage);

        $content = $this->renderCategoryPage($category, $paginatedCasinos, $filters, $sort, $page, $totalPages);
        
        return $content;
    }

    /**
     * Display casinos matching multiple categories
     */
    public function showMultipleCategories()
    {
        $categoryIds = $_GET['categories'] ?? [];
        
        if (empty($categoryIds) || !is_array($categoryIds)) {
            return $this->index();
        }

        $filters = $_GET['filters'] ?? [];
        $sort = $_GET['sort'] ?? 'rating';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 20;

        $casinos = $this->categoriesService->getCasinosByMultipleCategories($categoryIds, $filters, $sort);
        
        // Get category details for display
        $categories = [];
        foreach ($categoryIds as $categoryId) {
            $category = $this->categoriesService->getCategory($categoryId);
            if ($category) {
                $categories[] = $category;
            }
        }

        // Paginate results
        $totalCasinos = count($casinos);
        $totalPages = ceil($totalCasinos / $perPage);
        $offset = ($page - 1) * $perPage;
        $paginatedCasinos = array_slice($casinos, $offset, $perPage);

        $content = $this->renderMultipleCategoriesPage($categories, $paginatedCasinos, $filters, $sort, $page, $totalPages);
        
        return $content;
    }

    /**
     * AJAX endpoint for category filtering
     */
    public function filterCategory($categoryId)
    {
        $category = $this->categoriesService->getCategory($categoryId);
        
        if (!$category) {
            header('HTTP/1.1 404 Not Found');
            return json_encode(['error' => 'Category not found']);
        }

        $filters = $_GET['filters'] ?? [];
        $sort = $_GET['sort'] ?? 'rating';
        
        $casinos = $this->categoriesService->getCasinosByCategory($categoryId, $filters, $sort);
        
        header('Content-Type: application/json');
        return json_encode([
            'casinos' => $casinos,
            'total' => count($casinos),
            'category' => $category
        ]);
    }

    /**
     * Get category filters via AJAX
     */
    public function getCategoryFilters($categoryId)
    {
        $filters = $this->categoriesService->getCategoryFilters($categoryId);
        $sortingOptions = $this->categoriesService->getCategorySortingOptions($categoryId);
        
        header('Content-Type: application/json');
        return json_encode([
            'filters' => $filters,
            'sorting_options' => $sortingOptions
        ]);
    }

    /**
     * Render categories overview page
     */
    private function renderCategoriesOverview($categories, $pageTitle, $metaDescription)
    {
        $categoryCards = '';
        foreach ($categories as $category) {
            $categoryCards .= $this->renderCategoryCard($category);
        }

        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($pageTitle) . '</title>
    <meta name="description" content="' . htmlspecialchars($metaDescription) . '">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://bestcasinoportal.com/categories">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { color: #2c3e50; margin-bottom: 10px; font-size: 2.5rem; }
        .header p { color: #7f8c8d; font-size: 1.1rem; max-width: 600px; margin: 0 auto; }
        .categories-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-top: 40px; }
        .category-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 2px solid transparent; }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .category-header { display: flex; align-items: center; margin-bottom: 20px; }
        .category-icon { font-size: 2.5rem; margin-right: 20px; width: 60px; text-align: center; }
        .category-title { font-size: 1.5rem; font-weight: 700; color: #2c3e50; margin: 0; }
        .category-count { background: #ecf0f1; color: #7f8c8d; padding: 4px 12px; border-radius: 20px; font-size: 0.9rem; margin-left: 15px; }
        .category-description { color: #7f8c8d; line-height: 1.6; margin-bottom: 20px; }
        .category-button { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; display: inline-block; }
        .category-button:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(102,126,234,0.3); }
        .breadcrumb { margin-bottom: 20px; }
        .breadcrumb a { color: #3498db; text-decoration: none; }
        .breadcrumb span { color: #7f8c8d; margin: 0 10px; }
        .stats-section { background: white; border-radius: 15px; padding: 30px; margin-bottom: 40px; text-align: center; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 20px; }
        .stat-item { padding: 20px; }
        .stat-number { font-size: 2.5rem; font-weight: 700; color: #3498db; }
        .stat-label { color: #7f8c8d; margin-top: 5px; }
        @media (max-width: 768px) {
            .categories-grid { grid-template-columns: 1fr; gap: 20px; }
            .container { padding: 15px; }
            .header h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Home</a> <span>/</span> <span>Casino Categories</span>
        </div>
        
        <div class="header">
            <h1>🎰 Casino Categories</h1>
            <p>Find your perfect casino experience with our comprehensive category system. From live dealer action to crypto gaming, discover casinos that match your exact preferences.</p>
        </div>

        <div class="stats-section">
            <h2>Discover Your Perfect Casino</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">' . count($categories) . '+</div>
                    <div class="stat-label">Casino Categories</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Reviewed Casinos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Expert Analysis</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Canadian Focused</div>
                </div>
            </div>
        </div>

        <div class="categories-grid">
            ' . $categoryCards . '
        </div>
    </div>
</body>
</html>';
    }

    /**
     * Render individual category card
     */
    private function renderCategoryCard($category)
    {
        return '<div class="category-card" style="border-color: ' . $category['color'] . '20;">
            <div class="category-header">
                <div class="category-icon" style="color: ' . $category['color'] . ';">
                    <i class="' . $category['icon'] . '"></i>
                </div>
                <div>
                    <h3 class="category-title">' . htmlspecialchars($category['name']) . '</h3>
                    <span class="category-count">' . $category['casino_count'] . ' casinos</span>
                </div>
            </div>
            <p class="category-description">' . htmlspecialchars($category['description']) . '</p>
            <a href="/categories/' . $category['id'] . '" class="category-button" style="background: linear-gradient(135deg, ' . $category['color'] . ' 0%, ' . $category['color'] . '99 100%);">
                Explore ' . htmlspecialchars($category['name']) . '
            </a>
        </div>';
    }

    /**
     * Render category page with casinos
     */
    private function renderCategoryPage($category, $casinos, $filters, $sort, $page, $totalPages)
    {
        $casinoCards = '';
        foreach ($casinos as $casino) {
            $casinoCards .= $this->renderCasinoCard($casino);
        }

        $pagination = $this->renderPagination($page, $totalPages, '/categories/' . $category['id']);

        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($category['seo_title']) . '</title>
    <meta name="description" content="' . htmlspecialchars($category['seo_description']) . '">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://bestcasinoportal.com/categories/' . $category['id'] . '">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 40px; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 15px; font-size: 2.5rem; }
        .header p { color: #7f8c8d; font-size: 1.1rem; max-width: 700px; margin: 0 auto 20px; line-height: 1.6; }
        .casino-count { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 20px; border-radius: 25px; font-weight: 600; display: inline-block; }
        .filters-section { background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; }
        .filters-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .filter-group { }
        .filter-label { font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block; }
        .filter-select { width: 100%; padding: 10px; border: 2px solid #ecf0f1; border-radius: 8px; font-size: 14px; }
        .casinos-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; }
        .casino-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; }
        .casino-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .casino-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px; }
        .casino-name { font-size: 1.4rem; font-weight: 700; color: #2c3e50; margin: 0; }
        .casino-rating { background: #f39c12; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; }
        .casino-bonus { color: #27ae60; font-size: 1.1rem; font-weight: 600; margin-bottom: 15px; }
        .casino-features { margin-bottom: 15px; }
        .feature-tag { background: #ecf0f1; color: #7f8c8d; padding: 4px 10px; border-radius: 15px; font-size: 0.8rem; margin-right: 8px; margin-bottom: 8px; display: inline-block; }
        .casino-highlight { background: #e8f5e8; color: #27ae60; padding: 8px 15px; border-radius: 8px; font-weight: 600; margin-bottom: 15px; }
        .casino-button { background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s ease; }
        .casino-button:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(46,204,113,0.3); }
        .breadcrumb { margin-bottom: 20px; }
        .breadcrumb a { color: #3498db; text-decoration: none; }
        .breadcrumb span { color: #7f8c8d; margin: 0 10px; }
        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 40px; }
        .pagination a, .pagination span { padding: 10px 15px; border: 2px solid #ecf0f1; border-radius: 8px; text-decoration: none; color: #7f8c8d; }
        .pagination .current { background: #3498db; color: white; border-color: #3498db; }
        @media (max-width: 768px) {
            .casinos-grid { grid-template-columns: 1fr; gap: 20px; }
            .filters-grid { grid-template-columns: 1fr; }
            .container { padding: 15px; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Home</a> <span>/</span> <a href="/categories">Categories</a> <span>/</span> <span>' . htmlspecialchars($category['name']) . '</span>
        </div>
        
        <div class="header">
            <h1><i class="' . $category['icon'] . '" style="color: ' . $category['color'] . '; margin-right: 15px;"></i>' . htmlspecialchars($category['name']) . '</h1>
            <p>' . htmlspecialchars($category['long_description']) . '</p>
            <div class="casino-count">' . $category['casino_count'] . ' casinos available</div>
        </div>

        <div class="filters-section">
            <h3>Filter & Sort Options</h3>
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">Sort By</label>
                    <select class="filter-select" onchange="updateSort(this.value)">
                        <option value="rating"' . ($sort === 'rating' ? ' selected' : '') . '>Highest Rated</option>
                        <option value="bonus_amount"' . ($sort === 'bonus_amount' ? ' selected' : '') . '>Best Bonuses</option>
                        <option value="games_count"' . ($sort === 'games_count' ? ' selected' : '') . '>Most Games</option>
                        <option value="new_date"' . ($sort === 'new_date' ? ' selected' : '') . '>Newest First</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="casinos-grid">
            ' . $casinoCards . '
        </div>

        ' . $pagination . '
    </div>

    <script>
        function updateSort(sortValue) {
            const url = new URL(window.location);
            url.searchParams.set("sort", sortValue);
            window.location = url;
        }
    </script>
</body>
</html>';
    }

    /**
     * Render casino card for category listings
     */
    private function renderCasinoCard($casino)
    {
        $features = '';
        if (isset($casino['category_features'])) {
            foreach ($casino['category_features'] as $feature) {
                $features .= '<span class="feature-tag">' . htmlspecialchars($feature) . '</span>';
            }
        }

        $highlight = '';
        if (isset($casino['category_highlight'])) {
            $highlight = '<div class="casino-highlight">' . htmlspecialchars($casino['category_highlight']) . '</div>';
        }

        return '<div class="casino-card">
            <div class="casino-header">
                <h3 class="casino-name">' . htmlspecialchars($casino['name']) . '</h3>
                <span class="casino-rating">★ ' . $casino['rating'] . '</span>
            </div>
            <div class="casino-bonus">' . htmlspecialchars($casino['bonus']) . '</div>
            ' . $highlight . '
            <div class="casino-features">
                ' . $features . '
            </div>
            <button class="casino-button" onclick="window.open(\'#\', \'_blank\')">
                Play Now at ' . htmlspecialchars($casino['name']) . '
            </button>
        </div>';
    }

    /**
     * Render pagination
     */
    private function renderPagination($currentPage, $totalPages, $baseUrl)
    {
        if ($totalPages <= 1) {
            return '';
        }

        $pagination = '<div class="pagination">';
        
        // Previous page
        if ($currentPage > 1) {
            $pagination .= '<a href="' . $baseUrl . '?page=' . ($currentPage - 1) . '">‹ Previous</a>';
        }

        // Page numbers
        for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++) {
            if ($i == $currentPage) {
                $pagination .= '<span class="current">' . $i . '</span>';
            } else {
                $pagination .= '<a href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a>';
            }
        }

        // Next page
        if ($currentPage < $totalPages) {
            $pagination .= '<a href="' . $baseUrl . '?page=' . ($currentPage + 1) . '">Next ›</a>';
        }

        $pagination .= '</div>';

        return $pagination;
    }

    /**
     * Render multiple categories page
     */
    private function renderMultipleCategoriesPage($categories, $casinos, $filters, $sort, $page, $totalPages)
    {
        $categoryNames = array_map(function($cat) { return $cat['name']; }, $categories);
        $title = 'Casinos matching: ' . implode(' + ', $categoryNames);
        
        // Similar to renderCategoryPage but for multiple categories
        return $this->renderCategoryPage([
            'id' => 'multiple',
            'name' => $title,
            'long_description' => 'Casinos that match all your selected criteria.',
            'icon' => 'fas fa-filter',
            'color' => '#9b59b6',
            'casino_count' => count($casinos),
            'seo_title' => $title . ' | Best Casino Portal',
            'seo_description' => 'Find casinos matching multiple categories: ' . implode(', ', $categoryNames) . '. Compare options that meet all your gaming preferences.'
        ], $casinos, $filters, $sort, $page, $totalPages);
    }

    /**
     * Render 404 not found page
     */
    private function renderNotFound()
    {
        header('HTTP/1.1 404 Not Found');
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Not Found | Best Casino Portal</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 600px; margin: 100px auto; padding: 40px; text-align: center; background: white; border-radius: 15px; }
        h1 { color: #e74c3c; font-size: 3rem; margin-bottom: 20px; }
        p { color: #7f8c8d; font-size: 1.1rem; margin-bottom: 30px; }
        a { background: #3498db; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>The casino category you\'re looking for doesn\'t exist.</p>
        <a href="/categories">View All Categories</a>
    </div>
</body>
</html>';
    }
}
