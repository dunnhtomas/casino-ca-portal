<?php
/**
 * Popular Casino Games Grid - Homepage Section
 * Displays a responsive grid of 9 popular casino games with categories, RTP, and Canadian statistics
 * 
 * @var array $games Game categories data from GamesService
 * @var array $stats Game statistics from GamesService 
 * @var array $canadianData Canadian gaming preferences from GamesService
 */
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
                    <span class="stat-number"><?= $stats['total_games'] ?></span>
                    <span class="stat-label">Game Types</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= $stats['average_rtp'] ?>%</span>
                    <span class="stat-label">Average RTP</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= $canadianData['canadian_players'] ?></span>
                    <span class="stat-label">Canadian Players</span>
                </div>
            </div>
        </div>

        <!-- Games Grid -->
        <div class="games-grid">
            <?php foreach ($games as $index => $game): ?>
            <div class="game-card" data-category="<?= htmlspecialchars($game['slug']) ?>" data-index="<?= $index ?>">
                <div class="game-card-inner">
                    <!-- Game Icon -->
                    <div class="game-icon">
                        <span class="icon"><?= $game['icon'] ?></span>
                    </div>
                    
                    <!-- Game Info -->
                    <div class="game-info">
                        <h3 class="game-title"><?= htmlspecialchars($game['name']) ?></h3>
                        <p class="game-description"><?= htmlspecialchars($game['short_description']) ?></p>
                        
                        <!-- Game Stats -->
                        <div class="game-stats">
                            <div class="stat">
                                <span class="stat-label">Games:</span>
                                <span class="stat-value"><?= $game['game_count'] ?>+</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">RTP:</span>
                                <span class="stat-value highlight"><?= $game['average_rtp'] ?>%</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Popularity:</span>
                                <span class="stat-value">
                                    <?php
                                    $stars = round($game['popularity_score'] / 20);
                                    echo str_repeat('⭐', $stars) . str_repeat('☆', 5 - $stars);
                                    ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Canadian Focus -->
                        <?php if (isset($game['canadian_favorite']) && $game['canadian_favorite']): ?>
                        <div class="canadian-badge">
                            <span class="badge">🍁 Canadian Favorite</span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Action Buttons -->
                        <div class="game-actions">
                            <a href="/games/<?= $game['slug'] ?>" class="btn btn-primary btn-sm">
                                Learn More
                            </a>
                            <button class="btn btn-outline btn-sm" onclick="openGameModal('<?= $game['slug'] ?>')">
                                Quick View
                            </button>
                        </div>
                    </div>
                    
                    <!-- Hover Overlay -->
                    <div class="game-overlay">
                        <div class="overlay-content">
                            <h4><?= htmlspecialchars($game['name']) ?></h4>
                            <p><?= htmlspecialchars($game['description']) ?></p>
                            <div class="featured-games">
                                <h5>Popular Games:</h5>
                                <ul>
                                    <?php foreach ($game['featured_games'] as $featured): ?>
                                    <li><?= htmlspecialchars($featured) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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

// Schema.org structured data for SEO
const gamesSchema = {
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "Popular Casino Games in Canada",
    "description": "Comprehensive guide to the most popular casino games available to Canadian players",
    "numberOfItems": <?= count($games) ?>,
    "itemListElement": [
        <?php foreach ($games as $index => $game): ?>
        {
            "@type": "ListItem",
            "position": <?= $index + 1 ?>,
            "item": {
                "@type": "Game",
                "name": "<?= addslashes(htmlspecialchars($game['name'])) ?>",
                "description": "<?= addslashes(htmlspecialchars($game['description'])) ?>",
                "gameLocation": "Online Casino",
                "numberOfPlayers": "1+",
                "characterAttribute": {
                    "@type": "PropertyValue",
                    "name": "RTP",
                    "value": "<?= $game['average_rtp'] ?>%"
                }
            }
        }<?php if ($index < count($games) - 1): ?>,<?php endif; ?>
        <?php endforeach; ?>
    ]
};

// Inject schema into page head
const script = document.createElement('script');
script.type = 'application/ld+json';
script.textContent = JSON.stringify(gamesSchema);
document.head.appendChild(script);
</script>
