<?php
/**
 * Individual Game Category Page
 * Detailed guide for a specific casino game category
 * 
 * @var array $category Game category details
 * @var array $featuredGames Featured games in this category
 * @var array $relatedCategories Related game categories
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
    <meta name="keywords" content="<?= htmlspecialchars($category['name']) ?>, casino games, RTP, Canada, online casino, strategy">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Best Casino Portal Team">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://bestcasinoportal.com/games/<?= $category['slug'] ?>">
    <meta property="og:image" content="https://bestcasinoportal.com/images/games/<?= $category['slug'] ?>-guide.jpg">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/games.css">
    <link rel="canonical" href="https://bestcasinoportal.com/games/<?= $category['slug'] ?>">
</head>
<body>
    <!-- Navigation -->
    <?php include __DIR__ . '/../layout/header.php'; ?>
    
    <!-- Breadcrumbs -->
    <section class="breadcrumbs">
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb-list">
                    <li><a href="/">Home</a></li>
                    <li><a href="/games">Casino Games</a></li>
                    <li class="current"><?= htmlspecialchars($category['name']) ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="category-hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-icon">
                    <span class="icon"><?= $category['icon'] ?></span>
                </div>
                <h1 class="hero-title"><?= htmlspecialchars($category['name']) ?> Games Guide</h1>
                <p class="hero-subtitle"><?= htmlspecialchars($category['description']) ?></p>
                
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="stat-number"><?= $category['game_count'] ?>+</span>
                        <span class="stat-label">Games Available</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?= $category['average_rtp'] ?>%</span>
                        <span class="stat-label">Average RTP</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number"><?= htmlspecialchars($category['difficulty_level']) ?></span>
                        <span class="stat-label">Difficulty</span>
                    </div>
                    <div class="hero-stat">
                        <span class="stat-number">CAD <?= $category['min_bet'] ?></span>
                        <span class="stat-label">Min Bet</span>
                    </div>
                </div>
                
                <?php if (isset($category['canadian_favorite']) && $category['canadian_favorite']): ?>
                <div class="canadian-badge-hero">
                    <span class="badge">🍁 Canadian Favorite</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    <section class="quick-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🎮</div>
                    <div class="stat-content">
                        <h3>Game Variety</h3>
                        <p><?= $category['game_count'] ?>+ different <?= strtolower($category['name']) ?> games</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🏆</div>
                    <div class="stat-content">
                        <h3>Best RTP</h3>
                        <p>Up to <?= $category['max_rtp'] ?? $category['average_rtp'] ?>% return to player</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-content">
                        <h3>Betting Range</h3>
                        <p>From CAD <?= $category['min_bet'] ?> to CAD <?= $category['max_bet'] ?? '1000' ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📱</div>
                    <div class="stat-content">
                        <h3>Mobile Ready</h3>
                        <p>Play on any device, anywhere in Canada</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Game Rules & Strategy -->
    <section class="game-guide">
        <div class="container">
            <div class="guide-content">
                <div class="guide-main">
                    <h2>How to Play <?= htmlspecialchars($category['name']) ?></h2>
                    
                    <div class="guide-section">
                        <h3>📋 Basic Rules</h3>
                        <div class="rules-content">
                            <?php if ($category['slug'] === 'slots'): ?>
                            <p>Slot machines are the simplest casino games to play. Select your bet amount, spin the reels, and win when matching symbols align on paylines. Modern slots feature bonus rounds, free spins, and progressive jackpots.</p>
                            <ul>
                                <li>Choose your coin value and number of paylines</li>
                                <li>Click spin to start the reels</li>
                                <li>Win by matching symbols on active paylines</li>
                                <li>Trigger bonus features for bigger wins</li>
                            </ul>
                            <?php elseif ($category['slug'] === 'blackjack'): ?>
                            <p>The goal in blackjack is to beat the dealer's hand without exceeding 21. Cards 2-10 are worth face value, face cards are worth 10, and Aces are worth 1 or 11.</p>
                            <ul>
                                <li>Get as close to 21 as possible without going over</li>
                                <li>Beat the dealer's hand to win</li>
                                <li>Hit to take another card, stand to keep your total</li>
                                <li>Double down or split when advantageous</li>
                            </ul>
                            <?php elseif ($category['slug'] === 'roulette'): ?>
                            <p>Roulette involves betting on where a ball will land on a spinning wheel. Choose from various betting options including specific numbers, colors, or ranges.</p>
                            <ul>
                                <li>Place bets on numbers, colors, or sections</li>
                                <li>The dealer spins the wheel and drops the ball</li>
                                <li>Win if the ball lands on your bet</li>
                                <li>Different bets have different payout odds</li>
                            </ul>
                            <?php else: ?>
                            <p><?= htmlspecialchars($category['rules'] ?? $category['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="guide-section">
                        <h3>🎯 Strategy Tips</h3>
                        <div class="strategy-content">
                            <?php if ($category['slug'] === 'blackjack'): ?>
                            <div class="strategy-tips">
                                <div class="tip">
                                    <h4>Basic Strategy</h4>
                                    <p>Always use basic strategy charts to make mathematically optimal decisions. This reduces the house edge to around 0.5%.</p>
                                </div>
                                <div class="tip">
                                    <h4>Avoid Insurance</h4>
                                    <p>Never take insurance bets as they have a high house edge of about 7.4%.</p>
                                </div>
                                <div class="tip">
                                    <h4>Bankroll Management</h4>
                                    <p>Set win/loss limits and stick to them. Never bet more than you can afford to lose.</p>
                                </div>
                            </div>
                            <?php elseif ($category['slug'] === 'slots'): ?>
                            <div class="strategy-tips">
                                <div class="tip">
                                    <h4>Choose High RTP</h4>
                                    <p>Look for slots with RTP above 96% for better long-term returns.</p>
                                </div>
                                <div class="tip">
                                    <h4>Manage Your Bets</h4>
                                    <p>Adjust bet sizes based on your bankroll and the game's volatility.</p>
                                </div>
                                <div class="tip">
                                    <h4>Understand Volatility</h4>
                                    <p>High volatility slots pay larger but less frequent wins. Low volatility offers smaller, more frequent payouts.</p>
                                </div>
                            </div>
                            <?php else: ?>
                            <p>Focus on understanding the game mechanics, managing your bankroll effectively, and taking advantage of the best betting strategies for <?= strtolower($category['name']) ?>.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="guide-sidebar">
                    <div class="sidebar-card">
                        <h3>🎲 Quick Facts</h3>
                        <ul class="fact-list">
                            <li><strong>House Edge:</strong> <?= $category['house_edge'] ?? 'Varies' ?></li>
                            <li><strong>Skill Level:</strong> <?= htmlspecialchars($category['difficulty_level']) ?></li>
                            <li><strong>Min Bet:</strong> CAD <?= $category['min_bet'] ?></li>
                            <li><strong>Max Payout:</strong> <?= $category['max_payout'] ?? 'Unlimited' ?></li>
                            <li><strong>Mobile:</strong> ✅ Fully Supported</li>
                        </ul>
                    </div>
                    
                    <div class="sidebar-card">
                        <h3>🏆 Best Casinos</h3>
                        <p>Play <?= strtolower($category['name']) ?> at our top-rated Canadian casinos:</p>
                        <a href="/casinos?game=<?= $category['slug'] ?>" class="btn btn-primary btn-block">
                            Find Best Casinos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Games -->
    <section class="featured-games-section">
        <div class="container">
            <div class="section-header">
                <h2>🌟 Popular <?= htmlspecialchars($category['name']) ?> Games</h2>
                <p>The most popular <?= strtolower($category['name']) ?> games among Canadian players</p>
            </div>
            
            <div class="featured-games-grid">
                <?php foreach ($featuredGames as $game): ?>
                <div class="featured-game-card">
                    <div class="game-image">
                        <img src="/images/games/<?= $category['slug'] ?>/<?= strtolower(str_replace(' ', '-', $game)) ?>.jpg" 
                             alt="<?= htmlspecialchars($game) ?>"
                             onerror="this.src='/images/placeholder-game.svg'">
                    </div>
                    <div class="game-info">
                        <h4><?= htmlspecialchars($game) ?></h4>
                        <p>Popular <?= strtolower($category['name']) ?> game</p>
                        <div class="game-rating">
                            <span class="stars">⭐⭐⭐⭐⭐</span>
                            <span class="rating-text">Highly Rated</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Related Categories -->
    <section class="related-categories">
        <div class="container">
            <div class="section-header">
                <h2>🎮 Other Popular Games</h2>
                <p>Explore other exciting casino game categories</p>
            </div>
            
            <div class="related-grid">
                <?php foreach ($relatedCategories as $related): ?>
                <?php if ($related['slug'] !== $category['slug']): ?>
                <a href="/games/<?= $related['slug'] ?>" class="related-card">
                    <div class="related-icon">
                        <span class="icon"><?= $related['icon'] ?></span>
                    </div>
                    <div class="related-content">
                        <h4><?= htmlspecialchars($related['name']) ?></h4>
                        <p><?= htmlspecialchars($related['short_description']) ?></p>
                        <span class="related-rtp"><?= $related['average_rtp'] ?>% RTP</span>
                    </div>
                </a>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2>❓ Frequently Asked Questions</h2>
                <p>Common questions about <?= strtolower($category['name']) ?> games</p>
            </div>
            
            <div class="faq-list">
                <div class="faq-item">
                    <h3 class="faq-question">What is the RTP of <?= strtolower($category['name']) ?> games?</h3>
                    <div class="faq-answer">
                        <p>The average RTP (Return to Player) for <?= strtolower($category['name']) ?> games is <?= $category['average_rtp'] ?>%. This means that for every $100 wagered, the game returns approximately $<?= $category['average_rtp'] ?> to players over time.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <h3 class="faq-question">Can I play <?= strtolower($category['name']) ?> games for free?</h3>
                    <div class="faq-answer">
                        <p>Yes! Most online casinos offer free demo versions of <?= strtolower($category['name']) ?> games. This allows you to practice and learn the game mechanics before playing with real money.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <h3 class="faq-question">Are <?= strtolower($category['name']) ?> games legal in Canada?</h3>
                    <div class="faq-answer">
                        <p>Yes, <?= strtolower($category['name']) ?> games are legal to play at licensed online casinos in Canada. Make sure to play only at reputable, licensed operators.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <h3 class="faq-question">What's the minimum bet for <?= strtolower($category['name']) ?> games?</h3>
                    <div class="faq-answer">
                        <p>The minimum bet for <?= strtolower($category['name']) ?> games is typically CAD <?= $category['min_bet'] ?>, though this can vary between different games and casinos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="category-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Play <?= htmlspecialchars($category['name']) ?>?</h2>
                <p>Start playing <?= strtolower($category['name']) ?> games at our top-rated Canadian casinos</p>
                <div class="cta-buttons">
                    <a href="/casinos?game=<?= $category['slug'] ?>" class="btn btn-primary btn-lg">
                        Find Best Casinos
                    </a>
                    <a href="/bonuses" class="btn btn-outline btn-lg">
                        Claim Bonuses
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
    // FAQ accordion functionality
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            const faqItem = this.parentElement;
            const answer = faqItem.querySelector('.faq-answer');
            
            // Toggle current item
            faqItem.classList.toggle('active');
            
            if (faqItem.classList.contains('active')) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
            } else {
                answer.style.maxHeight = '0';
            }
        });
    });
    
    // Smooth animations on scroll
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
    
    document.querySelectorAll('.stat-card, .featured-game-card, .related-card, .faq-item').forEach(element => {
        observer.observe(element);
    });
    </script>
</body>
</html>
