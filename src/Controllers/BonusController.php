<?php

namespace App\Controllers;

use App\Services\BonusService;

/**
 * Bonus Controller for PRD #32
 * Handles bonus database, comparison, and calculator requests
 */
class BonusController extends BaseController
{
    private $bonusService;
    
    public function __construct()
    {
        parent::__construct();
        $this->bonusService = new BonusService();
    }
    
    /**
     * Main bonus database page
     */
    public function index()
    {
        // Force HTML for debugging - completely bypass JSON logic
        error_log("BonusController::index() called");
        
        $filters = [
            'bonus_type' => $_GET['type'] ?? null,
            'casino_id' => $_GET['casino'] ?? null,
            'featured' => isset($_GET['featured']) ? true : null,
            'exclusive' => isset($_GET['exclusive']) ? true : null,
            'max_wagering' => $_GET['max_wagering'] ?? null,
            'min_amount' => $_GET['min_amount'] ?? null
        ];
        
        // Remove null values
        $filters = array_filter($filters, function($value) {
            return $value !== null;
        });
        
        $bonuses = $this->bonusService->getAllBonuses($filters);
        $statistics = $this->bonusService->getBonusStatistics();
        
        // Get filter options for dropdowns
        $bonusTypes = ['welcome', 'no_deposit', 'free_spins', 'reload', 'cashback', 'loyalty'];
        $wageringOptions = [10, 20, 25, 30, 35, 40, 50];
        $amountOptions = [25, 50, 100, 500, 1000, 2000];
        
        return $this->render('bonuses/index', [
            'bonuses' => $bonuses,
            'statistics' => $statistics,
            'filters' => $filters,
            'bonusTypes' => $bonusTypes,
            'wageringOptions' => $wageringOptions,
            'amountOptions' => $amountOptions,
            'title' => 'Best Casino Bonuses 2025 - Exclusive Deals & Offers',
            'meta_description' => 'Find the best casino bonuses in Canada 2025. Compare exclusive deals, no deposit bonuses, and welcome packages from top-rated casinos.',
            'canonical_url' => 'https://bestcasinoportal.com/bonuses'
        ]);
    }
    
    /**
     * Bonus comparison tool
     */
    public function compare()
    {
        $bonusIds = $_GET['ids'] ?? [];
        if (is_string($bonusIds)) {
            $bonusIds = explode(',', $bonusIds);
        }
        $bonusIds = array_filter($bonusIds); // Remove empty values
        
        $bonuses = [];
        foreach ($bonusIds as $id) {
            $bonus = $this->bonusService->getBonusById($id);
            if ($bonus) {
                $bonuses[] = $bonus;
            }
        }
        
        // Track comparison for analytics
        if (count($bonuses) > 1) {
            $this->bonusService->trackComparison($bonusIds);
        }
        
        return $this->render('bonuses/compare', [
            'bonuses' => $bonuses,
            'title' => 'Casino Bonus Comparison Tool',
            'meta_description' => 'Compare casino bonuses side-by-side. Analyze wagering requirements, time limits, and find the best bonus for your playing style.',
            'canonical_url' => 'https://bestcasinoportal.com/bonuses/compare'
        ]);
    }
    
    /**
     * Bonus calculator tool
     */
    public function calculator()
    {
        $calculation = null;
        $selectedBonus = null;
        
        if ($_POST) {
            $bonusId = $_POST['bonus_id'] ?? null;
            $depositAmount = (float)($_POST['deposit_amount'] ?? 100);
            $gameRTP = (float)($_POST['game_rtp'] ?? 96.0);
            
            if ($bonusId && is_numeric($bonusId)) {
                $selectedBonus = $this->bonusService->getBonusById($bonusId);
                $calculation = $this->bonusService->calculateBonusValue($bonusId, [
                    'deposit_amount' => $depositAmount,
                    'game_rtp' => $gameRTP
                ]);
            }
        }
        
        // Get all bonuses for dropdown
        $allBonuses = $this->bonusService->getAllBonuses();
        
        return $this->render('bonuses/calculator', [
            'bonuses' => $allBonuses,
            'selectedBonus' => $selectedBonus,
            'calculation' => $calculation,
            'title' => 'Casino Bonus Calculator - Calculate Real Value',
            'meta_description' => 'Calculate the real value of casino bonuses. Understand wagering requirements, expected value, and make informed decisions.',
            'canonical_url' => 'https://bestcasinoportal.com/bonuses/calculator'
        ]);
    }
    
    /**
     * AJAX endpoint for filtering bonuses
     */
    public function ajax(): void
    {
        header('Content-Type: application/json');
        
        // Get filter parameters
        $filters = [
            'bonus_type' => $_GET['bonus_type'] ?? null,
            'min_amount' => $_GET['min_amount'] ?? null,
            'max_amount' => $_GET['max_amount'] ?? null,
            'max_wagering' => $_GET['max_wagering'] ?? null,
            'min_time_limit' => $_GET['min_time_limit'] ?? null,
            'casino_name' => $_GET['casino_name'] ?? null,
            'featured_only' => isset($_GET['featured_only']),
            'exclusive_only' => isset($_GET['exclusive_only']),
        ];
        
        // Get sorting and pagination
        $sort = $_GET['sort'] ?? 'value_desc';
        $page = (int)($_GET['page'] ?? 1);
        $limit = (int)($_GET['limit'] ?? 20);
        $offset = ($page - 1) * $limit;
        
        try {
            $bonuses = $this->bonusService->searchBonuses($filters, $sort, $limit, $offset);
            $total = $this->bonusService->countBonuses($filters);
            
            echo json_encode([
                'success' => true,
                'bonuses' => $bonuses,
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API endpoint for bonus calculation
     */
    public function calculateApi(): void
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            return;
        }
        
        $input = json_decode(file_get_contents('php://input'), true);
        $bonusId = $input['bonus_id'] ?? null;
        $deposit = (float)($input['deposit'] ?? 0);
        $gameRtp = (float)($input['game_rtp'] ?? 96.0);
        
        if (!$bonusId || !$deposit) {
            echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
            return;
        }
        
        try {
            $bonus = $this->bonusService->getBonusById($bonusId);
            if (!$bonus) {
                echo json_encode(['success' => false, 'error' => 'Bonus not found']);
                return;
            }
            
            $calculation = $this->bonusService->calculateBonusValue($bonusId, [
                'deposit_amount' => $deposit,
                'game_rtp' => $gameRtp
            ]);
            
            echo json_encode([
                'success' => true,
                'calculation' => $calculation,
                'bonus' => $bonus
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * API endpoint for bonus search
     */
    public function searchApi(): void
    {
        header('Content-Type: application/json');
        
        $query = $_GET['q'] ?? '';
        $limit = min((int)($_GET['limit'] ?? 10), 50);
        
        try {
            $bonuses = $this->bonusService->quickSearch($query, $limit);
            
            echo json_encode([
                'success' => true,
                'bonuses' => $bonuses,
                'query' => $query
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
