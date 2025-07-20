<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\FeaturedCasinoService;
use App\Services\CasinoCategoriesService;
use App\Services\BonusComparisonService;
use App\Services\ExpertTeamService;
use App\Services\DetailedCasinoReviewsService;
use App\Services\BonusDatabaseService;
use App\Services\FreeGamesLibraryService;
use App\Services\LiveDealerGamesService;
use App\Services\PaymentMethodsService;
use App\Services\MobileAppService;
use App\Services\NewsService;
use App\Services\ProvinceService;
use App\Services\ProvincesService;
use App\Services\SoftwareProviderService;
use App\Services\LegalStatusService;
use App\Services\CategoryComparisonService;
use App\Services\EnhancedDetailedReviewsService;
use App\Controllers\BonusDatabaseController;
use Exception;

class HomeController extends Controller {
    public function index(): void {
        // Get casino data
        $topCasinos = $this->getTopCasinos();
        
        // Get comprehensive casino categories for navigation
        $categoriesService = new CasinoCategoriesService();
        $categories = $categoriesService->getAllCategories();
        
        // Get bonus comparison data
        $bonusService = new BonusComparisonService();
        $topBonuses = $bonusService->getTopBonuses(4, 'overall_value');
        
        // Get expert team data
        $expertTeamService = new ExpertTeamService();
        $expertTeamData = $expertTeamService->getExpertTeamSection();
        
        // Get detailed casino reviews data
        $reviewsService = new DetailedCasinoReviewsService();
        $top3Reviews = $reviewsService->getTop3DetailedReviews();
        
        // Get bonus database data
        $bonusDatabaseController = new BonusDatabaseController();
        $bonusDatabaseSection = $bonusDatabaseController->renderBonusDatabase();
        
        // Get free games library data
        $freeGamesService = new FreeGamesLibraryService();
        $freeGamesData = [
            'games' => $freeGamesService->getPopularGames(12),
            'statistics' => $freeGamesService->getLibraryStatistics(),
            'total_available' => $freeGamesService->getLibraryStatistics()['total_games']
        ];
        
        // Get live dealer games data
        $liveDealerService = new LiveDealerGamesService();
        $paymentMethodsService = new PaymentMethodsService();
        $liveDealerData = $liveDealerService->getHomepageLiveDealerData(8);
        $paymentMethodsData = $paymentMethodsService->getPaymentMethods();
        
        // Get mobile app data
        $mobileAppService = new MobileAppService();
        $mobileAppData = [
            'featured_apps' => $mobileAppService->getFeaturedMobileApps(),
            'advantages' => $mobileAppService->getMobileAdvantages(),
            'statistics' => $mobileAppService->getMobileStats()
        ];
        
        // Get news and updates data
        $newsService = new NewsService();
        $newsData = [
            'featured_articles' => $newsService->getFeaturedNews(),
            'latest_updates' => array_slice($newsService->getLatestUpdates(), 0, 6),
            'news_statistics' => $newsService->getNewsStatistics()
        ];
        
        // Get Canadian provinces data (PRD #24)
        $provincesService = new ProvincesService(null);
        $provincesData = [
            'provinces' => $provincesService->getTopProvincesByCasinoCount(6),
            'statistics' => $provincesService->getProvinceStatistics()
        ];
        
        // Get software providers data
        $softwareProviderService = new \App\Services\SoftwareProviderService();
        $softwareProvidersData = [
            'featured_providers' => array_slice($softwareProviderService->getAllProviders(), 0, 6),
            'total_providers' => count($softwareProviderService->getAllProviders()),
            'categories' => $softwareProviderService->getProviderCategories(),
            'statistics' => $softwareProviderService->getProviderStatistics()
        ];
        
        // Get legal status data
        $legalStatusService = new LegalStatusService();
        $legalStatusData = [
            'legal_summary' => $legalStatusService->getLegalSummaryForHomepage(),
            'authorities' => array_slice($legalStatusService->getAllAuthorities(), 0, 4),
            'featured_provinces' => array_slice($legalStatusService->getAllProvinces(), 0, 3),
            'payment_regulations' => $legalStatusService->getPaymentRegulations()
        ];
        
        // Get category comparison data
        $categoryComparisonService = new CategoryComparisonService();
        $categoryComparisonData = [
            'category_leaders' => $categoryComparisonService->getCategoryLeaders(),
            'statistics' => $categoryComparisonService->getCategoryStatistics()
        ];

        // Get enhanced detailed reviews data (PRD #23)
        $enhancedReviewsService = new \App\Services\EnhancedDetailedReviewsService();
        $enhancedReviewsData = [
            'top_3_reviews' => $enhancedReviewsService->getEnhancedTop3Reviews(),
            'review_categories' => $enhancedReviewsService->getReviewCategories(),
            'expert_insights' => $enhancedReviewsService->getExpertInsights()
        ];
        
        // Get enhanced detailed reviews data
        $enhancedReviewsService = new EnhancedDetailedReviewsService();
        $enhancedReviewsData = [
            'top_3_reviews' => $enhancedReviewsService->getTop3Reviews(),
            'review_categories' => $enhancedReviewsService->getReviewCategories(),
            'expert_insights' => $enhancedReviewsService->getExpertInsights()
        ];
        
        $featuredGames = $this->getFeaturedGames();
        $bonusCategories = $this->getBonusCategories();
        
        // Get featured casinos for spotlight carousel
        $featuredCasinoService = new FeaturedCasinoService();
        $featuredCasinos = $featuredCasinoService->getFeaturedCasinos();
        $carouselConfig = $featuredCasinoService->getCarouselConfig();
        
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare the best Canadian online casinos in 2025</title>
    <meta name="description" content="Casino.ca is your go-to for finding the best online casino in Canada. With 10 years online, we\'ve reviewed over 120 popular CA casinos. Expert reviews, exclusive bonuses, and trusted recommendations.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/detailed-reviews.css">
    <link rel="stylesheet" href="/css/bonus-database.css">
    <link rel="stylesheet" href="/css/free-games-library.css">
    <link rel="stylesheet" href="/css/live-dealer-games.css">
    <link rel="stylesheet" href="/css/payment-methods.css">
    <link rel="stylesheet" href="/css/mobile-app.css">
    <link rel="stylesheet" href="/css/news-updates.css">
    <link rel="stylesheet" href="/css/provinces.css">
    <link rel="stylesheet" href="/css/provinces-section.css">
    <link rel="stylesheet" href="/css/software-providers.css">
    <link rel="stylesheet" href="/css/category-comparison.css">
    <link rel="stylesheet" href="/css/enhanced-detailed-reviews.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #ffffff;
        }
        
        .header {
            background: #ffffff;
            border-bottom: 1px solid #e5e5e5;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #d63384;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-links a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: #d63384;
        }
        
        .hero {
            background: #ffffff;
            padding: 3rem 0;
            text-align: center;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
            font-weight: 700;
        }
        
        .hero p {
            font-size: 1.1rem;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .section {
            margin: 4rem 0;
        }
        
        .section-title {
            font-size: 2rem;
            margin-bottom: 2rem;
            color: #333;
            font-weight: 700;
        }
        
        .casinos-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .casino-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.3s ease;
        }
        
        .casino-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .casino-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }
        
        .casino-rank {
            font-size: 1.2rem;
            font-weight: bold;
            color: #d63384;
            min-width: 30px;
        }
        
        .casino-logo {
            width: 60px;
            height: 60px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #666;
        }
        
        .casino-details {
            flex: 1;
        }
        
        .casino-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .casino-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .casino-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .stars {
            color: #ffc107;
        }
        
        .rating-text {
            font-size: 0.9rem;
            color: #28a745;
            font-weight: 600;
        }
        
        .casino-bonus {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
            margin: 0 1rem;
            min-width: 200px;
        }
        
        .casino-stats {
            display: flex;
            gap: 1rem;
            margin: 0 1rem;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.25rem;
        }
        
        .stat-value {
            font-weight: 600;
            color: #333;
        }
        
        .casino-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: #d63384;
            color: white;
        }
        
        .btn-secondary {
            background: transparent;
            color: #d63384;
            border: 1px solid #d63384;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .view-all {
            text-align: center;
            margin-top: 2rem;
        }
        
        .view-all-btn {
            background: #6c757d;
            color: white;
            padding: 1rem 2rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: background 0.3s ease;
        }
        
        .view-all-btn:hover {
            background: #5a6268;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .casino-categories-nav {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .categories-intro {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .categories-stats {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .stat-item {
            color: #666;
            font-size: 0.9rem;
        }
        
        .stat-item strong {
            color: #333;
            display: block;
            font-size: 1.2rem;
        }
        
        .view-all-categories-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .view-all-categories-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102,126,234,0.3);
        }
        
        .category-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-color: transparent;
        }
        
        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .category-icon {
            font-size: 2rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .category-count {
            background: #f8f9fa;
            color: #666;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .category-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        
        .category-description {
            color: #7f8c8d;
            line-height: 1.5;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .category-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .category-link:hover {
            color: #2980b9;
        }
        
        /* Bonus Comparison Section Styles */
        .bonus-comparison-section {
            background: #ffffff;
            border-radius: 15px;
            border: 1px solid #e5e5e5;
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .bonus-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .bonus-stats .stat-item {
            padding: 1rem;
        }
        
        .bonus-stats .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #27ae60;
            display: block;
        }
        
        .bonus-stats .stat-label {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        
        .bonus-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .bonus-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .bonus-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-color: #3498db;
        }
        
        .bonus-rank {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .bonus-casino {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .bonus-offer {
            color: #27ae60;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .bonus-details {
            margin-bottom: 1rem;
        }
        
        .bonus-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .detail-label {
            color: #7f8c8d;
        }
        
        .detail-value {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .bonus-score {
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .score-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin: 0 auto 5px;
        }
        
        .score-label {
            font-size: 0.8rem;
            color: #7f8c8d;
        }
        
        .bonus-cta {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
        }
        
        .bonus-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(231,76,60,0.3);
        }
        
        .bonus-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .view-all-btn.primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }
        
        .view-all-btn.secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
        }
        
        /* Expert Team Section Styles */
        .expert-team-section {
            background: #f8f9fa;
            padding: 4rem 0;
        }
        
        .expert-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .expert-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            text-align: center;
        }
        
        .expert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .expert-photo-container {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .expert-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto;
            border: 4px solid #3498db;
        }
        
        .expert-photo-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3498db, #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0 auto;
        }
        
        .expert-experience {
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%);
            background: #27ae60;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .expert-name {
            color: #2c3e50;
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }
        
        .expert-title {
            color: #3498db;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .expert-bio {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }
        
        .expert-specializations {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        
        .spec-tag {
            background: #e8f5e8;
            color: #27ae60;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
        }
        
        .expert-stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 1.5rem;
        }
        
        .expert-stats .stat {
            text-align: center;
        }
        
        .expert-stats .stat-number {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            display: block;
        }
        
        .expert-stats .stat-label {
            color: #7f8c8d;
            font-size: 0.8rem;
        }
        
        .expert-link {
            background: #3498db;
            color: white;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
            display: inline-block;
        }
        
        .expert-link:hover {
            background: #2980b9;
        }
        
        .trust-signals {
            margin: 4rem 0;
            text-align: center;
        }
        
        .trust-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        
        .trust-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
        
        .trust-icon {
            width: 50px;
            height: 50px;
            background: #27ae60;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .trust-content h4 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .trust-content p {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .expert-recommendations {
            margin: 4rem 0;
            text-align: center;
        }
        
        .recommendations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        
        .recommendation-card {
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: left;
        }
        
        .rec-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .rec-header .casino-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .rec-header .rating {
            color: #f39c12;
            font-weight: bold;
        }
        
        .expert-rec {
            margin-bottom: 1rem;
        }
        
        .expert-rec .expert-name {
            font-weight: bold;
            color: #3498db;
        }
        
        .expert-rec .expert-title {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .rec-reason {
            color: #555;
            margin-bottom: 1rem;
        }
        
        .rec-highlight {
            background: #e8f5e8;
            color: #27ae60;
            padding: 0.8rem;
            border-radius: 6px;
            font-style: italic;
            font-size: 0.9rem;
        }
        
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .game-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .game-card:hover {
            transform: translateY(-2px);
        }
        
        .game-image {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .game-info {
            padding: 1rem;
        }
        
        .game-name {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .game-provider {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .game-rtp {
            background: #28a745;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            display: inline-block;
        }
        
        .footer {
            background: #f8f9fa;
            border-top: 1px solid #e5e5e5;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h3 {
            color: #333;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .footer-section a {
            color: #666;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }
        
        .footer-section a:hover {
            color: #d63384;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #e5e5e5;
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Interactive Casino Grid Styles (PRD #02) */
        .casino-grid-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 12px;
            border: 1px solid #e9ecef;
            margin: 2rem 0;
        }
        
        .casino-grid-preview {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .grid-preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .grid-stats {
            display: flex;
            gap: 2rem;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            display: block;
            font-size: 1.5rem;
            font-weight: bold;
            color: #d63384;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }
        
        .btn-large {
            padding: 12px 24px;
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .casino-grid-mini {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .grid-casino-item {
            text-align: center;
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .grid-casino-item:hover {
            border-color: #d63384;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .casino-mini-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #d63384, #e91e63);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 auto 0.5rem;
            font-size: 0.9rem;
        }
        
        .casino-mini-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: #333;
        }
        
        .grid-casino-item:last-child .casino-mini-logo {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
        
        .grid-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .feature {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 6px;
        }
        
        .feature-icon {
            font-size: 1.2rem;
        }
        
        .feature-text {
            font-weight: 500;
            color: #333;
        }
        
        /* Featured Casino Spotlight Carousel Styles (PRD #03) */
        .featured-casino-spotlight {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            color: white;
            padding: 3rem 0;
            margin: 2rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .featured-casino-spotlight::before {
            content: \'\';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(214, 51, 132, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(255, 215, 0, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .spotlight-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 2;
        }
        
        .spotlight-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .spotlight-subtitle {
            font-size: 1.1rem;
            color: #e9ecef;
            margin: 0;
        }
        
        .carousel-container {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .carousel-wrapper {
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .carousel-track {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .carousel-slide {
            min-width: 100%;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .carousel-slide.active {
            opacity: 1;
        }
        
        .featured-casino-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            color: #333;
            border-radius: 12px;
            padding: 2.5rem;
            position: relative;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .casino-featured-badge {
            position: absolute;
            top: -10px;
            right: 2rem;
            background: linear-gradient(45deg, #d63384, #e91e63);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(214, 51, 132, 0.3);
        }
        
        .badge-reason {
            display: block;
            font-size: 0.7rem;
            opacity: 0.9;
            margin-top: 0.2rem;
        }
        
        .featured-casino-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .featured-casino-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #d63384, #e91e63);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(214, 51, 132, 0.3);
        }
        
        .featured-casino-name {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0 0 0.5rem 0;
            color: #1a1a2e;
        }
        
        .featured-casino-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .featured-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .featured-rating .stars {
            color: #ffd700;
            font-size: 1.1rem;
        }
        
        .rating-value {
            font-weight: bold;
            color: #d63384;
        }
        
        .featured-casino-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .featured-description p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
            margin: 0;
        }
        
        .featured-bonus-highlight {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #d63384;
        }
        
        .bonus-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }
        
        .bonus-amount {
            font-size: 1.3rem;
            font-weight: bold;
            color: #d63384;
            margin-bottom: 0.5rem;
        }
        
        .bonus-code {
            font-size: 0.9rem;
            color: #666;
            font-family: monospace;
            background: #fff;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            display: inline-block;
        }
        
        .featured-stats {
            display: flex;
            justify-content: space-around;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .featured-stats .stat-item {
            text-align: center;
            flex: 1;
        }
        
        .featured-stats .stat-label {
            display: block;
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.3rem;
        }
        
        .featured-stats .stat-value {
            display: block;
            font-size: 1.1rem;
            font-weight: bold;
            color: #d63384;
        }
        
        .featured-highlights h4 {
            font-size: 1rem;
            margin: 0 0 0.8rem 0;
            color: #333;
        }
        
        .highlight-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .highlight-list li {
            padding: 0.3rem 0;
            position: relative;
            padding-left: 1.2rem;
            font-size: 0.9rem;
            color: #555;
        }
        
        .highlight-list li::before {
            content: \'✓\';
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }
        
        .featured-casino-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        .btn-large {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
        }
        
        .carousel-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 1rem;
            transform: translateY(-50%);
            pointer-events: none;
        }
        
        .carousel-btn {
            background: rgba(255,255,255,0.9);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            pointer-events: auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .carousel-btn:hover {
            background: white;
            transform: scale(1.1);
        }
        
        .carousel-indicators {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        
        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: none;
            background: rgba(255,255,255,0.4);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .indicator.active,
        .indicator:hover {
            background: #ffd700;
            transform: scale(1.2);
        }
        
        .spotlight-footer {
            text-align: center;
            margin-top: 2rem;
            position: relative;
            z-index: 2;
        }
        
        .spotlight-disclaimer {
            font-size: 0.9rem;
            color: #adb5bd;
            margin: 0;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 1.8rem;
            }
            
            .nav-links {
                display: none;
            }
            
            .casino-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .casino-info {
                width: 100%;
            }
            
            .casino-bonus,
            .casino-stats {
                margin: 0;
                width: 100%;
            }
            
            .casino-stats {
                justify-content: space-around;
            }
            
            .casino-actions {
                width: 100%;
                justify-content: center;
            }
            
            /* Casino Grid Mobile Styles */
            .grid-preview-header {
                flex-direction: column;
                text-align: center;
            }
            
            .grid-stats {
                justify-content: center;
                gap: 1rem;
            }
            
            .casino-grid-mini {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.5rem;
            }
            
            .grid-casino-item {
                padding: 0.5rem;
            }
            
            .casino-mini-logo {
                width: 40px;
                height: 40px;
                font-size: 0.8rem;
            }
            
            .casino-mini-name {
                font-size: 0.7rem;
            }
            
            .grid-features {
                grid-template-columns: repeat(2, 1fr);
            }
            
            /* Featured Casino Spotlight Mobile Styles */
            .spotlight-title {
                font-size: 1.8rem;
            }
            
            .carousel-container {
                padding: 0 1rem;
            }
            
            .featured-casino-card {
                padding: 1.5rem;
            }
            
            .featured-casino-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .featured-casino-logo {
                width: 60px;
                height: 60px;
                font-size: 1.2rem;
            }
            
            .featured-casino-name {
                font-size: 1.4rem;
            }
            
            .featured-casino-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .featured-bonus-highlight {
                order: -1;
            }
            
            .featured-stats {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .featured-stats .stat-item {
                display: flex;
                justify-content: space-between;
                padding: 0.5rem;
                background: #f8f9fa;
                border-radius: 4px;
            }
            
            .featured-casino-actions {
                flex-direction: column;
            }
            
            .carousel-controls {
                display: none;
            }
        }
        
        /* How We Review Section Styles (PRD #19) */
        .methodology-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            padding: 4rem 0;
            border-top: 3px solid #e74c3c;
        }
        
        .methodology-overview {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .methodology-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin: 1rem 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: white;
        }
        
        .stat-number {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .criteria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .criteria-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 4px solid #3498db;
        }
        
        .criteria-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .criteria-card.security { border-left-color: #e53e3e; }
        .criteria-card.bonuses { border-left-color: #38a169; }
        .criteria-card.games { border-left-color: #3182ce; }
        .criteria-card.customer-service { border-left-color: #00b894; }
        .criteria-card.banking { border-left-color: #ff6b6b; }
        .criteria-card.localization { border-left-color: #d69e2e; }
        .criteria-card.mobile { border-left-color: #805ad5; }
        
        .criteria-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .criteria-card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }
        
        .criteria-weight {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        
        .criteria-card p {
            color: #4a5568;
            line-height: 1.5;
            margin: 0;
        }
        
        .methodology-actions {
            text-align: center;
            margin-top: 2rem;
        }
        
        @media (max-width: 768px) {
            .methodology-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .criteria-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .methodology-actions {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <a href="/" class="logo">Casino.ca</a>
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/reviews">Casino reviews</a></li>
                <li><a href="/bonus">Bonus offers</a></li>
                <li><a href="/free-games">Free games</a></li>
                <li><a href="/real-money">Real money casinos</a></li>
                <li><a href="/authors">Our Experts</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Compare the best Canadian online casinos in 2025</h1>
            <p>Casino.ca is your go-to for finding the best online casino in Canada. With 10 years online, we\'ve reviewed over 120 popular CA casinos. Tap one of our experts\' top recommendations to get playing.</p>
        </div>
    </section>

    <!-- Featured Casino Spotlight Carousel (PRD #03) -->
    <section class="featured-casino-spotlight">
        <div class="container">
            <div class="spotlight-header">
                <h2 class="spotlight-title">🌟 Featured Casino Spotlight</h2>
                <p class="spotlight-subtitle">Our expert-selected premium casinos with the best bonuses and highest ratings</p>
            </div>
            
            <div class="carousel-container">
                <div class="carousel-wrapper">
                    <div class="carousel-track" id="featuredCarousel">';
                    
        foreach ($featuredCasinos as $index => $casino) {
            $activeClass = $index === 0 ? ' active' : '';
            echo '<div class="carousel-slide' . $activeClass . '" data-casino-id="' . $casino['id'] . '">
                        <div class="featured-casino-card">
                            <div class="casino-featured-badge">
                                <span class="badge-text">Featured</span>
                                <span class="badge-reason">' . htmlspecialchars($casino['featured_reason']) . '</span>
                            </div>
                            
                            <div class="featured-casino-header">
                                <div class="featured-casino-logo">' . $casino['logo'] . '</div>
                                <div class="featured-casino-info">
                                    <h3 class="featured-casino-name">' . htmlspecialchars($casino['name']) . '</h3>
                                    <div class="featured-casino-meta">
                                        <span class="established">Est. ' . $casino['established'] . '</span>
                                        <span class="license">' . $casino['license'] . '</span>
                                    </div>
                                    <div class="featured-rating">
                                        <span class="stars">★★★★★</span>
                                        <span class="rating-value">' . $casino['rating'] . '/5</span>
                                        <span class="rating-text">' . $casino['rating_text'] . '</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="featured-casino-content">
                                <div class="featured-description">
                                    <p>' . htmlspecialchars($casino['featured_description']) . '</p>
                                </div>
                                
                                <div class="featured-bonus-highlight">
                                    <div class="bonus-label">Welcome Bonus</div>
                                    <div class="bonus-amount">' . htmlspecialchars($casino['bonus']) . '</div>
                                    <div class="bonus-code">Code: ' . $casino['bonus_code'] . '</div>
                                </div>
                                
                                <div class="featured-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">RTP</span>
                                        <span class="stat-value">' . $casino['rtp'] . '</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Games</span>
                                        <span class="stat-value">' . $casino['games'] . '</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Payout</span>
                                        <span class="stat-value">' . $casino['payout'] . '</span>
                                    </div>
                                </div>
                                
                                <div class="featured-highlights">
                                    <h4>Why It\'s Featured:</h4>
                                    <ul class="highlight-list">';
            
            foreach (array_slice($casino['key_features'], 0, 3) as $feature) {
                echo '<li>' . htmlspecialchars($feature) . '</li>';
            }
            
            echo '</ul>
                                </div>
                            </div>
                            
                            <div class="featured-casino-actions">
                                <a href="/casino/' . $casino['slug'] . '" class="btn btn-primary btn-large">
                                    🎁 Claim ' . $casino['bonus_code'] . ' Bonus
                                </a>
                                <a href="/casino/' . $casino['slug'] . '" class="btn btn-secondary">
                                    📖 Read Full Review
                                </a>
                            </div>
                        </div>
                    </div>';
        }
        
        echo '</div>
                </div>
                
                <div class="carousel-controls">
                    <button class="carousel-btn carousel-prev" onclick="moveCarousel(-1)">‹</button>
                    <button class="carousel-btn carousel-next" onclick="moveCarousel(1)">›</button>
                </div>
                
                <div class="carousel-indicators">';
                
        foreach ($featuredCasinos as $index => $casino) {
            $activeClass = $index === 0 ? ' active' : '';
            echo '<button class="indicator' . $activeClass . '" onclick="goToSlide(' . $index . ')" data-slide="' . $index . '"></button>';
        }
        
        echo '</div>
            </div>
            
            <div class="spotlight-footer">
                <p class="spotlight-disclaimer">* Featured casinos are selected based on player ratings, bonus value, game variety, and payout reliability.</p>
            </div>
        </div>
    </section>

    <main class="container">
        <section class="section">
            <h2 class="section-title">Top online casinos for Canadian players</h2>
            <div class="casinos-list">';
        
        foreach ($topCasinos as $index => $casino) {
            echo '<div class="casino-card">
                <div class="casino-info">
                    <div class="casino-rank">' . ($index + 1) . '</div>
                    <div class="casino-logo">' . substr($casino['name'], 0, 3) . '</div>
                    <div class="casino-details">
                        <div class="casino-name">' . htmlspecialchars($casino['name']) . '</div>
                        <div class="casino-meta">Established in ' . $casino['established'] . '</div>
                        <div class="casino-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">' . $casino['rating'] . '/5 ' . $casino['rating_text'] . '</span>
                        </div>
                    </div>
                </div>
                
                <div class="casino-bonus">
                    ' . htmlspecialchars($casino['bonus']) . '
                </div>
                
                <div class="casino-stats">
                    <div class="stat">
                        <div class="stat-label">RTP</div>
                        <div class="stat-value">' . $casino['rtp'] . '</div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">Payout</div>
                        <div class="stat-value">' . $casino['payout'] . '</div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">Games</div>
                        <div class="stat-value">' . $casino['games'] . '</div>
                    </div>
                </div>
                
                <div class="casino-actions">
                    <a href="/casino/' . $casino['slug'] . '" class="btn btn-primary">Get bonus</a>
                    <a href="/casino/' . $casino['slug'] . '" class="btn btn-secondary">More info</a>
                </div>
            </div>';
        }
        
        echo '</div>
            <div class="view-all">
                <a href="/reviews" class="view-all-btn">View 90+ casino reviews</a>
            </div>
        </section>

        <!-- Interactive Casino Grid Section (PRD #02) -->
        <section class="section casino-grid-section">
            <h2 class="section-title">Compare All Casinos - Interactive Grid</h2>
            <p>Explore our complete database of 90+ Canadian-friendly online casinos. Use our interactive grid to compare bonuses, ratings, game selections, and find your perfect casino match.</p>
            
            <div class="casino-grid-preview">
                <div class="grid-preview-header">
                    <div class="grid-stats">
                        <div class="stat-item">
                            <span class="stat-number">90+</span>
                            <span class="stat-label">Casinos</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Categories</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">Real-time</span>
                            <span class="stat-label">Filtering</span>
                        </div>
                    </div>
                    <a href="/compare-all-casinos" class="btn btn-primary btn-large">Explore All Casinos →</a>
                </div>
                
                <div class="casino-grid-mini">
                    <div class="grid-casino-item"><div class="casino-mini-logo">BR</div><div class="casino-mini-name">BonRush</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">SV</div><div class="casino-mini-name">SLOTSVIL</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">CJ</div><div class="casino-mini-name">CASINOJOY</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">SM</div><div class="casino-mini-name">SLOTIMO</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">NJ</div><div class="casino-mini-name">NOVAJACKPOT</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">N54</div><div class="casino-mini-name">NEON54</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">666</div><div class="casino-mini-name">666 Gambit</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">SN</div><div class="casino-mini-name">SPINIGHT</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">+12</div><div class="casino-mini-name">More Casinos</div></div>
                </div>
                
                <div class="grid-features">
                    <div class="feature">
                        <div class="feature-icon">🔍</div>
                        <div class="feature-text">Search & Filter</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">⚡</div>
                        <div class="feature-text">Real-time Results</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">📊</div>
                        <div class="feature-text">Compare Side-by-Side</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🎯</div>
                        <div class="feature-text">Detailed Info</div>
                    </div>
                </div>
            </div>
        </section>';

        // Best Casinos by Category Table Section (PRD #22) - TEMPORARILY DISABLED
        // echo $this->renderCategoryComparisonSection($categoryComparisonData);

        echo '<section class="section">
            <h2 class="section-title">Discover Canada\'s Best Online Casinos by Category</h2>
            <p>Find your perfect casino experience with our comprehensive category system. Whether you\'re interested in live dealer action, mobile gaming, cryptocurrency payments, or massive bonuses, we\'ve organized Canada\'s top casinos to match your exact preferences.</p>
            <div class="casino-categories-nav">
                <div class="categories-intro">
                    <div class="categories-stats">
                        <span class="stat-item"><strong>' . count($categories) . '+</strong> Categories</span>
                        <span class="stat-item"><strong>200+</strong> Reviewed Casinos</span>
                        <span class="stat-item"><strong>24/7</strong> Expert Analysis</span>
                    </div>
                    <a href="/categories" class="view-all-categories-btn">View All Categories</a>
                </div>
                <div class="categories-grid">';
        
        // Show top 6 categories on homepage
        $topCategories = array_slice($categories, 0, 6, true);
        foreach ($topCategories as $categoryId => $category) {
            echo '<div class="category-card" style="border-left: 4px solid ' . $category['color'] . ';">
                <div class="category-header">
                    <div class="category-icon" style="color: ' . $category['color'] . ';">
                        <i class="' . $category['icon'] . '"></i>
                    </div>
                    <div class="category-count">' . $category['casino_count'] . ' casinos</div>
                </div>
                <div class="category-title">' . htmlspecialchars($category['name']) . '</div>
                <div class="category-description">' . htmlspecialchars($category['description']) . '</div>
                <a href="/categories/' . $categoryId . '" class="category-link">Explore Category →</a>
            </div>';
        }
        
        echo '</div>
            </div>
        </section>

        <section class="section">
            <h2 class="section-title">Play online casino games for free - no download required</h2>
            <p>Looking to join the world of casinos online and play games without any software downloads? We offer a huge library of over 20,000 free casino games you can play right on Casino.ca with no sign up required.</p>
            <div class="games-grid">';
        
        foreach ($featuredGames as $game) {
            echo '<div class="game-card">
                <div class="game-image">' . $game['icon'] . '</div>
                <div class="game-info">
                    <div class="game-name">' . $game['name'] . '</div>
                    <div class="game-provider">' . $game['provider'] . '</div>
                    <div class="game-rtp">' . $game['rtp'] . ' RTP</div>
                </div>
            </div>';
        }
        
        echo '</div>
            <div class="view-all">
                <a href="/free-games" class="view-all-btn">Play 21,500+ casino games free</a>
            </div>
        </section>

        <?php echo $this->renderPopularSlotsSection(); ?>

        <!-- Expert Team Section -->
        <section class="section expert-team-section">
            <div class="container">
                <h2>Our Casino Experts</h2>
                <p class="section-subtitle">Meet the professional team evaluating Canada&apos;s best online casinos</p>
                
                <div class="expert-grid">
                    <div class="expert-card">
                        <div class="expert-photo-container">
                            <div class="expert-photo-placeholder">E</div>
                            <div class="expert-experience">12+ Years</div>
                        </div>
                        <div class="expert-info">
                            <h3 class="expert-name">Dr. Emily Rodriguez</h3>
                            <div class="expert-title">Senior Casino Analyst</div>
                            <p class="expert-bio">PhD in Statistics with 12+ years analyzing casino algorithms and RTP rates.</p>
                            <div class="expert-specializations">
                                <span class="spec-tag">Slot Machine Analysis</span>
                                <span class="spec-tag">RTP Calculations</span>
                            </div>
                            <div class="expert-stats">
                                <div class="stat">
                                    <span class="stat-number">127</span>
                                    <span class="stat-label">Articles</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-number">89</span>
                                    <span class="stat-label">Reviews</span>
                                </div>
                            </div>
                            <a href="/experts/dr-emily-rodriguez" class="expert-link">View Profile</a>
                        </div>
                    </div>
                    
                    <div class="expert-card">
                        <div class="expert-photo-container">
                            <div class="expert-photo-placeholder">M</div>
                            <div class="expert-experience">15+ Years</div>
                        </div>
                        <div class="expert-info">
                            <h3 class="expert-name">Marcus Thompson</h3>
                            <div class="expert-title">Table Games Specialist</div>
                            <p class="expert-bio">Former professional blackjack player with 15+ years in casino table game analysis.</p>
                            <div class="expert-specializations">
                                <span class="spec-tag">Table Game Strategy</span>
                                <span class="spec-tag">Live Dealer Analysis</span>
                            </div>
                            <div class="expert-stats">
                                <div class="stat">
                                    <span class="stat-number">94</span>
                                    <span class="stat-label">Articles</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-number">67</span>
                                    <span class="stat-label">Reviews</span>
                                </div>
                            </div>
                            <a href="/experts/marcus-thompson" class="expert-link">View Profile</a>
                        </div>
                    </div>
                    
                    <div class="expert-card">
                        <div class="expert-photo-container">
                            <div class="expert-photo-placeholder">S</div>
                            <div class="expert-experience">8+ Years</div>
                        </div>
                        <div class="expert-info">
                            <h3 class="expert-name">Sarah Chen</h3>
                            <div class="expert-title">Mobile Gaming Expert</div>
                            <p class="expert-bio">Mobile technology specialist focusing on casino app performance and user experience.</p>
                            <div class="expert-specializations">
                                <span class="spec-tag">Mobile App Analysis</span>
                                <span class="spec-tag">User Experience Design</span>
                            </div>
                            <div class="expert-stats">
                                <div class="stat">
                                    <span class="stat-number">76</span>
                                    <span class="stat-label">Articles</span>
                                </div>
                                <div class="stat">
                                    <span class="stat-number">52</span>
                                    <span class="stat-label">Reviews</span>
                                </div>
                            </div>
                            <a href="/experts/sarah-chen" class="expert-link">View Profile</a>
                        </div>
                    </div>
                </div>
                
                <div class="trust-signals">
                    <h3>Why Trust Our Experts?</h3>
                    <div class="trust-grid">
                        <div class="trust-item">
                            <div class="trust-icon">✓</div>
                            <div class="trust-content">
                                <h4>50+ Years Combined Experience</h4>
                                <p>Our expert team brings decades of casino industry knowledge</p>
                            </div>
                        </div>
                        <div class="trust-item">
                            <div class="trust-icon">✓</div>
                            <div class="trust-content">
                                <h4>Independent Reviews</h4>
                                <p>Unbiased evaluations with no casino partnerships affecting ratings</p>
                            </div>
                        </div>
                        <div class="trust-item">
                            <div class="trust-icon">✓</div>
                            <div class="trust-content">
                                <h4>Real Canadian Experts</h4>
                                <p>Local professionals who understand Canadian gaming regulations</p>
                            </div>
                        </div>
                        <div class="trust-item">
                            <div class="trust-icon">✓</div>
                            <div class="trust-content">
                                <h4>1000+ Casinos Reviewed</h4>
                                <p>Comprehensive analysis of Canada&apos;s entire online casino market</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="expert-recommendations">
                    <h3>Our Experts&apos; Favourite Casinos</h3>
                    <div class="recommendations-grid">
                        <div class="recommendation-card">
                            <div class="rec-header">
                                <div class="casino-name">BonRush</div>
                                <div class="rating">★ 4.9</div>
                            </div>
                            <div class="expert-rec">
                                <span class="expert-name">Dr. Emily Rodriguez</span>
                                <span class="expert-title">Senior Casino Analyst</span>
                            </div>
                            <p class="rec-reason">Exceptional RTP rates and transparent slot mathematics</p>
                            <div class="rec-highlight">Best for serious slot players who understand the math</div>
                        </div>
                        
                        <div class="recommendation-card">
                            <div class="rec-header">
                                <div class="casino-name">SLOTSVIL</div>
                                <div class="rating">★ 4.9</div>
                            </div>
                            <div class="expert-rec">
                                <span class="expert-name">Marcus Thompson</span>
                                <span class="expert-title">Table Games Specialist</span>
                            </div>
                            <p class="rec-reason">Superior live dealer tables with professional dealers</p>
                            <div class="rec-highlight">Best blackjack variants and table limits</div>
                        </div>
                        
                        <div class="recommendation-card">
                            <div class="rec-header">
                                <div class="casino-name">CASINOJOY</div>
                                <div class="rating">★ 4.9</div>
                            </div>
                            <div class="expert-rec">
                                <span class="expert-name">Sarah Chen</span>
                                <span class="expert-title">Mobile Gaming Expert</span>
                            </div>
                            <p class="rec-reason">Award-winning mobile app with flawless performance</p>
                            <div class="rec-highlight">Industry-leading mobile gaming experience</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Detailed Top 3 Casino Reviews Section -->
        <section class="detailed-reviews-section">
            <div class="container">
                <div class="section-header">
                    <h2>Expert Reviews: Top 3 Canadian Casinos</h2>
                    <p>Comprehensive analysis from our casino experts with detailed ratings and honest assessments</p>
                </div>
                
                <div class="reviews-grid">';
        
        foreach ($top3Reviews as $review) {
            echo $this->renderDetailedReviewCard($review);
        }
        
        echo '
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
        </section>

        <!-- Enhanced Detailed Top 3 Casino Reviews Section (PRD #23) -->
        <section class="enhanced-detailed-reviews-section">
            <?php echo $this->renderEnhancedDetailedReviewsSection($enhancedReviewsData); ?>
        </section>

        <!-- Free Games Library Section -->
        <section class="free-games-library-section">
            <div class="container">
                <div class="free-games-content">
                    <div class="free-games-header">
                        <h2>Free Casino Games Library</h2>
                        <p class="free-games-subtitle">
                            Play 50+ premium slot games absolutely free! No download, no registration required. 
                            Experience the thrill of top casino games from industry-leading providers.
                        </p>
                        
                        <div class="library-stats">
                            <div class="stat-item">
                                <span class="stat-number">' . $freeGamesData['statistics']['total_games'] . '</span>
                                <span class="stat-label">Free Games</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">' . $freeGamesData['statistics']['providers'] . '</span>
                                <span class="stat-label">Providers</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">' . $freeGamesData['statistics']['average_rtp'] . '</span>
                                <span class="stat-label">Avg RTP</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">' . $freeGamesData['statistics']['mobile_compatible'] . '</span>
                                <span class="stat-label">Mobile Ready</span>
                            </div>
                        </div>
                    </div>

                    <div class="games-grid">';

        foreach (array_slice($freeGamesData['games'], 0, 12) as $game) {
            echo '
                        <div class="game-card">
                            <div class="game-image">
                                <img src="' . htmlspecialchars($game['image']) . '" alt="' . htmlspecialchars($game['name']) . '" loading="lazy">
                                <div class="play-demo-overlay">
                                    <button class="play-demo-btn" onclick="playDemo(\'' . htmlspecialchars($game['id']) . '\')">
                                        <i class="fas fa-play"></i> Play Demo
                                    </button>
                                </div>
                            </div>
                            <div class="game-info">
                                <h3 class="game-title">' . htmlspecialchars($game['name']) . '</h3>
                                <p class="game-provider">by ' . htmlspecialchars($game['provider']) . '</p>
                                
                                <div class="game-details">
                                    <div class="detail-item">
                                        <span class="detail-label">RTP:</span>
                                        <span class="detail-value">' . htmlspecialchars($game['rtp']) . '</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Volatility:</span>
                                        <span class="detail-value">' . htmlspecialchars($game['volatility']) . '</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Max Win:</span>
                                        <span class="detail-value">' . htmlspecialchars($game['max_win']) . '</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Paylines:</span>
                                        <span class="detail-value">' . htmlspecialchars($game['paylines']) . '</span>
                                    </div>
                                </div>
                                
                                <div class="game-features">';
            
            foreach (array_slice($game['features'], 0, 3) as $feature) {
                echo '
                                    <span class="feature-tag">' . htmlspecialchars($feature) . '</span>';
            }
            
            echo '
                                </div>
                            </div>
                        </div>';
        }

        echo '
                    </div>

                    <div class="view-all-section">
                        <a href="/free-games" class="view-all-btn">
                            <i class="fas fa-gamepad"></i> View All ' . $freeGamesData['total_available'] . ' Free Games
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Live Dealer Games Section -->
        <section class="live-dealer-games-section">
            <div class="container">
                <div class="live-dealer-content">
                    <div class="live-dealer-header">
                        <h2>🎲 Live Dealer Casino Games</h2>
                        <p class="live-dealer-subtitle">
                            Experience the thrill of real casino gaming with professional dealers streaming live in HD quality. 
                            Play authentic blackjack, roulette, baccarat and more from the comfort of your home.
                        </p>
                        
                        <div class="live-stats">
                            <div class="live-stat-item">
                                <span class="live-stat-number">' . $liveDealerData['statistics']['total_games'] . '</span>
                                <span class="live-stat-label">Live Games</span>
                            </div>
                            <div class="live-stat-item">
                                <span class="live-stat-number">' . $liveDealerData['statistics']['providers'] . '</span>
                                <span class="live-stat-label">Providers</span>
                            </div>
                            <div class="live-stat-item">
                                <span class="live-stat-number">' . $liveDealerData['statistics']['average_rtp'] . '</span>
                                <span class="live-stat-label">Avg RTP</span>
                            </div>
                            <div class="live-stat-item">
                                <span class="live-stat-number">' . $liveDealerData['statistics']['studio_locations'] . '</span>
                                <span class="live-stat-label">Studios</span>
                            </div>
                        </div>
                    </div>

                    <div class="live-games-grid">';

        foreach (array_slice($liveDealerData['games'], 0, 8) as $game) {
            echo '
                        <div class="live-game-card">
                            <div class="live-game-image">
                                <img src="' . htmlspecialchars($game['image']) . '" alt="' . htmlspecialchars($game['name']) . '" loading="lazy">
                                <div class="live-status-badge">LIVE</div>
                                <div class="dealer-overlay">
                                    <i class="fas fa-video"></i> ' . htmlspecialchars($game['dealer_info']['studio_location']) . ' Studio
                                    • ' . htmlspecialchars($game['dealer_info']['availability']) . '
                                </div>
                            </div>
                            <div class="live-game-info">
                                <h3 class="live-game-title">' . htmlspecialchars($game['name']) . '</h3>
                                <p class="live-game-provider">by ' . htmlspecialchars($game['provider']) . '</p>
                                
                                <div class="table-limits">
                                    <div class="limits-label">Table Limits</div>
                                    <div class="limits-range">$' . number_format($game['table_limits']['min_bet']) . ' - $' . number_format($game['table_limits']['max_bet']) . '</div>
                                </div>
                                
                                <div class="live-game-details">
                                    <div class="live-detail-item">
                                        <span class="live-detail-label">RTP:</span>
                                        <span class="live-detail-value">' . htmlspecialchars($game['rtp']) . '</span>
                                    </div>
                                    <div class="live-detail-item">
                                        <span class="live-detail-label">Quality:</span>
                                        <span class="live-detail-value">' . htmlspecialchars($game['streaming_quality']['resolution']) . '</span>
                                    </div>
                                    <div class="live-detail-item">
                                        <span class="live-detail-label">Languages:</span>
                                        <span class="live-detail-value">' . count($game['dealer_info']['languages']) . '</span>
                                    </div>
                                    <div class="live-detail-item">
                                        <span class="live-detail-label">Category:</span>
                                        <span class="live-detail-value">' . htmlspecialchars($game['category']) . '</span>
                                    </div>
                                </div>
                                
                                <div class="streaming-quality">
                                    <i class="fas fa-hd-video quality-icon"></i>
                                    <span class="quality-text">' . htmlspecialchars($game['streaming_quality']['resolution']) . ' • ' . htmlspecialchars($game['streaming_quality']['technology']) . '</span>
                                </div>
                                
                                <div class="live-game-features">';
            
            foreach (array_slice($game['features'], 0, 3) as $feature) {
                echo '
                                    <span class="live-feature-tag">' . htmlspecialchars($feature) . '</span>';
            }
            
            echo '
                                </div>
                                
                                <div class="live-game-actions">
                                    <button class="play-live-btn" onclick="playLive(\'' . htmlspecialchars($game['id']) . '\')">
                                        <i class="fas fa-play-circle"></i> Play Live
                                    </button>
                                    <button class="game-info-btn" onclick="viewGameInfo(\'' . htmlspecialchars($game['id']) . '\')">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>';
        }

        echo '
                    </div>

                    <div class="providers-showcase">
                        <h3>Leading Live Gaming Providers</h3>
                        <div class="providers-grid">';

        foreach ($liveDealerData['providers'] as $providerSlug => $provider) {
            echo '
                            <div class="provider-card">
                                <div class="provider-logo">' . strtoupper(substr($provider['name'], 0, 2)) . '</div>
                                <h4 class="provider-name">' . htmlspecialchars($provider['name']) . '</h4>
                                <p class="provider-specialties">' . implode(' • ', array_slice($provider['specialties'], 0, 2)) . '</p>
                                <div class="provider-stats">
                                    <div class="provider-stat">
                                        <span class="provider-stat-number">' . $provider['languages_supported'] . '</span>
                                        <span class="provider-stat-label">Languages</span>
                                    </div>
                                    <div class="provider-stat">
                                        <span class="provider-stat-number">' . count($provider['studio_locations']) . '</span>
                                        <span class="provider-stat-label">Studios</span>
                                    </div>
                                    <div class="provider-stat">
                                        <span class="provider-stat-number">' . $provider['quality_rating'] . '</span>
                                        <span class="provider-stat-label">Rating</span>
                                    </div>
                                </div>
                            </div>';
        }

        echo '
                        </div>
                    </div>

                    <div class="technology-info">
                        <h3>Advanced Streaming Technology</h3>
                        <div class="tech-grid">
                            <div class="tech-item">
                                <i class="fas fa-video tech-icon"></i>
                                <h4 class="tech-title">HD Streaming</h4>
                                <p class="tech-description">Crystal clear 1080p-4K video quality with 60fps for smooth gameplay</p>
                            </div>
                            <div class="tech-item">
                                <i class="fas fa-mobile-alt tech-icon"></i>
                                <h4 class="tech-title">Mobile Optimized</h4>
                                <p class="tech-description">Perfect performance on iOS and Android devices with touch controls</p>
                            </div>
                            <div class="tech-item">
                                <i class="fas fa-globe tech-icon"></i>
                                <h4 class="tech-title">Multi-Language</h4>
                                <p class="tech-description">Professional dealers speaking 40+ languages from global studios</p>
                            </div>
                            <div class="tech-item">
                                <i class="fas fa-shield-alt tech-icon"></i>
                                <h4 class="tech-title">Certified Fair</h4>
                                <p class="tech-description">All games certified by independent testing labs for fairness</p>
                            </div>
                        </div>
                    </div>

                    <div class="view-all-section">
                        <a href="/live-dealer-games" class="view-all-live-btn">
                            <i class="fas fa-video"></i> Explore All Live Casino Games
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Payment Methods Guide Section -->
        <section class="payment-methods-section">
            <div class="container">
                <div class="payment-methods-content">
                    <div class="payment-methods-header">
                        <h2>🏦 Secure Payment Methods</h2>
                        <p class="payment-subtitle">
                            Choose from 15+ trusted payment options designed for Canadian players. All methods feature 
                            bank-level security, competitive processing times, and transparent fee structures.
                        </p>
                        
                        <div class="payment-stats">
                            <div class="payment-stat-item">
                                <span class="payment-stat-number">' . $paymentMethodsData['statistics']['total_methods'] . '</span>
                                <span class="payment-stat-label">Payment Methods</span>
                            </div>
                            <div class="payment-stat-item">
                                <span class="payment-stat-number">' . $paymentMethodsData['statistics']['instant_methods'] . '</span>
                                <span class="payment-stat-label">Instant Methods</span>
                            </div>
                            <div class="payment-stat-item">
                                <span class="payment-stat-number">' . $paymentMethodsData['statistics']['free_methods'] . '</span>
                                <span class="payment-stat-label">Free Methods</span>
                            </div>
                            <div class="payment-stat-item">
                                <span class="payment-stat-number">' . $paymentMethodsData['statistics']['canadian_methods'] . '</span>
                                <span class="payment-stat-label">Canadian Methods</span>
                            </div>
                        </div>
                    </div>

                    <div class="category-tabs">
                        <button class="category-tab active" data-category="all">All Methods</button>
                        <button class="category-tab" data-category="credit_debit">Credit Cards</button>
                        <button class="category-tab" data-category="e_wallet">E-Wallets</button>
                        <button class="category-tab" data-category="bank_transfer">Bank Transfer</button>
                        <button class="category-tab" data-category="mobile">Mobile Pay</button>
                        <button class="category-tab" data-category="crypto">Cryptocurrency</button>
                    </div>

                    <div class="payment-methods-grid">';

        $featuredMethods = ['interac', 'visa', 'mastercard', 'paypal', 'skrill', 'neteller', 'bitcoin', 'apple_pay'];
        foreach ($featuredMethods as $methodId) {
            if (isset($paymentMethodsData['methods'][$methodId])) {
                $method = $paymentMethodsData['methods'][$methodId];
                echo '
                        <div class="payment-method-card" data-category="' . $method['category'] . '">
                            <div class="payment-method-header">
                                <div class="payment-logo">
                                    <img src="' . htmlspecialchars($method['logo']) . '" alt="' . htmlspecialchars($method['name']) . '" loading="lazy">
                                </div>
                                <div class="payment-name">
                                    <h3>' . htmlspecialchars($method['name']) . '</h3>';
                
                if ($method['canadian_specific']) {
                    echo '
                                    <span class="canadian-badge">🍁 Canadian</span>';
                }
                
                echo '
                                </div>
                                <div class="trust-rating">
                                    <span class="rating-score">' . $method['trust_rating'] . '</span>
                                    <div class="rating-stars">';
                
                for ($i = 1; $i <= 5; $i++) {
                    $activeClass = $i <= floor($method['trust_rating']) ? 'active' : '';
                    echo '
                                        <i class="fas fa-star ' . $activeClass . '"></i>';
                }
                
                echo '
                                    </div>
                                </div>
                            </div>
                            
                            <div class="payment-method-info">
                                <p class="payment-description">' . htmlspecialchars($method['description']) . '</p>
                                
                                <div class="payment-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Deposit Time:</span>
                                        <span class="detail-value processing-time">' . htmlspecialchars($method['processing_time']['deposit']) . '</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Withdrawal Time:</span>
                                        <span class="detail-value processing-time">' . htmlspecialchars($method['processing_time']['withdrawal']) . '</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Deposit Fee:</span>
                                        <span class="detail-value fee">' . htmlspecialchars($method['fees']['deposit']) . '</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Withdrawal Fee:</span>
                                        <span class="detail-value fee">' . htmlspecialchars($method['fees']['withdrawal']) . '</span>
                                    </div>
                                </div>
                                
                                <div class="payment-limits">
                                    <h4>Transaction Limits</h4>
                                    <div class="limits-grid">
                                        <div class="limit-item">
                                            <span class="limit-label">Min Deposit:</span>
                                            <span class="limit-value">$' . number_format($method['limits']['min_deposit']) . '</span>
                                        </div>
                                        <div class="limit-item">
                                            <span class="limit-label">Max Deposit:</span>
                                            <span class="limit-value">$' . number_format($method['limits']['max_deposit']) . '</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="payment-features">
                                    <h4>Key Features</h4>
                                    <ul class="features-list">';
                
                foreach (array_slice($method['features'], 0, 3) as $feature) {
                    echo '
                                        <li><i class="fas fa-check"></i> ' . htmlspecialchars($feature) . '</li>';
                }
                
                echo '
                                    </ul>
                                </div>
                                
                                <div class="security-certifications">';
                
                foreach ($method['security_certifications'] as $cert) {
                    echo '
                                    <span class="security-badge">' . htmlspecialchars($cert) . '</span>';
                }
                
                echo '
                                </div>
                                
                                <div class="payment-actions">
                                    <button class="learn-more-btn" onclick="viewPaymentMethodDetails(\'' . htmlspecialchars($method['id']) . '\')">
                                        <i class="fas fa-info-circle"></i> Learn More
                                    </button>
                                    <button class="use-method-btn" onclick="usePaymentMethod(\'' . htmlspecialchars($method['id']) . '\')">
                                        <i class="fas fa-credit-card"></i> Use This Method
                                    </button>
                                </div>
                            </div>
                        </div>';
            }
        }

        echo '
                    </div>

                    <div class="security-trust-section">
                        <h3>🔒 Security & Trust Features</h3>
                        <div class="security-features-grid">
                            <div class="security-feature-item">
                                <div class="security-feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h4 class="security-feature-title">SSL 256-bit Encryption</h4>
                                <p class="security-feature-description">Bank-level encryption protecting all transactions and personal data</p>
                            </div>
                            <div class="security-feature-item">
                                <div class="security-feature-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                                <h4 class="security-feature-title">PCI DSS Compliance</h4>
                                <p class="security-feature-description">Payment Card Industry security standards for safe transactions</p>
                            </div>
                            <div class="security-feature-item">
                                <div class="security-feature-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <h4 class="security-feature-title">Two-Factor Authentication</h4>
                                <p class="security-feature-description">Additional security layer for account protection</p>
                            </div>
                            <div class="security-feature-item">
                                <div class="security-feature-icon">
                                    <i class="fas fa-maple-leaf"></i>
                                </div>
                                <h4 class="security-feature-title">CDIC Protection</h4>
                                <p class="security-feature-description">Canadian Deposit Insurance Corporation coverage for banking methods</p>
                            </div>
                        </div>
                    </div>

                    <div class="canadian-banking-section">
                        <h3><i class="fas fa-maple-leaf"></i> Canadian Banking Integration</h3>
                        <p class="canadian-banking-description">
                            All major Canadian banks and financial institutions are supported. Enjoy seamless integration 
                            with your existing banking relationships and trusted Canadian payment solutions.
                        </p>
                        <div class="canadian-methods-showcase">
                            <div class="canadian-method-item">
                                <div class="canadian-method-name">Interac e-Transfer</div>
                                <div class="canadian-method-description">Direct bank account access with instant deposits</div>
                            </div>
                            <div class="canadian-method-item">
                                <div class="canadian-method-name">Canadian Banks</div>
                                <div class="canadian-method-description">RBC, TD, BMO, Scotia, CIBC, and all major banks</div>
                            </div>
                            <div class="canadian-method-item">
                                <div class="canadian-method-name">CDIC Protection</div>
                                <div class="canadian-method-description">Government-backed deposit insurance coverage</div>
                            </div>
                            <div class="canadian-method-item">
                                <div class="canadian-method-name">CAD Currency</div>
                                <div class="canadian-method-description">No conversion fees, all transactions in Canadian dollars</div>
                            </div>
                        </div>
                    </div>

                    <div class="view-all-payment-methods">
                        <a href="/payment-methods" class="view-all-payment-btn">
                            <i class="fas fa-credit-card"></i> View All Payment Methods Guide
                        </a>
                    </div>
                </div>
            </div>
        </section>';

        // Mobile App Section (PRD #13)
        $mobileAppService = new \App\Services\MobileAppService();
        $mobileApps = $mobileAppService->getFeaturedMobileApps();
        $mobileAdvantages = $mobileAppService->getMobileAdvantages();
        $mobileStats = $mobileAppService->getMobileStats();
        
        echo '
        <section class="mobile-app-section">
            <div class="container">
                <div class="mobile-app-content">
                    <div class="mobile-app-header">
                        <h2>📱 Best Mobile Casino Apps</h2>
                        <p class="mobile-app-subtitle">
                            Experience seamless gaming on the go with our top-rated mobile casino apps. 
                            Optimized for iOS and Android with exclusive mobile bonuses.
                        </p>
                        
                        <div class="mobile-app-stats">';
        
        foreach ($mobileStats as $stat) {
            echo '
                            <div class="mobile-stat-item">
                                <span class="mobile-stat-number">' . htmlspecialchars($stat['number']) . '</span>
                                <span class="mobile-stat-label">' . htmlspecialchars($stat['label']) . '</span>
                            </div>';
        }
        
        echo '
                        </div>
                    </div>
                    
                    <div class="platform-tabs">
                        <button class="platform-tab active" data-platform="all">All Platforms</button>
                        <button class="platform-tab" data-platform="ios">iOS Apps</button>
                        <button class="platform-tab" data-platform="android">Android Apps</button>
                        <button class="platform-tab" data-platform="pwa">Web Apps</button>
                    </div>
                    
                    <div class="mobile-apps-grid">';
        
        foreach ($mobileApps as $app) {
            echo '
                        <div class="mobile-app-card" data-platform="' . implode(' ', $app['platforms']) . '">
                            <div class="mobile-app-header">
                                <div class="app-icon">
                                    <img src="' . htmlspecialchars($app['icon']) . '" alt="' . htmlspecialchars($app['name']) . ' App Icon">
                                </div>
                                <div class="app-title-section">
                                    <h3 class="app-name">' . htmlspecialchars($app['name']) . '</h3>
                                    <p class="app-company">' . htmlspecialchars($app['company']) . '</p>
                                    <div class="app-rating">
                                        <div class="rating-stars">';
                                        
            $rating = $app['ratings']['average'];
            for ($i = 1; $i <= 5; $i++) {
                $activeClass = $i <= $rating ? 'active' : '';
                echo '
                                            <i class="fas fa-star ' . $activeClass . '"></i>';
            }
            
            echo '
                                        </div>
                                        <span class="rating-score">' . $rating . '</span>
                                        <span class="rating-count">(' . number_format($app['reviews']['total']) . ')</span>
                                    </div>
                                </div>
                                <div class="platform-badges">';
                                
            foreach ($app['platforms'] as $platform) {
                echo '
                                    <span class="platform-badge platform-' . $platform . '">' . ucfirst($platform) . '</span>';
            }
            
            echo '
                                </div>
                            </div>
                            
                            <div class="mobile-app-info">
                                <p class="app-description">' . htmlspecialchars($app['description']) . '</p>
                                
                                <div class="app-details">
                                    <div class="detail-row">
                                        <span class="detail-label">App Size:</span>
                                        <span class="detail-value">' . htmlspecialchars($app['file_size']['ios'] ?? 'Varies') . '</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Version:</span>
                                        <span class="detail-value">' . htmlspecialchars($app['version']['ios'] ?? 'Latest') . '</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Developer:</span>
                                        <span class="detail-value">' . htmlspecialchars($app['company']) . '</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Last Update:</span>
                                        <span class="detail-value">' . htmlspecialchars($app['last_updated']) . '</span>
                                    </div>
                                </div>';
                                
            if (!empty($app['mobile_bonus'])) {
                echo '
                                <div class="mobile-bonus-highlight">
                                    <h4>📱 Mobile Exclusive Bonus</h4>
                                    <div class="bonus-amount">' . htmlspecialchars($app['mobile_bonus']['amount']) . '</div>
                                    <div class="bonus-description">' . htmlspecialchars($app['mobile_bonus']['description']) . '</div>';
                    
                if (!empty($app['mobile_bonus']['code'])) {
                    echo '
                                    <div class="bonus-code">Code: ' . htmlspecialchars($app['mobile_bonus']['code']) . '</div>';
                }
                
                echo '
                                </div>';
            }
            
            echo '
                                <div class="app-features">
                                    <h4>Key Features:</h4>
                                    <ul class="features-list">';
                                    
            foreach ($app['features'] as $feature) {
                echo '
                                        <li><i class="fas fa-check"></i> ' . htmlspecialchars($feature) . '</li>';
            }
            
            echo '
                                    </ul>
                                </div>
                                
                                <div class="download-section">
                                    <div class="qr-codes">';
                                    
            if (in_array('ios', $app['platforms'])) {
                echo '
                                        <div class="qr-code">
                                            <img src="' . htmlspecialchars($app['qr_codes']['ios']) . '" alt="iOS QR Code">
                                            <span>iOS</span>
                                        </div>';
            }
            
            if (in_array('android', $app['platforms'])) {
                echo '
                                        <div class="qr-code">
                                            <img src="' . htmlspecialchars($app['qr_codes']['android']) . '" alt="Android QR Code">
                                            <span>Android</span>
                                        </div>';
            }
            
            echo '
                                    </div>
                                    
                                    <div class="download-buttons">';
                                    
            if (in_array('ios', $app['platforms'])) {
                echo '
                                        <a href="' . htmlspecialchars($app['app_store_links']['ios']) . '" class="download-btn platform-ios">
                                            <i class="fab fa-apple"></i>
                                            Download for iOS
                                        </a>';
            }
            
            if (in_array('android', $app['platforms'])) {
                echo '
                                        <a href="' . htmlspecialchars($app['app_store_links']['android']) . '" class="download-btn platform-android">
                                            <i class="fab fa-google-play"></i>
                                            Download for Android
                                        </a>';
            }
            
            if (in_array('pwa', $app['platforms'])) {
                echo '
                                        <a href="' . htmlspecialchars($app['app_store_links']['pwa']) . '" class="download-btn platform-pwa">
                                            <i class="fas fa-globe"></i>
                                            Open Web App
                                        </a>';
            }
            
            echo '
                                    </div>
                                </div>
                            </div>
                        </div>';
        }
        
        echo '
                    </div>
                    
                    <div class="mobile-advantages-section">
                        <h2>🚀 Why Choose Mobile Casinos?</h2>
                        <div class="advantages-grid">';
                        
        foreach ($mobileAdvantages as $advantage) {
            echo '
                            <div class="advantage-item">
                                <i class="' . htmlspecialchars($advantage['icon']) . ' advantage-icon"></i>
                                <h3>' . htmlspecialchars($advantage['title']) . '</h3>
                                <p>' . htmlspecialchars($advantage['description']) . '</p>
                            </div>';
        }
        
        echo '
                        </div>
                    </div>
                    
                    <div class="view-all-mobile-apps">
                        <a href="/mobile-apps" class="view-all-mobile-btn">
                            <i class="fas fa-mobile-alt"></i>
                            View All Mobile Apps
                        </a>
                    </div>
                </div>
            </div>
        </section>';

        // News & Updates Section (PRD #14)
        echo '
        <section class="news-updates-homepage-section">
            <div class="container">
                <div class="news-section-header">
                    <h2>📰 Latest Casino News & Updates</h2>
                    <p class="news-section-subtitle">
                        Stay informed with the latest developments in the Canadian online casino industry. 
                        From new game releases to regulatory updates, we cover everything that matters.
                    </p>
                    
                    <div class="news-stats-bar">';
        
        foreach ($newsData['news_statistics'] as $stat) {
            echo '
                        <div class="news-stat-item">
                            <span class="news-stat-number">' . htmlspecialchars($stat['number']) . '</span>
                            <span class="news-stat-label">' . htmlspecialchars($stat['label']) . '</span>
                        </div>';
        }
        
        echo '
                    </div>
                </div>
                
                <div class="featured-news-row">';
        
        foreach (array_slice($newsData['featured_articles'], 0, 3) as $index => $article) {
            $isMajor = $index === 0;
            $cardClass = $isMajor ? 'featured-news-card major' : 'featured-news-card';
            
            echo '
                    <article class="' . $cardClass . '">
                        <div class="news-image">
                            <img src="' . htmlspecialchars($article['featured_image']) . '" alt="' . htmlspecialchars($article['title']) . '">
                            <span class="news-category">' . htmlspecialchars(ucwords(str_replace('-', ' ', $article['category']))) . '</span>
                        </div>
                        <div class="news-content">
                            <h3><a href="/news/' . htmlspecialchars($article['slug']) . '">' . htmlspecialchars($article['title']) . '</a></h3>
                            <p class="news-excerpt">' . htmlspecialchars($article['excerpt']) . '</p>
                            <div class="news-meta">
                                <div class="author-info">
                                    <img src="' . htmlspecialchars($article['author']['avatar']) . '" alt="' . htmlspecialchars($article['author']['name']) . '">
                                    <span>' . htmlspecialchars($article['author']['name']) . '</span>
                                </div>
                                <span class="news-date">' . date('M j, Y', strtotime($article['publication_date'])) . '</span>
                                <span class="reading-time">' . htmlspecialchars($article['reading_time']) . '</span>
                            </div>
                        </div>
                    </article>';
        }
        
        echo '
                </div>
                
                <div class="latest-updates-row">
                    <h3>Latest Updates</h3>
                    <div class="updates-grid">';
        
        foreach ($newsData['latest_updates'] as $update) {
            echo '
                        <article class="update-card">
                            <div class="update-meta">
                                <span class="update-category">' . htmlspecialchars(ucwords(str_replace('-', ' ', $update['category']))) . '</span>
                                <span class="update-date">' . date('M j', strtotime($update['publication_date'])) . '</span>
                            </div>
                            <h4><a href="/news/' . htmlspecialchars($update['slug']) . '">' . htmlspecialchars($update['title']) . '</a></h4>
                            <p class="update-excerpt">' . htmlspecialchars(substr($update['excerpt'], 0, 100)) . '...</p>
                            <span class="reading-time">' . htmlspecialchars($update['reading_time']) . '</span>
                        </article>';
        }
        
        echo '
                    </div>
                </div>
                
                <div class="view-all-news">
                    <a href="/news" class="view-all-news-btn">
                        <i class="fas fa-newspaper"></i>
                        View All News & Updates
                    </a>
                </div>
            </div>
        </section>

        <!-- Canadian Provinces Section (PRD #24) -->';
        
        try {
            // Direct service call for debugging
            $provinces = $provincesService->getTopProvincesByCasinoCount(6);
            $statistics = $provincesService->getProvinceStatistics();
            
            echo '<section class="provinces-section" id="canadian-provinces">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Canadian Provinces & Territories</h2>
            <p class="section-subtitle">
                Explore online casino options across all ' . $statistics['total_provinces'] . ' provinces and ' . $statistics['total_territories'] . ' territories.
            </p>
        </div>
        <div class="provinces-grid">';
            
            foreach ($provinces as $province) {
                echo '<div class="province-card">
                    <h3>' . htmlspecialchars($province['name']) . '</h3>
                    <p>Legal Age: ' . $province['gambling_age'] . '+</p>
                    <p>Casinos: ' . $province['casino_count'] . '</p>
                    <p>Top Casino: ' . htmlspecialchars($province['top_casino']) . '</p>
                </div>';
            }
            
            echo '</div>
        <div class="section-footer">
            <a href="/provinces" class="btn btn-outline btn-large">
                View All ' . ($statistics['total_provinces'] + $statistics['total_territories']) . ' Provinces & Territories
            </a>
        </div>
    </div>
</section>';
            
        } catch (Exception $e) {
            echo '<div class="error">Unable to load provinces section: ' . htmlspecialchars($e->getMessage()) . '</div>';
            error_log('Provinces section error: ' . $e->getMessage());
        }
        
        echo '
        
        <!-- Software Providers Section (PRD #17) -->
        <section class="providers-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Top Casino Software Providers</h2>
                    <p class="section-subtitle">
                        Discover the world\'s leading casino software providers powering Canada\'s most trusted online casinos. 
                        From innovative slot games to cutting-edge live dealer experiences, these industry giants deliver 
                        the highest quality gaming entertainment with unmatched reliability and fairness.
                    </p>
                </div>

                <div class="providers-overview">
                    <div class="overview-stats">
                        <div class="overview-stat">
                            <span class="number">' . $softwareProvidersData['total_providers'] . '</span>
                            <span class="label">Licensed Providers</span>
                        </div>
                        <div class="overview-stat">
                            <span class="number">' . $softwareProvidersData['statistics']['total_games'] . '+</span>
                            <span class="label">Games Available</span>
                        </div>
                        <div class="overview-stat">
                            <span class="number">' . count($softwareProvidersData['categories']) . '</span>
                            <span class="label">Game Categories</span>
                        </div>
                        <div class="overview-stat">
                            <span class="number">' . $softwareProvidersData['statistics']['casino_partnerships'] . '+</span>
                            <span class="label">Casino Partnerships</span>
                        </div>
                    </div>
                    
                    <div class="provider-categories">
                        <a href="/providers" class="category-filter active">All Providers</a>';
                        
                        foreach ($softwareProvidersData['categories'] as $category) {
                            echo '<a href="/providers?category=' . urlencode($category) . '" class="category-filter">' . htmlspecialchars($category) . '</a>';
                        }
                        
                        echo '
                    </div>
                </div>

                <div class="providers-container">
                    <div class="providers-grid">';
                    
                    foreach ($softwareProvidersData['featured_providers'] as $slug => $provider) {
                        echo '
                        <div class="provider-card">
                            <div class="provider-header">
                                <img src="/images/providers/' . strtolower(str_replace([' ', '.'], '-', $provider['name'])) . '.svg" 
                                     alt="' . htmlspecialchars($provider['name']) . ' Logo" 
                                     class="provider-logo">
                                <div class="provider-info">
                                    <h3>' . htmlspecialchars($provider['name']) . '</h3>
                                    <p class="founded">Founded ' . $provider['founded'] . '</p>
                                </div>
                            </div>

                            <div class="provider-stats">
                                <div class="stat">
                                    <span class="label">Games</span>
                                    <span class="value">' . $provider['game_count'] . '+</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Rating</span>
                                    <span class="value">' . ($provider['rating'] ?? '4.5') . '/5</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Casinos</span>
                                    <span class="value">' . ($provider['casino_count'] ?? '25') . '+</span>
                                </div>
                            </div>

                            <div class="provider-specialties">';
                            
                            foreach (array_slice($provider['specialties'], 0, 3) as $specialty) {
                                echo '<span class="specialty-tag">' . htmlspecialchars($specialty) . '</span>';
                            }
                            
                            echo '
                            </div>

                            <p class="provider-description">
                                ' . htmlspecialchars(substr($provider['description'], 0, 150)) . '...
                            </p>

                            <a href="/providers/' . strtolower(str_replace([' ', '.'], '-', $provider['name'])) . '" 
                               class="btn-view-provider">
                                View Provider Details
                            </a>
                        </div>';
                    }
                    
                    echo '
                    </div>
                    
                    <div class="view-all-providers">
                        <a href="/providers" class="view-all-providers-btn">
                            <i class="fas fa-code"></i>
                            View All Software Providers
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Legal Status & Regulation Section (PRD #18) -->
        <section class="legal-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">🏛️ Legal Status & Regulation in Canada</h2>
                    <p class="section-subtitle">
                        Complete transparency about online gambling laws, regulations, and licensing authorities. 
                        Understand the legal framework that protects Canadian players and ensures safe gaming.
                    </p>
                </div>

                <!-- Legal Summary Widget -->
                <div class="legal-summary-widget">
                    <h3>⚖️ Canadian Online Gambling - Quick Legal Overview</h3>
                    <div class="legal-highlights">
                        <div class="legal-highlight">
                            <div class="icon">✅</div>
                            <div class="label">Legal Status</div>
                            <div class="value">' . htmlspecialchars($legalStatusData['legal_summary']['status']) . '</div>
                        </div>
                        <div class="legal-highlight">
                            <div class="icon">🎰</div>
                            <div class="label">Licensed Casinos</div>
                            <div class="value">' . $legalStatusData['legal_summary']['total_casinos'] . '+</div>
                        </div>
                        <div class="legal-highlight">
                            <div class="icon">🏢</div>
                            <div class="label">Local Casinos</div>
                            <div class="value">' . $legalStatusData['legal_summary']['local_casinos'] . '</div>
                        </div>
                        <div class="legal-highlight">
                            <div class="icon">🎂</div>
                            <div class="label">Min Age</div>
                            <div class="value">' . htmlspecialchars($legalStatusData['legal_summary']['gambling_age']) . '</div>
                        </div>
                    </div>
                </div>

                <!-- Comprehensive Legal Status Table -->
                <div class="legal-status-table">
                    <div class="legal-row">
                        <div class="legal-label">⚖️ Legal Status</div>
                        <div class="legal-value legal-status-legal">' . htmlspecialchars($legalStatusData['legal_summary']['status']) . '</div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">🎰 Number of Casinos</div>
                        <div class="legal-value">' . $legalStatusData['legal_summary']['total_casinos'] . '+</div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">🔎 Authorities</div>
                        <div class="legal-value">';
                        
                        foreach ($legalStatusData['legal_summary']['authorities'] as $authority) {
                            echo '<span class="authority-tag">' . htmlspecialchars($authority) . '</span>';
                        }
                        
                        echo '
                        </div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">🏢 Local Casinos</div>
                        <div class="legal-value">' . $legalStatusData['legal_summary']['local_casinos'] . '</div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">💰 Min Deposit</div>
                        <div class="legal-value">' . htmlspecialchars($legalStatusData['legal_summary']['min_deposit']) . '</div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">💳 Payment Methods</div>
                        <div class="legal-value">' . (is_array($legalStatusData['legal_summary']['payment_methods'] ?? null) ? implode(', ', $legalStatusData['legal_summary']['payment_methods']) : 'Visa, Mastercard, Interac') . '</div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">🎮 Popular Games</div>
                        <div class="legal-value">' . (is_array($legalStatusData['legal_summary']['popular_games'] ?? null) ? implode(', ', $legalStatusData['legal_summary']['popular_games']) : 'Slots, Blackjack, Roulette') . '</div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">🏆 Best Casino</div>
                        <div class="legal-value">
                            <a href="/casinos/jackpot-city" class="best-casino-link">' . htmlspecialchars($legalStatusData['legal_summary']['best_casino']) . '</a>
                        </div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">🎁 Biggest Bonus</div>
                        <div class="legal-value">' . htmlspecialchars($legalStatusData['legal_summary']['biggest_bonus']) . '</div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">🎂 Gambling Age</div>
                        <div class="legal-value">' . htmlspecialchars($legalStatusData['legal_summary']['gambling_age']) . '</div>
                    </div>
                    <div class="legal-row">
                        <div class="legal-label">💰 Tax</div>
                        <div class="legal-value">' . htmlspecialchars($legalStatusData['legal_summary']['tax_info']) . '</div>
                    </div>
                </div>

                <div class="view-all-legal">
                    <a href="/legal-status" class="view-all-legal-btn">
                        <i class="fas fa-gavel"></i>
                        View Complete Legal Guide
                    </a>
                </div>
            </div>
        </section>

        <!-- How We Review Section (PRD #19) -->
        <section class="methodology-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">How We Review Online Casinos</h2>
                    <p class="section-subtitle">
                        Our expert team follows a rigorous 7-point methodology to evaluate every aspect of online casinos, 
                        ensuring you get honest, unbiased reviews you can trust.
                    </p>
                </div>
                
                <div class="methodology-overview">
                    <div class="methodology-stats">
                        <div class="stat-item">
                            <span class="stat-number">7</span>
                            <span class="stat-label">Review Criteria</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">3</span>
                            <span class="stat-label">Expert Reviewers</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">14-21</span>
                            <span class="stat-label">Days Per Review</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">200+</span>
                            <span class="stat-label">Annual Reviews</span>
                        </div>
                    </div>
                </div>
                
                <div class="criteria-grid">
                    <div class="criteria-card security">
                        <div class="criteria-icon">🔒</div>
                        <h4>Security & Fairness</h4>
                        <div class="criteria-weight">20%</div>
                        <p>License verification, SSL encryption, RNG certification, responsible gambling tools</p>
                    </div>
                    
                    <div class="criteria-card bonuses">
                        <div class="criteria-icon">🎁</div>
                        <h4>Bonuses & Promotions</h4>
                        <div class="criteria-weight">15%</div>
                        <p>Welcome bonus value, wagering requirements, ongoing promotions, loyalty programs</p>
                    </div>
                    
                    <div class="criteria-card games">
                        <div class="criteria-icon">🎮</div>
                        <h4>Games & Software</h4>
                        <div class="criteria-weight">15%</div>
                        <p>Game variety, software providers, game quality, mobile compatibility</p>
                    </div>
                    
                    <div class="criteria-card customer-service">
                        <div class="criteria-icon">🎧</div>
                        <h4>Customer Service</h4>
                        <div class="criteria-weight">15%</div>
                        <p>Support availability, response times, channel options, staff knowledge</p>
                    </div>
                    
                    <div class="criteria-card banking">
                        <div class="criteria-icon">💳</div>
                        <h4>Banking & Payouts</h4>
                        <div class="criteria-weight">15%</div>
                        <p>Payment method variety, processing speeds, withdrawal limits, fees</p>
                    </div>
                    
                    <div class="criteria-card localization">
                        <div class="criteria-icon">🇨🇦</div>
                        <h4>Localization</h4>
                        <div class="criteria-weight">10%</div>
                        <p>Canadian focus, local payment methods, currency support, regional compliance</p>
                    </div>
                    
                    <div class="criteria-card mobile">
                        <div class="criteria-icon">📱</div>
                        <h4>Mobile Experience</h4>
                        <div class="criteria-weight">10%</div>
                        <p>Mobile site quality, app availability, mobile game selection, touch optimization</p>
                    </div>
                </div>
                
                <div class="methodology-actions">
                    <a href="/review-methodology" class="view-all-btn primary">
                        <i class="fas fa-search"></i>
                        View Complete Methodology
                    </a>
                    <a href="/expert-team" class="view-all-btn secondary">
                        <i class="fas fa-users"></i>
                        Meet Our Expert Team
                    </a>
                </div>
            </div>
        </section>

        ' . $bonusDatabaseSection . '
        
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Casino Reviews</h3>
                    <a href="/reviews">All Casino Reviews</a>
                    <a href="/reviews/bonrush">BonRush Review</a>
                    <a href="/reviews/slotsvil">SLOTSVIL Review</a>
                    <a href="/reviews/casinojoy">CASINOJOY Review</a>
                    <a href="/reviews/slotimo">SLOTIMO Review</a>
                </div>
                <div class="footer-section">
                    <h3>Casino Games</h3>
                    <a href="/slots">Online Slots</a>
                    <a href="/blackjack">Blackjack</a>
                    <a href="/roulette">Roulette</a>
                    <a href="/poker">Poker</a>
                    <a href="/baccarat">Baccarat</a>
                </div>
                <div class="footer-section">
                    <h3>Bonuses</h3>
                    <a href="/bonus">All Bonuses</a>
                    <a href="/no-deposit">No Deposit Bonuses</a>
                    <a href="/minimum-deposit/1-dollar-deposit-casinos">$1 Deposit Casinos</a>
                    <a href="/minimum-deposit/5-dollar-deposit-casinos">$5 Deposit Casinos</a>
                    <a href="/minimum-deposit/10-dollar-deposit-casinos">$10 Deposit Casinos</a>
                </div>
                <div class="footer-section">
                    <h3>Our Experts</h3>
                    <a href="/authors">Meet Our Team</a>
                    <a href="/authors/sarah-mitchell">Sarah Mitchell</a>
                    <a href="/authors/david-thompson">David Thompson</a>
                    <a href="/authors/jennifer-carter">Jennifer Carter</a>
                    <a href="/about">About Us</a>
                </div>
                <div class="footer-section">
                    <h3>Canadian Provinces</h3>
                    <a href="/regions/ontario">Ontario</a>
                    <a href="/regions/british-columbia">British Columbia</a>
                    <a href="/regions/alberta">Alberta</a>
                    <a href="/regions/quebec">Quebec</a>
                    <a href="/regions">View all regions</a>
                </div>
                <div class="footer-section">
                    <h3>Legal & Help</h3>
                    <a href="/privacy-policy">Privacy Policy</a>
                    <a href="/terms-and-conditions">Terms & Conditions</a>
                    <a href="/problem-gambling">Problem Gambling</a>
                    <a href="/sitemap">Sitemap</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Casino.ca</p>
                <p>1918 St. Regis Blvd, Montreal, Dorval, QC H9P 1H6, Canada</p>
                <p>Copyright © 2012 - 2025 Casino.ca | All rights reserved</p>
                <p>Gambling can be addictive, please play responsibly. 19+</p>
            </div>
        </div>
    </footer>

    <script>
        // Featured Casino Spotlight Carousel JavaScript (PRD #03)
        let currentSlide = 0;
        let autoRotateTimer = null;
        const slides = document.querySelectorAll(\'.carousel-slide\');
        const indicators = document.querySelectorAll(\'.indicator\');
        const totalSlides = slides.length;
        
        // Configuration from PHP
        const carouselConfig = {
            autoRotate: ' . ($carouselConfig['auto_rotate'] ? 'true' : 'false') . ',
            rotationSpeed: ' . $carouselConfig['rotation_speed'] . ',
            transitionDuration: ' . $carouselConfig['transition_duration'] . ',
            pauseOnHover: ' . ($carouselConfig['pause_on_hover'] ? 'true' : 'false') . '
        };
        
        function showSlide(index) {
            // Hide all slides
            slides.forEach(slide => slide.classList.remove(\'active\'));
            indicators.forEach(indicator => indicator.classList.remove(\'active\'));
            
            // Show current slide
            if (slides[index]) {
                slides[index].classList.add(\'active\');
                indicators[index].classList.add(\'active\');
            }
            
            currentSlide = index;
        }
        
        function moveCarousel(direction) {
            const newIndex = currentSlide + direction;
            
            if (newIndex >= totalSlides) {
                showSlide(0);
            } else if (newIndex < 0) {
                showSlide(totalSlides - 1);
            } else {
                showSlide(newIndex);
            }
            
            resetAutoRotate();
        }
        
        function goToSlide(index) {
            showSlide(index);
            resetAutoRotate();
        }
        
        function nextSlide() {
            moveCarousel(1);
        }
        
        function startAutoRotate() {
            if (carouselConfig.autoRotate) {
                autoRotateTimer = setInterval(nextSlide, carouselConfig.rotationSpeed);
            }
        }
        
        function stopAutoRotate() {
            if (autoRotateTimer) {
                clearInterval(autoRotateTimer);
                autoRotateTimer = null;
            }
        }
        
        function resetAutoRotate() {
            stopAutoRotate();
            startAutoRotate();
        }
        
        // Initialize carousel
        document.addEventListener(\'DOMContentLoaded\', function() {
            // Show first slide
            showSlide(0);
            
            // Start auto-rotation
            startAutoRotate();
            
            // Pause on hover if enabled
            if (carouselConfig.pauseOnHover) {
                const carousel = document.querySelector(\'.carousel-container\');
                if (carousel) {
                    carousel.addEventListener(\'mouseenter\', stopAutoRotate);
                    carousel.addEventListener(\'mouseleave\', startAutoRotate);
                }
            }
            
            // Touch/swipe support for mobile
            let touchStartX = 0;
            let touchEndX = 0;
            
            const carouselWrapper = document.querySelector(\'.carousel-wrapper\');
            if (carouselWrapper) {
                carouselWrapper.addEventListener(\'touchstart\', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                });
                
                carouselWrapper.addEventListener(\'touchend\', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                });
            }
            
            function handleSwipe() {
                const swipeThreshold = 50;
                const swipeDistance = touchEndX - touchStartX;
                
                if (Math.abs(swipeDistance) > swipeThreshold) {
                    if (swipeDistance > 0) {
                        moveCarousel(-1); // Swipe right, go to previous
                    } else {
                        moveCarousel(1); // Swipe left, go to next
                    }
                }
            }
        });
        
        // Analytics tracking for featured casino interactions
        function trackFeaturedCasinoClick(casinoId, action) {
            // Track featured casino interactions
            if (typeof gtag !== \'undefined\') {
                gtag(\'event\', \'featured_casino_click\', {
                    \'casino_id\': casinoId,
                    \'action\': action,
                    \'slide_position\': currentSlide
                });
            }
            
            // Console log for debugging
            console.log(\'Featured Casino Interaction:\', {
                casinoId: casinoId,
                action: action,
                slidePosition: currentSlide
            });
        }
        
        // Add click tracking to featured casino elements
        document.addEventListener(\'DOMContentLoaded\', function() {
            document.querySelectorAll(\'.featured-casino-card\').forEach(function(card) {
                const casinoId = card.closest(\'.carousel-slide\').dataset.casinoId;
                
                // Track clicks on casino cards
                card.addEventListener(\'click\', function(e) {
                    if (!e.target.closest(\'.btn\')) {
                        trackFeaturedCasinoClick(casinoId, \'card_click\');
                    }
                });
                
                // Track bonus button clicks
                card.querySelectorAll(\'.btn-primary\').forEach(function(btn) {
                    btn.addEventListener(\'click\', function() {
                        trackFeaturedCasinoClick(casinoId, \'bonus_click\');
                    });
                });
                
                // Track review button clicks
                card.querySelectorAll(\'.btn-secondary\').forEach(function(btn) {
                    btn.addEventListener(\'click\', function() {
                        trackFeaturedCasinoClick(casinoId, \'review_click\');
                    });
                });
            });
        });
    </script>
</body>
</html>';
    }
    
    private function getTopCasinos(): array {
        return [
            [
                'name' => 'BonRush',
                'established' => 2020,
                'rating' => 4.9,
                'rating_text' => 'Exceptional',
                'bonus' => '100% up to $500 + 100 Free Spins',
                'rtp' => '97.8%',
                'payout' => '0-24 hours',
                'games' => '2500+',
                'slug' => 'bonrush'
            ],
            [
                'name' => 'SLOTSVIL',
                'established' => 2019,
                'rating' => 4.9,
                'rating_text' => 'Exceptional',
                'bonus' => '200% up to $1000 + 200 Free Spins',
                'rtp' => '97.6%',
                'payout' => '0-24 hours',
                'games' => '3000+',
                'slug' => 'slotsvil'
            ],
            [
                'name' => 'CASINOJOY',
                'established' => 2021,
                'rating' => 4.9,
                'rating_text' => 'Exceptional',
                'bonus' => '150% up to $750 + 150 Free Spins',
                'rtp' => '97.4%',
                'payout' => '1-24 hours',
                'games' => '2200+',
                'slug' => 'casinojoy'
            ],
            [
                'name' => 'SLOTIMO',
                'established' => 2020,
                'rating' => 4.8,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $400 + 120 Free Spins',
                'rtp' => '97.2%',
                'payout' => '1-24 hours',
                'games' => '2800+',
                'slug' => 'slotimo'
            ],
            [
                'name' => 'NOVAJACKPOT',
                'established' => 2018,
                'rating' => 4.8,
                'rating_text' => 'Excellent',
                'bonus' => '300% up to $1500 + 300 Free Spins',
                'rtp' => '97.0%',
                'payout' => '1-2 days',
                'games' => '3500+',
                'slug' => 'novajackpot'
            ],
            [
                'name' => 'NEON54',
                'established' => 2019,
                'rating' => 4.8,
                'rating_text' => 'Excellent',
                'bonus' => '125% up to $600 + 180 Free Spins',
                'rtp' => '96.9%',
                'payout' => '1-2 days',
                'games' => '2700+',
                'slug' => 'neon54'
            ],
            [
                'name' => '666 Gambit',
                'established' => 2021,
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'bonus' => '200% up to $800 + 150 Free Spins',
                'rtp' => '96.8%',
                'payout' => '1-2 days',
                'games' => '2400+',
                'slug' => '666-gambit'
            ],
            [
                'name' => 'SPINIGHT',
                'established' => 2020,
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $500 + 100 Free Spins',
                'rtp' => '96.7%',
                'payout' => '1-2 days',
                'games' => '2600+',
                'slug' => 'spinight'
            ],
            [
                'name' => 'FUNBET',
                'established' => 2019,
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'bonus' => '150% up to $600 + 120 Free Spins',
                'rtp' => '96.6%',
                'payout' => '1-3 days',
                'games' => '2300+',
                'slug' => 'funbet'
            ],
            [
                'name' => 'GAMBLEZENS',
                'established' => 2020,
                'rating' => 4.6,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $400 + 100 Free Spins',
                'rtp' => '96.5%',
                'payout' => '1-3 days',
                'games' => '2100+',
                'slug' => 'gamblezens'
            ]
        ];
    }
    
    private function getFeaturedGames(): array {
        return [
            [
                'name' => 'Gates of Olympus Super Scatter',
                'provider' => 'Pragmatic Play',
                'rtp' => '96.5%',
                'icon' => '⚡'
            ],
            [
                'name' => 'Gates of Hades',
                'provider' => 'Pragmatic Play',
                'rtp' => '95.5%',
                'icon' => '🔥'
            ],
            [
                'name' => 'Cleopatra',
                'provider' => 'IGT',
                'rtp' => '95.7%',
                'icon' => '👑'
            ],
            [
                'name' => 'Buffalo',
                'provider' => 'Aristocrat Gaming',
                'rtp' => '95.96%',
                'icon' => '🦬'
            ],
            [
                'name' => 'The Wild Life',
                'provider' => 'IGT',
                'rtp' => '96.16%',
                'icon' => '🦁'
            ],
            [
                'name' => 'Da Vinci Diamonds',
                'provider' => 'IGT',
                'rtp' => '94.94%',
                'icon' => '💎'
            ],
            [
                'name' => 'Big Bass Splash',
                'provider' => 'Pragmatic Play',
                'rtp' => '96.71%',
                'icon' => '🎣'
            ],
            [
                'name' => 'Sweet Bonanza 1000',
                'provider' => 'Pragmatic Play',
                'rtp' => '96.53%',
                'icon' => '🍭'
            ]
        ];
    }
    
    private function getBonusCategories(): array {
        return [
            [
                'icon' => '🎁',
                'title' => 'Casino bonuses',
                'description' => 'Claim the top promotions and incentives offered by online casinos in Canada'
            ],
            [
                'icon' => '🆓',
                'title' => 'No deposit bonuses',
                'description' => 'Enjoy the thrill of playing for real money without risking your own'
            ],
            [
                'icon' => '💵',
                'title' => '$1 deposit casinos',
                'description' => 'Start small with Canadian online casinos that accept just $1'
            ],
            [
                'icon' => '💰',
                'title' => '$5 deposit casinos',
                'description' => 'Affordable access to games with a minimum deposit of only $5'
            ],
            [
                'icon' => '💸',
                'title' => '$10 deposit casinos',
                'description' => 'Get the most out of your budget with a minimum deposit of $10'
            ],
            [
                'icon' => '🎰',
                'title' => 'Free spins',
                'description' => 'Try new slot games with free spins bonuses'
            ]
        ];
    }
    
    /**
     * Get popular slots section data
     */
    private function getPopularSlotsSection(): array {
        $popularSlotsService = new \App\Services\PopularSlotsService();
        return $popularSlotsService->getPopularSlotsSection();
    }
    
    /**
     * Render popular slots section HTML
     */
    private function renderPopularSlotsSection(): string {
        $slotsData = $this->getPopularSlotsSection();
        
        ob_start();
        ?>
        <!-- Popular Slots Detailed Section -->
        <section class="popular-slots-section">
            <div class="container">
                <div class="section-header">
                    <h2>Popular Casino Slots</h2>
                    <p>Discover the most exciting slot games with top RTP rates and massive jackpots</p>
                </div>
                
                <div class="slots-categories">
                    <div class="category-tabs">
                        <button class="tab-btn active" data-category="all">All Slots</button>
                        <button class="tab-btn" data-category="new">New Releases</button>
                        <button class="tab-btn" data-category="popular">Most Popular</button>
                        <button class="tab-btn" data-category="jackpot">Progressive Jackpots</button>
                        <button class="tab-btn" data-category="megaways">Megaways</button>
                    </div>
                </div>
                
                <div class="slots-grid" id="popular-slots-grid">
                    <?php foreach (array_slice($slotsData['featured_slots'], 0, 8) as $slot): ?>
                        <div class="slot-card" data-category="<?php echo htmlspecialchars($slot['category']); ?>">
                            <div class="slot-image">
                                <div class="slot-provider"><?php echo htmlspecialchars($slot['provider']['name']); ?></div>
                                <div class="slot-title"><?php echo htmlspecialchars($slot['name']); ?></div>
                            </div>
                            <div class="slot-content">
                                <div class="slot-stats">
                                    <div class="stat">
                                        <span class="stat-label">RTP</span>
                                        <span class="stat-value"><?php echo $slot['rtp']; ?>%</span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-label">Max Win</span>
                                        <span class="stat-value"><?php echo $slot['max_win_formatted']; ?></span>
                                    </div>
                                    <div class="stat">
                                        <span class="stat-label">Volatility</span>
                                        <span class="stat-value"><?php echo ucfirst($slot['volatility']); ?></span>
                                    </div>
                                </div>
                                <div class="slot-features">
                                    <?php foreach (array_slice($slot['features'], 0, 3) as $feature): ?>
                                        <span class="feature-tag"><?php echo htmlspecialchars($feature); ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="slot-actions">
                                    <a href="/slots/<?php echo $slot['slug']; ?>" class="btn btn-secondary">Details</a>
                                    <a href="/casinos" class="btn btn-primary">Play Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="slots-features">
                    <div class="feature-highlights">
                        <div class="feature-item">
                            <div class="feature-icon">🎰</div>
                            <h3>High RTP Games</h3>
                            <p>Our selection features slots with RTPs above 96% for better winning chances</p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">💰</div>
                            <h3>Massive Jackpots</h3>
                            <p>Progressive slots with jackpots reaching millions of dollars</p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">⚡</div>
                            <h3>Instant Play</h3>
                            <p>No download required - play directly in your browser</p>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">📱</div>
                            <h3>Mobile Optimized</h3>
                            <p>Perfect gameplay on all devices - desktop, tablet, and mobile</p>
                        </div>
                    </div>
                </div>
                
                <div class="provider-showcase">
                    <h3>Top Slot Providers</h3>
                    <div class="provider-grid">
                        <?php foreach ($slotsData['providers'] as $provider): ?>
                            <div class="provider-item">
                                <div class="provider-logo"><?php echo htmlspecialchars($provider['name']); ?></div>
                                <p><?php echo htmlspecialchars($provider['short_description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="view-all-slots">
                    <a href="/slots" class="btn btn-primary btn-large">View All Slots</a>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Render detailed review card for homepage
     */
    private function renderDetailedReviewCard($review)
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
            $html = '
                <div class="app-ratings">
                    <span><i class="fab fa-google-play"></i> ' . htmlspecialchars($review['mobile_app']['play_store_rating']) . '</span>
                    <span><i class="fab fa-apple"></i> ' . htmlspecialchars($review['mobile_app']['app_store_rating']) . '</span>
                    <span><i class="fas fa-download"></i> ' . htmlspecialchars($review['mobile_app']['size']) . '</span>
                </div>';
        } else {
            $html = '
                <div class="app-info">
                    <span><i class="fas fa-mobile-alt"></i> ' . htmlspecialchars($review['mobile_app']['type']) . '</span>
                </div>';
        }
        
        $html .= '
            </div>
            
            <div class="detailed-ratings">
                <h4>Expert Ratings</h4>
                <div class="rating-bars">';
        
        $ratingCategories = [
            'security' => 'Security & Fairness',
            'games' => 'Games & Software', 
            'bonuses' => 'Bonuses & Promotions',
            'mobile' => 'Mobile Experience',
            'payments' => 'Banking & Payments',
            'support' => 'Customer Support'
        ];
        
        foreach ($review['category_ratings'] as $category => $rating) {
            $categoryName = $ratingCategories[$category] ?? ucfirst($category);
            $percentage = ($rating / 5) * 100;
            
            $html .= '
                    <div class="rating-bar">
                        <span class="category-name">' . htmlspecialchars($categoryName) . '</span>
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
     * Render Best Casinos by Category Table Section
     */
    private function renderCategoryComparisonSection($categoryComparisonData)
    {
        $categories = $categoryComparisonData['category_leaders'];
        $statistics = $categoryComparisonData['statistics'];
        
        ob_start();
        include __DIR__ . '/../Views/category-comparison/section.php';
        return ob_get_clean();
    }

    /**
     * Render Enhanced Detailed Reviews Section (PRD #23)
     */
    private function renderEnhancedDetailedReviewsSection($enhancedReviewsData): string
    {
        $reviews = $enhancedReviewsData['top_3_reviews'];
        $categories = $enhancedReviewsData['review_categories'];
        $insights = $enhancedReviewsData['expert_insights'];
        
        ob_start();
        include __DIR__ . '/../Views/enhanced-detailed-reviews/section.php';
        return ob_get_clean();
    }
}
