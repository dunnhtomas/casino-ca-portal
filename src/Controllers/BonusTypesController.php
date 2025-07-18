<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\BonusTypesService;

/**
 * BonusTypesController
 * 
 * Handles bonus types educational content, interactive calculator,
 * and strategic recommendations for Canadian casino players.
 * 
 * @package App\Controllers
 * @version 2.0.0
 * @since 2025-01-20
 */
class BonusTypesController extends Controller
{
    private BonusTypesService $bonusTypesService;

    public function __construct()
    {
        $this->bonusTypesService = new BonusTypesService();
    }

    /**
     * Render the bonus types section for homepage integration
     * 
     * @return string HTML content for the bonus types section
     */
    public function section(): string
    {
        try {
            $bonusTypes = $this->bonusTypesService->getBonusTypes();
            $strategies = $this->bonusTypesService->getBonusStrategies();
            $termsExplanations = $this->bonusTypesService->getTermsExplanations();

            return $this->renderBonusTypesSection($bonusTypes, $strategies, $termsExplanations);
        } catch (\Exception $e) {
            error_log("Error in BonusTypesController::section(): " . $e->getMessage());
            return $this->renderSimpleError('bonus types guide');
        }
    }

    /**
     * API endpoint for bonus calculator
     * 
     * @return void JSON response with calculated bonus values
     */
    public function calculator(): void
    {
        try {
            // Get JSON input
            $inputData = file_get_contents('php://input');
            $input = json_decode($inputData, true);
            
            // Check if JSON decoding failed
            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid JSON input']);
                return;
            }
            
            if (!$input || !isset($input['deposit']) || !isset($input['terms'])) {
                http_response_code(400);
                echo json_encode([
                    'error' => 'Missing required parameters: deposit and terms',
                    'received' => $input,
                    'raw_input' => $inputData
                ]);
                return;
            }

            $deposit = floatval($input['deposit']);
            $terms = $input['terms'];

            // Validate input
            if ($deposit <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Deposit amount must be positive']);
                return;
            }

            $calculation = $this->bonusTypesService->calculateBonusValue($deposit, $terms);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'calculation' => $calculation,
                'timestamp' => time()
            ]);

        } catch (\Exception $e) {
            error_log("Error in BonusTypesController::calculator(): " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Calculation failed', 'message' => $e->getMessage()]);
        }
    }

    /**
     * API endpoint for bonus comparison
     * 
     * @return void JSON response with bonus comparison results
     */
    public function compare(): void
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['bonuses']) || !is_array($input['bonuses'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required parameter: bonuses array']);
                return;
            }

            $comparisons = $this->bonusTypesService->compareBonuses($input['bonuses']);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'comparisons' => $comparisons,
                'best_value' => $comparisons[0] ?? null,
                'timestamp' => time()
            ]);

        } catch (\Exception $e) {
            error_log("Error in BonusTypesController::compare(): " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Comparison failed', 'message' => $e->getMessage()]);
        }
    }

    /**
     * API endpoint for player type recommendations
     * 
     * @param string $playerType Player type (beginner, casual, strategic, high_roller)
     * @return void JSON response with personalized recommendations
     */
    public function strategies(string $playerType = ''): void
    {
        try {
            // Get player type from URL parameter or POST data
            if (empty($playerType)) {
                $input = json_decode(file_get_contents('php://input'), true);
                $playerType = $input['player_type'] ?? '';
            }

            if (empty($playerType)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required parameter: player_type']);
                return;
            }

            $recommendations = $this->bonusTypesService->getRecommendationsByPlayerType($playerType);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'recommendations' => $recommendations,
                'timestamp' => time()
            ]);

        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            error_log("Error in BonusTypesController::strategies(): " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to get recommendations', 'message' => $e->getMessage()]);
        }
    }

    /**
     * API endpoint for terms explanations
     * 
     * @return void JSON response with terms and conditions explanations
     */
    public function terms(): void
    {
        try {
            $termsExplanations = $this->bonusTypesService->getTermsExplanations();

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'terms' => $termsExplanations,
                'timestamp' => time()
            ]);

        } catch (\Exception $e) {
            error_log("Error in BonusTypesController::terms(): " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Failed to get terms explanations']);
        }
    }

    /**
     * Render the complete bonus types section HTML
     * 
     * @param array $bonusTypes Available bonus types
     * @param array $strategies Player strategies
     * @param array $termsExplanations Terms explanations
     * @return string Complete HTML section
     */
    private function renderBonusTypesSection(array $bonusTypes, array $strategies, array $termsExplanations): string
    {
        $bonusCardsHtml = '';
        foreach ($bonusTypes as $key => $bonus) {
            $bonusCardsHtml .= $this->renderBonusCard($key, $bonus);
        }

        $strategiesHtml = '';
        foreach ($strategies as $type => $strategy) {
            $strategiesHtml .= $this->renderStrategyCard($type, $strategy);
        }

        $termsHtml = '';
        foreach ($termsExplanations as $key => $term) {
            $termsHtml .= $this->renderTermCard($key, $term);
        }

        return "
        <section class='bonus-types-guide' id='bonus-types-guide'>
            <div class='container'>
                <div class='section-header'>
                    <h2>Complete Guide to Casino Bonus Types</h2>
                    <p class='section-description'>
                        Master the art of casino bonuses with our comprehensive guide. Learn about different bonus types, 
                        calculate their real value, and discover strategies to maximize your gambling entertainment.
                    </p>
                </div>

                <!-- Interactive Bonus Calculator -->
                <div class='bonus-calculator-widget'>
                    <h3>🧮 Interactive Bonus Calculator</h3>
                    <div class='calculator-form'>
                        <div class='calculator-inputs'>
                            <div class='input-group'>
                                <label for='calc-deposit'>Your Deposit (CAD)</label>
                                <input type='number' id='calc-deposit' min='10' max='10000' value='100' step='10'>
                            </div>
                            <div class='input-group'>
                                <label for='calc-percentage'>Bonus Percentage (%)</label>
                                <input type='number' id='calc-percentage' min='0' max='500' value='100' step='5'>
                            </div>
                            <div class='input-group'>
                                <label for='calc-wagering'>Wagering Requirement (x)</label>
                                <input type='number' id='calc-wagering' min='1' max='100' value='35' step='1'>
                            </div>
                            <div class='input-group'>
                                <label for='calc-max-bet'>Max Bet per Spin ($)</label>
                                <input type='number' id='calc-max-bet' min='0.1' max='50' value='5' step='0.5'>
                            </div>
                            <button type='button' id='calculate-bonus' class='btn btn-primary'>Calculate Value</button>
                        </div>
                        <div class='calculator-results' id='calculator-results' style='display: none;'>
                            <div class='result-grid'>
                                <div class='result-item'>
                                    <span class='result-label'>Bonus Amount:</span>
                                    <span class='result-value' id='result-bonus-amount'>$0</span>
                                </div>
                                <div class='result-item'>
                                    <span class='result-label'>Total Funds:</span>
                                    <span class='result-value' id='result-total-funds'>$0</span>
                                </div>
                                <div class='result-item'>
                                    <span class='result-label'>Wagering Required:</span>
                                    <span class='result-value' id='result-wagering-required'>$0</span>
                                </div>
                                <div class='result-item'>
                                    <span class='result-label'>Estimated Time:</span>
                                    <span class='result-value' id='result-time-required'>0 hours</span>
                                </div>
                                <div class='result-item'>
                                    <span class='result-label'>Real Value:</span>
                                    <span class='result-value' id='result-real-value'>$0</span>
                                </div>
                                <div class='result-item risk-assessment'>
                                    <span class='result-label'>Risk Level:</span>
                                    <span class='result-value risk-indicator' id='result-risk-level'>Low</span>
                                </div>
                            </div>
                            <div class='recommendation-box' id='recommendation-box'>
                                <p id='recommendation-text'></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bonus Types Grid -->
                <div class='bonus-types-section'>
                    <h3>📚 6 Major Casino Bonus Types</h3>
                    <div class='bonus-types-grid'>
                        {$bonusCardsHtml}
                    </div>
                </div>

                <!-- Terms Decoder -->
                <div class='terms-decoder-section'>
                    <h3>🔍 Bonus Terms Decoder</h3>
                    <p class='terms-intro'>
                        Complex casino terms explained in simple language. Know exactly what you're agreeing to before claiming any bonus.
                    </p>
                    <div class='terms-grid'>
                        {$termsHtml}
                    </div>
                </div>

                <!-- Strategy Recommendations -->
                <div class='strategy-section'>
                    <h3>🎯 Strategic Bonus Recommendations</h3>
                    <p class='strategy-intro'>
                        Choose your player profile to get personalized bonus recommendations and strategic advice.
                    </p>
                    <div class='player-type-selector'>
                        <button class='player-type-btn active' data-type='beginner'>New Player</button>
                        <button class='player-type-btn' data-type='casual'>Casual Player</button>
                        <button class='player-type-btn' data-type='strategic'>Strategic Player</button>
                        <button class='player-type-btn' data-type='high_roller'>High Roller</button>
                    </div>
                    <div class='strategies-grid' id='strategies-container'>
                        {$strategiesHtml}
                    </div>
                </div>

                <!-- Safety Notice -->
                <div class='safety-notice'>
                    <h4>⚠️ Responsible Gaming Notice</h4>
                    <p>
                        Casino bonuses are entertainment tools, not guaranteed profit opportunities. Always gamble responsibly, 
                        set strict limits, and never chase losses. If gambling becomes a problem, seek help from 
                        <a href='https://www.responsiblegambling.org/' target='_blank'>Responsible Gambling Canada</a>.
                    </p>
                </div>
            </div>
        </section>";
    }

    /**
     * Render individual bonus type card
     * 
     * @param string $key Bonus type key
     * @param array $bonus Bonus data
     * @return string HTML for bonus card
     */
    private function renderBonusCard(string $key, array $bonus): string
    {
        $riskClass = strtolower($bonus['risk_level']);
        $prosHtml = implode('', array_map(fn($pro) => "<li>{$pro}</li>", $bonus['pros']));
        $consHtml = implode('', array_map(fn($con) => "<li>{$con}</li>", $bonus['cons']));
        
        return "
        <div class='bonus-type-card {$riskClass}-risk' data-bonus-type='{$key}'>
            <div class='bonus-card-header'>
                <div class='bonus-icon'>
                    <img src='/images/icons/{$bonus['icon']}' alt='{$bonus['name']} icon' loading='lazy'>
                </div>
                <h4>{$bonus['name']}</h4>
                <div class='risk-badge risk-{$riskClass}'>{$bonus['risk_level']} Risk</div>
            </div>
            <div class='bonus-card-body'>
                <p class='bonus-description'>{$bonus['description']}</p>
                
                <div class='bonus-stats'>
                    <div class='stat-item'>
                        <span class='stat-label'>Typical %:</span>
                        <span class='stat-value'>{$bonus['typical_percentage']}%</span>
                    </div>
                    <div class='stat-item'>
                        <span class='stat-label'>Avg. Wagering:</span>
                        <span class='stat-value'>{$bonus['average_wagering']}x</span>
                    </div>
                </div>

                <div class='pros-cons-container'>
                    <div class='pros-section'>
                        <h5>✅ Pros</h5>
                        <ul>{$prosHtml}</ul>
                    </div>
                    <div class='cons-section'>
                        <h5>❌ Cons</h5>
                        <ul>{$consHtml}</ul>
                    </div>
                </div>

                <div class='strategy-tips'>
                    <h5>💡 Strategy Tips</h5>
                    <p>{$bonus['strategy_tips']}</p>
                </div>

                <button class='btn btn-outline expand-bonus-btn' data-bonus='{$key}'>
                    View Examples & Details
                </button>
            </div>
        </div>";
    }

    /**
     * Render strategy recommendation card
     * 
     * @param string $type Player type
     * @param array $strategy Strategy data
     * @return string HTML for strategy card
     */
    private function renderStrategyCard(string $type, array $strategy): string
    {
        $tipsHtml = implode('', array_map(fn($tip) => "<li>{$tip}</li>", $strategy['tips']));
        $avoidHtml = implode('', array_map(fn($avoid) => "<li>{$avoid}</li>", $strategy['avoid']));
        
        return "
        <div class='strategy-card' data-player-type='{$type}' style='display: " . ($type === 'beginner' ? 'block' : 'none') . "'>
            <h4>{$strategy['title']}</h4>
            <p class='strategy-description'>{$strategy['description']}</p>
            
            <div class='strategy-content'>
                <div class='strategy-tips'>
                    <h5>📈 Recommended Approach</h5>
                    <ul>{$tipsHtml}</ul>
                </div>
                
                <div class='strategy-avoid'>
                    <h5>⚠️ What to Avoid</h5>
                    <ul>{$avoidHtml}</ul>
                </div>
            </div>
        </div>";
    }

    /**
     * Render terms explanation card
     * 
     * @param string $key Term key
     * @param array $term Term data
     * @return string HTML for term card
     */
    private function renderTermCard(string $key, array $term): string
    {
        $warningClass = strtolower($term['warning_level']);
        $impactStars = str_repeat('⭐', $term['impact_rating']);
        
        return "
        <div class='term-card {$warningClass}-warning' data-term='{$key}'>
            <div class='term-header'>
                <h4>{$term['term']}</h4>
                <div class='impact-rating' title='Impact Level'>{$impactStars}</div>
                <div class='warning-badge warning-{$warningClass}'>{$term['warning_level']}</div>
            </div>
            <div class='term-body'>
                <div class='simple-explanation'>
                    <h5>In Simple Terms:</h5>
                    <p>{$term['simple_explanation']}</p>
                </div>
                
                <div class='example-scenario'>
                    <h5>Example:</h5>
                    <p>{$term['example_scenario']}</p>
                </div>
                
                <div class='what-this-means'>
                    <h5>What This Means for You:</h5>
                    <p class='impact-text'>{$term['what_this_means']}</p>
                </div>
            </div>
        </div>";
    }

    /**
     * Render simple error fallback
     * 
     * @param string $sectionName Section name for error message
     * @return string HTML error content
     */
    private function renderSimpleError(string $sectionName): string
    {
        return "
        <section class='bonus-types-guide error-section'>
            <div class='container'>
                <div class='error-message'>
                    <h2>Bonus Types Guide</h2>
                    <p>We're currently updating our {$sectionName}. Please check back soon!</p>
                </div>
            </div>
        </section>";
    }
}
