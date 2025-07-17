<?php

namespace App\Controllers;

use App\Services\BonusComparisonService;

/**
 * Bonus Comparison Controller
 * 
 * Handles bonus comparison engine, table display, and filtering
 * Provides comprehensive bonus analysis matching casino.ca functionality
 * 
 * @author Jennifer Walsh, Casino Bonus Strategy Director
 */
class BonusComparisonController
{
    private $bonusService;

    public function __construct()
    {
        $this->bonusService = new BonusComparisonService();
    }

    /**
     * Display bonus comparison overview page
     */
    public function index()
    {
        $topBonuses = $this->bonusService->getTopBonuses(5, 'overall_value');
        $filterOptions = $this->bonusService->getFilterOptions();
        
        $pageTitle = 'Best Casino Bonuses Canada 2025 | Compare Welcome Bonuses & Free Spins';
        $metaDescription = 'Compare the best casino bonuses in Canada. Detailed bonus comparison table with wagering requirements, free spins, and terms. Find the perfect bonus for your playing style.';
        
        return $this->renderBonusOverview($topBonuses, $filterOptions, $pageTitle, $metaDescription);
    }

    /**
     * Display comprehensive bonus comparison table
     */
    public function comparisonTable()
    {
        // Get filters from query params
        $filters = $_GET['filters'] ?? [];
        $sort = $_GET['sort'] ?? 'bonus_value';
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 20;

        $bonuses = $this->bonusService->getAllBonuses($filters, $sort);
        $comparisonTable = $this->bonusService->getBonusComparisonTable();
        $filterOptions = $this->bonusService->getFilterOptions();
        
        // Paginate results
        $totalBonuses = count($bonuses);
        $totalPages = ceil($totalBonuses / $perPage);
        $offset = ($page - 1) * $perPage;
        $paginatedBonuses = array_slice($bonuses, $offset, $perPage);

        return $this->renderComparisonTable($comparisonTable, $filterOptions, $filters, $sort, $page, $totalPages);
    }

    /**
     * Display detailed bonus analysis for specific casino
     */
    public function bonusAnalysis($casinoId)
    {
        $analysis = $this->bonusService->getBonusAnalysis((int)$casinoId);
        
        if (!$analysis) {
            return $this->renderNotFound();
        }

        return $this->renderBonusAnalysis($analysis);
    }

    /**
     * AJAX endpoint for bonus filtering
     */
    public function filterBonuses()
    {
        $filters = $_GET['filters'] ?? [];
        $sort = $_GET['sort'] ?? 'bonus_value';
        
        $bonuses = $this->bonusService->getAllBonuses($filters, $sort);
        
        header('Content-Type: application/json');
        return json_encode([
            'bonuses' => $bonuses,
            'total' => count($bonuses),
            'filters_applied' => $filters
        ]);
    }

    /**
     * Get bonus calculator data
     */
    public function bonusCalculator()
    {
        $casinoId = $_GET['casino_id'] ?? null;
        $depositAmount = (float)($_GET['deposit'] ?? 100);
        
        if (!$casinoId) {
            header('Content-Type: application/json');
            return json_encode(['error' => 'Casino ID required']);
        }

        $analysis = $this->bonusService->getBonusAnalysis((int)$casinoId);
        
        if (!$analysis) {
            header('Content-Type: application/json');
            return json_encode(['error' => 'Casino not found']);
        }

        $bonus = $analysis['bonus'];
        $bonusAmount = min($depositAmount * ($bonus['welcome_percentage'] / 100), $bonus['welcome_amount']);
        $totalAmount = $depositAmount + $bonusAmount;
        $wageringRequired = $totalAmount * $bonus['wagering_requirement'];

        header('Content-Type: application/json');
        return json_encode([
            'deposit_amount' => $depositAmount,
            'bonus_amount' => $bonusAmount,
            'total_amount' => $totalAmount,
            'wagering_required' => $wageringRequired,
            'free_spins' => $bonus['free_spins'],
            'time_limit' => $bonus['time_limit'],
            'game_restrictions' => $bonus['game_restrictions']
        ]);
    }

    /**
     * Render bonus overview page
     */
    private function renderBonusOverview($topBonuses, $filterOptions, $pageTitle, $metaDescription)
    {
        $bonusCards = '';
        foreach ($topBonuses as $bonus) {
            $bonusCards .= $this->renderBonusCard($bonus);
        }

        $filterHTML = $this->renderFilters($filterOptions);

        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($pageTitle) . '</title>
    <meta name="description" content="' . htmlspecialchars($metaDescription) . '">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://bestcasinoportal.com/bonuses">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 40px; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 15px; font-size: 2.5rem; }
        .header p { color: #7f8c8d; font-size: 1.1rem; max-width: 700px; margin: 0 auto 20px; line-height: 1.6; }
        .stats-section { background: white; border-radius: 15px; padding: 30px; margin-bottom: 40px; text-align: center; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 20px; }
        .stat-item { padding: 20px; }
        .stat-number { font-size: 2.5rem; font-weight: 700; color: #27ae60; }
        .stat-label { color: #7f8c8d; margin-top: 5px; }
        .bonuses-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .bonus-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; position: relative; overflow: hidden; }
        .bonus-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .bonus-rank { position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .casino-name { font-size: 1.4rem; font-weight: 700; color: #2c3e50; margin-bottom: 10px; }
        .welcome-bonus { color: #27ae60; font-size: 1.2rem; font-weight: 600; margin-bottom: 15px; }
        .bonus-details { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 15px; }
        .detail-item { font-size: 0.9rem; color: #7f8c8d; }
        .detail-value { font-weight: 600; color: #2c3e50; }
        .bonus-score { text-align: center; margin-bottom: 15px; }
        .score-circle { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 700; margin: 0 auto 5px; }
        .score-label { font-size: 0.8rem; color: #7f8c8d; }
        .bonus-button { background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.3s ease; text-decoration: none; display: block; text-align: center; }
        .bonus-button:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(46,204,113,0.3); }
        .view-all-section { text-align: center; margin-top: 40px; }
        .view-all-btn { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; padding: 15px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; }
        .view-all-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(52,152,219,0.3); }
        .breadcrumb { margin-bottom: 20px; }
        .breadcrumb a { color: #3498db; text-decoration: none; }
        .breadcrumb span { color: #7f8c8d; margin: 0 10px; }
        .filters-section { background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; }
        .filters-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .filter-group { }
        .filter-label { font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block; }
        .filter-select { width: 100%; padding: 10px; border: 2px solid #ecf0f1; border-radius: 8px; font-size: 14px; }
        @media (max-width: 768px) {
            .bonuses-grid { grid-template-columns: 1fr; gap: 20px; }
            .filters-grid { grid-template-columns: 1fr; }
            .container { padding: 15px; }
            .header h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Home</a> <span>/</span> <span>Casino Bonuses</span>
        </div>
        
        <div class="header">
            <h1><i class="fas fa-gift" style="color: #27ae60; margin-right: 15px;"></i>Best Casino Bonuses in Canada</h1>
            <p>Compare welcome bonuses, free spins, and wagering requirements from Canada\'s top online casinos. Find the perfect bonus that matches your playing style and budget with our comprehensive comparison tools.</p>
        </div>

        <div class="stats-section">
            <h2>Bonus Comparison Statistics</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Casino Bonuses</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">$50K+</div>
                    <div class="stat-label">Total Bonus Value</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1,500+</div>
                    <div class="stat-label">Free Spins Available</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Bonus Analysis</div>
                </div>
            </div>
        </div>

        <div class="filters-section">
            <h3>Filter Bonuses by Your Preferences</h3>
            ' . $filterHTML . '
        </div>

        <h2>Top Rated Casino Bonuses</h2>
        <div class="bonuses-grid">
            ' . $bonusCards . '
        </div>

        <div class="view-all-section">
            <a href="/bonuses/comparison-table" class="view-all-btn">
                <i class="fas fa-table" style="margin-right: 10px;"></i>
                View Complete Bonus Comparison Table
            </a>
        </div>
    </div>

    <script>
        function updateFilters() {
            const filters = {};
            document.querySelectorAll(".filter-select").forEach(select => {
                if (select.value) {
                    filters[select.name] = select.value;
                }
            });
            
            const params = new URLSearchParams();
            Object.keys(filters).forEach(key => {
                params.append("filters[" + key + "]", filters[key]);
            });
            
            window.location.search = params.toString();
        }
    </script>
</body>
</html>';
    }

    /**
     * Render bonus comparison table
     */
    private function renderComparisonTable($comparisonTable, $filterOptions, $filters, $sort, $page, $totalPages)
    {
        $filterHTML = $this->renderFilters($filterOptions, $filters);
        $tableHTML = $this->renderTable($comparisonTable);
        $paginationHTML = $this->renderPagination($page, $totalPages, '/bonuses/comparison-table');

        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino Bonus Comparison Table | Compare All Bonuses Side-by-Side</title>
    <meta name="description" content="Detailed casino bonus comparison table. Compare welcome bonuses, wagering requirements, free spins, and terms from all major Canadian casinos in one place.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://bestcasinoportal.com/bonuses/comparison-table">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 40px; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; margin-bottom: 15px; font-size: 2.5rem; }
        .filters-section { background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; }
        .filters-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .filter-group { }
        .filter-label { font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block; }
        .filter-select { width: 100%; padding: 10px; border: 2px solid #ecf0f1; border-radius: 8px; font-size: 14px; }
        .table-container { background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 30px; }
        .comparison-table { width: 100%; border-collapse: collapse; }
        .comparison-table th { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 10px; text-align: left; font-weight: 600; font-size: 0.9rem; }
        .comparison-table td { padding: 15px 10px; border-bottom: 1px solid #ecf0f1; vertical-align: middle; }
        .comparison-table tr:hover { background: #f8f9fa; }
        .casino-cell { font-weight: 600; color: #2c3e50; }
        .bonus-cell { color: #27ae60; font-weight: 600; }
        .score-cell { text-align: center; }
        .score-badge { background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
        .claim-btn { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none; padding: 8px 16px; border-radius: 5px; font-weight: 600; cursor: pointer; text-decoration: none; }
        .claim-btn:hover { opacity: 0.9; }
        .breadcrumb { margin-bottom: 20px; }
        .breadcrumb a { color: #3498db; text-decoration: none; }
        .breadcrumb span { color: #7f8c8d; margin: 0 10px; }
        @media (max-width: 768px) {
            .comparison-table { font-size: 0.8rem; }
            .comparison-table th, .comparison-table td { padding: 8px 5px; }
            .container { padding: 15px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="/">Home</a> <span>/</span> <a href="/bonuses">Bonuses</a> <span>/</span> <span>Comparison Table</span>
        </div>
        
        <div class="header">
            <h1><i class="fas fa-table" style="color: #3498db; margin-right: 15px;"></i>Casino Bonus Comparison Table</h1>
            <p>Compare all casino bonuses side-by-side. Detailed analysis of welcome bonuses, wagering requirements, free spins, and terms to help you make the best choice.</p>
        </div>

        <div class="filters-section">
            <h3>Filter & Sort Bonuses</h3>
            ' . $filterHTML . '
        </div>

        <div class="table-container">
            ' . $tableHTML . '
        </div>

        ' . $paginationHTML . '
    </div>

    <script>
        function updateSort(sortValue) {
            const url = new URL(window.location);
            url.searchParams.set("sort", sortValue);
            window.location = url;
        }

        function updateFilters() {
            const filters = {};
            document.querySelectorAll(".filter-select").forEach(select => {
                if (select.value) {
                    filters[select.name] = select.value;
                }
            });
            
            const params = new URLSearchParams();
            Object.keys(filters).forEach(key => {
                params.append("filters[" + key + "]", filters[key]);
            });
            
            window.location.search = params.toString();
        }
    </script>
</body>
</html>';
    }

    /**
     * Render individual bonus card
     */
    private function renderBonusCard($bonus)
    {
        return '<div class="bonus-card">
            <div class="bonus-rank">' . htmlspecialchars($bonus['bonus_rank']) . '</div>
            <h3 class="casino-name">' . htmlspecialchars($bonus['casino_name']) . '</h3>
            <div class="welcome-bonus">' . htmlspecialchars($bonus['formatted_welcome']) . '</div>
            <div class="bonus-details">
                <div class="detail-item">Free Spins: <span class="detail-value">' . ($bonus['free_spins'] > 0 ? $bonus['free_spins'] : 'None') . '</span></div>
                <div class="detail-item">Wagering: <span class="detail-value">' . $bonus['wagering_requirement'] . 'x</span></div>
                <div class="detail-item">Time Limit: <span class="detail-value">' . htmlspecialchars($bonus['time_limit']) . '</span></div>
                <div class="detail-item">Min Deposit: <span class="detail-value">$' . $bonus['min_deposit'] . '</span></div>
            </div>
            <div class="bonus-score">
                <div class="score-circle">' . $bonus['bonus_score'] . '</div>
                <div class="score-label">Bonus Score</div>
            </div>
            <a href="' . htmlspecialchars($bonus['affiliate_link'] ?? '#') . '" class="bonus-button" target="_blank">
                Claim Bonus at ' . htmlspecialchars($bonus['casino_name']) . '
            </a>
        </div>';
    }

    /**
     * Render filters HTML
     */
    private function renderFilters($filterOptions, $currentFilters = [])
    {
        $filtersHTML = '<div class="filters-grid">';
        
        // Sort dropdown
        $filtersHTML .= '<div class="filter-group">
            <label class="filter-label">Sort By</label>
            <select class="filter-select" onchange="updateSort(this.value)">
                <option value="bonus_value">Best Overall Value</option>
                <option value="welcome_amount">Highest Bonus Amount</option>
                <option value="wagering_requirement">Lowest Wagering</option>
                <option value="free_spins">Most Free Spins</option>
            </select>
        </div>';

        foreach ($filterOptions as $filterId => $filter) {
            $currentValue = $currentFilters[$filterId] ?? '';
            $filtersHTML .= '<div class="filter-group">
                <label class="filter-label">' . htmlspecialchars($filter['label']) . '</label>
                <select class="filter-select" name="' . $filterId . '" onchange="updateFilters()">
                    <option value="">All ' . htmlspecialchars($filter['label']) . '</option>';
            
            foreach ($filter['options'] as $value => $label) {
                $selected = $currentValue === $value ? ' selected' : '';
                $filtersHTML .= '<option value="' . htmlspecialchars($value) . '"' . $selected . '>' . htmlspecialchars($label) . '</option>';
            }
            
            $filtersHTML .= '</select>
            </div>';
        }
        
        $filtersHTML .= '</div>';
        
        return $filtersHTML;
    }

    /**
     * Render comparison table
     */
    private function renderTable($comparisonTable)
    {
        $tableHTML = '<table class="comparison-table">
            <thead>
                <tr>';
        
        foreach ($comparisonTable['headers'] as $header) {
            $tableHTML .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        
        $tableHTML .= '</tr>
            </thead>
            <tbody>';

        foreach ($comparisonTable['rows'] as $row) {
            $tableHTML .= '<tr>
                <td class="casino-cell">' . htmlspecialchars($row['casino_name']) . '</td>
                <td class="bonus-cell">' . htmlspecialchars($row['welcome_bonus']) . '</td>
                <td>' . htmlspecialchars($row['free_spins']) . '</td>
                <td>' . htmlspecialchars($row['wagering_requirement']) . '</td>
                <td>' . htmlspecialchars($row['game_restrictions']) . '</td>
                <td>' . htmlspecialchars($row['time_limit']) . '</td>
                <td>' . htmlspecialchars($row['min_deposit']) . '</td>
                <td class="score-cell">
                    <span class="score-badge">' . $row['bonus_score'] . '</span>
                </td>
                <td>
                    <a href="' . htmlspecialchars($row['affiliate_link']) . '" class="claim-btn" target="_blank">
                        ' . htmlspecialchars($row['cta_text']) . '
                    </a>
                </td>
            </tr>';
        }

        $tableHTML .= '</tbody>
        </table>';

        return $tableHTML;
    }

    /**
     * Render pagination
     */
    private function renderPagination($currentPage, $totalPages, $baseUrl)
    {
        if ($totalPages <= 1) {
            return '';
        }

        $pagination = '<div style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">';
        
        // Previous page
        if ($currentPage > 1) {
            $pagination .= '<a href="' . $baseUrl . '?page=' . ($currentPage - 1) . '" style="padding: 10px 15px; border: 2px solid #ecf0f1; border-radius: 8px; text-decoration: none; color: #7f8c8d;">‹ Previous</a>';
        }

        // Page numbers
        for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++) {
            if ($i == $currentPage) {
                $pagination .= '<span style="padding: 10px 15px; background: #3498db; color: white; border-radius: 8px;">' . $i . '</span>';
            } else {
                $pagination .= '<a href="' . $baseUrl . '?page=' . $i . '" style="padding: 10px 15px; border: 2px solid #ecf0f1; border-radius: 8px; text-decoration: none; color: #7f8c8d;">' . $i . '</a>';
            }
        }

        // Next page
        if ($currentPage < $totalPages) {
            $pagination .= '<a href="' . $baseUrl . '?page=' . ($currentPage + 1) . '" style="padding: 10px 15px; border: 2px solid #ecf0f1; border-radius: 8px; text-decoration: none; color: #7f8c8d;">Next ›</a>';
        }

        $pagination .= '</div>';

        return $pagination;
    }

    /**
     * Render bonus analysis page
     */
    private function renderBonusAnalysis($analysis)
    {
        $bonus = $analysis['bonus'];
        $bonusAnalysis = $analysis['analysis'];

        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($bonus['casino_name']) . ' Bonus Analysis | Detailed Review & Terms</title>
    <meta name="description" content="Detailed analysis of ' . htmlspecialchars($bonus['casino_name']) . ' casino bonus. Welcome offer, wagering requirements, terms, and our expert recommendation.">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .analysis-card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .casino-header { text-align: center; margin-bottom: 30px; }
        .casino-name { font-size: 2rem; color: #2c3e50; margin-bottom: 10px; }
        .bonus-offer { font-size: 1.5rem; color: #27ae60; font-weight: 600; }
        .analysis-section { margin-bottom: 25px; }
        .section-title { font-size: 1.2rem; color: #2c3e50; margin-bottom: 15px; font-weight: 600; }
        .strengths, .weaknesses { display: grid; gap: 10px; }
        .strength-item { background: #d5f4e6; color: #27ae60; padding: 10px 15px; border-radius: 8px; border-left: 4px solid #27ae60; }
        .weakness-item { background: #ffeaa7; color: #e17055; padding: 10px 15px; border-radius: 8px; border-left: 4px solid #e17055; }
        .recommendation { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="analysis-card">
            <div class="casino-header">
                <h1 class="casino-name">' . htmlspecialchars($bonus['casino_name']) . '</h1>
                <div class="bonus-offer">' . htmlspecialchars($bonus['formatted_welcome']) . '</div>
            </div>

            <div class="analysis-section">
                <h3 class="section-title">Bonus Strengths</h3>
                <div class="strengths">';
        
        foreach ($bonusAnalysis['strengths'] as $strength) {
            $analysisHTML .= '<div class="strength-item"><i class="fas fa-check"></i> ' . htmlspecialchars($strength) . '</div>';
        }

        $analysisHTML .= '</div>
            </div>

            <div class="analysis-section">
                <h3 class="section-title">Areas of Concern</h3>
                <div class="weaknesses">';
        
        foreach ($bonusAnalysis['weaknesses'] as $weakness) {
            $analysisHTML .= '<div class="weakness-item"><i class="fas fa-exclamation-triangle"></i> ' . htmlspecialchars($weakness) . '</div>';
        }

        $analysisHTML .= '</div>
            </div>

            <div class="recommendation">
                <h3>Our Recommendation</h3>
                <p>' . htmlspecialchars($bonusAnalysis['recommendation']) . '</p>
            </div>
        </div>
    </div>
</body>
</html>';

        return $analysisHTML;
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
    <title>Bonus Not Found | Best Casino Portal</title>
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
        <p>The bonus analysis you\'re looking for doesn\'t exist.</p>
        <a href="/bonuses">View All Bonuses</a>
    </div>
</body>
</html>';
    }
}
