<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\EnhancedDetailedReviewsService;

/**
 * Enhanced Detailed Reviews Controller
 * 
 * Handles requests for enhanced casino reviews with comprehensive data,
 * expert analysis, mobile app integration, and detailed comparisons.
 * 
 * @package App\Controllers
 * @author Best Casino Portal Team
 * @version 1.0.0
 */
class EnhancedDetailedReviewsController extends Controller
{
    private EnhancedDetailedReviewsService $reviewsService;

    public function __construct()
    {
        $this->reviewsService = new EnhancedDetailedReviewsService();
    }

    /**
     * Display the main enhanced reviews page
     */
    public function index(): void
    {
        $reviews = $this->reviewsService->getEnhancedTop3Reviews();
        $statistics = $this->reviewsService->getSectionStatistics();
        $comparisonMatrix = $this->reviewsService->getComparisonMatrix();
        
        $this->render('enhanced-detailed-reviews/index', [
            'reviews' => $reviews,
            'statistics' => $statistics,
            'comparison_matrix' => $comparisonMatrix
        ]);
    }

    /**
     * API endpoint for enhanced reviews data
     */
    public function apiReviews(): void
    {
        header('Content-Type: application/json');
        
        $reviews = $this->reviewsService->getEnhancedTop3Reviews();
        $statistics = $this->reviewsService->getSectionStatistics();
        
        echo json_encode([
            'success' => true,
            'reviews' => $reviews,
            'statistics' => $statistics,
            'last_updated' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * API endpoint for specific casino review
     * 
     * @param string $casinoId Casino identifier
     */
    public function apiCasinoReview(string $casinoId): void
    {
        header('Content-Type: application/json');
        
        $reviews = $this->reviewsService->getEnhancedTop3Reviews();
        $casinoReview = null;
        
        foreach ($reviews as $review) {
            if ($review['casino_id'] === $casinoId) {
                $casinoReview = $review;
                break;
            }
        }
        
        if ($casinoReview) {
            echo json_encode([
                'success' => true,
                'casino_review' => $casinoReview,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Casino review not found',
                'casino_id' => $casinoId
            ]);
        }
    }

    /**
     * API endpoint for expert commentary
     * 
     * @param string $casinoId Casino identifier
     */
    public function apiExpertCommentary(string $casinoId): void
    {
        header('Content-Type: application/json');
        
        $commentary = $this->reviewsService->getExpertCommentary($casinoId);
        
        if (!empty($commentary)) {
            echo json_encode([
                'success' => true,
                'expert_commentary' => $commentary,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Expert commentary not found',
                'casino_id' => $casinoId
            ]);
        }
    }

    /**
     * API endpoint for mobile app details
     * 
     * @param string $casinoId Casino identifier
     */
    public function apiMobileAppDetails(string $casinoId): void
    {
        header('Content-Type: application/json');
        
        $mobileDetails = $this->reviewsService->getMobileAppDetails($casinoId);
        
        if (!empty($mobileDetails)) {
            echo json_encode([
                'success' => true,
                'mobile_app_details' => $mobileDetails,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Mobile app details not found',
                'casino_id' => $casinoId
            ]);
        }
    }

    /**
     * API endpoint for payment analysis
     * 
     * @param string $casinoId Casino identifier
     */
    public function apiPaymentAnalysis(string $casinoId): void
    {
        header('Content-Type: application/json');
        
        $paymentAnalysis = $this->reviewsService->getPaymentAnalysis($casinoId);
        
        if (!empty($paymentAnalysis)) {
            echo json_encode([
                'success' => true,
                'payment_analysis' => $paymentAnalysis,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Payment analysis not found',
                'casino_id' => $casinoId
            ]);
        }
    }

    /**
     * API endpoint for game portfolio highlights
     * 
     * @param string $casinoId Casino identifier
     */
    public function apiGamePortfolio(string $casinoId): void
    {
        header('Content-Type: application/json');
        
        $gameHighlights = $this->reviewsService->getGamePortfolioHighlights($casinoId);
        
        if (!empty($gameHighlights)) {
            echo json_encode([
                'success' => true,
                'game_portfolio' => $gameHighlights,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Game portfolio not found',
                'casino_id' => $casinoId
            ]);
        }
    }

    /**
     * API endpoint for comparison matrix
     */
    public function apiComparisonMatrix(): void
    {
        header('Content-Type: application/json');
        
        $comparisonMatrix = $this->reviewsService->getComparisonMatrix();
        
        echo json_encode([
            'success' => true,
            'comparison_matrix' => $comparisonMatrix,
            'last_updated' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Render enhanced reviews section for homepage integration
     * 
     * @return string HTML content for homepage section
     */
    public function renderHomepageSection(): string
    {
        $reviews = $this->reviewsService->getEnhancedTop3Reviews();
        $statistics = $this->reviewsService->getSectionStatistics();
        
        ob_start();
        include __DIR__ . '/../Views/enhanced-detailed-reviews/section.php';
        return ob_get_clean();
    }

    /**
     * Render individual enhanced review card
     * 
     * @param array $review Review data
     * @return string HTML content for review card
     */
    public function renderEnhancedReviewCard(array $review): string
    {
        ob_start();
        include __DIR__ . '/../Views/enhanced-detailed-reviews/review-card.php';
        return ob_get_clean();
    }

    /**
     * Render expert commentary component
     * 
     * @param array $commentary Expert commentary data
     * @return string HTML content for expert commentary
     */
    public function renderExpertCommentary(array $commentary): string
    {
        ob_start();
        include __DIR__ . '/../Views/enhanced-detailed-reviews/expert-commentary.php';
        return ob_get_clean();
    }

    /**
     * Render mobile app showcase component
     * 
     * @param array $mobileApp Mobile app data
     * @return string HTML content for mobile app showcase
     */
    public function renderMobileAppShowcase(array $mobileApp): string
    {
        ob_start();
        include __DIR__ . '/../Views/enhanced-detailed-reviews/mobile-app-showcase.php';
        return ob_get_clean();
    }
}
