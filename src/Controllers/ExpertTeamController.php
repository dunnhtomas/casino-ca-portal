<?php

namespace App\Controllers;

use App\Services\ExpertTeamService;

/**
 * Expert Team Controller
 * 
 * Handles expert team display, individual profiles, and recommendations
 * Provides routing for expert-related pages and API endpoints
 */
class ExpertTeamController
{
    private $expertTeamService;

    public function __construct()
    {
        $this->expertTeamService = new ExpertTeamService();
    }

    /**
     * Display expert team section (for homepage integration)
     */
    public function getExpertTeamSection()
    {
        header('Content-Type: application/json');
        
        try {
            $expertTeamData = $this->expertTeamService->getExpertTeamSection();
            echo json_encode([
                'success' => true,
                'data' => $expertTeamData
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to load expert team data'
            ]);
        }
    }

    /**
     * Display all experts
     */
    public function index()
    {
        header('Content-Type: application/json');
        
        try {
            $experts = $this->expertTeamService->getAllExperts();
            echo json_encode([
                'success' => true,
                'data' => [
                    'experts' => $experts,
                    'total_count' => count($experts)
                ]
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to load experts'
            ]);
        }
    }

    /**
     * Display individual expert profile
     */
    public function show($expertSlug)
    {
        // Find expert by slug
        $expert = null;
        $experts = $this->expertTeamService->getAllExperts();
        
        foreach ($experts as $e) {
            if ($e['slug'] === $expertSlug) {
                $expert = $e;
                break;
            }
        }

        if (!$expert) {
            if (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'error' => 'Expert not found'
                ]);
                return;
            } else {
                // Redirect to experts page for HTML requests
                header('Location: /experts');
                return;
            }
        }

        // Get expert recommendations
        $recommendations = $this->expertTeamService->getExpertRecommendations($expert['id']);

        if (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => [
                    'expert' => $expert,
                    'recommendations' => $recommendations
                ]
            ]);
        } else {
            // Return HTML page
            $this->renderExpertProfile($expert, $recommendations);
        }
    }

    /**
     * Get expert recommendations API
     */
    public function getExpertRecommendations($expertId = null)
    {
        header('Content-Type: application/json');
        
        try {
            if ($expertId) {
                $recommendations = $this->expertTeamService->getExpertRecommendations($expertId);
                $expert = $this->expertTeamService->getExpert($expertId);
                
                echo json_encode([
                    'success' => true,
                    'data' => [
                        'expert' => $expert,
                        'recommendations' => $recommendations
                    ]
                ]);
            } else {
                $allRecommendations = $this->expertTeamService->getAllExpertRecommendations();
                
                echo json_encode([
                    'success' => true,
                    'data' => [
                        'recommendations' => $allRecommendations,
                        'total_count' => count($allRecommendations)
                    ]
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Failed to load expert recommendations'
            ]);
        }
    }

    /**
     * Render expert profile HTML page
     */
    private function renderExpertProfile($expert, $recommendations)
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($expert['name']); ?> - Casino Expert | Best Casino Portal</title>
            <meta name="description" content="Meet <?php echo htmlspecialchars($expert['name']); ?>, <?php echo htmlspecialchars($expert['title']); ?> with <?php echo $expert['experience_years']; ?>+ years of casino industry experience. Read expert casino reviews and recommendations.">
            <style>
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
                
                .expert-header {
                    background: white;
                    border-radius: 15px;
                    padding: 2rem;
                    margin-bottom: 2rem;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                }
                
                .expert-profile {
                    display: grid;
                    grid-template-columns: 200px 1fr;
                    gap: 2rem;
                    align-items: start;
                }
                
                .expert-photo {
                    width: 200px;
                    height: 200px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 4px solid #3498db;
                }
                
                .expert-photo-placeholder {
                    width: 200px;
                    height: 200px;
                    border-radius: 50%;
                    background: linear-gradient(135deg, #3498db, #2980b9);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 3rem;
                    font-weight: bold;
                }
                
                .expert-info h1 {
                    color: #2c3e50;
                    margin-bottom: 0.5rem;
                }
                
                .expert-title {
                    color: #3498db;
                    font-size: 1.2rem;
                    font-weight: 600;
                    margin-bottom: 1rem;
                }
                
                .expert-stats {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                    gap: 1rem;
                    margin: 1rem 0;
                }
                
                .stat-item {
                    text-align: center;
                    padding: 1rem;
                    background: #f8f9fa;
                    border-radius: 8px;
                }
                
                .stat-number {
                    font-size: 1.5rem;
                    font-weight: bold;
                    color: #27ae60;
                }
                
                .stat-label {
                    color: #7f8c8d;
                    font-size: 0.9rem;
                }
                
                .expert-bio {
                    background: white;
                    border-radius: 15px;
                    padding: 2rem;
                    margin-bottom: 2rem;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                }
                
                .specializations {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.5rem;
                    margin: 1rem 0;
                }
                
                .specialization-tag {
                    background: #3498db;
                    color: white;
                    padding: 0.3rem 0.8rem;
                    border-radius: 20px;
                    font-size: 0.9rem;
                }
                
                .recommendations-section {
                    background: white;
                    border-radius: 15px;
                    padding: 2rem;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                }
                
                .recommendation-card {
                    border: 1px solid #e5e5e5;
                    border-radius: 12px;
                    padding: 1.5rem;
                    margin-bottom: 1rem;
                    transition: transform 0.3s ease;
                }
                
                .recommendation-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
                }
                
                .casino-name {
                    font-size: 1.3rem;
                    font-weight: bold;
                    color: #2c3e50;
                    margin-bottom: 0.5rem;
                }
                
                .rating {
                    color: #f39c12;
                    font-size: 1.1rem;
                    margin-bottom: 0.5rem;
                }
                
                .reason {
                    color: #555;
                    margin-bottom: 0.5rem;
                }
                
                .highlight {
                    background: #e8f5e8;
                    color: #27ae60;
                    padding: 0.5rem;
                    border-radius: 6px;
                    font-style: italic;
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
                    .expert-profile {
                        grid-template-columns: 1fr;
                        text-align: center;
                    }
                    
                    .expert-photo, .expert-photo-placeholder {
                        margin: 0 auto;
                    }
                    
                    .expert-stats {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <a href="/" class="back-link">← Back to Homepage</a>
                
                <div class="expert-header">
                    <div class="expert-profile">
                        <div>
                            <?php if (file_exists('.' . $expert['photo'])): ?>
                                <img src="<?php echo htmlspecialchars($expert['photo']); ?>" alt="<?php echo htmlspecialchars($expert['name']); ?>" class="expert-photo">
                            <?php else: ?>
                                <div class="expert-photo-placeholder">
                                    <?php echo strtoupper(substr($expert['name'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="expert-info">
                            <h1><?php echo htmlspecialchars($expert['name']); ?></h1>
                            <div class="expert-title"><?php echo htmlspecialchars($expert['title']); ?></div>
                            <p><?php echo htmlspecialchars($expert['bio_short']); ?></p>
                            
                            <div class="expert-stats">
                                <div class="stat-item">
                                    <div class="stat-number"><?php echo $expert['experience_years']; ?>+</div>
                                    <div class="stat-label">Years Experience</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number"><?php echo $expert['articles_count']; ?></div>
                                    <div class="stat-label">Articles Written</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number"><?php echo $expert['reviews_count']; ?></div>
                                    <div class="stat-label">Casino Reviews</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number"><?php echo count($recommendations); ?></div>
                                    <div class="stat-label">Top Recommendations</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="expert-bio">
                    <h2>About <?php echo htmlspecialchars($expert['name']); ?></h2>
                    <p><?php echo htmlspecialchars($expert['bio_long']); ?></p>
                    
                    <h3>Specializations</h3>
                    <div class="specializations">
                        <?php foreach ($expert['specializations'] as $spec): ?>
                            <span class="specialization-tag"><?php echo htmlspecialchars($spec); ?></span>
                        <?php endforeach; ?>
                    </div>
                    
                    <h3>Professional Credentials</h3>
                    <ul>
                        <?php foreach ($expert['credentials'] as $credential): ?>
                            <li><?php echo htmlspecialchars($credential); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="recommendations-section">
                    <h2><?php echo htmlspecialchars($expert['name']); ?>'s Top Casino Recommendations</h2>
                    <p>Based on <?php echo $expert['experience_years']; ?>+ years of professional casino analysis and evaluation.</p>
                    
                    <?php foreach ($recommendations as $rec): ?>
                        <div class="recommendation-card">
                            <div class="casino-name"><?php echo htmlspecialchars($rec['casino_name']); ?></div>
                            <div class="rating">★★★★★ <?php echo $rec['rating']; ?>/5.0</div>
                            <div class="reason"><?php echo htmlspecialchars($rec['reason']); ?></div>
                            <div class="highlight"><?php echo htmlspecialchars($rec['highlight']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
