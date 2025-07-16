<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index(): void {
        // Get comprehensive data matching casino.ca exactly
        $topCasinos = $this->getTopCasinos();
        $categories = $this->getCasinoCategories();
        $featuredGames = $this->getFeaturedGames();
        $bonusCategories = $this->getBonusCategories();
        $topCasinosDetailed = $this->getTopCasinosDetailed();
        $popularGames = $this->getPopularGames();
        $experts = $this->getExperts();
        $mobileApps = $this->getMobileApps();
        $paymentMethods = $this->getPaymentMethods();
        
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare the best Canadian online casinos in 2025</title>
    <meta name="description" content="Casino.ca is your go-to for finding the best online casino in Canada. With 10 years online, we\'ve reviewed over 120 popular CA casinos. Expert reviews, exclusive bonuses, and trusted recommendations.">
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
        
        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
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
        
        .casino-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .casino-grid-item {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .casino-grid-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .casino-grid-logo {
            width: 60px;
            height: 60px;
            background: #fff;
            border-radius: 6px;
            margin: 0 auto 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #666;
            font-size: 0.8rem;
        }
        
        .casino-grid-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: #333;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .category-card {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
        }
        
        .category-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .category-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .category-casino {
            color: #d63384;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .category-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .detailed-casino {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .detailed-casino-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .detailed-casino-logo {
            width: 80px;
            height: 80px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #666;
        }
        
        .detailed-casino-info h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .detailed-casino-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .detailed-casino-bonus {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        
        .pros-cons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin: 1.5rem 0;
        }
        
        .pros, .cons {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
        }
        
        .pros h4, .cons h4 {
            margin-bottom: 1rem;
            color: #333;
        }
        
        .pros ul {
            list-style: none;
        }
        
        .pros li {
            padding: 0.25rem 0;
            color: #28a745;
        }
        
        .pros li:before {
            content: "✓ ";
            font-weight: bold;
        }
        
        .cons ul {
            list-style: none;
        }
        
        .cons li {
            padding: 0.25rem 0;
            color: #dc3545;
        }
        
        .cons li:before {
            content: "✗ ";
            font-weight: bold;
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
        
        .trust-section {
            background: #f8f9fa;
            padding: 3rem 0;
            margin: 4rem 0;
        }
        
        .expert-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        
        .expert-card {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
        }
        
        .expert-photo {
            width: 80px;
            height: 80px;
            background: #d63384;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .expert-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .expert-title {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }
        
        .expert-picks {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
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
            
            .pros-cons {
                grid-template-columns: 1fr;
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

        <section class="section">
            <h2 class="section-title">Compare every recommended Canadian online casino</h2>
            <p class="section-subtitle">Choose an online casino from the following list and find all the important information around this casino brand at a glance. You can compare how our experts rated the Canadian online casinos in full detail, but also the bonuses, promotions and games each one offers or dive deep into the statistics for each operator.</p>
            <div class="casino-grid">';
        
        foreach ($topCasinos as $casino) {
            echo '<div class="casino-grid-item">
                <div class="casino-grid-logo">' . substr($casino['name'], 0, 3) . '</div>
                <div class="casino-grid-name">' . htmlspecialchars($casino['name']) . '</div>
            </div>';
        }
        
        echo '</div>
        </section>

        <section class="section">
            <h2 class="section-title">The best online casinos in Canada by category</h2>
            <p class="section-subtitle">To help narrow down your choice of casinos online, our experts have recommended Canada\'s top casino sites by key feature. These brands lead in their field, from real money online casinos with high payout games at 97%+ to valuable bonuses with reasonable wagering requirements below 30x.</p>
            <div class="categories-grid">';
        
        foreach ($categories as $category) {
            echo '<div class="category-card">
                <div class="category-icon">' . $category['icon'] . '</div>
                <div class="category-title">' . $category['title'] . '</div>
                <div class="category-casino">' . $category['casino'] . '</div>
                <div class="category-stats">
                    <span>' . $category['rtp'] . '</span>
                    <span>' . $category['games'] . '</span>
                    <span>' . $category['rating'] . '</span>
                </div>
            </div>';
        }
        
        echo '</div>
        </section>

        <section class="section">
            <h2 class="section-title">Our top 3 recommended online casinos in detail</h2>
            <p class="section-subtitle">With so many options, choosing the best online casino for your gaming style can be daunting. That\'s why we\'ve filtered out the noise. These are our top three Canadian online casinos, each packed with an impressive selection of games, generous bonuses, and unbeatable customer service. You\'re just a click away from enjoying the best casino gameplay online.</p>';
        
        foreach ($topCasinosDetailed as $casino) {
            echo '<div class="detailed-casino">
                <div class="detailed-casino-header">
                    <div class="detailed-casino-logo">' . substr($casino['name'], 0, 3) . '</div>
                    <div class="detailed-casino-info">
                        <h3>' . htmlspecialchars($casino['name']) . '</h3>
                        <div class="detailed-casino-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-text">' . $casino['rating'] . '/5 ' . $casino['rating_text'] . '</span>
                            <span style="margin-left: 1rem; color: #666;">' . $casino['rtp'] . ' Win rate</span>
                        </div>
                        <a href="/casino/' . $casino['slug'] . '" class="detailed-casino-bonus">' . htmlspecialchars($casino['bonus']) . '</a>
                    </div>
                </div>
                
                <p>' . $casino['description'] . '</p>
                
                <div class="pros-cons">
                    <div class="pros">
                        <h4>Pros</h4>
                        <ul>';
            
            foreach ($casino['pros'] as $pro) {
                echo '<li>' . htmlspecialchars($pro) . '</li>';
            }
            
            echo '</ul>
                    </div>
                    <div class="cons">
                        <h4>Cons</h4>
                        <ul>';
            
            foreach ($casino['cons'] as $con) {
                echo '<li>' . htmlspecialchars($con) . '</li>';
            }
            
            echo '</ul>
                    </div>
                </div>
                
                <div class="view-all">
                    <a href="/casino/' . $casino['slug'] . '" class="view-all-btn">Read ' . htmlspecialchars($casino['name']) . ' review</a>
                </div>
            </div>';
        }
        
        echo '</section>

        <section class="section">
            <h2 class="section-title">Play online casino games for free - no download required</h2>
            <p class="section-subtitle">Looking to join the world of casinos online and play games without any software downloads? We offer a huge library of over 20,000 free casino games you can play right on Casino.ca with no sign up required. Try out new titles and hone your skills without having to wager at a real money casino. Jump right in and experience the excitement firsthand.</p>
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
            <h2 class="section-title">Most popular online slots with Canadian players</h2>
            <p class="section-subtitle">Certain online slots have captured the hearts of players who enjoy gambling online in Canada. From the immersive adventures of Gates of Olympus to the high-octane thrills of Da Vinci Diamond, these popular slots offer captivating gameplay, enticing bonuses, and the potential for big wins. Get ready to spin and win!</p>
            <div class="games-grid">';
        
        foreach ($popularGames as $game) {
            echo '<div class="game-card">
                <div class="game-image">' . $game['icon'] . '</div>
                <div class="game-info">
                    <div class="game-name">' . $game['name'] . ' – ' . $game['provider'] . '</div>
                    <div class="game-description">' . $game['description'] . '</div>
                    <div class="game-rtp">' . $game['rtp'] . ' RTP</div>
                </div>
            </div>';
        }
        
        echo '</div>
        </section>

        <section class="section">
            <h2 class="section-title">Claim the best online casino bonuses</h2>
            <p class="section-subtitle">Bonuses are one of the best perks of playing casino games online. You could choose a free spins bonus, ideal for checking out new and exclusive slot games, or pick a rarer no deposit bonus and claim free casino cash with no upfront risk. There\'s plenty of variety to suit any budget and play style. You can even choose a casino online with bonuses for low deposits. Explore all the bonuses below and tap the right one for you.</p>
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

    <section class="trust-section">
        <div class="container">
            <h2 class="section-title">Why trust Casino.ca?</h2>
            <p class="section-subtitle">We guide thousands of Canadians to better casino and online gaming experiences every month. As a trusted authority, our expertise has been quoted in the Toronto Sun, National Post, and The Montreal Gazette. Our expert team is based in Canada and globally, and has over 25 years in iGaming. They\'ve written hundreds of gambling guides and reviewed scores of new games and casinos. You always have the latest advice and information to hand before you join your next game.</p>
            
            <div class="expert-grid">';
        
        foreach ($experts as $expert) {
            echo '<div class="expert-card">
                <div class="expert-photo">' . substr($expert['name'], 0, 2) . '</div>
                <div class="expert-name">' . htmlspecialchars($expert['name']) . '</div>
                <div class="expert-title">' . htmlspecialchars($expert['title']) . '</div>
                <p>' . $expert['bio'] . '</p>
                <div class="expert-picks">
                    <h4>Top picks:</h4>';
            
            foreach ($expert['picks'] as $pick) {
                echo '<div class="casino-grid-item">
                    <div class="casino-grid-logo">' . substr($pick['name'], 0, 3) . '</div>
                    <div class="casino-grid-name">' . htmlspecialchars($pick['name']) . '</div>
                </div>';
            }
            
            echo '</div>
            </div>';
        }
        
        echo '</div>
        </div>
    </section>

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
</body>
</html>';
    }
        
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare the best Canadian online casinos in 2025</title>
    <meta name="description" content="Casino.ca is your go-to for finding the best online casino in Canada. With 10 years online, we\'ve reviewed over 120 popular CA casinos. Expert reviews, exclusive bonuses, and trusted recommendations.">
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
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .category-card {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
        }
        
        .category-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .category-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .category-casino {
            color: #d63384;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .category-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #666;
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

        <section class="section">
            <h2 class="section-title">The best online casinos in Canada by category</h2>
            <p>To help narrow down your choice of casinos online, our experts have recommended Canada\'s top casino sites by key feature. These brands lead in their field, from real money online casinos with high payout games at 97%+ to valuable bonuses with reasonable wagering requirements below 30x.</p>
            <div class="categories-grid">';
        
        foreach ($categories as $category) {
            echo '<div class="category-card">
                <div class="category-icon">' . $category['icon'] . '</div>
                <div class="category-title">' . $category['title'] . '</div>
                <div class="category-casino">' . $category['casino'] . '</div>
                <div class="category-stats">
                    <span>' . $category['rtp'] . '</span>
                    <span>' . $category['games'] . '</span>
                    <span>' . $category['rating'] . '</span>
                </div>
            </div>';
        }
        
        echo '</div>
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
</body>
</html>';
    }
    
    private function getTopCasinos(): array {
        return [
            [
                'name' => 'Jackpot City Casino',
                'established' => 1998,
                'rating' => 4.8,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $4,000 + 210 Free Spins',
                'rtp' => '97.39%',
                'payout' => '1-3 days',
                'games' => '1,350+',
                'slug' => 'jackpot-city'
            ],
            [
                'name' => 'Spin Palace',
                'established' => 2001,
                'rating' => 4.7,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $1,000 + 345 Free Spins',
                'rtp' => '97.45%',
                'payout' => '1-3 days',
                'games' => '1,000+',
                'slug' => 'spin-palace'
            ],
            [
                'name' => 'Lucky Ones',
                'established' => 2023,
                'rating' => 4.4,
                'rating_text' => 'Great',
                'bonus' => '100% up to $20,000 + 500 Free Spins',
                'rtp' => '98.27%',
                'payout' => '0-2 days',
                'games' => '8,000+',
                'slug' => 'lucky-ones'
            ],
            [
                'name' => 'Pistolo',
                'established' => 2025,
                'rating' => 4.6,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $750 + 200 Free Spins',
                'rtp' => '97.21%',
                'payout' => '1-3 days',
                'games' => '11,000+',
                'slug' => 'pistolo'
            ],
            [
                'name' => 'Magius',
                'established' => 2024,
                'rating' => 4.6,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $2,500 + 300 Free Spins',
                'rtp' => '98.13%',
                'payout' => '1-2 days',
                'games' => '7,400+',
                'slug' => 'magius'
            ],
            [
                'name' => 'BetVictor',
                'established' => 1946,
                'rating' => 4.5,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $3,000 + 100 Free Spins',
                'rtp' => '96.85%',
                'payout' => '0-2 days',
                'games' => '1,500+',
                'slug' => 'betvictor'
            ],
            [
                'name' => 'Vegas Hero',
                'established' => 2017,
                'rating' => 4.5,
                'rating_text' => 'Excellent',
                'bonus' => '100% up to $750 + 200 Free Spins',
                'rtp' => '96.92%',
                'payout' => '1-2 days',
                'games' => '2,400+',
                'slug' => 'vegas-hero'
            ],
            [
                'name' => 'Spinbara',
                'established' => 2025,
                'rating' => 4.4,
                'rating_text' => 'Great',
                'bonus' => '300% up to $5,000 + 350 Free Spins',
                'rtp' => '97.23%',
                'payout' => '1-3 days',
                'games' => '5,200+',
                'slug' => 'spinbara'
            ],
            [
                'name' => 'Mafia Casino',
                'established' => 2025,
                'rating' => 4.3,
                'rating_text' => 'Great',
                'bonus' => '100% up to $750 + 200 Free Spins',
                'rtp' => '96.89%',
                'payout' => '0-1 days',
                'games' => '4,800+',
                'slug' => 'mafia-casino'
            ],
            [
                'name' => 'Tooniebet',
                'established' => 2024,
                'rating' => 4.3,
                'rating_text' => 'Great',
                'bonus' => 'Up to $3,500 + 200 Free Spins',
                'rtp' => '96.78%',
                'payout' => '1-3 days',
                'games' => '3,000+',
                'slug' => 'tooniebet'
            ],
            [
                'name' => 'Casinova',
                'established' => 2024,
                'rating' => 4.2,
                'rating_text' => 'Good',
                'bonus' => '100% up to $3,000 + 350 Free Spins',
                'rtp' => '96.74%',
                'payout' => '1-2 days',
                'games' => '3,200+',
                'slug' => 'casinova'
            ],
            [
                'name' => 'Royal Vegas',
                'established' => 2000,
                'rating' => 4.1,
                'rating_text' => 'Good',
                'bonus' => '100% up to $1,200 + 120 Free Spins',
                'rtp' => '96.58%',
                'payout' => '2-4 days',
                'games' => '850+',
                'slug' => 'royal-vegas'
            ],
            [
                'name' => 'Ruby Fortune',
                'established' => 2003,
                'rating' => 4.0,
                'rating_text' => 'Good',
                'bonus' => '100% up to $750 + 100 Free Spins',
                'rtp' => '96.45%',
                'payout' => '2-5 days',
                'games' => '680+',
                'slug' => 'ruby-fortune'
            ],
            [
                'name' => 'Captain Cooks',
                'established' => 1999,
                'rating' => 3.9,
                'rating_text' => 'Good',
                'bonus' => '100 chances to win for $5',
                'rtp' => '96.22%',
                'payout' => '3-7 days',
                'games' => '550+',
                'slug' => 'captain-cooks'
            ],
            [
                'name' => 'Gaming Club',
                'established' => 1994,
                'rating' => 3.8,
                'rating_text' => 'Fair',
                'bonus' => '100% up to $350 + 100 Free Spins',
                'rtp' => '96.18%',
                'payout' => '3-7 days',
                'games' => '450+',
                'slug' => 'gaming-club'
            ]
        ];
    }
    
    private function getCasinoCategories(): array {
        return [
            [
                'icon' => '💸',
                'title' => 'Best real money casino',
                'casino' => 'Jackpot City',
                'rtp' => '97.39%',
                'games' => '1,350+',
                'rating' => '4.7/5'
            ],
            [
                'icon' => '🎰',
                'title' => 'Best for online slots',
                'casino' => 'Spin Palace',
                'rtp' => '97.45%',
                'games' => '1,000+',
                'rating' => '4.7/5'
            ],
            [
                'icon' => '💰',
                'title' => 'Best welcome bonus',
                'casino' => 'Lucky Ones',
                'rtp' => '98.27%',
                'games' => '8,000+',
                'rating' => '4.4/5'
            ],
            [
                'icon' => '💳',
                'title' => 'Best payment options',
                'casino' => 'Pistolo',
                'rtp' => '97.21%',
                'games' => '11,000+',
                'rating' => '4.6/5'
            ],
            [
                'icon' => '🎲',
                'title' => 'Best live casino',
                'casino' => 'Vegas Hero',
                'rtp' => '98.13%',
                'games' => '2,400+',
                'rating' => '4.6/5'
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
    
    private function getTopCasinosDetailed(): array {
        return [
            [
                'name' => 'Jackpot City',
                'slug' => 'jackpot-city',
                'rating' => '4.8',
                'rating_text' => 'Excellent',
                'rtp' => '97.39%',
                'bonus' => '100% match up to $4,000 + 210 Free Spins',
                'description' => 'Jackpot City Casino has been a trusted name in online gambling since 1998. With over 1,350 games from Microgaming and Evolution Gaming, including exclusive progressive jackpot slots, this platform offers one of the most comprehensive gaming experiences available to Canadian players. Their customer support team is available 24/7 via live chat, email, and phone, ensuring players always have assistance when needed.',
                'pros' => [
                    'Over 1,350 premium casino games',
                    'Licensed by the Malta Gaming Authority',
                    '24/7 multilingual customer support',
                    'Fast payouts within 1-3 days',
                    'Mobile-optimized platform with dedicated app',
                    'VIP loyalty program with exclusive rewards',
                    'Established reputation since 1998'
                ],
                'cons' => [
                    'Limited cryptocurrency payment options',
                    'Restricted in some countries',
                    'High wagering requirements on some bonuses'
                ]
            ],
            [
                'name' => 'Spin Palace',
                'slug' => 'spin-palace',
                'rating' => '4.7',
                'rating_text' => 'Excellent',
                'rtp' => '97.45%',
                'bonus' => '100% match up to $1,000 + 345 Free Spins',
                'description' => 'Spin Palace Casino delivers a royal gaming experience with over 1,000 carefully selected games. Known for their excellent customer service and fast payouts, they\'ve built a reputation as one of Canada\'s most reliable online casinos since 2001. Their platform features the latest SSL encryption technology to ensure all player data remains secure, while their loyalty program rewards regular players with exclusive bonuses and perks.',
                'pros' => [
                    'Established reputation since 2001',
                    'Excellent mobile casino app',
                    'Multiple payment methods accepted',
                    'Regular promotional offers and tournaments',
                    'High-quality game graphics and animations',
                    'Dedicated Canadian customer support',
                    'Fast withdrawal processing times'
                ],
                'cons' => [
                    'Limited live dealer game selection',
                    'Some games restricted by region',
                    'Withdrawal limits for new players'
                ]
            ],
            [
                'name' => 'Lucky Ones',
                'slug' => 'lucky-ones',
                'rating' => '4.4',
                'rating_text' => 'Great',
                'rtp' => '98.27%',
                'bonus' => '100% match up to $20,000 + 500 Free Spins',
                'description' => 'Lucky Ones Casino is one of the newest additions to the Canadian online casino scene, launched in 2023 with a focus on modern gaming experiences. Featuring over 8,000 games from leading providers and one of the most generous welcome bonuses in the industry, Lucky Ones has quickly established itself as a serious competitor. Their platform emphasizes user experience with fast loading times, intuitive navigation, and comprehensive mobile optimization.',
                'pros' => [
                    'Massive welcome bonus up to $20,000',
                    'Over 8,000 casino games available',
                    'Fast payout processing (0-2 days)',
                    'Modern, user-friendly interface',
                    'Comprehensive mobile optimization',
                    'High RTP of 98.27%',
                    'Regular new game additions'
                ],
                'cons' => [
                    'Relatively new casino (established 2023)',
                    'Limited VIP program compared to established casinos',
                    'Some payment methods may have fees'
                ]
            ]
        ];
    }
    
    private function getPopularGames(): array {
        return [
            [
                'name' => 'Gates of Olympus',
                'provider' => 'Pragmatic Play',
                'rtp' => '96.50%',
                'icon' => '⚡',
                'description' => 'Zeus-themed slot with cascading wins and multiplier features'
            ],
            [
                'name' => 'Sweet Bonanza',
                'provider' => 'Pragmatic Play',
                'rtp' => '96.51%',
                'icon' => '🍭',
                'description' => 'Colorful candy-themed slot with tumbling reels and free spins'
            ],
            [
                'name' => 'Da Vinci Diamonds',
                'provider' => 'IGT',
                'rtp' => '94.93%',
                'icon' => '💎',
                'description' => 'Renaissance art-inspired slot with tumbling diamonds feature'
            ],
            [
                'name' => 'Book of Dead',
                'provider' => 'Play\'n GO',
                'rtp' => '96.21%',
                'icon' => '📚',
                'description' => 'Egyptian adventure slot with expanding symbols and free spins'
            ],
            [
                'name' => 'Starburst',
                'provider' => 'NetEnt',
                'rtp' => '96.09%',
                'icon' => '⭐',
                'description' => 'Classic space-themed slot with expanding wilds and re-spins'
            ],
            [
                'name' => 'Gonzo\'s Quest',
                'provider' => 'NetEnt',
                'rtp' => '95.97%',
                'icon' => '🗿',
                'description' => 'Adventure slot with avalanche reels and increasing multipliers'
            ]
        ];
    }
    
    private function getExperts(): array {
        return [
            [
                'name' => 'Sarah Mitchell',
                'title' => 'Senior Casino Analyst',
                'bio' => 'With over 8 years of experience in the Canadian iGaming industry, Sarah specializes in slot machine analysis and bonus evaluation.',
                'picks' => [
                    ['name' => 'Jackpot City', 'slug' => 'jackpot-city'],
                    ['name' => 'Spin Palace', 'slug' => 'spin-palace']
                ]
            ],
            [
                'name' => 'David Thompson',
                'title' => 'Table Games Expert',
                'bio' => 'Former casino dealer turned analyst, David brings insider knowledge of blackjack, roulette, and poker to his comprehensive reviews.',
                'picks' => [
                    ['name' => 'Royal Vegas', 'slug' => 'royal-vegas'],
                    ['name' => 'Lucky Ones', 'slug' => 'lucky-ones']
                ]
            ],
            [
                'name' => 'Jennifer Carter',
                'title' => 'Mobile Gaming Specialist',
                'bio' => 'Tech-savvy reviewer focusing on mobile casino apps and user experience across all devices and platforms.',
                'picks' => [
                    ['name' => 'Ruby Fortune', 'slug' => 'ruby-fortune'],
                    ['name' => 'Captain Cooks', 'slug' => 'captain-cooks']
                ]
            ]
        ];
    }
    
    private function getMobileApps(): array {
        return [
            [
                'name' => 'Jackpot City',
                'size' => '34 MB',
                'play_store' => '4.3/5',
                'app_store' => '4.5/5',
                'features' => 'Progressive jackpots, game notifications'
            ],
            [
                'name' => 'LeoVegas',
                'size' => '86.2 MB',
                'play_store' => '4.2/5',
                'app_store' => '4.3/5',
                'features' => 'Live casino, mobile bonuses'
            ],
            [
                'name' => 'BetVictor',
                'size' => '134.8 MB',
                'play_store' => '3.8/5',
                'app_store' => '4.7/5',
                'features' => 'Live betting, casino games'
            ]
        ];
    }
    
    private function getPaymentMethods(): array {
        return [
            [
                'name' => 'Interac e-Transfer',
                'processing_time' => '24-48 hours',
                'limits' => '$0.01-$10,000'
            ],
            [
                'name' => 'Visa/Mastercard',
                'processing_time' => '1-2 days',
                'limits' => '$10-$10,000'
            ],
            [
                'name' => 'MuchBetter',
                'processing_time' => 'Up to 24 hours',
                'limits' => '$10-$7,000'
            ],
            [
                'name' => 'PayPal',
                'processing_time' => 'Instant',
                'limits' => '$10-$5,000'
            ],
            [
                'name' => 'Bitcoin',
                'processing_time' => '10-60 minutes',
                'limits' => '$20-$50,000'
            ]
        ];
    }
}
