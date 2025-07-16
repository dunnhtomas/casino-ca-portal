<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index(): void {
        // Get top casinos data
        $topCasinos = $this->getTopCasinos();
        $categories = $this->getCasinoCategories();
        $featuredGames = $this->getFeaturedGames();
        $bonusCategories = $this->getBonusCategories();
        
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
}
