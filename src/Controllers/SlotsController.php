<?php

namespace App\Controllers;

use App\Core\Controller;
use CasinoPortal\Services\SlotsService;

class SlotsController extends Controller
{
    private SlotsService $slotsService;

    public function __construct()
    {
        $this->slotsService = new SlotsService();
    }

    /**
     * Homepage section for popular slots
     * 
     * @return string Rendered homepage section
     */
    public function section(): string
    {
        $slots = $this->slotsService->getPopularSlots(16);
        $categories = $this->slotsService->getSlotCategories();
        $rtpAnalysis = $this->slotsService->getRTPAnalysis();
        $volatilityAnalysis = $this->slotsService->getVolatilityAnalysis();

        return $this->renderSlotsSection($slots, $categories, $rtpAnalysis, $volatilityAnalysis);
    }

    /**
     * Main slots page with full functionality
     * 
     * @return string Rendered slots page
     */
    public function index(): string
    {
        $slots = $this->slotsService->getPopularSlots(50);
        $categories = $this->slotsService->getSlotCategories();
        
        // For now, return the section content
        // In production, this would render a full page template
        return $this->section();
    }

    /**
     * Get demo game data
     * 
     * @param int $slotId Slot ID
     * @return string JSON response
     */
    public function demo(int $slotId): string
    {
        $demoUrl = $this->slotsService->getDemoGameUrl($slotId);
        $analytics = $this->slotsService->getSlotAnalytics($slotId);

        $response = [
            'success' => !empty($demoUrl),
            'demo_url' => $demoUrl,
            'analytics' => $analytics,
            'message' => !empty($demoUrl) ? 'Demo game loaded successfully' : 'Demo not available'
        ];

        header('Content-Type: application/json');
        return json_encode($response);
    }

    /**
     * Get slot analytics data
     * 
     * @param int $slotId Slot ID
     * @return string JSON response
     */
    public function analytics(int $slotId): string
    {
        $analytics = $this->slotsService->getSlotAnalytics($slotId);

        $response = [
            'success' => !empty($analytics),
            'data' => $analytics,
            'message' => !empty($analytics) ? 'Analytics loaded successfully' : 'Slot not found'
        ];

        header('Content-Type: application/json');
        return json_encode($response);
    }

    /**
     * Filter slots via AJAX
     * 
     * @return string JSON response with filtered slots
     */
    public function filter(): string
    {
        $filters = [
            'provider' => $_GET['provider'] ?? '',
            'theme' => $_GET['theme'] ?? '',
            'volatility' => $_GET['volatility'] ?? '',
            'min_rtp' => $_GET['min_rtp'] ?? '',
            'max_rtp' => $_GET['max_rtp'] ?? ''
        ];

        $filteredSlots = $this->slotsService->filterSlots($filters);

        $response = [
            'success' => true,
            'count' => count($filteredSlots),
            'slots' => $filteredSlots,
            'filters_applied' => array_filter($filters)
        ];

        header('Content-Type: application/json');
        return json_encode($response);
    }

    /**
     * Render the popular slots homepage section
     * 
     * @param array $slots Popular slots data
     * @param array $categories Available categories
     * @param array $rtpAnalysis RTP statistics
     * @param array $volatilityAnalysis Volatility statistics
     * @return string Rendered HTML section
     */
    private function renderSlotsSection(array $slots, array $categories, array $rtpAnalysis, array $volatilityAnalysis): string
    {
        $html = '
        <section class="popular-slots-detailed" id="popular-slots">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Popular Slots - Detailed Analysis</h2>
                    <p class="section-subtitle">Discover the most popular slot games with comprehensive RTP analysis, volatility ratings, and free demos. Our expert team has analyzed hundreds of slots to bring you the best options for Canadian players.</p>
                    
                    <!-- Filter Controls -->
                    <div class="filter-controls">
                        <div class="filter-group">
                            <label for="provider-filter">Provider:</label>
                            <select id="provider-filter" name="provider">
                                <option value="">All Providers</option>';
                                
        foreach ($categories['providers'] as $provider) {
            $html .= '<option value="' . htmlspecialchars($provider) . '">' . htmlspecialchars($provider) . '</option>';
        }
        
        $html .= '
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="theme-filter">Theme:</label>
                            <select id="theme-filter" name="theme">
                                <option value="">All Themes</option>';
                                
        foreach ($categories['themes'] as $theme) {
            $html .= '<option value="' . htmlspecialchars($theme) . '">' . htmlspecialchars($theme) . '</option>';
        }
        
        $html .= '
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="volatility-filter">Volatility:</label>
                            <select id="volatility-filter" name="volatility">
                                <option value="">All Volatility</option>';
                                
        foreach ($categories['volatility_levels'] as $volatility) {
            $html .= '<option value="' . htmlspecialchars($volatility) . '">' . htmlspecialchars($volatility) . '</option>';
        }
        
        $html .= '
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="rtp-filter">Min RTP:</label>
                            <select id="rtp-filter" name="min_rtp">
                                <option value="">Any RTP</option>
                                <option value="95">95%+</option>
                                <option value="96">96%+</option>
                                <option value="96.5">96.5%+</option>
                                <option value="97">97%+</option>
                            </select>
                        </div>
                        <button id="apply-filters" class="btn btn-primary">Apply Filters</button>
                        <button id="clear-filters" class="btn btn-secondary">Clear All</button>
                    </div>
                </div>

                <!-- Slots Analytics Panel -->
                <div class="slots-analytics-panel">
                    <div class="analytics-grid">
                        <div class="analytics-card">
                            <h4>Average RTP</h4>
                            <div class="stat-value">' . $rtpAnalysis['average_rtp'] . '%</div>
                            <p>Across all popular slots</p>
                        </div>
                        <div class="analytics-card">
                            <h4>Highest RTP</h4>
                            <div class="stat-value">' . $rtpAnalysis['highest_rtp'] . '%</div>
                            <p>Best player return rate</p>
                        </div>
                        <div class="analytics-card">
                            <h4>High Volatility</h4>
                            <div class="stat-value">' . ($volatilityAnalysis['distribution']['High'] ?? 0) . '</div>
                            <p>Big win potential slots</p>
                        </div>
                        <div class="analytics-card">
                            <h4>Demo Games</h4>
                            <div class="stat-value">' . count($slots) . '</div>
                            <p>Free demos available</p>
                        </div>
                    </div>
                </div>

                <!-- Slots Grid -->
                <div class="slots-grid" id="slots-grid">
                    <div class="grid-header">
                        <h3>Top ' . count($slots) . ' Popular Slots</h3>
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="grid">Grid View</button>
                            <button class="view-btn" data-view="list">List View</button>
                        </div>
                    </div>
                    
                    <div class="slots-container grid-view">';

        foreach ($slots as $slot) {
            $rtpClass = $slot['rtp_percentage'] >= 96.5 ? 'excellent' : ($slot['rtp_percentage'] >= 96 ? 'good' : 'fair');
            $volatilityClass = strtolower($slot['volatility']);
            
            $html .= '
                        <div class="slot-card" data-slot-id="' . $slot['id'] . '">
                            <div class="slot-image">
                                <img src="' . htmlspecialchars($slot['thumbnail_image']) . '" 
                                     alt="' . htmlspecialchars($slot['name']) . ' slot game" 
                                     loading="lazy">
                                <div class="slot-overlay">
                                    <button class="demo-btn" data-slot-id="' . $slot['id'] . '">
                                        <i class="icon-play"></i> Play Demo
                                    </button>
                                    <button class="real-money-btn" data-slot-id="' . $slot['id'] . '">
                                        <i class="icon-coins"></i> Play for Real
                                    </button>
                                </div>
                            </div>
                            
                            <div class="slot-info">
                                <h4 class="slot-name">' . htmlspecialchars($slot['name']) . '</h4>
                                <p class="slot-provider">' . htmlspecialchars($slot['provider']) . '</p>
                                
                                <div class="slot-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">RTP:</span>
                                        <span class="stat-value rtp-' . $rtpClass . '">' . $slot['rtp_percentage'] . '%</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Volatility:</span>
                                        <span class="stat-value volatility-' . $volatilityClass . '">' . $slot['volatility'] . '</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Max Win:</span>
                                        <span class="stat-value">' . number_format($slot['max_win_multiplier']) . 'x</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Paylines:</span>
                                        <span class="stat-value">' . ($slot['paylines_count'] == 0 ? 'All Ways' : number_format($slot['paylines_count'])) . '</span>
                                    </div>
                                </div>
                                
                                <div class="slot-features">
                                    <h5>Key Features:</h5>
                                    <ul>';
                                    
            foreach (array_slice($slot['bonus_features'], 0, 3) as $feature) {
                $html .= '<li>' . htmlspecialchars($feature) . '</li>';
            }
            
            $html .= '
                                    </ul>
                                </div>
                                
                                <div class="slot-theme">
                                    <span class="theme-tag">' . htmlspecialchars($slot['theme_category']) . '</span>
                                </div>
                                
                                <div class="slot-actions">
                                    <button class="btn btn-primary demo-btn" data-slot-id="' . $slot['id'] . '">
                                        Try Free Demo
                                    </button>
                                    <button class="btn btn-secondary analytics-btn" data-slot-id="' . $slot['id'] . '">
                                        View Analytics
                                    </button>
                                </div>
                            </div>
                        </div>';
        }

        $html .= '
                    </div>
                </div>

                <!-- Load More Button -->
                <div class="load-more-section">
                    <button id="load-more-slots" class="btn btn-outline">
                        Load More Slots
                    </button>
                    <p class="slots-count">Showing ' . count($slots) . ' of 500+ popular slots</p>
                </div>

                <!-- Educational Content -->
                <div class="slots-education">
                    <div class="education-grid">
                        <div class="education-card">
                            <h4>Understanding RTP</h4>
                            <p>Return to Player (RTP) represents the percentage of wagered money that a slot will pay back to players over time. Higher RTP means better long-term value for players.</p>
                            <ul>
                                <li><strong>Excellent:</strong> 96.5%+ RTP</li>
                                <li><strong>Good:</strong> 96-96.5% RTP</li>
                                <li><strong>Fair:</strong> Below 96% RTP</li>
                            </ul>
                        </div>
                        <div class="education-card">
                            <h4>Volatility Explained</h4>
                            <p>Volatility indicates how often and how much a slot pays out. Choose based on your playing style and bankroll management strategy.</p>
                            <ul>
                                <li><strong>Low:</strong> Frequent small wins</li>
                                <li><strong>Medium:</strong> Balanced payouts</li>
                                <li><strong>High:</strong> Rare but big wins</li>
                            </ul>
                        </div>
                        <div class="education-card">
                            <h4>Responsible Gaming</h4>
                            <p>Always gamble responsibly. Set limits, never chase losses, and remember that slots are entertainment. Use demo modes to learn games before playing with real money.</p>
                            <a href="/responsible-gambling" class="btn btn-link">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Demo Game Modal -->
        <div id="demo-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Free Demo Game</h3>
                    <button class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <iframe id="demo-frame" src="" frameborder="0"></iframe>
                </div>
            </div>
        </div>

        <!-- Analytics Modal -->
        <div id="analytics-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Slot Analytics</h3>
                    <button class="modal-close">&times;</button>
                </div>
                <div class="modal-body" id="analytics-content">
                    <!-- Analytics content loaded dynamically -->
                </div>
            </div>
        </div>';

        return $html;
    }
}
