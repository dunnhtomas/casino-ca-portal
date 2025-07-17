<?php

namespace App\Controllers;

use App\Services\PopularSlotsService;
use Exception;

/**
 * Popular Slots Controller
 * 
 * Handles popular slots display, filtering, and individual slot pages
 * Provides routing for slot-related pages and API endpoints
 */
class PopularSlotsController
{
    private $popularSlotsService;

    public function __construct()
    {
        $this->popularSlotsService = new PopularSlotsService();
    }

    /**
     * Display popular slots section (for homepage integration)
     */
    public function getPopularSlotsSection()
    {
        header('Content-Type: application/json');
        
        try {
            $slotsData = $this->popularSlotsService->getPopularSlotsSection();
            echo json_encode([
                'success' => true,
                'data' => $slotsData
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to load popular slots data'
            ]);
        }
    }

    /**
     * Display all popular slots with filtering
     */
    public function index()
    {
        $filters = [];
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 24;
        
        // Parse filters from query parameters
        if (isset($_GET['provider'])) $filters['provider'] = $_GET['provider'];
        if (isset($_GET['volatility'])) $filters['volatility'] = $_GET['volatility'];
        if (isset($_GET['rtp_min'])) $filters['rtp_min'] = (float)$_GET['rtp_min'];
        if (isset($_GET['rtp_max'])) $filters['rtp_max'] = (float)$_GET['rtp_max'];
        if (isset($_GET['category'])) $filters['category'] = (int)$_GET['category'];

        if (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            header('Content-Type: application/json');
            
            try {
                $slots = $this->popularSlotsService->getPopularSlots($filters, $limit);
                $filterOptions = $this->popularSlotsService->getFilterOptions();
                
                echo json_encode([
                    'success' => true,
                    'data' => [
                        'slots' => $slots,
                        'filters' => $filterOptions,
                        'total_count' => count($slots)
                    ]
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Failed to load slots'
                ]);
            }
        } else {
            // Return HTML page
            $this->renderSlotsPage($filters, $limit);
        }
    }

    /**
     * Display individual slot details
     */
    public function show($slotSlug)
    {
        $slot = $this->popularSlotsService->getSlot($slotSlug);

        if (!$slot) {
            if (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'error' => 'Slot not found'
                ]);
                return;
            } else {
                // Redirect to slots page for HTML requests
                header('Location: /slots');
                return;
            }
        }

        // Get related slots from same provider
        $relatedSlots = $this->popularSlotsService->getSlotsByProvider($slot['provider_id'], 4);

        if (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => [
                    'slot' => $slot,
                    'related_slots' => $relatedSlots
                ]
            ]);
        } else {
            // Return HTML page
            $this->renderSlotDetail($slot, $relatedSlots);
        }
    }

    /**
     * Search slots API
     */
    public function search()
    {
        header('Content-Type: application/json');
        
        $query = isset($_GET['q']) ? $_GET['q'] : '';
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
        
        if (empty($query)) {
            echo json_encode([
                'success' => false,
                'error' => 'Search query required'
            ]);
            return;
        }

        try {
            $results = $this->popularSlotsService->searchSlots($query, $limit);
            echo json_encode([
                'success' => true,
                'data' => [
                    'slots' => $results,
                    'query' => $query,
                    'total_count' => count($results)
                ]
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Search failed'
            ]);
        }
    }

    /**
     * Get slots by provider
     */
    public function getSlotsByProvider($providerId)
    {
        header('Content-Type: application/json');
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        
        try {
            $slots = $this->popularSlotsService->getSlotsByProvider($providerId, $limit);
            echo json_encode([
                'success' => true,
                'data' => [
                    'slots' => $slots,
                    'provider_id' => $providerId,
                    'total_count' => count($slots)
                ]
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to load provider slots'
            ]);
        }
    }

    /**
     * Render slots listing page
     */
    private function renderSlotsPage($filters, $limit)
    {
        $slots = $this->popularSlotsService->getPopularSlots($filters, $limit);
        $filterOptions = $this->popularSlotsService->getFilterOptions();
        $stats = $this->popularSlotsService->getSlotsStats();
        
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Popular Casino Slots - Best Casino Portal</title>
            <meta name="description" content="Discover the most popular casino slots with detailed reviews, RTP rates, and where to play. Find your perfect slot game from top providers.">
            <style>
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    line-height: 1.6;
                    margin: 0;
                    padding: 0;
                    background-color: #f8f9fa;
                }
                
                .container {
                    max-width: 1400px;
                    margin: 0 auto;
                    padding: 2rem;
                }
                
                .page-header {
                    text-align: center;
                    margin-bottom: 3rem;
                    background: white;
                    padding: 3rem;
                    border-radius: 15px;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                }
                
                .page-header h1 {
                    color: #2c3e50;
                    font-size: 2.5rem;
                    margin-bottom: 1rem;
                }
                
                .page-header p {
                    color: #666;
                    font-size: 1.1rem;
                }
                
                .stats-bar {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 1rem;
                    margin-bottom: 3rem;
                }
                
                .stat-item {
                    background: white;
                    padding: 1.5rem;
                    border-radius: 12px;
                    text-align: center;
                    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
                }
                
                .stat-number {
                    font-size: 2rem;
                    font-weight: bold;
                    color: #27ae60;
                    display: block;
                }
                
                .stat-label {
                    color: #7f8c8d;
                    font-size: 0.9rem;
                }
                
                .slots-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                    gap: 2rem;
                    margin: 2rem 0;
                }
                
                .slot-card {
                    background: white;
                    border-radius: 15px;
                    overflow: hidden;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    transition: transform 0.3s ease;
                }
                
                .slot-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
                }
                
                .slot-image {
                    width: 100%;
                    height: 180px;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 1.2rem;
                    font-weight: bold;
                }
                
                .slot-content {
                    padding: 1.5rem;
                }
                
                .slot-name {
                    font-size: 1.2rem;
                    font-weight: bold;
                    color: #2c3e50;
                    margin-bottom: 0.5rem;
                }
                
                .slot-provider {
                    color: #3498db;
                    font-size: 0.9rem;
                    margin-bottom: 1rem;
                }
                
                .slot-stats {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 1rem;
                    margin-bottom: 1rem;
                }
                
                .stat {
                    text-align: center;
                }
                
                .stat-value {
                    font-weight: bold;
                    color: #27ae60;
                    display: block;
                }
                
                .stat-name {
                    font-size: 0.8rem;
                    color: #7f8c8d;
                }
                
                .slot-features {
                    margin-bottom: 1rem;
                }
                
                .feature-tag {
                    display: inline-block;
                    background: #e8f5e8;
                    color: #27ae60;
                    padding: 0.2rem 0.6rem;
                    border-radius: 12px;
                    font-size: 0.8rem;
                    margin: 0.2rem;
                }
                
                .slot-actions {
                    display: flex;
                    gap: 0.5rem;
                }
                
                .btn {
                    padding: 0.8rem 1.2rem;
                    border: none;
                    border-radius: 6px;
                    cursor: pointer;
                    text-decoration: none;
                    text-align: center;
                    transition: background 0.3s ease;
                    flex: 1;
                }
                
                .btn-primary {
                    background: #3498db;
                    color: white;
                }
                
                .btn-primary:hover {
                    background: #2980b9;
                }
                
                .btn-secondary {
                    background: #95a5a6;
                    color: white;
                }
                
                .btn-secondary:hover {
                    background: #7f8c8d;
                }
                
                .back-link {
                    display: inline-block;
                    background: #3498db;
                    color: white;
                    padding: 0.8rem 1.5rem;
                    text-decoration: none;
                    border-radius: 6px;
                    margin-bottom: 2rem;
                    transition: background 0.3s ease;
                }
                
                .back-link:hover {
                    background: #2980b9;
                }
                
                @media (max-width: 768px) {
                    .page-header h1 {
                        font-size: 2rem;
                    }
                    
                    .stats-bar {
                        grid-template-columns: repeat(2, 1fr);
                    }
                    
                    .slots-grid {
                        grid-template-columns: 1fr;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <a href="/" class="back-link">← Back to Homepage</a>
                
                <div class="page-header">
                    <h1>Popular Casino Slots</h1>
                    <p>Discover the most exciting slot games from top providers with detailed information and where to play</p>
                </div>
                
                <div class="stats-bar">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $stats['total_slots']; ?></span>
                        <span class="stat-label">Available Slots</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $stats['avg_rtp']; ?>%</span>
                        <span class="stat-label">Average RTP</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo number_format((int)$stats['max_win_available']); ?>x</span>
                        <span class="stat-label">Max Win Available</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $stats['provider_count']; ?></span>
                        <span class="stat-label">Top Providers</span>
                    </div>
                </div>
                
                <div class="slots-grid">
                    <?php foreach ($slots as $slot): ?>
                        <div class="slot-card">
                            <div class="slot-image">
                                <?php echo htmlspecialchars($slot['name']); ?>
                            </div>
                            
                            <div class="slot-content">
                                <div class="slot-name"><?php echo htmlspecialchars($slot['name']); ?></div>
                                <div class="slot-provider"><?php echo htmlspecialchars($slot['provider']['name']); ?></div>
                                
                                <div class="slot-stats">
                                    <div class="stat">
                                        <span class="stat-value"><?php echo $slot['rtp_formatted']; ?></span>
                                        <span class="stat-name">RTP</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-value"><?php echo $slot['max_win_formatted']; ?></span>
                                        <span class="stat-name">Max Win</span>
                                    </div>
                                </div>
                                
                                <div class="slot-features">
                                    <?php foreach (array_slice($slot['features'], 0, 3) as $feature): ?>
                                        <span class="feature-tag"><?php echo htmlspecialchars($feature); ?></span>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="slot-actions">
                                    <a href="/slots/<?php echo $slot['slug']; ?>" class="btn btn-primary">View Details</a>
                                    <a href="/casinos" class="btn btn-secondary">Play Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </body>
        </html>
        <?php
    }

    /**
     * Render individual slot detail page
     */
    private function renderSlotDetail($slot, $relatedSlots)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($slot['name']); ?> Slot Review - Best Casino Portal</title>
            <meta name="description" content="Complete review of <?php echo htmlspecialchars($slot['name']); ?> slot by <?php echo htmlspecialchars($slot['provider']['name']); ?>. RTP: <?php echo $slot['rtp']; ?>%, Max Win: <?php echo $slot['max_win_formatted']; ?>.">
            <style>
                /* Include same styles as above for consistency */
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    line-height: 1.6;
                    margin: 0;
                    padding: 0;
                    background-color: #f8f9fa;
                }
                
                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 2rem;
                }
                
                .slot-header {
                    background: white;
                    border-radius: 15px;
                    padding: 3rem;
                    margin-bottom: 2rem;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    text-align: center;
                }
                
                .slot-title {
                    font-size: 2.5rem;
                    color: #2c3e50;
                    margin-bottom: 1rem;
                }
                
                .slot-subtitle {
                    color: #3498db;
                    font-size: 1.2rem;
                    margin-bottom: 2rem;
                }
                
                .slot-rating {
                    font-size: 1.5rem;
                    color: #f39c12;
                    margin-bottom: 1rem;
                }
                
                .slot-details {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 2rem;
                    margin: 2rem 0;
                }
                
                .detail-section {
                    background: white;
                    padding: 2rem;
                    border-radius: 12px;
                    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
                }
                
                .detail-title {
                    color: #2c3e50;
                    font-size: 1.2rem;
                    margin-bottom: 1rem;
                }
                
                .back-link {
                    display: inline-block;
                    background: #3498db;
                    color: white;
                    padding: 0.8rem 1.5rem;
                    text-decoration: none;
                    border-radius: 6px;
                    margin-bottom: 2rem;
                    transition: background 0.3s ease;
                }
                
                .back-link:hover {
                    background: #2980b9;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <a href="/slots" class="back-link">← Back to Slots</a>
                
                <div class="slot-header">
                    <h1 class="slot-title"><?php echo htmlspecialchars($slot['name']); ?></h1>
                    <p class="slot-subtitle">by <?php echo htmlspecialchars($slot['provider']['name']); ?></p>
                    <div class="slot-rating">★★★★★ <?php echo $slot['rating']; ?>/5.0</div>
                    <p><?php echo htmlspecialchars($slot['description']); ?></p>
                </div>
                
                <div class="slot-details">
                    <div class="detail-section">
                        <h3 class="detail-title">Game Specifications</h3>
                        <p><strong>Reels:</strong> <?php echo $slot['reels']; ?></p>
                        <p><strong>Paylines:</strong> <?php echo $slot['paylines']; ?></p>
                        <p><strong>RTP:</strong> <?php echo $slot['rtp']; ?>%</p>
                        <p><strong>Volatility:</strong> <?php echo ucfirst($slot['volatility']); ?></p>
                        <p><strong>Max Win:</strong> <?php echo $slot['max_win_formatted']; ?></p>
                    </div>
                    
                    <div class="detail-section">
                        <h3 class="detail-title">Betting Options</h3>
                        <p><strong>Min Bet:</strong> $<?php echo $slot['min_bet']; ?></p>
                        <p><strong>Max Bet:</strong> $<?php echo $slot['max_bet']; ?></p>
                        <p><strong>Theme:</strong> <?php echo htmlspecialchars($slot['theme']); ?></p>
                        <p><strong>Mobile:</strong> <?php echo $slot['mobile_optimized'] ? 'Yes' : 'No'; ?></p>
                        <p><strong>Released:</strong> <?php echo date('M Y', strtotime($slot['release_date'])); ?></p>
                    </div>
                    
                    <div class="detail-section">
                        <h3 class="detail-title">Special Features</h3>
                        <?php foreach ($slot['features'] as $feature): ?>
                            <p>• <?php echo htmlspecialchars($feature); ?></p>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="detail-section">
                        <h3 class="detail-title">Provider Info</h3>
                        <p><strong>Developer:</strong> <?php echo htmlspecialchars($slot['provider']['name']); ?></p>
                        <p><strong>Founded:</strong> <?php echo $slot['provider']['founded']; ?></p>
                        <p><?php echo htmlspecialchars($slot['provider']['description']); ?></p>
                    </div>
                </div>
                
                <?php if (!empty($relatedSlots)): ?>
                <div class="related-slots">
                    <h2>More from <?php echo htmlspecialchars($slot['provider']['name']); ?></h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                        <?php foreach ($relatedSlots as $related): ?>
                            <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                <h4><?php echo htmlspecialchars($related['name']); ?></h4>
                                <p>RTP: <?php echo $related['rtp']; ?>% | Max Win: <?php echo $related['max_win_formatted']; ?></p>
                                <a href="/slots/<?php echo $related['slug']; ?>" style="color: #3498db;">View Details</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </body>
        </html>
        <?php
    }
}
