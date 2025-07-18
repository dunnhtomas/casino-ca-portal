<!-- Best Casinos by Category Section -->
<section class="section category-comparison-section">
    <div class="container">
        <div class="section-header">
            <h2>Best Casinos by Category</h2>
            <p class="section-description">Expert-curated casino recommendations for every gaming preference</p>
        </div>
        
        <div class="category-table-compact">
            <?php foreach ($categories as $category): ?>
                <div class="category-row-compact">
                    <div class="category-info">
                        <span class="category-icon"><?= $category['icon'] ?></span>
                        <div class="category-details">
                            <h3 class="category-title"><?= htmlspecialchars($category['category']) ?></h3>
                            <p class="category-subtitle"><?= htmlspecialchars($category['highlight']) ?></p>
                        </div>
                    </div>
                    
                    <div class="casino-winner">
                        <div class="casino-logo"><?= htmlspecialchars($category['casino_logo']) ?></div>
                        <div class="casino-details">
                            <h4 class="casino-name"><?= htmlspecialchars($category['casino_name']) ?></h4>
                            <div class="casino-metrics">
                                <span class="rating">⭐ <?= number_format($category['rating'], 1) ?></span>
                                <span class="rtp"><?= $category['rtp'] ?>% RTP</span>
                                <span class="games"><?= number_format($category['games']) ?>+ Games</span>
                            </div>
                            <div class="casino-bonus"><?= htmlspecialchars($category['bonus']) ?></div>
                        </div>
                    </div>
                    
                    <div class="category-actions">
                        <a href="/casino/<?= htmlspecialchars($category['casino_slug']) ?>" class="btn btn-secondary btn-sm">Details</a>
                        <a href="/casino/<?= htmlspecialchars($category['casino_slug']) ?>/play" class="btn btn-primary btn-sm">Play Now</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="section-footer">
            <div class="category-stats">
                <div class="stat">
                    <span class="stat-number"><?= $statistics['total_categories'] ?></span>
                    <span class="stat-label">Categories</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?= number_format($statistics['average_rating'], 1) ?>/5</span>
                    <span class="stat-label">Avg Rating</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?= $statistics['highest_rtp'] ?>%</span>
                    <span class="stat-label">Best RTP</span>
                </div>
            </div>
            
            <div class="section-cta">
                <a href="/category-comparison" class="btn btn-outline">View Full Comparison</a>
            </div>
        </div>
    </div>
</section>
