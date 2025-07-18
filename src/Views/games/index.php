<?php
/**
 * Popular Casino Games - Dedicated Page
 * Complete guide to casino games with detailed information, strategies, and recommendations
 * 
 * @var array $games All game categories from GamesService
 * @var array $stats Game statistics from GamesService
 * @var array $canadianData Canadian gaming preferences from GamesService
 * @var array $highRtpGames Highest RTP games from GamesService
 * @var array $schema Schema.org structured data from GamesService
 * @var string $pageTitle Page title for meta tags
 * @var string $metaDescription Meta description for SEO
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta name="keywords" content="casino games, slots, blackjack, roulette, poker, baccarat, RTP, Canada, online casino">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Best Casino Portal Team">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://bestcasinoportal.com/games">
    <meta property="og:image" content="https://bestcasinoportal.com/images/games-guide-og.jpg">
    
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    <?= json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>
    </script>
    
    <!-- CSS -->
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/games.css">
    <link rel="canonical" href="https://bestcasinoportal.com/games">
</head>
<body>
    <!-- Navigation -->
    <?php include __DIR__ . '/../layout/header.php'; ?>
    
    <!-- Hero Section -->
    <section class="games-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <span class="icon">🎮</span>
                    Complete Casino Games Guide
                </h1>
                <p class="hero-subtitle">
                    Master the most popular casino games in Canada with our comprehensive guides, RTP analysis, and winning strategies
                </p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="stat-number"><?= $stats['total_games'] ?></span>
                        <span class="stat-label">Game Categories</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?= $stats['average_rtp'] ?>%</span>
                        <span class="stat-label">Average RTP</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?= $canadianData['canadian_players'] ?></span>
                        <span class="stat-label">Canadian Players</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Navigation -->
    <section class="games-navigation">
        <div class="container">
            <div class="nav-grid">
                <?php foreach ($games as $game): ?>
                <a href="#<?= $game['slug'] ?>" class="nav-item">
                    <span class="nav-icon"><?= $game['icon'] ?></span>
                    <span class="nav-label"><?= htmlspecialchars($game['name']) ?></span>
                    <span class="nav-rtp"><?= $game['average_rtp'] ?>% RTP</span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Games Grid -->
    <section class="games-main">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <h2>Popular Casino Games in Canada</h2>
                <p>Discover detailed guides for each game category, including rules, strategies, RTP rates, and the best Canadian casinos to play.</p>
            </div>

            <!-- Games Cards -->
            <div class="games-detailed-grid">
                <?php foreach ($games as $game): ?>
                <div class="game-detailed-card" id="<?= $game['slug'] ?>">
                    <div class="card-header">
                        <div class="game-icon-large">
                            <span class="icon"><?= $game['icon'] ?></span>
                        </div>
                        <div class="game-title-area">
                            <h3 class="game-title"><?= htmlspecialchars($game['name']) ?></h3>
                            <p class="game-subtitle"><?= htmlspecialchars($game['short_description']) ?></p>
                        </div>
                        <div class="game-rtp-badge">
                            <span class="rtp-label">RTP</span>
                            <span class="rtp-value"><?= $game['average_rtp'] ?>%</span>
                        </div>
                    </div>
                    
                    <div class="card-content">
                        <div class="game-description">
                            <p><?= htmlspecialchars($game['description']) ?></p>
                        </div>
                        
                        <div class="game-stats-detailed">
                            <div class="stats-row">
                                <div class="stat-item">
                                    <span class="stat-label">Available Games</span>
                                    <span class="stat-value"><?= $game['game_count'] ?>+</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Difficulty</span>
                                    <span class="stat-value"><?= htmlspecialchars($game['difficulty_level']) ?></span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Min Bet</span>
                                    <span class="stat-value">CAD <?= $game['min_bet'] ?></span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Popularity</span>
                                    <span class="stat-value">
                                        <?php
                                        $stars = round($game['popularity_score'] / 20);
                                        echo str_repeat('⭐', $stars);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="featured-games">
                            <h4>Popular <?= htmlspecialchars($game['name']) ?> Games:</h4>
                            <ul class="games-list">
                                <?php foreach ($game['featured_games'] as $featured): ?>
                                <li><?= htmlspecialchars($featured) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <?php if (isset($game['canadian_favorite']) && $game['canadian_favorite']): ?>
                        <div class="canadian-highlight">
                            <span class="canadian-badge">🍁 Canadian Favorite</span>
                            <p>This game is particularly popular among Canadian players</p>
                        </div>
                        <?php endif; ?>
                        
                        <div class="game-actions">
                            <a href="/games/<?= $game['slug'] ?>" class="btn btn-primary">
                                Full <?= htmlspecialchars($game['name']) ?> Guide
                            </a>
                            <a href="/casinos?game=<?= $game['slug'] ?>" class="btn btn-outline">
                                Find Casinos
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Highest RTP Games -->
    <section class="highest-rtp-section">
        <div class="container">
            <div class="section-header">
                <h2>🏆 Highest RTP Casino Games</h2>
                <p>Games with the best return-to-player percentages for Canadian players</p>
            </div>
            
            <div class="rtp-games-grid">
                <?php foreach ($highRtpGames as $index => $rtpGame): ?>
                <div class="rtp-game-card">
                    <div class="rtp-rank">#<?= $index + 1 ?></div>
                    <div class="rtp-game-info">
                        <h4><?= htmlspecialchars($rtpGame['name']) ?></h4>
                        <p><?= htmlspecialchars($rtpGame['category']) ?></p>
                    </div>
                    <div class="rtp-percentage">
                        <span class="rtp-value"><?= $rtpGame['rtp'] ?>%</span>
                        <span class="rtp-label">RTP</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Canadian Gaming Insights -->
    <section class="canadian-insights-detailed">
        <div class="container">
            <div class="insights-header">
                <h2>🍁 Canadian Gaming Insights</h2>
                <p>Understand how Canadian players prefer to play casino games</p>
            </div>
            
            <div class="insights-grid-detailed">
                <div class="insight-card">
                    <div class="insight-icon">🎰</div>
                    <div class="insight-content">
                        <h3>Most Popular Game</h3>
                        <p class="insight-value"><?= htmlspecialchars($canadianData['most_popular_game']) ?></p>
                        <p class="insight-description">Preferred by <?= $canadianData['popularity_percentage'] ?>% of Canadian players</p>
                    </div>
                </div>
                
                <div class="insight-card">
                    <div class="insight-icon">💰</div>
                    <div class="insight-content">
                        <h3>Average Bet Size</h3>
                        <p class="insight-value">CAD <?= $canadianData['average_bet'] ?></p>
                        <p class="insight-description">Typical bet amount per spin/hand</p>
                    </div>
                </div>
                
                <div class="insight-card">
                    <div class="insight-icon">🏆</div>
                    <div class="insight-content">
                        <h3>Best RTP Choice</h3>
                        <p class="insight-value"><?= htmlspecialchars($canadianData['highest_rtp_game']) ?></p>
                        <p class="insight-description">Game with highest return percentage</p>
                    </div>
                </div>
                
                <div class="insight-card">
                    <div class="insight-icon">📱</div>
                    <div class="insight-content">
                        <h3>Mobile Gaming</h3>
                        <p class="insight-value"><?= $canadianData['mobile_percentage'] ?>%</p>
                        <p class="insight-description">Players who prefer mobile gaming</p>
                    </div>
                </div>
                
                <div class="insight-card">
                    <div class="insight-icon">⏰</div>
                    <div class="insight-content">
                        <h3>Peak Gaming Hours</h3>
                        <p class="insight-value"><?= $canadianData['peak_hours'] ?></p>
                        <p class="insight-description">Most active gaming times</p>
                    </div>
                </div>
                
                <div class="insight-card">
                    <div class="insight-icon">🎲</div>
                    <div class="insight-content">
                        <h3>Game Variety</h3>
                        <p class="insight-value"><?= $canadianData['games_per_session'] ?></p>
                        <p class="insight-description">Average games played per session</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Game Strategy Tips -->
    <section class="strategy-tips">
        <div class="container">
            <div class="section-header">
                <h2>🎯 Essential Gaming Tips</h2>
                <p>Expert strategies to improve your casino gaming experience</p>
            </div>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">📊</div>
                    <h3>Choose High RTP Games</h3>
                    <p>Focus on games with RTP above 96% for better long-term returns. Check our RTP rankings above.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">💰</div>
                    <h3>Manage Your Bankroll</h3>
                    <p>Set strict limits for your gaming sessions and never chase losses. Play within your means.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🎓</div>
                    <h3>Learn Basic Strategies</h3>
                    <p>Study optimal strategies for skill-based games like blackjack and poker to reduce house edge.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🎁</div>
                    <h3>Use Casino Bonuses</h3>
                    <p>Take advantage of welcome bonuses and promotions, but always read the terms and conditions.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">📱</div>
                    <h3>Try Free Demos</h3>
                    <p>Practice with free demo versions before playing with real money to understand game mechanics.</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">⏱️</div>
                    <h3>Take Regular Breaks</h3>
                    <p>Set time limits and take breaks to maintain focus and avoid impulsive decision-making.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="games-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Start Playing?</h2>
                <p>Choose from our top-rated Canadian casinos and start playing your favorite games today</p>
                <div class="cta-buttons">
                    <a href="/casinos" class="btn btn-primary btn-lg">
                        Find Best Casinos
                    </a>
                    <a href="/bonuses" class="btn btn-outline btn-lg">
                        View Bonuses
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <!-- JavaScript -->
    <script src="/js/main.js"></script>
    <script>
    // Smooth scrolling for navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Animate cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.game-detailed-card, .rtp-game-card, .insight-card, .tip-card').forEach(card => {
        observer.observe(card);
    });
    </script>
</body>
</html>
