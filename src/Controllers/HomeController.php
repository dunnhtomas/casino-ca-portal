<?php
namespace App\Controllers;

class HomeController {
    
    public function index(): void {
        $title = "Best Casino Portal - Top Rated Online Casinos in Canada";
        $description = "Discover the best online casinos in Canada with our expert reviews, bonuses, and ratings. Find your perfect casino match today!";
        
        // Get some featured casinos
        $featuredCasinos = $this->getFeaturedCasinos();
        
        echo $this->renderHomePage($title, $description, $featuredCasinos);
    }
    
    private function getFeaturedCasinos(): array {
        return [
            [
                'id' => 1,
                'name' => 'JackpotCity Casino',
                'rating' => 4.8,
                'bonus' => 'Up to $1,600 Welcome Bonus',
                'games' => '525+ Games',
                'logo' => '/images/jackpotcity-logo.png',
                'review_url' => '/casino/jackpotcity',
                'play_url' => 'https://www.jackpotcitycasino.com',
                'features' => ['Live Casino', 'Mobile Optimized', 'Fast Payouts']
            ],
            [
                'id' => 2,
                'name' => 'Spin Casino',
                'rating' => 4.7,
                'bonus' => 'Up to $1,000 Welcome Bonus',
                'games' => '400+ Games',
                'logo' => '/images/spin-casino-logo.png',
                'review_url' => '/casino/spin-casino',
                'play_url' => 'https://www.spincasino.com',
                'features' => ['VIP Program', 'Weekly Bonuses', '24/7 Support']
            ],
            [
                'id' => 3,
                'name' => 'Royal Vegas Casino',
                'rating' => 4.6,
                'bonus' => 'Up to $1,200 Welcome Bonus',
                'games' => '700+ Games',
                'logo' => '/images/royal-vegas-logo.png',
                'review_url' => '/casino/royal-vegas',
                'play_url' => 'https://www.royalvegas.com',
                'features' => ['Microgaming', 'Progressive Jackpots', 'Secure Banking']
            ]
        ];
    }
    
    private function renderHomePage(string $title, string $description, array $casinos): string {
        ob_start();
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background: rgba(0,0,0,0.3);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(212,175,55,0.3);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffd700;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        nav a:hover {
            color: #ffd700;
        }
        
        .hero {
            text-align: center;
            padding: 4rem 0;
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 300"><defs><pattern id="casino" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="20" fill="%23ffd700" opacity="0.1"/></pattern></defs><rect width="1000" height="300" fill="url(%23casino)"/></svg>');
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: #ffd700;
        }
        
        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            color: #cccccc;
        }
        
        .cta-button {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s ease;
        }
        
        .cta-button:hover {
            transform: scale(1.05);
        }
        
        .section {
            padding: 4rem 0;
        }
        
        .section h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #ffd700;
        }
        
        .casino-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .casino-card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(212,175,55,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .casino-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(212,175,55,0.2);
        }
        
        .casino-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .casino-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffd700;
        }
        
        .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .stars {
            color: #ffd700;
        }
        
        .casino-bonus {
            font-size: 1.1rem;
            color: #4ade80;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        
        .casino-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-tag {
            background: rgba(212,175,55,0.2);
            color: #ffd700;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.9rem;
        }
        
        .casino-actions {
            display: flex;
            gap: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            flex: 1;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
            padding: 10px 20px;
            border: 1px solid rgba(212,175,55,0.5);
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            flex: 1;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover, .btn-secondary:hover {
            transform: scale(1.05);
        }
        
        .btn-secondary:hover {
            background: rgba(212,175,55,0.1);
        }
        
        footer {
            background: rgba(0,0,0,0.5);
            padding: 2rem 0;
            text-align: center;
            border-top: 1px solid rgba(212,175,55,0.3);
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .casino-grid {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            nav ul {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">🎰 Best Casino Portal</div>
                <nav>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/casinos">Casinos</a></li>
                        <li><a href="/reviews">Reviews</a></li>
                        <li><a href="/bonuses">Bonuses</a></li>
                        <li><a href="/news">News</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>🎯 Best Online Casinos in Canada</h1>
            <p>Discover top-rated casinos with exclusive bonuses, expert reviews, and trusted security</p>
            <a href="/casinos" class="cta-button">Explore Casinos 🎲</a>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2>🏆 Featured Casinos</h2>
            <div class="casino-grid">
                <?php foreach ($casinos as $casino): ?>
                <div class="casino-card">
                    <div class="casino-header">
                        <div class="casino-name"><?= htmlspecialchars($casino['name']) ?></div>
                        <div class="rating">
                            <span class="stars">⭐⭐⭐⭐⭐</span>
                            <span><?= $casino['rating'] ?></span>
                        </div>
                    </div>
                    <div class="casino-bonus"><?= htmlspecialchars($casino['bonus']) ?></div>
                    <div class="casino-features">
                        <?php foreach ($casino['features'] as $feature): ?>
                        <span class="feature-tag"><?= htmlspecialchars($feature) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="casino-actions">
                        <a href="<?= htmlspecialchars($casino['play_url']) ?>" class="btn-primary" target="_blank" rel="noopener">Play Now 🎮</a>
                        <a href="<?= htmlspecialchars($casino['review_url']) ?>" class="btn-secondary">Read Review 📖</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2025 Best Casino Portal. All rights reserved. | 🔞 18+ Only | Play Responsibly</p>
        </div>
    </footer>
</body>
</html>
        <?php
        return ob_get_clean();
    }
}
