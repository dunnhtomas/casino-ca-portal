<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\CasinoGridService;
use App\Services\AuthorService;

class CasinoGridController extends Controller {
    private CasinoGridService $casinoGridService;
    private AuthorService $authorService;
    
    public function __construct() {
        $this->casinoGridService = new CasinoGridService();
        $this->authorService = new AuthorService();
    }
    
    /**
     * Render the casino grid section for homepage
     */
    public function section(): string
    {
        $casinos = $this->casinoGridService->getAllCasinos();
        $statistics = $this->casinoGridService->getStatistics();
        $categories = $this->casinoGridService->getCategories();
        
        // Get top-rated casinos for initial display
        $topCasinos = array_filter($casinos, function($casino) {
            return $casino['rating'] >= 4.5;
        });
        
        // Sort by rating
        usort($topCasinos, function($a, $b) {
            return $b['rating'] <=> $a['rating'];
        });
        
        // Take first 12 for initial grid display
        $displayCasinos = array_slice($topCasinos, 0, 12);
        
        return $this->renderGridSection($displayCasinos, $statistics, $categories);
    }
    
    /**
     * Generate HTML for the casino grid section
     */
    private function renderGridSection(array $casinos, array $statistics, array $categories): string
    {
        $html = '
        <!-- Interactive Casino Grid Section (PRD #31) -->
        <section class="casino-grid-section" id="casino-grid">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-th-large"></i>
                        Compare ' . $statistics['total_casinos'] . '+ Canadian Online Casinos
                    </h2>
                    <p class="section-subtitle">
                        Interactive grid with advanced filtering, search, and comparison tools. Find your perfect casino match.
                    </p>
                </div>
                
                <!-- Grid Statistics -->
                <div class="grid-statistics">
                    <div class="stat-cards">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">' . $statistics['total_casinos'] . '</div>
                                <div class="stat-label">Total Casinos</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">' . $statistics['average_rating'] . '</div>
                                <div class="stat-label">Average Rating</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">' . $statistics['mobile_casinos'] . '</div>
                                <div class="stat-label">Mobile Optimized</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-bitcoin"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-number">' . $statistics['crypto_casinos'] . '</div>
                                <div class="stat-label">Crypto Friendly</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Search and Filter Controls -->
                <div class="grid-controls">
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="casino-search" placeholder="Search casinos, providers, or games..." class="search-input">
                            <div id="search-suggestions" class="search-suggestions"></div>
                        </div>
                    </div>
                    
                    <div class="filter-controls">
                        <button class="filter-toggle" id="filter-toggle">
                            <i class="fas fa-filter"></i>
                            Filters
                            <span class="filter-count" id="filter-count" style="display: none;"></span>
                        </button>
                        
                        <div class="sort-controls">
                            <select id="sort-select" class="sort-select">
                                <option value="rating">Sort by Rating</option>
                                <option value="name">Sort by Name</option>
                                <option value="established">Sort by Newest</option>
                                <option value="games">Sort by Game Count</option>
                            </select>
                        </div>
                        
                        <button class="compare-toggle" id="compare-toggle" style="display: none;">
                            <i class="fas fa-exchange-alt"></i>
                            Compare (<span id="compare-count">0</span>)
                        </button>
                    </div>
                </div>
                
                <!-- Advanced Filter Panel -->
                <div class="filter-panel" id="filter-panel" style="display: none;">
                    <div class="filter-panel-content">
                        <div class="filter-section">
                            <h4>Rating</h4>
                            <div class="rating-filter">
                                <input type="range" id="rating-slider" min="1" max="5" step="0.1" value="3.5" class="slider">
                                <div class="slider-labels">
                                    <span>1.0+</span>
                                    <span id="rating-value">3.5+</span>
                                    <span>5.0</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="filter-section">
                            <h4>Categories</h4>
                            <div class="category-filters">
                                ' . $this->generateCategoryFilters($categories) . '
                            </div>
                        </div>
                        
                        <div class="filter-section">
                            <h4>License</h4>
                            <div class="license-filters">
                                <label><input type="checkbox" value="MGA"> Malta Gaming Authority</label>
                                <label><input type="checkbox" value="UKGC"> UK Gambling Commission</label>
                                <label><input type="checkbox" value="Curacao"> Curaçao eGaming</label>
                                <label><input type="checkbox" value="Gibraltar"> Gibraltar Regulatory</label>
                                <label><input type="checkbox" value="Kahnawake"> Kahnawake Gaming</label>
                            </div>
                        </div>
                        
                        <div class="filter-section">
                            <h4>Established</h4>
                            <div class="established-filters">
                                <label><input type="radio" name="established" value="2021-2025"> 2021-2025 (New)</label>
                                <label><input type="radio" name="established" value="2011-2020"> 2011-2020</label>
                                <label><input type="radio" name="established" value="2001-2010"> 2001-2010</label>
                                <label><input type="radio" name="established" value="1990-2000"> 1990-2000 (Established)</label>
                            </div>
                        </div>
                        
                        <div class="filter-actions">
                            <button class="btn btn-primary" id="apply-filters">Apply Filters</button>
                            <button class="btn btn-secondary" id="clear-filters">Clear All</button>
                        </div>
                    </div>
                </div>
                
                <!-- Casino Grid Preview -->
                <div class="casino-grid-preview" id="casino-grid-preview">
                    ' . $this->generateCasinoCards($casinos) . '
                </div>
                
                <!-- View All Button -->
                <div class="grid-actions">
                    <a href="/casinos" class="btn btn-primary btn-lg view-all-casinos">
                        <i class="fas fa-th-large"></i>
                        View All ' . $statistics['total_casinos'] . '+ Casinos
                    </a>
                    <div class="grid-info">
                        Showing top-rated casinos. Use filters to find your perfect match.
                    </div>
                </div>
                
                <!-- Comparison Modal -->
                <div class="comparison-modal" id="comparison-modal" style="display: none;">
                    <div class="modal-backdrop" id="modal-backdrop"></div>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Casino Comparison</h3>
                            <button class="modal-close" id="modal-close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="comparison-content">
                            <!-- Comparison content will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </section>';
        
        return $html;
    }
    
    /**
     * Generate category filter checkboxes
     */
    private function generateCategoryFilters(array $categories): string
    {
        $html = '';
        foreach ($categories as $key => $label) {
            if ($key !== 'all') {
                $html .= '<label><input type="checkbox" value="' . $key . '"> ' . $label . '</label>';
            }
        }
        return $html;
    }
    
    /**
     * Generate casino cards HTML for homepage preview
     */
    private function generateCasinoCards(array $casinos): string
    {
        $html = '<div class="casino-grid-cards">';
        
        foreach ($casinos as $casino) {
            $html .= '
            <div class="casino-grid-card" data-casino-id="' . $casino['id'] . '" data-rating="' . $casino['rating'] . '" data-categories="' . implode(',', $casino['categories']) . '">
                <div class="card-header">
                    <div class="casino-logo">
                        <span class="logo-placeholder">' . $casino['logo'] . '</span>
                    </div>
                    <div class="casino-rating">
                        <div class="rating-stars">
                            ' . $this->generateStars($casino['rating']) . '
                        </div>
                        <span class="rating-number">' . $casino['rating'] . '</span>
                    </div>
                    <div class="comparison-checkbox">
                        <input type="checkbox" class="compare-checkbox" value="' . $casino['id'] . '">
                    </div>
                </div>
                
                <div class="card-body">
                    <h3 class="casino-name">' . $casino['name'] . '</h3>
                    <div class="casino-meta">
                        <span class="established">Est. ' . $casino['established'] . '</span>
                        <span class="license">' . $casino['license'] . '</span>
                    </div>
                    
                    <div class="casino-highlights">
                        <div class="highlight-item">
                            <i class="fas fa-gift"></i>
                            <span>' . $casino['bonus'] . '</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-gamepad"></i>
                            <span>' . $casino['games'] . ' games</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-clock"></i>
                            <span>' . $casino['payout'] . '</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-percentage"></i>
                            <span>' . $casino['rtp'] . ' RTP</span>
                        </div>
                    </div>
                    
                    <div class="casino-categories">
                        ' . $this->generateCategoryBadges(array_slice($casino['categories'], 0, 3)) . '
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="card-actions">
                        <a href="/casino/' . $casino['slug'] . '" class="btn btn-primary">
                            <i class="fas fa-external-link-alt"></i>
                            Visit Casino
                        </a>
                        <button class="btn btn-secondary quick-stats-btn" data-casino-id="' . $casino['id'] . '">
                            <i class="fas fa-info-circle"></i>
                            Details
                        </button>
                    </div>
                </div>
            </div>';
        }
        
        $html .= '</div>';
        return $html;
    }
    
    /**
     * Generate star rating HTML
     */
    private function generateStars(float $rating): string
    {
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        
        $html = '';
        
        // Full stars
        for ($i = 0; $i < $fullStars; $i++) {
            $html .= '<i class="fas fa-star"></i>';
        }
        
        // Half star
        if ($halfStar) {
            $html .= '<i class="fas fa-star-half-alt"></i>';
        }
        
        // Empty stars
        for ($i = 0; $i < $emptyStars; $i++) {
            $html .= '<i class="far fa-star"></i>';
        }
        
        return $html;
    }
    
    /**
     * Generate category badges
     */
    private function generateCategoryBadges(array $categories): string
    {
        $html = '';
        foreach ($categories as $category) {
            $html .= '<span class="category-badge category-' . $category . '">' . ucwords(str_replace('-', ' ', $category)) . '</span>';
        }
        return $html;
    }
    
    /**
     * Display the main casino grid page
     */
    public function index(): void {
        $author = $this->authorService->getRandomAuthor();
        $categories = $this->casinoGridService->getCategories();
        $allCasinos = $this->casinoGridService->getAllCasinos();
        
        // Get query parameters
        $category = $_GET['category'] ?? 'all';
        $search = $_GET['search'] ?? '';
        $sortBy = $_GET['sort'] ?? 'rating';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 20;
        
        // Filter and search
        $filters = [];
        if ($category !== 'all') {
            $filters['category'] = $category;
        }
        
        $filteredCasinos = $this->casinoGridService->filterCasinos($filters);
        
        // Apply search if provided
        if (!empty($search)) {
            $filteredCasinos = array_filter($filteredCasinos, function($casino) use ($search) {
                return stripos($casino['name'], $search) !== false || 
                       stripos($casino['bonus'], $search) !== false;
            });
        }
        
        // Sort
        $sortedCasinos = $this->casinoGridService->sortCasinos($filteredCasinos, $sortBy);
        
        // Paginate
        $paginatedResults = $this->casinoGridService->paginateCasinos($sortedCasinos, $page, $perPage);
        
        // Generate page content
        $this->renderGrid($paginatedResults, $categories, $category, $search, $sortBy, $author);
    }
    
    /**
     * Get casino data via AJAX
     */
    public function ajax(): void {
        header('Content-Type: application/json');
        
        $allCasinos = $this->casinoGridService->getAllCasinos();
        
        // Get query parameters
        $category = $_GET['category'] ?? 'all';
        $search = $_GET['search'] ?? '';
        $sortBy = $_GET['sort'] ?? 'rating';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 20;
        
        // Filter and search
        $filters = [];
        if ($category !== 'all') {
            $filters['category'] = $category;
        }
        
        $filteredCasinos = $this->casinoGridService->filterCasinos($filters);
        
        // Apply search if provided
        if (!empty($search)) {
            $filteredCasinos = array_filter($filteredCasinos, function($casino) use ($search) {
                return stripos($casino['name'], $search) !== false || 
                       stripos($casino['bonus'], $search) !== false;
            });
        }
        
        // Sort
        $sortedCasinos = $this->casinoGridService->sortCasinos($filteredCasinos, $sortBy);
        
        // Paginate
        $paginatedResults = $this->casinoGridService->paginateCasinos($sortedCasinos, $page, $perPage);
        
        echo json_encode($paginatedResults);
        exit;
    }
    
    /**
     * Render the casino grid HTML
     */
    private function renderGrid($paginatedResults, $categories, $currentCategory, $search, $sortBy, $author): void {
        $casinos = $paginatedResults['items'];
        $pagination = [
            'page' => $paginatedResults['page'],
            'totalPages' => $paginatedResults['totalPages'],
            'total' => $paginatedResults['total'],
            'hasMore' => $paginatedResults['hasMore']
        ];
        
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Casino Comparison Grid - Compare 90+ Online Casinos | Best Casino Portal</title>
            <meta name="description" content="Compare 90+ online casinos side by side. Filter by bonuses, games, ratings, and more. Find your perfect casino with our comprehensive comparison tool.">
            <meta name="keywords" content="casino comparison, online casinos, casino reviews, best casinos, casino bonuses">
            <link rel="stylesheet" href="/assets/css/style.css">
            <style>
                .casino-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 20px;
                    margin: 20px 0;
                }
                
                .casino-card {
                    background: white;
                    border: 1px solid #e0e0e0;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    transition: transform 0.2s;
                }
                
                .casino-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
                }
                
                .casino-header {
                    display: flex;
                    align-items: center;
                    margin-bottom: 15px;
                }
                
                .casino-logo {
                    width: 50px;
                    height: 50px;
                    background: #2196F3;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-weight: bold;
                    margin-right: 15px;
                }
                
                .casino-name {
                    font-size: 18px;
                    font-weight: bold;
                    color: #333;
                    margin: 0;
                }
                
                .casino-rating {
                    color: #ff6b35;
                    font-weight: bold;
                    margin: 5px 0;
                }
                
                .casino-details {
                    margin: 15px 0;
                }
                
                .detail-row {
                    display: flex;
                    justify-content: space-between;
                    margin: 8px 0;
                    font-size: 14px;
                }
                
                .detail-label {
                    color: #666;
                }
                
                .detail-value {
                    font-weight: 500;
                    color: #333;
                }
                
                .casino-bonus {
                    background: #f8f9fa;
                    padding: 12px;
                    border-radius: 6px;
                    margin: 15px 0;
                    text-align: center;
                    font-weight: bold;
                    color: #2196F3;
                }
                
                .casino-actions {
                    display: flex;
                    gap: 10px;
                    margin-top: 15px;
                }
                
                .btn {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    font-weight: bold;
                    text-decoration: none;
                    text-align: center;
                    cursor: pointer;
                    flex: 1;
                }
                
                .btn-primary {
                    background: #2196F3;
                    color: white;
                }
                
                .btn-secondary {
                    background: #f8f9fa;
                    color: #333;
                    border: 1px solid #ddd;
                }
                
                .filters-section {
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    margin: 20px 0;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                
                .filters-row {
                    display: flex;
                    gap: 15px;
                    flex-wrap: wrap;
                    align-items: center;
                }
                
                .filter-group {
                    display: flex;
                    flex-direction: column;
                    gap: 5px;
                }
                
                .filter-group label {
                    font-weight: 500;
                    color: #333;
                    font-size: 14px;
                }
                
                .filter-input, .filter-select {
                    padding: 8px 12px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 14px;
                }
                
                .results-info {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin: 20px 0;
                    color: #666;
                }
                
                .pagination {
                    display: flex;
                    justify-content: center;
                    gap: 10px;
                    margin: 30px 0;
                }
                
                .pagination a, .pagination span {
                    padding: 8px 12px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    text-decoration: none;
                    color: #333;
                }
                
                .pagination .current {
                    background: #2196F3;
                    color: white;
                    border-color: #2196F3;
                }
                
                .featured-badge {
                    background: #ff6b35;
                    color: white;
                    padding: 2px 8px;
                    border-radius: 12px;
                    font-size: 11px;
                    font-weight: bold;
                    margin-left: 10px;
                }
                
                .category-tags {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 5px;
                    margin: 10px 0;
                }
                
                .category-tag {
                    background: #e3f2fd;
                    color: #1976d2;
                    padding: 2px 8px;
                    border-radius: 12px;
                    font-size: 11px;
                }
                
                @media (max-width: 768px) {
                    .casino-grid {
                        grid-template-columns: 1fr;
                    }
                    
                    .filters-row {
                        flex-direction: column;
                        align-items: stretch;
                    }
                    
                    .filter-group {
                        width: 100%;
                    }
                    
                    .results-info {
                        flex-direction: column;
                        gap: 10px;
                        text-align: center;
                    }
                }
            </style>
        </head>
        <body>
            <header class="site-header">
                <div class="container">
                    <nav class="main-nav">
                        <a href="/" class="logo">Best Casino Portal</a>
                        <div class="nav-links">
                            <a href="/reviews">Reviews</a>
                            <a href="/casinos" class="active">All Casinos</a>
                            <a href="/bonuses">Bonuses</a>
                            <a href="/games">Games</a>
                        </div>
                    </nav>
                </div>
            </header>

            <main class="main-content">
                <div class="container">
                    <div class="page-header">
                        <h1>Casino Comparison Grid</h1>
                        <p class="page-description">Compare 90+ online casinos side by side. Use our advanced filters to find the perfect casino for your gaming preferences.</p>
                        
                        <div class="author-info">
                            <small>Expert analysis by <strong><?= htmlspecialchars($author['name']) ?></strong>, <?= htmlspecialchars($author['title']) ?></small>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="filters-section">
                        <h3>Filter & Search Casinos</h3>
                        <form method="GET" class="filters-form" id="filtersForm">
                            <div class="filters-row">
                                <div class="filter-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="filter-select">
                                        <?php foreach ($categories as $key => $label): ?>
                                            <option value="<?= htmlspecialchars($key) ?>" <?= $currentCategory === $key ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($label) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="filter-group">
                                    <label for="search">Search</label>
                                    <input type="text" name="search" id="search" class="filter-input" 
                                           placeholder="Search casino name..." value="<?= htmlspecialchars($search) ?>">
                                </div>
                                
                                <div class="filter-group">
                                    <label for="sort">Sort By</label>
                                    <select name="sort" id="sort" class="filter-select">
                                        <option value="rating" <?= $sortBy === 'rating' ? 'selected' : '' ?>>Rating</option>
                                        <option value="established" <?= $sortBy === 'established' ? 'selected' : '' ?>>Established</option>
                                        <option value="name" <?= $sortBy === 'name' ? 'selected' : '' ?>>Name</option>
                                    </select>
                                </div>
                                
                                <div class="filter-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Results Info -->
                    <div class="results-info">
                        <div>
                            Showing <?= count($casinos) ?> of <?= $pagination['total'] ?> casinos
                            <?php if ($search): ?>
                                for "<?= htmlspecialchars($search) ?>"
                            <?php endif; ?>
                            <?php if ($currentCategory !== 'all'): ?>
                                in <?= htmlspecialchars($categories[$currentCategory]) ?>
                            <?php endif; ?>
                        </div>
                        <div>
                            Page <?= $pagination['page'] ?> of <?= $pagination['totalPages'] ?>
                        </div>
                    </div>

                    <!-- Casino Grid -->
                    <div class="casino-grid" id="casinoGrid">
                        <?php foreach ($casinos as $casino): ?>
                            <div class="casino-card">
                                <div class="casino-header">
                                    <div class="casino-logo"><?= htmlspecialchars($casino['logo']) ?></div>
                                    <div>
                                        <h3 class="casino-name">
                                            <?= htmlspecialchars($casino['name']) ?>
                                            <?php if ($casino['featured']): ?>
                                                <span class="featured-badge">FEATURED</span>
                                            <?php endif; ?>
                                        </h3>
                                        <div class="casino-rating">
                                            ⭐ <?= number_format($casino['rating'], 1) ?>/5.0
                                        </div>
                                    </div>
                                </div>

                                <div class="casino-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Established:</span>
                                        <span class="detail-value"><?= $casino['established'] ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Games:</span>
                                        <span class="detail-value"><?= htmlspecialchars($casino['games']) ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">RTP:</span>
                                        <span class="detail-value"><?= htmlspecialchars($casino['rtp']) ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Payout:</span>
                                        <span class="detail-value"><?= htmlspecialchars($casino['payout']) ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">License:</span>
                                        <span class="detail-value"><?= htmlspecialchars($casino['license']) ?></span>
                                    </div>
                                </div>

                                <div class="casino-bonus">
                                    <?= htmlspecialchars($casino['bonus']) ?>
                                </div>

                                <div class="category-tags">
                                    <?php foreach (array_slice($casino['categories'], 0, 3) as $category): ?>
                                        <span class="category-tag"><?= htmlspecialchars($category) ?></span>
                                    <?php endforeach; ?>
                                </div>

                                <div class="casino-actions">
                                    <a href="/casino/<?= htmlspecialchars($casino['slug']) ?>" class="btn btn-secondary">View Details</a>
                                    <a href="/casino/<?= htmlspecialchars($casino['slug']) ?>/play" class="btn btn-primary">Play Now</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($pagination['totalPages'] > 1): ?>
                        <div class="pagination">
                            <?php if ($pagination['page'] > 1): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['page'] - 1])) ?>">← Previous</a>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $pagination['page'] - 2); $i <= min($pagination['totalPages'], $pagination['page'] + 2); $i++): ?>
                                <?php if ($i === $pagination['page']): ?>
                                    <span class="current"><?= $i ?></span>
                                <?php else: ?>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                            <?php if ($pagination['page'] < $pagination['totalPages']): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['page'] + 1])) ?>">Next →</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Expert Analysis Section -->
                    <div class="expert-section" style="margin-top: 40px; padding: 30px; background: #f8f9fa; border-radius: 8px;">
                        <h2>Expert Casino Comparison Analysis</h2>
                        <div class="author-bio">
                            <p><strong><?= htmlspecialchars($author['name']) ?></strong> has been analyzing Canadian online casinos for <?= htmlspecialchars($author['experience']) ?>. <?= htmlspecialchars($author['bio']) ?></p>
                        </div>
                        
                        <div class="analysis-content">
                            <h3>How to Use Our Casino Comparison Grid</h3>
                            <p>Our comprehensive casino comparison tool allows you to evaluate over 90 online casinos side by side. Here's how to make the most of it:</p>
                            
                            <ul>
                                <li><strong>Filter by Category:</strong> Use our category filters to narrow down casinos by your preferences - whether you're looking for the best live dealer games, mobile casinos, or crypto-friendly sites.</li>
                                <li><strong>Compare Key Metrics:</strong> Each casino card displays essential information including ratings, RTP percentages, game counts, and payout times.</li>
                                <li><strong>Bonus Comparison:</strong> Easily compare welcome bonuses and promotional offers across different casinos.</li>
                                <li><strong>Expert Ratings:</strong> Our ratings are based on <?= htmlspecialchars($author['expertise']) ?> and real player experiences.</li>
                            </ul>
                            
                            <h3>What Makes a Great Online Casino?</h3>
                            <p>When comparing casinos, <?= htmlspecialchars($author['name']) ?> recommends focusing on these key factors:</p>
                            
                            <ul>
                                <li><strong>Licensing & Safety:</strong> Look for casinos licensed by reputable authorities like MGA, UKGC, or Curacao.</li>
                                <li><strong>Game Variety:</strong> The best casinos offer 1,000+ games from top providers.</li>
                                <li><strong>Payout Speed:</strong> Fast payouts (1-3 days) indicate a well-managed casino.</li>
                                <li><strong>Return to Player (RTP):</strong> Higher RTPs mean better value for players.</li>
                                <li><strong>Customer Support:</strong> 24/7 support with multiple contact methods is essential.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </main>

            <script>
                // Auto-submit form on filter changes
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('filtersForm');
                    const selects = form.querySelectorAll('select');
                    const searchInput = document.getElementById('search');
                    
                    selects.forEach(select => {
                        select.addEventListener('change', () => {
                            // Reset to page 1 when filters change
                            const pageInput = form.querySelector('input[name="page"]');
                            if (pageInput) pageInput.value = '1';
                            form.submit();
                        });
                    });
                    
                    // Debounced search
                    let searchTimeout;
                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            const pageInput = form.querySelector('input[name="page"]');
                            if (pageInput) pageInput.value = '1';
                            form.submit();
                        }, 500);
                    });
                });
            </script>
        </body>
        </html>
        <?php
    }
    
    /**
     * Filter casinos via API with advanced filters
     */
    public function filter(): void {
        header('Content-Type: application/json');
        
        $filters = [];
        parse_str(file_get_contents('php://input'), $filters);
        
        $casinos = $this->casinoGridService->getAllCasinos();
        
        // Apply filters using new service methods
        if (!empty($filters)) {
            $casinos = $this->casinoGridService->filterCasinos($filters);
        }
        
        // Apply sorting
        $sortBy = $filters['sort'] ?? 'rating';
        $order = $filters['order'] ?? 'desc';
        $casinos = $this->casinoGridService->sortCasinos($casinos, $sortBy, $order);
        
        // Search
        if (isset($filters['search']) && !empty($filters['search'])) {
            $casinos = array_filter($casinos, function($casino) use ($filters) {
                return stripos($casino['name'], $filters['search']) !== false || 
                       stripos($casino['bonus'], $filters['search']) !== false;
            });
        }
        
        // Pagination
        $page = intval($filters['page'] ?? 1);
        $perPage = intval($filters['per_page'] ?? 20);
        $paginatedResult = $this->casinoGridService->paginateCasinos($casinos, $page, $perPage);
        
        echo json_encode([
            'success' => true,
            'casinos' => $paginatedResult['items'],
            'pagination' => $paginatedResult,
            'total' => count($casinos),
            'filters_applied' => $filters
        ]);
        exit;
    }
    
    /**
     * Compare multiple casinos
     */
    public function compare(): void {
        $casino_ids = [];
        
        if (isset($_GET['casinos'])) {
            $casino_ids = explode(',', $_GET['casinos']);
        } elseif (isset($_POST['casino_ids'])) {
            $casino_ids = $_POST['casino_ids'];
        }

        $casinos = $this->casinoGridService->getCasinosByIds($casino_ids);
        
        // Include the comparison view
        $comparison_count = count($casinos);
        include __DIR__ . '/../Views/casino-grid/compare.php';
    }    /**
     * API endpoint for casino data
     */
    public function apiCasinos(): void {
        header('Content-Type: application/json');
        
        $filters = $_GET;
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 20);
        
        $casinos = $this->casinoGridService->getAllCasinos();
        
        // Apply filters
        if (!empty($filters)) {
            $casinos = $this->casinoGridService->filterCasinos($filters);
        }
        
        // Apply sorting
        $sortBy = $_GET['sort'] ?? 'rating';
        $order = $_GET['order'] ?? 'desc';
        $casinos = $this->casinoGridService->sortCasinos($casinos, $sortBy, $order);
        
        // Pagination
        $paginatedResult = $this->casinoGridService->paginateCasinos($casinos, $page, $limit);
        
        echo json_encode([
            'success' => true,
            'casinos' => $paginatedResult['items'],
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $paginatedResult['totalPages'],
                'total_casinos' => $paginatedResult['total'],
                'per_page' => $limit,
                'has_more' => $paginatedResult['hasMore']
            ]
        ]);
        exit;
    }
    
    /**
     * API endpoint for statistics
     */
    public function apiStatistics(): void {
        header('Content-Type: application/json');
        
        $statistics = $this->casinoGridService->getStatistics();
        $categories = $this->casinoGridService->getCategories();
        
        echo json_encode([
            'success' => true,
            'statistics' => $statistics,
            'categories' => $categories
        ]);
        exit;
    }
    
    /**
     * API endpoint for casino search
     */
    public function search(): void {
        header('Content-Type: application/json');
        
        $query = $_GET['q'] ?? '';
        $limit = intval($_GET['limit'] ?? 10);
        
        if (empty($query)) {
            echo json_encode([
                'success' => false,
                'error' => 'Search query is required'
            ]);
            return;
        }
        
        $casinos = $this->casinoGridService->getAllCasinos();
        $results = array_filter($casinos, function($casino) use ($query) {
            return stripos($casino['name'], $query) !== false || 
                   stripos($casino['bonus'], $query) !== false ||
                   stripos($casino['license'], $query) !== false;
        });
        
        // Limit results
        $results = array_slice($results, 0, $limit);
        
        echo json_encode([
            'success' => true,
            'results' => $results,
            'query' => $query,
            'total_found' => count($results)
        ]);
        exit;
    }
}
