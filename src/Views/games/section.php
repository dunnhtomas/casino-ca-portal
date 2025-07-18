<?php
/**
 * Popular Casino Games Grid - Homepage Section
 * Displays a responsive grid of 9 popular casino games with categories, RTP, and Canadian statistics
 * 
 * @var array $games Game categories data from GamesService
 * @var array $stats Game statistics from GamesService 
 * @var array $canadianData Canadian gaming preferences from GamesService
 */

// Apply CTO-level 2025 null safety and data validation
$safeGames = is_array($games ?? null) ? $games : [];
$safeStats = is_array($stats ?? null) ? $stats : [];
$safeCanadianData = is_array($canadianData ?? null) ? $canadianData : [];

// Provide default values for stats
$totalGames = $safeStats['total_games'] ?? 9;
$averageRtp = $safeStats['average_rtp'] ?? 96.5;
$canadianPlayers = $safeCanadianData['canadian_players'] ?? '50K+';
?>
<section class="games-grid-section" id="popular-games">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header text-center">
            <h2 class="section-title">
                <span class="icon">🎮</span>
                Popular Casino Games in Canada
            </h2>
            <p class="section-subtitle">
                Discover the most popular casino games with the highest RTP rates and best odds for Canadian players
            </p>
            <div class="section-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= htmlspecialchars((string)$totalGames, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></span>
                    <span class="stat-label">Game Types</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= htmlspecialchars((string)$averageRtp, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>%</span>
                    <span class="stat-label">Average RTP</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= htmlspecialchars((string)$canadianPlayers, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></span>
                    <span class="stat-label">Canadian Players</span>
                </div>
            </div>
        </div>

        <!-- Games Grid -->
        <div class="games-grid">
            <?php if (!empty($safeGames)): ?>
                <?php foreach ($safeGames as $index => $game): ?>
                    <?php
                    // Apply modern null safety to game data
                    $safeGame = is_array($game) ? $game : [];
                    $gameName = trim($safeGame['name'] ?? 'Unknown Game');
                    $gameSlug = $safeGame['slug'] ?? 'game-' . $index;
                    $gameIcon = $safeGame['icon'] ?? '🎰';
                    $gameDescription = trim($safeGame['short_description'] ?? 'Popular casino game');
                    $gameCount = (int)($safeGame['game_count'] ?? 50);
                    $gameRtp = (float)($safeGame['average_rtp'] ?? 96.5);
                    $popularityScore = (int)($safeGame['popularity_score'] ?? 80);
                    $isCanadianFavorite = (bool)($safeGame['canadian_favorite'] ?? false);
                    ?>
            <div class="game-card" data-category="<?= htmlspecialchars($gameSlug, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>" data-index="<?= $index ?>">
                <div class="game-card-inner">
                    <!-- Game Icon -->
                    <div class="game-icon">
                        <span class="icon"><?= htmlspecialchars($gameIcon, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></span>
                    </div>
                    
                    <!-- Game Info -->
                    <div class="game-info">
                        <h3 class="game-title"><?= htmlspecialchars($gameName, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></h3>
                        <p class="game-description"><?= htmlspecialchars($gameDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></p>
                        <!-- Game Stats -->
                        <div class="game-stats">
                            <div class="stat">
                                <span class="stat-label">Games:</span>
                                <span class="stat-value"><?= htmlspecialchars((string)$gameCount, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>+</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">RTP:</span>
                                <span class="stat-value highlight"><?= htmlspecialchars((string)$gameRtp, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>%</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Popularity:</span>
                                <span class="stat-value">
                                    <?php
                                    $stars = min(5, max(0, round($popularityScore / 20)));
                                    echo str_repeat('⭐', $stars) . str_repeat('☆', 5 - $stars);
                                    ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Canadian Focus -->
                        <?php if ($isCanadianFavorite): ?>
                        <div class="canadian-badge">
                            <span class="badge">🍁 Canadian Favorite</span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Action Buttons -->
                        <div class="game-actions">
                            <a href="/games/<?= htmlspecialchars($gameSlug, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>" class="btn btn-primary btn-sm">
                                Learn More
                            </a>
                            <button class="btn btn-outline btn-sm" onclick="openGameModal('<?= htmlspecialchars($gameSlug, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>')">
                                Quick View
                            </button>
                        </div>
                    </div>
                    
                    <!-- Hover Overlay -->
                    <div class="game-overlay">
                        <div class="overlay-content">
                            <h4><?= htmlspecialchars($gameName, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></h4>
                            <p><?= htmlspecialchars($safeGame['description'] ?? $gameDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></p>
                            <div class="featured-games">
                                <h5>Popular Games:</h5>
                                <ul>
                                    <?php 
                                    $featuredGames = $safeGame['featured_games'] ?? [];
                                    if (is_array($featuredGames) && !empty($featuredGames)): 
                                    ?>
                                        <?php foreach ($featuredGames as $featured): ?>
                                    <li><?= htmlspecialchars((string)$featured, ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li>No featured games available</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-games-message">
                    <p>No games available at this time.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Canadian Gaming Insights -->
        <div class="canadian-insights">
            <div class="insight-card">
                <h3>🍁 Canadian Gaming Preferences</h3>
                <div class="insights-grid">
                    <div class="insight-item">
                        <span class="insight-icon">🎰</span>
                        <div class="insight-content">
                            <h4>Most Popular</h4>
                            <p><?= htmlspecialchars($canadianData['most_popular_game']) ?></p>
                        </div>
                    </div>
                    <div class="insight-item">
                        <span class="insight-icon">💰</span>
                        <div class="insight-content">
                            <h4>Average Bet</h4>
                            <p>CAD <?= $canadianData['average_bet'] ?></p>
                        </div>
                    </div>
                    <div class="insight-item">
                        <span class="insight-icon">🏆</span>
                        <div class="insight-content">
                            <h4>Best RTP</h4>
                            <p><?= htmlspecialchars($canadianData['highest_rtp_game']) ?></p>
                        </div>
                    </div>
                    <div class="insight-item">
                        <span class="insight-icon">📱</span>
                        <div class="insight-content">
                            <h4>Mobile Play</h4>
                            <p><?= $canadianData['mobile_percentage'] ?>% prefer mobile</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="section-cta text-center">
            <h3>Ready to Start Playing?</h3>
            <p>Explore our complete games guide with detailed reviews, strategies, and casino recommendations</p>
            <div class="cta-buttons">
                <a href="/games" class="btn btn-primary btn-lg">
                    View All Games
                </a>
                <a href="/casinos" class="btn btn-outline btn-lg">
                    Find Best Casinos
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Game Modal (Quick View) -->
<div id="game-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modal-title">Game Details</h2>
            <button class="modal-close" onclick="closeGameModal()">&times;</button>
        </div>
        <div class="modal-body" id="modal-content">
            <!-- Dynamic content loaded via JavaScript -->
        </div>
    </div>
</div>

<!-- JavaScript for Interactive Features -->
<script>
// Game modal functionality
function openGameModal(slug) {
    const modal = document.getElementById('game-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalContent = document.getElementById('modal-content');
    
    // Show modal
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Load game details via API
    fetch(`/api/games/category/${slug}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const game = data.data.category;
                modalTitle.textContent = game.name;
                modalContent.innerHTML = `
                    <div class="modal-game-details">
                        <div class="game-icon-large">${game.icon}</div>
                        <p class="game-description">${game.description}</p>
                        <div class="game-stats-modal">
                            <div class="stat-row">
                                <span>Games Available:</span>
                                <span>${game.game_count}+</span>
                            </div>
                            <div class="stat-row">
                                <span>Average RTP:</span>
                                <span class="highlight">${game.average_rtp}%</span>
                            </div>
                            <div class="stat-row">
                                <span>Difficulty:</span>
                                <span>${game.difficulty_level}</span>
                            </div>
                            <div class="stat-row">
                                <span>Min Bet:</span>
                                <span>CAD ${game.min_bet}</span>
                            </div>
                        </div>
                        <div class="featured-games-modal">
                            <h4>Popular ${game.name} Games:</h4>
                            <ul>
                                ${data.data.featured_games.map(game => `<li>${game}</li>`).join('')}
                            </ul>
                        </div>
                        <div class="modal-actions">
                            <a href="/games/${game.slug}" class="btn btn-primary">Full Guide</a>
                            <a href="/casinos?game=${game.slug}" class="btn btn-outline">Find Casinos</a>
                        </div>
                    </div>
                `;
            } else {
                modalContent.innerHTML = '<p>Failed to load game details. Please try again.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading game details:', error);
            modalContent.innerHTML = '<p>Error loading game details. Please try again.</p>';
        });
}

function closeGameModal() {
    const modal = document.getElementById('game-modal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal on background click
document.getElementById('game-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeGameModal();
    }
});

// Escape key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeGameModal();
    }
});

// Card hover effects and animations
document.addEventListener('DOMContentLoaded', function() {
    const gameCards = document.querySelectorAll('.game-card');
    
    gameCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
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
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    gameCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});

// Schema.org structured data for SEO (CTO-level 2025 approach)
<?php
// Prepare safe schema data
$schemaData = [
    "@context" => "https://schema.org",
    "@type" => "ItemList",
    "name" => "Popular Casino Games in Canada",
    "description" => "Comprehensive guide to the most popular casino games available to Canadian players",
    "numberOfItems" => count($safeGames),
    "itemListElement" => []
];

if (!empty($safeGames)) {
    foreach ($safeGames as $index => $game) {
        $safeGame = is_array($game) ? $game : [];
        $schemaData["itemListElement"][] = [
            "@type" => "ListItem",
            "position" => $index + 1,
            "item" => [
                "@type" => "Game",
                "name" => trim($safeGame['name'] ?? 'Unknown Game'),
                "description" => trim($safeGame['description'] ?? $safeGame['short_description'] ?? 'Popular casino game'),
                "gameLocation" => "Online Casino",
                "numberOfPlayers" => "1+",
                "characterAttribute" => [
                    "@type" => "PropertyValue",
                    "name" => "RTP",
                    "value" => ((float)($safeGame['average_rtp'] ?? 96.5)) . "%"
                ]
            ]
        ];
    }
}

// Safe JSON encoding with error handling
try {
    $schemaJson = json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    error_log("JSON Schema encoding error in games section: " . $e->getMessage());
    $schemaJson = '{}';
}
?>

// Inject schema using modern CTO-level approach
const gamesSchema = <?= $schemaJson ?>;

// Safe schema injection
if (gamesSchema && typeof gamesSchema === 'object') {
    const script = document.createElement('script');
    script.type = 'application/ld+json';
    script.textContent = JSON.stringify(gamesSchema);
    document.head.appendChild(script);
}
</script>
