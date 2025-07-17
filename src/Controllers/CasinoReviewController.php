<?php

namespace App\Controllers;

use App\Services\DetailedCasinoReviewsService;
use Exception;

/**
 * Casino Review Controller
 * 
 * Handles detailed casino review display and individual casino pages
 * Provides routing for top 3 casino reviews and comparison features
 */
class CasinoReviewController
{
    private $reviewsService;

    public function __construct()
    {
        $this->reviewsService = new DetailedCasinoReviewsService();
    }

    /**
     * Display top 3 detailed casino reviews section
     */
    public function getTop3ReviewsSection()
    {
        try {
            $reviews = $this->reviewsService->getTop3DetailedReviews();
            
            ob_start();
            echo $this->renderTop3ReviewsSection($reviews);
            return ob_get_clean();
            
        } catch (Exception $e) {
            error_log("Error in getTop3ReviewsSection: " . $e->getMessage());
            return '<div class="error">Unable to load casino reviews</div>';
        }
    }

    /**
     * Display individual casino review page
     */
    public function showCasinoReview($casinoSlug)
    {
        try {
            $review = $this->reviewsService->getCasinoDetailedReview($casinoSlug);
            
            if (!$review) {
                $this->show404();
                return;
            }
            
            echo $this->renderFullCasinoReview($review);
            
        } catch (Exception $e) {
            error_log("Error in showCasinoReview: " . $e->getMessage());
            $this->show500();
        }
    }

    /**
     * API endpoint for casino reviews data
     */
    public function getReviewsData()
    {
        header('Content-Type: application/json');
        
        try {
            $reviews = $this->reviewsService->getTop3DetailedReviews();
            echo json_encode([
                'success' => true,
                'data' => $reviews,
                'total' => count($reviews)
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Unable to fetch reviews data'
            ]);
        }
    }

    /**
     * Render top 3 casino reviews section for homepage
     */
    private function renderTop3ReviewsSection($reviews)
    {
        $html = '
        <section class="detailed-reviews-section">
            <div class="container">
                <div class="section-header">
                    <h2>Expert Reviews: Top 3 Canadian Casinos</h2>
                    <p>Comprehensive analysis from our casino experts with detailed ratings and honest assessments</p>
                </div>
                
                <div class="reviews-grid">';
        
        foreach ($reviews as $review) {
            $html .= $this->renderReviewCard($review);
        }
        
        $html .= '
                </div>
                
                <div class="reviews-methodology">
                    <h3>Our Review Process</h3>
                    <div class="methodology-grid">
                        <div class="method-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Security & Fairness (20%)</span>
                        </div>
                        <div class="method-item">
                            <i class="fas fa-gamepad"></i>
                            <span>Games & Software (15%)</span>
                        </div>
                        <div class="method-item">
                            <i class="fas fa-gift"></i>
                            <span>Bonuses & Promotions (15%)</span>
                        </div>
                        <div class="method-item">
                            <i class="fas fa-mobile-alt"></i>
                            <span>Mobile Experience (10%)</span>
                        </div>
                        <div class="method-item">
                            <i class="fas fa-credit-card"></i>
                            <span>Banking & Payments (15%)</span>
                        </div>
                        <div class="method-item">
                            <i class="fas fa-headset"></i>
                            <span>Customer Support (15%)</span>
                        </div>
                        <div class="method-item">
                            <i class="fas fa-user-check"></i>
                            <span>User Experience (10%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
        
        return $html;
    }

    /**
     * Render individual review card
     */
    private function renderReviewCard($review)
    {
        $prosHtml = '';
        foreach (array_slice($review['pros'], 0, 4) as $pro) {
            $prosHtml .= '<li><i class="fas fa-check"></i>' . htmlspecialchars($pro) . '</li>';
        }
        
        $consHtml = '';
        foreach (array_slice($review['cons'], 0, 3) as $con) {
            $consHtml .= '<li><i class="fas fa-times"></i>' . htmlspecialchars($con) . '</li>';
        }
        
        $specialtiesHtml = '';
        foreach ($review['specialties'] as $specialty) {
            $specialtiesHtml .= '<span class="specialty-tag">' . htmlspecialchars($specialty) . '</span>';
        }
        
        return '
        <div class="review-card">
            <div class="card-header">
                <div class="casino-logo">
                    <img src="' . htmlspecialchars($review['logo']) . '" alt="' . htmlspecialchars($review['name']) . ' Logo" loading="lazy">
                </div>
                <div class="casino-basic-info">
                    <h3>' . htmlspecialchars($review['name']) . '</h3>
                    <div class="established">Est. ' . htmlspecialchars($review['established']) . '</div>
                    <div class="overall-rating">
                        <div class="stars">' . $this->renderStars($review['expert_rating']) . '</div>
                        <span class="rating-score">' . number_format($review['expert_rating'], 1) . '/5</span>
                    </div>
                </div>
            </div>
            
            <div class="card-stats">
                <div class="stat-item">
                    <span class="stat-label">RTP</span>
                    <span class="stat-value">' . htmlspecialchars($review['rtp']) . '</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Games</span>
                    <span class="stat-value">' . htmlspecialchars($review['game_count']) . '</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Payout</span>
                    <span class="stat-value">' . htmlspecialchars($review['payout_speed']) . '</span>
                </div>
            </div>
            
            <div class="card-bonus">
                <div class="bonus-amount">' . htmlspecialchars($review['bonus']['welcome_package']) . '</div>
                <div class="bonus-details">Welcome Package + ' . htmlspecialchars($review['bonus']['free_spins']) . '</div>
            </div>
            
            <div class="card-specialties">
                ' . $specialtiesHtml . '
            </div>
            
            <div class="pros-cons">
                <div class="pros">
                    <h4>Pros</h4>
                    <ul>' . $prosHtml . '</ul>
                </div>
                <div class="cons">
                    <h4>Cons</h4>
                    <ul>' . $consHtml . '</ul>
                </div>
            </div>
            
            <div class="mobile-app-info">
                <h4>Mobile Experience</h4>';
        
        if (isset($review['mobile_app']['play_store_rating'])) {
            $html .= '
                <div class="app-ratings">
                    <span><i class="fab fa-google-play"></i> ' . htmlspecialchars($review['mobile_app']['play_store_rating']) . '</span>
                    <span><i class="fab fa-apple"></i> ' . htmlspecialchars($review['mobile_app']['app_store_rating']) . '</span>
                    <span><i class="fas fa-download"></i> ' . htmlspecialchars($review['mobile_app']['size']) . '</span>
                </div>';
        } else {
            $html .= '
                <div class="app-info">
                    <span><i class="fas fa-mobile-alt"></i> ' . htmlspecialchars($review['mobile_app']['type']) . '</span>
                </div>';
        }
        
        $html .= '
            </div>
            
            <div class="detailed-ratings">
                <h4>Expert Ratings</h4>
                <div class="rating-bars">';
        
        foreach ($review['category_ratings'] as $category => $rating) {
            $categoryInfo = $this->reviewsService->getRatingCategories()[$category] ?? ['name' => ucfirst($category)];
            $percentage = ($rating / 5) * 100;
            
            $html .= '
                    <div class="rating-bar">
                        <span class="category-name">' . htmlspecialchars($categoryInfo['name']) . '</span>
                        <div class="bar-container">
                            <div class="bar-fill" style="width: ' . $percentage . '%"></div>
                        </div>
                        <span class="rating-value">' . number_format($rating, 1) . '</span>
                    </div>';
        }
        
        $html .= '
                </div>
            </div>
            
            <div class="card-actions">
                <a href="#" class="btn btn-primary get-bonus-btn" data-casino="' . htmlspecialchars($review['id']) . '">
                    <i class="fas fa-gift"></i> Get Bonus
                </a>
                <a href="/casino/' . htmlspecialchars($review['id']) . '" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i> Full Review
                </a>
            </div>
        </div>';
        
        return $html;
    }

    /**
     * Render full casino review page
     */
    private function renderFullCasinoReview($review)
    {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($review['name']) . ' Review 2025 | Best Casino Portal</title>
    <meta name="description" content="Comprehensive ' . htmlspecialchars($review['name']) . ' review with expert analysis, ratings, bonuses, and game selection. Updated ' . date('F Y') . '.">
    <link rel="stylesheet" href="/css/detailed-reviews.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="review-page">
        <div class="review-hero">
            <div class="container">
                <div class="hero-content">
                    <div class="casino-branding">
                        <img src="' . htmlspecialchars($review['logo']) . '" alt="' . htmlspecialchars($review['name']) . ' Logo" class="casino-logo">
                        <div class="casino-info">
                            <h1>' . htmlspecialchars($review['name']) . ' Review</h1>
                            <div class="casino-meta">
                                <span>Est. ' . htmlspecialchars($review['established']) . '</span>
                                <span>•</span>
                                <span>' . htmlspecialchars($review['experience_years']) . '+ years experience</span>
                                <span>•</span>
                                <span>Updated ' . date('M Y') . '</span>
                            </div>
                            <div class="overall-rating">
                                <div class="stars">' . $this->renderStars($review['expert_rating']) . '</div>
                                <span class="rating-score">' . number_format($review['expert_rating'], 1) . '/5 Expert Rating</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hero-stats">
                        <div class="stat">
                            <span class="stat-value">' . htmlspecialchars($review['rtp']) . '</span>
                            <span class="stat-label">Average RTP</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">' . htmlspecialchars($review['game_count']) . '</span>
                            <span class="stat-label">Games Available</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">' . htmlspecialchars($review['payout_speed']) . '</span>
                            <span class="stat-label">Payout Speed</span>
                        </div>
                    </div>
                    
                    <div class="hero-cta">
                        <a href="#" class="btn btn-primary btn-large get-bonus-btn" data-casino="' . htmlspecialchars($review['id']) . '">
                            <i class="fas fa-gift"></i>
                            Get ' . htmlspecialchars($review['bonus']['welcome_package']) . ' Bonus
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="review-content">
            <div class="container">
                <div class="content-grid">
                    <main class="review-main">
                        <!-- Review content will be rendered here -->
                        ' . $this->renderFullReviewContent($review) . '
                    </main>
                    
                    <aside class="review-sidebar">
                        ' . $this->renderReviewSidebar($review) . '
                    </aside>
                </div>
            </div>
        </div>
    </div>
    
    <script src="/js/detailed-reviews.js"></script>
</body>
</html>';
    }

    /**
     * Render stars for rating display
     */
    private function renderStars($rating)
    {
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        
        $html = '';
        
        for ($i = 0; $i < $fullStars; $i++) {
            $html .= '<i class="fas fa-star"></i>';
        }
        
        if ($halfStar) {
            $html .= '<i class="fas fa-star-half-alt"></i>';
        }
        
        for ($i = 0; $i < $emptyStars; $i++) {
            $html .= '<i class="far fa-star"></i>';
        }
        
        return $html;
    }

    /**
     * Render full review content sections
     */
    private function renderFullReviewContent($review)
    {
        // This would contain the full detailed review content
        // For brevity, returning a simplified version
        return '
        <article class="review-article">
            <section class="review-summary">
                <h2>Expert Summary</h2>
                <p>' . htmlspecialchars($review['detailed_review']) . '</p>
            </section>
            
            <section class="pros-cons-detailed">
                <div class="pros-cons-grid">
                    <div class="pros-section">
                        <h3><i class="fas fa-thumbs-up"></i> Pros</h3>
                        <ul>';
        
        foreach ($review['pros'] as $pro) {
            $html .= '<li>' . htmlspecialchars($pro) . '</li>';
        }
        
        $html .= '
                        </ul>
                    </div>
                    <div class="cons-section">
                        <h3><i class="fas fa-thumbs-down"></i> Cons</h3>
                        <ul>';
        
        foreach ($review['cons'] as $con) {
            $html .= '<li>' . htmlspecialchars($con) . '</li>';
        }
        
        $html .= '
                        </ul>
                    </div>
                </div>
            </section>
            
            <!-- Additional review sections would go here -->
        </article>';
    }

    /**
     * Render review sidebar
     */
    private function renderReviewSidebar($review)
    {
        return '
        <div class="sidebar-content">
            <div class="quick-facts">
                <h3>Quick Facts</h3>
                <ul>
                    <li><strong>Established:</strong> ' . htmlspecialchars($review['established']) . '</li>
                    <li><strong>License:</strong> ' . implode(', ', array_slice($review['licenses'], 0, 2)) . '</li>
                    <li><strong>Games:</strong> ' . htmlspecialchars($review['game_count']) . '</li>
                    <li><strong>RTP:</strong> ' . htmlspecialchars($review['rtp']) . '</li>
                </ul>
            </div>
            
            <div class="bonus-info">
                <h3>Welcome Bonus</h3>
                <div class="bonus-details">
                    <div class="bonus-amount">' . htmlspecialchars($review['bonus']['welcome_package']) . '</div>
                    <div class="bonus-spins">' . htmlspecialchars($review['bonus']['free_spins']) . '</div>
                    <div class="wagering">Wagering: ' . htmlspecialchars($review['bonus']['wagering_requirement']) . '</div>
                </div>
            </div>
        </div>';
    }

    /**
     * Show 404 error page
     */
    private function show404()
    {
        http_response_code(404);
        echo '<!DOCTYPE html>
<html>
<head><title>404 - Casino Not Found</title></head>
<body><h1>Casino review not found</h1></body>
</html>';
    }

    /**
     * Show 500 error page
     */
    private function show500()
    {
        http_response_code(500);
        echo '<!DOCTYPE html>
<html>
<head><title>500 - Server Error</title></head>
<body><h1>Server error occurred</h1></body>
</html>';
    }
}
