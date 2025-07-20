<?php 
/**
 * Extended Top Casinos Homepage Section
 * Displays preview of top 8 casinos with comparison features
 */
?>

<section class="extended-top-casinos-section" id="extended-top-casinos">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Top 15 Canadian Online Casinos - Full Comparison</h2>
            <p class="section-subtitle">
                Compare Canada's highest-rated online casinos with detailed analysis, expert ratings, and comprehensive comparison tools
            </p>
        </div>

        <div class="casino-stats-bar">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number"><?= $stats['total_casinos'] ?></span>
                    <span class="stat-label">Casinos Reviewed</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= $stats['average_rating'] ?>/10</span>
                    <span class="stat-label">Average Rating</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">$<?= number_format($stats['bonus_range']['max']) ?></span>
                    <span class="stat-label">Highest Bonus</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= number_format($stats['game_count_range']['max']) ?></span>
                    <span class="stat-label">Most Games</span>
                </div>
            </div>
        </div>

        <!-- Casino Comparison Table Preview -->
        <div class="casino-comparison-preview">
            <div class="table-container">
                <table class="casino-comparison-table">
                    <thead>
                        <tr>
                            <th class="casino-column">Casino</th>
                            <th class="rating-column">Rating</th>
                            <th class="bonus-column">Welcome Bonus</th>
                            <th class="games-column">Games</th>
                            <th class="mobile-column">Mobile</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($casinos as $index => $casino): ?>
                        <tr class="casino-row" data-casino-id="<?= $casino['id'] ?>">
                            <!-- Casino Info -->
                            <td class="casino-info">
                                <div class="casino-basic">
                                    <div class="casino-logo">
                                        <img src="<?= htmlspecialchars($casino['logo'] ?? '/images/casino-placeholder.png') ?>" 
                                             alt="<?= htmlspecialchars($casino['name']) ?>" 
                                             onerror="this.src='/images/casino-placeholder.png'">
                                    </div>
                                    <div class="casino-details">
                                        <h3 class="casino-name"><?= htmlspecialchars($casino['name']) ?></h3>
                                        <div class="casino-badges">
                                            <span class="establishment-badge <?= $casino['establishment_badge']['class'] ?>">
                                                <?= $casino['establishment_badge']['text'] ?>
                                            </span>
                                            <span class="security-badge <?= $casino['security_level']['class'] ?>">
                                                <?= $casino['security_level']['level'] ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Rating -->
                            <td class="rating-info">
                                <div class="overall-rating">
                                    <span class="rating-number"><?= $casino['display_rating'] ?></span>
                                    <div class="star-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="star <?= $i <= $casino['star_rating'] ? 'filled' : '' ?>">★</span>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="rating-breakdown">
                                    <small>Security: <?= number_format($casino['category_ratings']['security'], 1) ?></small>
                                    <small>Games: <?= number_format($casino['category_ratings']['games'], 1) ?></small>
                                </div>
                            </td>

                            <!-- Welcome Bonus -->
                            <td class="bonus-info">
                                <div class="bonus-highlight">
                                    <span class="bonus-amount"><?= $casino['welcome_bonus_formatted']['formatted_amount'] ?></span>
                                    <?php if ($casino['welcome_bonus_formatted']['has_free_spins']): ?>
                                        <span class="free-spins">+ <?= $casino['welcome_bonus_formatted']['free_spins_count'] ?> Free Spins</span>
                                    <?php endif; ?>
                                </div>
                                <div class="bonus-text">
                                    <small><?= htmlspecialchars($casino['welcome_bonus'] ?? 'Bonus Available') ?></small>
                                </div>
                            </td>

                            <!-- Games -->
                            <td class="games-info">
                                <div class="game-count">
                                    <span class="games-number"><?= number_format($casino['games_count']) ?></span>
                                    <span class="games-label">Games</span>
                                </div>
                                <div class="game-providers">
                                    <?php 
                                    $providers = array_slice($casino['target_markets'] ?? ['NetEnt', 'Microgaming'], 0, 2);
                                    echo '<small>' . implode(', ', $providers) . '</small>';
                                    ?>
                                </div>
                            </td>

                            <!-- Mobile -->
                            <td class="mobile-info">
                                <div class="mobile-rating">
                                    <span class="mobile-status <?= $casino['mobile_compatibility']['has_app'] ? 'has-app' : 'web-only' ?>">
                                        <?= $casino['mobile_compatibility']['rating'] ?>
                                    </span>
                                </div>
                                <div class="mobile-features">
                                    <small><?= implode(', ', array_slice($casino['mobile_compatibility']['features'], 0, 2)) ?></small>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="actions-info">
                                <div class="action-buttons">
                                    <a href="/casino/<?= strtolower($casino['name']) ?>" class="btn btn-primary btn-small">
                                        Play Now
                                    </a>
                                    <button class="btn btn-secondary btn-small quick-view-btn" 
                                            data-casino-id="<?= $casino['id'] ?>">
                                        Quick View
                                    </button>
                                </div>
                                <div class="processing-time">
                                    <small><?= $casino['processing_time']['text'] ?></small>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="extended-stats-grid">
            <div class="stat-card">
                <h4>Rating Distribution</h4>
                <div class="rating-bars">
                    <?php foreach ($stats['rating_distribution'] as $range => $count): ?>
                    <div class="rating-bar">
                        <span class="range-label"><?= $range ?></span>
                        <div class="bar-container">
                            <div class="bar-fill" style="width: <?= ($count / $stats['total_casinos'] * 100) ?>%"></div>
                        </div>
                        <span class="count"><?= $count ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="stat-card">
                <h4>Bonus Range</h4>
                <div class="bonus-stats">
                    <div class="bonus-stat">
                        <span class="label">Highest:</span>
                        <span class="value">$<?= number_format($stats['bonus_range']['max']) ?></span>
                    </div>
                    <div class="bonus-stat">
                        <span class="label">Average:</span>
                        <span class="value">$<?= number_format($stats['bonus_range']['average']) ?></span>
                    </div>
                    <div class="bonus-stat">
                        <span class="label">Entry Level:</span>
                        <span class="value">$<?= number_format($stats['bonus_range']['min']) ?></span>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <h4>Game Library</h4>
                <div class="game-stats">
                    <div class="game-stat">
                        <span class="label">Largest:</span>
                        <span class="value"><?= number_format($stats['game_count_range']['max']) ?></span>
                    </div>
                    <div class="game-stat">
                        <span class="label">Average:</span>
                        <span class="value"><?= number_format($stats['game_count_range']['average']) ?></span>
                    </div>
                    <div class="game-stat">
                        <span class="label">Minimum:</span>
                        <span class="value"><?= number_format($stats['game_count_range']['min']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="section-cta">
            <div class="cta-content">
                <h3>Want to See All <?= $total_casinos ?> Casinos?</h3>
                <p>Access our complete comparison tool with advanced filtering, detailed reviews, and side-by-side comparisons.</p>
                <div class="cta-buttons">
                    <a href="/extended-top-casinos" class="btn btn-primary btn-large">
                        View Full Comparison
                    </a>
                    <a href="/api/extended-top-casinos" class="btn btn-secondary btn-large">
                        Download Data (JSON)
                    </a>
                </div>
            </div>
            <div class="cta-features">
                <div class="feature-list">
                    <div class="feature-item">
                        <span class="feature-icon">🔍</span>
                        <span>Advanced Filtering</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">⚖️</span>
                        <span>Side-by-Side Comparison</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">📊</span>
                        <span>Detailed Analytics</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">🎯</span>
                        <span>Expert Recommendations</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal Placeholder -->
    <div id="quick-view-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div id="quick-view-content">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
</section>
