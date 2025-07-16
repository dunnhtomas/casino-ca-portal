<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\FeaturedCasinoService;
use App\Services\CasinoCategoriesService;

class HomeController extends Controller {
    public function index(): void {
        // Get casino data
        $topCasinos = $this->getTopCasinos();
        
        // Get comprehensive casino categories for navigation
        $categoriesService = new CasinoCategoriesService();
        $categories = $categoriesService->getAllCategories();
        
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
                    <div class="grid-casino-item"><div class="casino-mini-logo">JC</div><div class="casino-mini-name">Jackpot City</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">SP</div><div class="casino-mini-name">Spin Palace</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">LO</div><div class="casino-mini-name">Lucky Ones</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">RV</div><div class="casino-mini-name">Royal Vegas</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">PK</div><div class="casino-mini-name">PokerStars</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">RF</div><div class="casino-mini-name">Ruby Fortune</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">CC</div><div class="casino-mini-name">Captain Cooks</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">PS</div><div class="casino-mini-name">Pistolo</div></div>
                    <div class="grid-casino-item"><div class="casino-mini-logo">+82</div><div class="casino-mini-name">More Casinos</div></div>
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
        </section>

        <section class="section">
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

        <section class="section">
            <h2 class="section-title">Claim the best online casino bonuses</h2>
            <p>Bonuses are one of the best perks of playing casino games online. You could choose a free spins bonus, ideal for checking out new and exclusive slot games, or pick a rarer no deposit bonus and claim free casino cash with no upfront risk.</p>
            <div class="categories-grid">';
        
        foreach ($bonusCategories as $bonus) {
            echo '<div class="category-card">
                <div class="category-icon">' . $bonus['icon'] . '</div>
                <div class="category-title">' . $bonus['title'] . '</div>
                <div class="category-casino">' . $bonus['description'] . '</div>
            </div>';
        }
        
        echo '</div>
            <div class="view-all">
                <a href="/bonus" class="view-all-btn">Find all bonuses</a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Casino Reviews</h3>
                    <a href="/reviews">All Casino Reviews</a>
                    <a href="/reviews/jackpot-city">Jackpot City Review</a>
                    <a href="/reviews/spin-palace">Spin Palace Review</a>
                    <a href="/reviews/lucky-ones">Lucky Ones Review</a>
                    <a href="/reviews/pistolo">Pistolo Review</a>
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
                'name' => 'Jackpot City Casino',
                'established' => 1998,
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $4,000 + 210 Free Spins',
                'rtp' => '97.39%',
                'payout' => '1-3 days',
                'games' => '700+',
                'slug' => 'jackpot-city'
            ],
            [
                'name' => 'Spin Palace',
                'established' => 2001,
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $1,000 + 345 Bonus Spins',
                'rtp' => '97.45%',
                'payout' => '1-3 days',
                'games' => '1,000+',
                'slug' => 'spin-palace'
            ],
            [
                'name' => 'Lucky Ones',
                'established' => 2023,
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $20,000 + 500 Free Spins',
                'rtp' => '98.27%',
                'payout' => '0-2 days',
                'games' => '10,000+',
                'slug' => 'lucky-ones'
            ],
            [
                'name' => 'Mafia Casino',
                'established' => 2025,
                'rating' => 4.0,
                'rating_text' => 'Great',
                'bonus' => '100% up to $750 + 200 Free Spins + 1 Bonus Crab',
                'rtp' => '98.19%',
                'payout' => '0-1 days',
                'games' => '9,000+',
                'slug' => 'mafia-casino'
            ],
            [
                'name' => 'Pistolo',
                'established' => 2025,
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $750 + 200 Free Spins',
                'rtp' => '98.21%',
                'payout' => '1-3 days',
                'games' => '11,000+',
                'slug' => 'pistolo'
            ],
            [
                'name' => 'Vegas Hero',
                'established' => null,
                'rating' => 4.6,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $750 + 200 Free Spins + 1 Bonus Crab',
                'rtp' => '98.34%',
                'payout' => '1-2 days',
                'games' => '2,000+',
                'slug' => 'vegas-hero'
            ],
            [
                'name' => 'Spinbara',
                'established' => 2025,
                'rating' => 4.5,
                'rating_text' => 'Excellent',
                'bonus' => '300% up to $5,000 + 350 Free Spins + 1 Claw Machine',
                'rtp' => '98.23%',
                'payout' => '1-3 days',
                'games' => '21,000+',
                'slug' => 'spinbara'
            ],
            [
                'name' => 'Tooniebet',
                'established' => 2024,
                'rating' => 4.4,
                'rating_text' => 'Great',
                'bonus' => 'Up to $3,500 + 200 Bonus Spins + 1 Claw Machine',
                'rtp' => '98.12%',
                'payout' => '1-3 days',
                'games' => '3,000+',
                'slug' => 'tooniebet'
            ],
            [
                'name' => 'BetVictor',
                'established' => 1946,
                'rating' => 4.5,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $3,000 + 100 Free Spins',
                'rtp' => '98.20%',
                'payout' => '0-2 days',
                'games' => '1,500+',
                'slug' => 'betvictor'
            ],
            [
                'name' => 'Casinova',
                'established' => 2024,
                'rating' => 4.3,
                'rating_text' => 'Great',
                'bonus' => '100% up to $3,000 + 350 Free Spins',
                'rtp' => '98.14%',
                'payout' => '1-2 days',
                'games' => '3,000',
                'slug' => 'casinova'
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
}
