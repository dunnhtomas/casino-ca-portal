<?php

namespace App\Controllers;

use App\Services\BonusDatabaseService;

/**
 * Bonus Database Controller
 * Handles bonus display, filtering, and API endpoints
 */
class BonusDatabaseController 
{
    private $bonusDatabaseService;

    public function __construct() 
    {
        $this->bonusDatabaseService = new BonusDatabaseService();
    }

    /**
     * Display bonus database section for homepage
     */
    public function renderBonusDatabase() 
    {
        $topBonuses = $this->bonusDatabaseService->getTopBonuses(12);
        $categories = $this->bonusDatabaseService->getBonusCategories();
        $exclusiveBonuses = $this->bonusDatabaseService->getExclusiveBonuses();
        $stats = $this->bonusDatabaseService->getBonusStatistics();

        $html = '
        <section id="bonus-database-section" class="bonus-database-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">🎁 Complete Bonus Database</h2>
                    <p class="section-subtitle">
                        Browse our comprehensive collection of <strong>' . $stats['total_bonuses'] . '+ casino bonuses</strong> with detailed terms, 
                        wagering requirements, and exclusive promotional codes for Canadian players.
                    </p>
                    <div class="bonus-stats">
                        <div class="stat-item">
                            <span class="stat-number">' . $stats['total_bonuses'] . '+</span>
                            <span class="stat-label">Total Bonuses</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">' . $stats['exclusive_bonuses'] . '</span>
                            <span class="stat-label">Exclusive Offers</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">' . $stats['categories'] . '</span>
                            <span class="stat-label">Categories</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">' . $stats['average_wagering'] . '</span>
                            <span class="stat-label">Avg. Wagering</span>
                        </div>
                    </div>
                </div>

                <div class="bonus-filters">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="bonus-category">Category:</label>
                            <select id="bonus-category" class="filter-select">
                                <option value="">All Categories</option>';
                                
        foreach ($categories as $category) {
            $html .= '<option value="' . htmlspecialchars($category) . '">' . htmlspecialchars($category) . '</option>';
        }
        
        $html .= '
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="bonus-type">Type:</label>
                            <select id="bonus-type" class="filter-select">
                                <option value="">All Types</option>
                                <option value="welcome_bonus">Welcome Bonus</option>
                                <option value="welcome_package">Welcome Package</option>
                                <option value="no_deposit">No Deposit</option>
                                <option value="reload_bonus">Reload Bonus</option>
                                <option value="cashback">Cashback</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="max-wagering">Max Wagering:</label>
                            <select id="max-wagering" class="filter-select">
                                <option value="">Any Wagering</option>
                                <option value="30">Up to 30x</option>
                                <option value="40">Up to 40x</option>
                                <option value="50">Up to 50x</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="exclusive-only">Exclusive Only:</label>
                            <input type="checkbox" id="exclusive-only" class="filter-checkbox">
                        </div>
                        <button id="apply-filters" class="btn btn-primary">Apply Filters</button>
                        <button id="reset-filters" class="btn btn-secondary">Reset</button>
                    </div>
                </div>

                <div id="bonus-grid" class="bonus-grid">';

        foreach ($topBonuses as $bonus) {
            $html .= $this->renderBonusCard($bonus);
        }

        $html .= '
                </div>

                <div class="bonus-actions">
                    <button id="load-more-bonuses" class="btn btn-outline">Load More Bonuses</button>
                    <a href="/bonuses" class="btn btn-primary">View All Bonuses</a>
                </div>

                <div class="exclusive-bonuses-highlight">
                    <h3>🌟 Exclusive Bonus Codes</h3>
                    <p>Get access to special promotional codes available only to our users:</p>
                    <div class="exclusive-codes">';

        $exclusiveCount = 0;
        foreach ($exclusiveBonuses as $bonus) {
            if ($exclusiveCount >= 6) break;
            $html .= '
                        <div class="exclusive-code-item">
                            <span class="casino-name">' . htmlspecialchars($bonus['casino']) . '</span>
                            <span class="bonus-code">' . htmlspecialchars($bonus['bonus_code']) . '</span>
                            <span class="bonus-amount">' . htmlspecialchars($bonus['amount']) . '</span>
                        </div>';
            $exclusiveCount++;
        }

        $html .= '
                    </div>
                </div>
            </div>
        </section>';

        return $html;
    }

    /**
     * Render individual bonus card
     */
    private function renderBonusCard($bonus) 
    {
        $exclusiveBadge = $bonus['exclusive'] ? '<span class="exclusive-badge">Exclusive</span>' : '';
        $ratingStars = str_repeat('⭐', floor($bonus['rating']));
        
        $bonusCardHtml = '
        <div class="bonus-card" data-bonus-id="' . htmlspecialchars($bonus['id']) . '">
            <div class="bonus-card-header">
                <div class="casino-info">
                    <h4 class="casino-name">' . htmlspecialchars($bonus['casino']) . '</h4>
                    <div class="bonus-rating">
                        <span class="stars">' . $ratingStars . '</span>
                        <span class="rating-value">' . $bonus['rating'] . '</span>
                    </div>
                </div>
                ' . $exclusiveBadge . '
            </div>
            
            <div class="bonus-card-body">
                <h5 class="bonus-title">' . htmlspecialchars($bonus['title']) . '</h5>
                <div class="bonus-amount">' . htmlspecialchars($bonus['amount']) . '</div>
                
                <div class="bonus-details">
                    <div class="detail-row">
                        <span class="detail-label">Wagering:</span>
                        <span class="detail-value">' . htmlspecialchars($bonus['wagering_requirement']) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Min Deposit:</span>
                        <span class="detail-value">' . htmlspecialchars($bonus['min_deposit']) . '</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Time Limit:</span>
                        <span class="detail-value">' . htmlspecialchars($bonus['time_limit']) . '</span>
                    </div>';
                    
        if ($bonus['free_spins'] > 0) {
            $bonusCardHtml .= '
                    <div class="detail-row">
                        <span class="detail-label">Free Spins:</span>
                        <span class="detail-value">' . $bonus['free_spins'] . ' spins</span>
                    </div>';
        }

        $bonusCardHtml .= '
                </div>

                <div class="bonus-description">
                    <p>' . htmlspecialchars($bonus['description']) . '</p>
                </div>
            </div>

            <div class="bonus-card-footer">
                <div class="bonus-code-section">
                    <span class="code-label">Bonus Code:</span>
                    <span class="bonus-code" data-code="' . htmlspecialchars($bonus['bonus_code']) . '">' . htmlspecialchars($bonus['bonus_code']) . '</span>
                    <button class="copy-code-btn" onclick="copyBonusCode(\'' . htmlspecialchars($bonus['bonus_code']) . '\')">Copy</button>
                </div>
                <div class="bonus-actions">
                    <a href="' . htmlspecialchars($bonus['claim_url']) . '" class="btn btn-primary claim-bonus-btn" target="_blank">Claim Bonus</a>
                    <a href="/bonus/' . htmlspecialchars($bonus['id']) . '" class="btn btn-secondary">View Terms</a>
                </div>
            </div>
        </div>';

        return $bonusCardHtml;
    }

    /**
     * API endpoint for bonus filtering
     */
    public function filterBonuses() 
    {
        $filters = [
            'type' => $_GET['type'] ?? '',
            'category' => $_GET['category'] ?? '',
            'min_amount' => $_GET['min_amount'] ?? '',
            'max_wagering' => $_GET['max_wagering'] ?? '',
            'exclusive' => $_GET['exclusive'] ?? '',
            'casino' => $_GET['casino'] ?? ''
        ];

        $bonuses = $this->bonusDatabaseService->filterBonuses($filters);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'count' => count($bonuses),
            'bonuses' => $bonuses,
            'filters_applied' => array_filter($filters)
        ]);
    }

    /**
     * API endpoint for individual bonus details
     */
    public function getBonusDetails($bonusId) 
    {
        $bonus = $this->bonusDatabaseService->getBonusById($bonusId);
        
        if (!$bonus) {
            header('HTTP/1.1 404 Not Found');
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Bonus not found']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'bonus' => $bonus
        ]);
    }

    /**
     * API endpoint for all bonuses with pagination
     */
    public function getAllBonuses() 
    {
        $page = (int) ($_GET['page'] ?? 1);
        $limit = (int) ($_GET['limit'] ?? 20);
        $offset = ($page - 1) * $limit;

        $allBonuses = $this->bonusDatabaseService->getAllBonuses();
        $total = count($allBonuses);
        $bonuses = array_slice($allBonuses, $offset, $limit);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'pages' => ceil($total / $limit),
            'bonuses' => $bonuses,
            'statistics' => $this->bonusDatabaseService->getBonusStatistics()
        ]);
    }

    /**
     * Display bonus terms page
     */
    public function showBonusTerms($bonusId) 
    {
        $bonus = $this->bonusDatabaseService->getBonusById($bonusId);
        
        if (!$bonus) {
            header('HTTP/1.1 404 Not Found');
            echo '<h1>Bonus not found</h1>';
            return;
        }

        $html = '
        <div class="bonus-terms-page">
            <div class="container">
                <div class="bonus-header">
                    <h1>' . htmlspecialchars($bonus['title']) . '</h1>
                    <h2>' . htmlspecialchars($bonus['casino']) . '</h2>
                    <div class="bonus-highlight">
                        <span class="amount">' . htmlspecialchars($bonus['amount']) . '</span>
                        <span class="code">Code: ' . htmlspecialchars($bonus['bonus_code']) . '</span>
                    </div>
                </div>

                <div class="terms-content">
                    <h3>Bonus Terms & Conditions</h3>
                    <div class="terms-summary">
                        <p><strong>Summary:</strong> ' . htmlspecialchars($bonus['terms_summary']) . '</p>
                    </div>

                    <div class="terms-details">
                        <h4>Key Information</h4>
                        <ul>
                            <li><strong>Bonus Amount:</strong> ' . htmlspecialchars($bonus['amount']) . '</li>
                            <li><strong>Wagering Requirement:</strong> ' . htmlspecialchars($bonus['wagering_requirement']) . '</li>
                            <li><strong>Minimum Deposit:</strong> ' . htmlspecialchars($bonus['min_deposit']) . '</li>
                            <li><strong>Time Limit:</strong> ' . htmlspecialchars($bonus['time_limit']) . '</li>
                            <li><strong>Bonus Code:</strong> ' . htmlspecialchars($bonus['bonus_code']) . '</li>';
                            
        if ($bonus['free_spins'] > 0) {
            $html .= '<li><strong>Free Spins:</strong> ' . $bonus['free_spins'] . ' spins included</li>';
        }

        $html .= '
                        </ul>
                    </div>

                    <div class="claim-section">
                        <a href="' . htmlspecialchars($bonus['claim_url']) . '" class="btn btn-primary btn-large">Claim This Bonus</a>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }
}
