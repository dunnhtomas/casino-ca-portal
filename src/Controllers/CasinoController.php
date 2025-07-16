<?php
namespace App\Controllers;

class CasinoController {
    
    public function list(): void {
        $title = "Online Casinos - Complete List | Best Casino Portal";
        $description = "Browse our complete list of top-rated online casinos in Canada. Compare bonuses, games, and features to find your perfect casino.";
        
        $casinos = $this->getAllCasinos();
        
        echo $this->renderCasinoList($title, $description, $casinos);
    }
    
    public function detail(string $casinoSlug): void {
        $casino = $this->getCasinoBySlug($casinoSlug);
        
        if (!$casino) {
            http_response_code(404);
            echo "Casino not found";
            return;
        }
        
        $title = $casino['name'] . " Review - Bonus, Games & Rating | Best Casino Portal";
        $description = "Detailed review of " . $casino['name'] . ". Get exclusive bonuses, read expert analysis, and discover why this casino is highly rated.";
        
        echo $this->renderCasinoDetail($title, $description, $casino);
    }
    
    private function getAllCasinos(): array {
        return [
            [
                'id' => 1,
                'name' => 'JackpotCity Casino',
                'slug' => 'jackpotcity',
                'rating' => 4.8,
                'bonus' => 'Up to $1,600 Welcome Bonus',
                'games' => 525,
                'established' => 1998,
                'license' => 'Malta Gaming Authority',
                'logo' => '/images/jackpotcity-logo.png',
                'play_url' => 'https://www.jackpotcitycasino.com',
                'features' => ['Live Casino', 'Mobile Optimized', 'Fast Payouts', 'Microgaming'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'PayPal', 'Skrill'],
                'pros' => ['Huge game selection', '25+ years experience', 'Excellent mobile app'],
                'cons' => ['High wagering requirements', 'Limited live chat hours']
            ],
            [
                'id' => 2,
                'name' => 'Spin Casino',
                'slug' => 'spin-casino',
                'rating' => 4.7,
                'bonus' => 'Up to $1,000 Welcome Bonus',
                'games' => 400,
                'established' => 2001,
                'license' => 'Malta Gaming Authority',
                'logo' => '/images/spin-casino-logo.png',
                'play_url' => 'https://www.spincasino.com',
                'features' => ['VIP Program', 'Weekly Bonuses', '24/7 Support', 'Evolution Gaming'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'ecoPayz'],
                'pros' => ['Great VIP program', 'Fast withdrawals', 'Live dealer games'],
                'cons' => ['Limited slots variety', 'Bonus terms complex']
            ],
            [
                'id' => 3,
                'name' => 'Royal Vegas Casino',
                'slug' => 'royal-vegas',
                'rating' => 4.6,
                'bonus' => 'Up to $1,200 Welcome Bonus',
                'games' => 700,
                'established' => 2000,
                'license' => 'Malta Gaming Authority',
                'logo' => '/images/royal-vegas-logo.png',
                'play_url' => 'https://www.royalvegas.com',
                'features' => ['Microgaming', 'Progressive Jackpots', 'Secure Banking', 'Mobile Casino'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Paysafecard', 'Bitcoin'],
                'pros' => ['Massive jackpots', 'Trusted brand', 'Canadian friendly'],
                'cons' => ['Slow customer support', 'Limited live games']
            ]
        ];
    }
    
    private function getCasinoBySlug(string $slug): ?array {
        $casinos = $this->getAllCasinos();
        
        foreach ($casinos as $casino) {
            if ($casino['slug'] === $slug) {
                return $casino;
            }
        }
        
        return null;
    }
    
    private function renderCasinoList(string $title, string $description, array $casinos): string {
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
        
        .page-header {
            text-align: center;
            padding: 3rem 0;
        }
        
        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ffd700;
        }
        
        .page-header p {
            font-size: 1.2rem;
            color: #cccccc;
        }
        
        .casino-list {
            padding: 2rem 0;
        }
        
        .casino-item {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(212,175,55,0.3);
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 2rem;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .casino-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(212,175,55,0.2);
        }
        
        .casino-info h3 {
            font-size: 1.8rem;
            color: #ffd700;
            margin-bottom: 0.5rem;
        }
        
        .casino-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        
        .meta-item {
            background: rgba(212,175,55,0.2);
            color: #ffd700;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.9rem;
        }
        
        .casino-bonus {
            font-size: 1.1rem;
            color: #4ade80;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .casino-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .feature-tag {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 10px;
            font-size: 0.8rem;
        }
        
        .casino-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            min-width: 200px;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
            padding: 12px 24px;
            border: 1px solid rgba(212,175,55,0.5);
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover, .btn-secondary:hover {
            transform: scale(1.05);
        }
        
        .btn-secondary:hover {
            background: rgba(212,175,55,0.1);
        }
        
        .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.1rem;
        }
        
        .stars {
            color: #ffd700;
        }
        
        @media (max-width: 768px) {
            .casino-item {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .casino-actions {
                min-width: auto;
            }
            
            .page-header h1 {
                font-size: 2.5rem;
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

    <section class="page-header">
        <div class="container">
            <h1>🎰 All Online Casinos</h1>
            <p>Compare top-rated Canadian online casinos and find your perfect match</p>
        </div>
    </section>

    <section class="casino-list">
        <div class="container">
            <?php foreach ($casinos as $casino): ?>
            <div class="casino-item">
                <div class="rating">
                    <span class="stars">⭐⭐⭐⭐⭐</span>
                    <span><?= $casino['rating'] ?></span>
                </div>
                
                <div class="casino-info">
                    <h3><?= htmlspecialchars($casino['name']) ?></h3>
                    <div class="casino-meta">
                        <span class="meta-item"><?= $casino['games'] ?>+ Games</span>
                        <span class="meta-item">Est. <?= $casino['established'] ?></span>
                        <span class="meta-item"><?= htmlspecialchars($casino['license']) ?></span>
                    </div>
                    <div class="casino-bonus"><?= htmlspecialchars($casino['bonus']) ?></div>
                    <div class="casino-features">
                        <?php foreach ($casino['features'] as $feature): ?>
                        <span class="feature-tag"><?= htmlspecialchars($feature) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="casino-actions">
                    <a href="<?= htmlspecialchars($casino['play_url']) ?>" class="btn-primary" target="_blank" rel="noopener">Play Now 🎮</a>
                    <a href="/casino/<?= htmlspecialchars($casino['slug']) ?>" class="btn-secondary">Read Review 📖</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>
        <?php
        return ob_get_clean();
    }
    
    private function renderCasinoDetail(string $title, string $description, array $casino): string {
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
        
        .casino-hero {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 3rem;
            margin: 2rem 0;
            border: 1px solid rgba(212,175,55,0.3);
            text-align: center;
        }
        
        .casino-hero h1 {
            font-size: 3rem;
            color: #ffd700;
            margin-bottom: 1rem;
        }
        
        .casino-rating {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stars {
            color: #ffd700;
        }
        
        .casino-bonus {
            font-size: 1.5rem;
            color: #4ade80;
            font-weight: bold;
            margin-bottom: 2rem;
        }
        
        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #d4af37, #ffd700);
            color: #1a1a2e;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            transition: transform 0.3s ease;
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
            padding: 15px 30px;
            border: 1px solid rgba(212,175,55,0.5);
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover, .btn-secondary:hover {
            transform: scale(1.05);
        }
        
        .review-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
            margin: 3rem 0;
        }
        
        .review-main {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(212,175,55,0.3);
        }
        
        .review-sidebar {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(212,175,55,0.3);
            height: fit-content;
        }
        
        .section-title {
            font-size: 2rem;
            color: #ffd700;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid rgba(212,175,55,0.3);
            padding-bottom: 0.5rem;
        }
        
        .pros-cons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin: 2rem 0;
        }
        
        .pros, .cons {
            background: rgba(255,255,255,0.05);
            padding: 1.5rem;
            border-radius: 10px;
        }
        
        .pros h4 {
            color: #4ade80;
            margin-bottom: 1rem;
        }
        
        .cons h4 {
            color: #ef4444;
            margin-bottom: 1rem;
        }
        
        .pros ul, .cons ul {
            list-style: none;
        }
        
        .pros li::before {
            content: "✅ ";
            margin-right: 0.5rem;
        }
        
        .cons li::before {
            content: "❌ ";
            margin-right: 0.5rem;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .info-label {
            font-weight: bold;
            color: #ffd700;
        }
        
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .payment-tag {
            background: rgba(212,175,55,0.2);
            color: #ffd700;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .review-content {
                grid-template-columns: 1fr;
            }
            
            .casino-hero h1 {
                font-size: 2.5rem;
            }
            
            .hero-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .pros-cons {
                grid-template-columns: 1fr;
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

    <div class="container">
        <div class="casino-hero">
            <h1><?= htmlspecialchars($casino['name']) ?> Review</h1>
            <div class="casino-rating">
                <span class="stars">⭐⭐⭐⭐⭐</span>
                <span><?= $casino['rating'] ?>/5</span>
            </div>
            <div class="casino-bonus"><?= htmlspecialchars($casino['bonus']) ?></div>
            <div class="hero-actions">
                <a href="<?= htmlspecialchars($casino['play_url']) ?>" class="btn-primary" target="_blank" rel="noopener">Play Now 🎮</a>
                <a href="#review" class="btn-secondary">Read Full Review 📖</a>
            </div>
        </div>

        <div class="review-content" id="review">
            <div class="review-main">
                <h2 class="section-title">📝 Casino Review</h2>
                <p><?= htmlspecialchars($casino['name']) ?> has been serving Canadian players since <?= $casino['established'] ?>, establishing itself as a trusted name in the online casino industry. With over <?= $casino['games'] ?> games and a generous welcome bonus, this casino offers an excellent gaming experience for both new and experienced players.</p>
                
                <h3 class="section-title">🎮 Games & Software</h3>
                <p>The casino features an impressive selection of <?= $casino['games'] ?>+ games, including slots, table games, and live dealer options. Powered by top software providers, players can enjoy high-quality graphics and smooth gameplay across all devices.</p>
                
                <h3 class="section-title">🎁 Bonuses & Promotions</h3>
                <p>New players can take advantage of the generous <?= htmlspecialchars($casino['bonus']) ?> welcome package. The casino also offers regular promotions, loyalty rewards, and VIP programs for returning players.</p>
                
                <div class="pros-cons">
                    <div class="pros">
                        <h4>✅ Pros</h4>
                        <ul>
                            <?php foreach ($casino['pros'] as $pro): ?>
                            <li><?= htmlspecialchars($pro) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="cons">
                        <h4>❌ Cons</h4>
                        <ul>
                            <?php foreach ($casino['cons'] as $con): ?>
                            <li><?= htmlspecialchars($con) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="review-sidebar">
                <h3 class="section-title">ℹ️ Casino Info</h3>
                
                <div class="info-item">
                    <span class="info-label">Established:</span>
                    <span><?= $casino['established'] ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">License:</span>
                    <span><?= htmlspecialchars($casino['license']) ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Games:</span>
                    <span><?= $casino['games'] ?>+</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Rating:</span>
                    <span><?= $casino['rating'] ?>/5</span>
                </div>
                
                <h4 style="color: #ffd700; margin: 2rem 0 1rem 0;">💳 Payment Methods</h4>
                <div class="payment-methods">
                    <?php foreach ($casino['payment_methods'] as $method): ?>
                    <span class="payment-tag"><?= htmlspecialchars($method) ?></span>
                    <?php endforeach; ?>
                </div>
                
                <div style="margin-top: 2rem;">
                    <a href="<?= htmlspecialchars($casino['play_url']) ?>" class="btn-primary" target="_blank" rel="noopener" style="width: 100%; text-align: center; display: block;">Play Now 🎮</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
        <?php
        return ob_get_clean();
    }
}
