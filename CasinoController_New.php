<?php
namespace App\Controllers;
use App\Services\CasinoDataService;

class CasinoController 
{
    private $casinoDataService;
    
    public function __construct() 
    {
        $this->casinoDataService = new CasinoDataService();
    }

    public function list(): void 
    {
        $title = "Online Casinos - Complete List | Best Casino Portal";
        $description = "Browse our complete list of top-rated online casinos in Canada. Compare bonuses, games, and features to find your perfect casino.";
        $casinos = $this->casinoDataService->getAllCasinos();

        echo $this->renderCasinoList($title, $description, $casinos);
    }

    public function detail(string $casinoSlug): void 
    {
        $casino = $this->casinoDataService->getCasinoBySlug($casinoSlug);

        if (!$casino) {
            http_response_code(404);
            echo "Casino not found";
            return;
        }

        $title = $casino['name'] . " Review - Bonus, Games & Rating | Best Casino Portal";
        $description = "Detailed review of " . $casino['name'] . ". Get exclusive bonuses, read expert analysis, and discover why this casino is highly rated.";
        
        echo $this->renderCasinoDetail($title, $description, $casino);
    }

    private function renderCasinoList(string $title, string $description, array $casinos): string 
    {
        ob_start();
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <link rel="stylesheet" href="/css/casino-list.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Best Online Casinos in Canada</h1>
            <p>Discover our handpicked selection of <?php echo count($casinos); ?> top-rated online casinos</p>
        </header>

        <div class="casino-grid">
            <?php foreach ($casinos as $casino): ?>
            <div class="casino-card">
                <div class="casino-header">
                    <div class="casino-logo"><?php echo htmlspecialchars($casino['logo']); ?></div>
                    <div class="casino-info">
                        <h3><?php echo htmlspecialchars($casino['name']); ?></h3>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="score"><?php echo $casino['rating']; ?>/10</span>
                        </div>
                    </div>
                </div>

                <div class="casino-details">
                    <div class="detail-row">
                        <span>Bonus:</span>
                        <span><?php echo htmlspecialchars($casino['bonus']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span>Games:</span>
                        <span><?php echo htmlspecialchars($casino['games']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span>Payout:</span>
                        <span><?php echo htmlspecialchars($casino['payout']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span>License:</span>
                        <span><?php echo htmlspecialchars($casino['license']); ?></span>
                    </div>
                </div>

                <?php if (!empty($casino['features'])): ?>
                <div class="casino-features">
                    <?php foreach (array_slice($casino['features'], 0, 3) as $feature): ?>
                        <span class="feature-badge"><?php echo htmlspecialchars($feature); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="casino-actions">
                    <a href="<?php echo htmlspecialchars($casino['play_url']); ?>" class="btn-play" target="_blank" rel="noopener">Play Now</a>
                    <a href="/casinos/<?php echo htmlspecialchars($casino['slug']); ?>" class="btn-review">Read Review</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="casino-stats">
            <h2>Why Choose Our Recommended Casinos?</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($casinos); ?></span>
                    <span class="stat-label">Verified Casinos</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $this->casinoDataService->getStats()['total_games']; ?>+</span>
                    <span class="stat-label">Total Games</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $this->casinoDataService->getStats()['average_rating']; ?></span>
                    <span class="stat-label">Average Rating</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
        <?php
        return ob_get_clean();
    }

    private function renderCasinoDetail(string $title, string $description, array $casino): string 
    {
        ob_start();
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <link rel="stylesheet" href="/css/casino-detail.css">
</head>
<body>
    <div class="container">
        <header class="casino-header">
            <div class="casino-logo-large"><?php echo htmlspecialchars($casino['logo']); ?></div>
            <div class="casino-main-info">
                <h1><?php echo htmlspecialchars($casino['name']); ?></h1>
                <div class="rating-large">
                    <span class="stars">★★★★★</span>
                    <span class="score"><?php echo $casino['rating']; ?>/10</span>
                </div>
                <div class="casino-meta">
                    <span>Est. <?php echo $casino['established']; ?></span>
                    <span>•</span>
                    <span><?php echo htmlspecialchars($casino['license']); ?></span>
                </div>
            </div>
            <div class="casino-cta">
                <div class="bonus-highlight">
                    <span class="bonus-label">Welcome Bonus</span>
                    <span class="bonus-amount"><?php echo htmlspecialchars($casino['bonus']); ?></span>
                </div>
                <a href="<?php echo htmlspecialchars($casino['play_url']); ?>" class="btn-play-large" target="_blank" rel="noopener">Play Now</a>
            </div>
        </header>

        <?php if (!empty($casino['description'])): ?>
        <section class="casino-description">
            <h2>About <?php echo htmlspecialchars($casino['name']); ?></h2>
            <p><?php echo htmlspecialchars($casino['description']); ?></p>
        </section>
        <?php endif; ?>

        <section class="casino-details-grid">
            <div class="detail-section">
                <h3>Casino Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Games:</span>
                        <span class="info-value"><?php echo htmlspecialchars($casino['games']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">RTP:</span>
                        <span class="info-value"><?php echo htmlspecialchars($casino['rtp']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payout Time:</span>
                        <span class="info-value"><?php echo htmlspecialchars($casino['payout']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Mobile:</span>
                        <span class="info-value"><?php echo $casino['mobile_optimized'] ? '✅ Yes' : '❌ No'; ?></span>
                    </div>
                </div>
            </div>

            <?php if (!empty($casino['pros']) || !empty($casino['cons'])): ?>
            <div class="pros-cons-section">
                <?php if (!empty($casino['pros'])): ?>
                <div class="pros">
                    <h4>✅ Pros</h4>
                    <ul>
                        <?php foreach ($casino['pros'] as $pro): ?>
                            <li><?php echo htmlspecialchars($pro); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($casino['cons'])): ?>
                <div class="cons">
                    <h4>❌ Cons</h4>
                    <ul>
                        <?php foreach ($casino['cons'] as $con): ?>
                            <li><?php echo htmlspecialchars($con); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </section>

        <?php if (!empty($casino['payment_methods'])): ?>
        <section class="payment-methods">
            <h3>Payment Methods</h3>
            <div class="payment-grid">
                <?php foreach ($casino['payment_methods'] as $method): ?>
                    <div class="payment-method"><?php echo htmlspecialchars($method); ?></div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($casino['software_providers'])): ?>
        <section class="software-providers">
            <h3>Software Providers</h3>
            <div class="provider-grid">
                <?php foreach ($casino['software_providers'] as $provider): ?>
                    <div class="provider"><?php echo htmlspecialchars($provider); ?></div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</body>
</html>
        <?php
        return ob_get_clean();
    }
}
