<?php

namespace App\Services;

use PDO;
use Exception;

class BonusService
{
    private $db;
    
    public function __construct()
    {
        // Database connection
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $dbname = $_ENV['DB_NAME'] ?? 'casino_portal';
        $username = $_ENV['DB_USER'] ?? 'casino_user';
        $password = $_ENV['DB_PASS'] ?? 'secure_password_123';
        
        try {
            $this->db = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (Exception $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }
    
    /**
     * Get all bonuses with optional filters
     */
    public function getAllBonuses(array $filters = []): array
    {
        try {
            $query = "SELECT b.*, c.name as casino_name FROM bonuses b LEFT JOIN casinos c ON b.casino_id = c.id WHERE 1=1";
            $params = [];
            
            if (!empty($filters['bonus_type'])) {
                $query .= " AND b.bonus_type = ?";
                $params[] = $filters['bonus_type'];
            }
            
            if (!empty($filters['featured'])) {
                $query .= " AND b.featured = 1";
            }
            
            if (!empty($filters['exclusive'])) {
                $query .= " AND b.exclusive = 1";
            }
            
            if (!empty($filters['max_wagering'])) {
                $query .= " AND b.wagering_requirement <= ?";
                $params[] = (int)$filters['max_wagering'];
            }
            
            if (!empty($filters['min_amount'])) {
                $query .= " AND b.bonus_amount >= ?";
                $params[] = (int)$filters['min_amount'];
            }
            
            $query .= " ORDER BY b.featured DESC, b.exclusive DESC, b.bonus_amount DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error fetching bonuses: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get bonus statistics
     */
    public function getBonusStatistics(): array
    {
        try {
            $stats = [];
            
            // Total bonuses
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM bonuses");
            $stats['total_bonuses'] = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Exclusive bonuses
            $stmt = $this->db->query("SELECT COUNT(*) as exclusive FROM bonuses WHERE exclusive = 1");
            $stats['exclusive_bonuses'] = $stmt->fetch(PDO::FETCH_OBJ)->exclusive;
            
            // Categories count
            $stmt = $this->db->query("SELECT COUNT(DISTINCT bonus_type) as categories FROM bonuses");
            $stats['categories'] = $stmt->fetch(PDO::FETCH_OBJ)->categories;
            
            // Average wagering
            $stmt = $this->db->query("SELECT AVG(wagering_requirement) as avg_wagering FROM bonuses WHERE wagering_requirement > 0");
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $stats['average_wagering'] = number_format($result->avg_wagering, 1) . 'x';
            
            // Average bonus amount
            $stmt = $this->db->query("SELECT AVG(bonus_amount) as avg_amount FROM bonuses WHERE bonus_amount > 0");
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $stats['average_amount'] = '$' . number_format($result->avg_amount);
            
            $stats['last_updated'] = date('Y-m-d H:i:s');
            
            return $stats;
        } catch (Exception $e) {
            error_log("Error getting bonus statistics: " . $e->getMessage());
            return [
                'total_bonuses' => 0,
                'exclusive_bonuses' => 0,
                'categories' => 0,
                'average_wagering' => '0x',
                'average_amount' => '$0',
                'last_updated' => date('Y-m-d H:i:s')
            ];
        }
    }
    
    /**
     * Get bonus by ID
     */
    public function getBonusById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM bonuses WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error fetching bonus by ID: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Calculate bonus value with expected return
     */
    public function calculateBonusValue($bonusId, array $params = []): ?array
    {
        try {
            $bonus = $this->getBonusById($bonusId);
            if (!$bonus) {
                return null;
            }
            
            $depositAmount = (float)($params['deposit_amount'] ?? 100);
            $gameRTP = (float)($params['game_rtp'] ?? 96.0) / 100;
            
            // Calculate bonus amount
            $bonusAmount = min($bonus->bonus_amount, ($depositAmount * $bonus->bonus_percentage / 100));
            
            // Calculate total amount to wager
            $totalToWager = ($bonusAmount + $depositAmount) * $bonus->wagering_requirement;
            
            // Calculate expected loss
            $expectedLoss = $totalToWager * (1 - $gameRTP);
            
            // Calculate expected value
            $expectedValue = $bonusAmount - $expectedLoss;
            
            // Calculate completion probability (simplified)
            $completionProbability = max(0, min(100, (100 - ($bonus->wagering_requirement - 20) * 2)));
            
            return [
                'bonus_amount' => $bonusAmount,
                'total_to_wager' => $totalToWager,
                'expected_loss' => $expectedLoss,
                'expected_value' => $expectedValue,
                'completion_probability' => $completionProbability,
                'recommendation' => $this->getRecommendation($expectedValue, $bonus),
                'risk_level' => $this->getRiskLevel($bonus)
            ];
        } catch (Exception $e) {
            error_log("Error calculating bonus value: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get recommendation text based on expected value
     */
    private function getRecommendation($expectedValue, $bonus)
    {
        if ($expectedValue > 0) {
            return "This bonus offers positive expected value (+$" . number_format($expectedValue, 2) . "). " .
                   "Consider playing high RTP games to maximize your advantage.";
        } elseif ($expectedValue > -50) {
            return "This bonus has a small negative expected value (" . number_format($expectedValue, 2) . "). " .
                   "Good for entertainment value with reasonable risk.";
        } else {
            return "This bonus has significant negative expected value (" . number_format($expectedValue, 2) . "). " .
                   "Consider smaller deposits or look for better terms.";
        }
    }
    
    /**
     * Determine risk level of bonus
     */
    private function getRiskLevel($bonus)
    {
        $riskScore = 0;
        
        // High wagering requirement increases risk
        if ($bonus->wagering_requirement > 40) $riskScore += 2;
        elseif ($bonus->wagering_requirement > 30) $riskScore += 1;
        
        // Short time limit increases risk
        if ($bonus->time_limit_days < 5) $riskScore += 2;
        elseif ($bonus->time_limit_days < 10) $riskScore += 1;
        
        // Game restrictions can increase risk
        if (strpos(strtolower($bonus->game_restrictions), 'slots only') !== false) $riskScore += 1;
        
        if ($riskScore >= 4) return 'High';
        elseif ($riskScore >= 2) return 'Medium';
        else return 'Low';
    }
    
    /**
     * Track bonus comparison for analytics
     */
    public function trackComparison($bonusIds)
    {
        // Simple logging for now
        error_log("Bonus comparison tracked: " . implode(', ', $bonusIds));
    }
    
    /**
     * Count bonuses with filters
     */
    public function countBonuses(array $filters = []): int
    {
        try {
            $query = "SELECT COUNT(*) as total FROM bonuses b";
            $needsJoin = !empty($filters['casino_name']);
            
            if ($needsJoin) {
                $query .= " LEFT JOIN casinos c ON b.casino_id = c.id";
            }
            
            $query .= " WHERE 1=1";
            $params = [];
            
            // Apply the same filters as searchBonuses
            if (!empty($filters['bonus_type'])) {
                $query .= " AND b.bonus_type = ?";
                $params[] = $filters['bonus_type'];
            }
            
            if (!empty($filters['min_amount'])) {
                $query .= " AND b.bonus_amount >= ?";
                $params[] = (int)$filters['min_amount'];
            }
            
            if (!empty($filters['max_amount'])) {
                $query .= " AND b.bonus_amount <= ?";
                $params[] = (int)$filters['max_amount'];
            }
            
            if (!empty($filters['max_wagering'])) {
                $query .= " AND b.wagering_requirement <= ?";
                $params[] = (int)$filters['max_wagering'];
            }
            
            if (!empty($filters['min_time_limit'])) {
                $query .= " AND b.time_limit_days >= ?";
                $params[] = (int)$filters['min_time_limit'];
            }
            
            if (!empty($filters['casino_name'])) {
                $query .= " AND c.name LIKE ?";
                $params[] = '%' . $filters['casino_name'] . '%';
            }
            
            if (isset($filters['featured_only']) && $filters['featured_only']) {
                $query .= " AND b.featured = 1";
            }
            
            if (isset($filters['exclusive_only']) && $filters['exclusive_only']) {
                $query .= " AND b.exclusive = 1";
            }
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return (int)$result['total'];
        } catch (Exception $e) {
            error_log("Error counting bonuses: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Quick search for bonuses (for autocomplete/search API)
     */
    public function quickSearch(string $query, int $limit = 10): array
    {
        try {
            $sql = "SELECT b.id, b.title, c.name as casino_name, b.bonus_type, b.bonus_amount, 
                           b.bonus_percentage, b.free_spins_count, b.wagering_requirement, b.min_deposit
                    FROM bonuses b
                    LEFT JOIN casinos c ON b.casino_id = c.id 
                    WHERE b.title LIKE ? OR c.name LIKE ? OR b.bonus_code LIKE ?
                    ORDER BY b.featured DESC, b.exclusive DESC, b.bonus_amount DESC 
                    LIMIT ?";
            
            $searchTerm = '%' . $query . '%';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $limit]);
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error in quick search: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Search bonuses with filters, sorting, and pagination
     */
    public function searchBonuses(array $filters = [], string $sort = 'value_desc', int $limit = 20, int $offset = 0): array
    {
        try {
            $query = "SELECT b.*, c.name as casino_name FROM bonuses b";
            $needsJoin = !empty($filters['casino_name']);
            
            if ($needsJoin) {
                $query .= " LEFT JOIN casinos c ON b.casino_id = c.id";
            } else {
                $query .= " LEFT JOIN casinos c ON b.casino_id = c.id";  // Always join for casino_name in results
            }
            
            $query .= " WHERE 1=1";
            $params = [];
            
            // Apply filters (same as countBonuses)
            if (!empty($filters['bonus_type'])) {
                $query .= " AND b.bonus_type = ?";
                $params[] = $filters['bonus_type'];
            }
            
            if (!empty($filters['min_amount'])) {
                $query .= " AND b.bonus_amount >= ?";
                $params[] = (int)$filters['min_amount'];
            }
            
            if (!empty($filters['max_amount'])) {
                $query .= " AND b.bonus_amount <= ?";
                $params[] = (int)$filters['max_amount'];
            }
            
            if (!empty($filters['max_wagering'])) {
                $query .= " AND b.wagering_requirement <= ?";
                $params[] = (int)$filters['max_wagering'];
            }
            
            if (!empty($filters['min_time_limit'])) {
                $query .= " AND b.time_limit_days >= ?";
                $params[] = (int)$filters['min_time_limit'];
            }
            
            if (!empty($filters['casino_name'])) {
                $query .= " AND c.name LIKE ?";
                $params[] = '%' . $filters['casino_name'] . '%';
            }
            
            if (isset($filters['featured_only']) && $filters['featured_only']) {
                $query .= " AND b.featured = 1";
            }
            
            if (isset($filters['exclusive_only']) && $filters['exclusive_only']) {
                $query .= " AND b.exclusive = 1";
            }
            
            // Apply sorting
            switch ($sort) {
                case 'amount_desc':
                    $query .= " ORDER BY b.bonus_amount DESC";
                    break;
                case 'amount_asc':
                    $query .= " ORDER BY b.bonus_amount ASC";
                    break;
                case 'wagering_asc':
                    $query .= " ORDER BY b.wagering_requirement ASC";
                    break;
                case 'wagering_desc':
                    $query .= " ORDER BY b.wagering_requirement DESC";
                    break;
                case 'time_desc':
                    $query .= " ORDER BY b.time_limit_days DESC";
                    break;
                case 'time_asc':
                    $query .= " ORDER BY b.time_limit_days ASC";
                    break;
                default: // value_desc
                    $query .= " ORDER BY b.featured DESC, b.exclusive DESC, b.bonus_amount DESC, b.wagering_requirement ASC";
            }
            
            // Apply pagination
            $query .= " LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error searching bonuses: " . $e->getMessage());
            return [];
        }
    }
}
