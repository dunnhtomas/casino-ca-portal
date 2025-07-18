<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Casinos by Category - Expert Canadian Casino Comparisons | Best Casino Portal</title>
    <meta name="description" content="Expert-curated best Canadian casinos by category. Compare top-rated casinos for slots, bonuses, live dealer games, payments & real money gaming.">
    <meta name="keywords" content="best casino Canada, top casino categories, casino comparison, best slots casino, best bonus casino, live dealer casino">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/css/category-comparison.css">
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Best Casinos by Category</h1>
                <p class="page-description">Expert-curated casino recommendations for every gaming preference. Our Canadian casino experts have analyzed hundreds of casinos to bring you the absolute best in each category.</p>
                
                <div class="author-info">
                    <small>Expert analysis by <strong><?= htmlspecialchars($author['name']) ?></strong>, <?= htmlspecialchars($author['title']) ?></small>
                </div>
            </div>

            <!-- Category Statistics -->
            <div class="stats-overview">
                <div class="stat-card">
                    <div class="stat-number"><?= $statistics['total_categories'] ?></div>
                    <div class="stat-label">Categories</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= number_format($statistics['average_rating'], 1) ?>/5</div>
                    <div class="stat-label">Avg Rating</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= number_format($statistics['total_games']) ?>+</div>
                    <div class="stat-label">Total Games</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $statistics['highest_rtp'] ?>%</div>
                    <div class="stat-label">Highest RTP</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">$<?= number_format($statistics['best_bonus_amount']) ?></div>
                    <div class="stat-label">Best Bonus</div>
                </div>
            </div>

            <!-- Category Comparison Table -->
            <div class="category-table-container">
                <table class="category-comparison-table">
                    <thead>
                        <tr>
                            <th class="category-column">Category</th>
                            <th class="casino-column">Best Casino</th>
                            <th class="rating-column">Rating</th>
                            <th class="rtp-column">RTP</th>
                            <th class="games-column">Games</th>
                            <th class="highlight-column">Why It's Best</th>
                            <th class="action-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr class="category-row">
                                <td class="category-cell">
                                    <div class="category-info">
                                        <span class="category-icon"><?= $category['icon'] ?></span>
                                        <span class="category-name"><?= htmlspecialchars($category['category']) ?></span>
                                    </div>
                                </td>
                                <td class="casino-cell">
                                    <div class="casino-info">
                                        <div class="casino-logo"><?= htmlspecialchars($category['casino_logo']) ?></div>
                                        <div class="casino-details">
                                            <h3 class="casino-name"><?= htmlspecialchars($category['casino_name']) ?></h3>
                                            <div class="casino-bonus"><?= htmlspecialchars($category['bonus']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="rating-cell">
                                    <div class="rating-display">
                                        <span class="rating-stars">⭐</span>
                                        <span class="rating-number"><?= number_format($category['rating'], 1) ?>/5</span>
                                    </div>
                                </td>
                                <td class="rtp-cell">
                                    <div class="rtp-display">
                                        <span class="rtp-number"><?= $category['rtp'] ?>%</span>
                                        <span class="rtp-label">RTP</span>
                                    </div>
                                </td>
                                <td class="games-cell">
                                    <div class="games-display">
                                        <span class="games-number"><?= number_format($category['games']) ?>+</span>
                                        <span class="games-label">Games</span>
                                    </div>
                                </td>
                                <td class="highlight-cell">
                                    <div class="highlight-text"><?= htmlspecialchars($category['highlight']) ?></div>
                                </td>
                                <td class="action-cell">
                                    <div class="action-buttons">
                                        <a href="/casino/<?= htmlspecialchars($category['casino_slug']) ?>" class="btn btn-secondary">Details</a>
                                        <a href="/casino/<?= htmlspecialchars($category['casino_slug']) ?>/play" class="btn btn-primary">Play Now</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Expert Analysis Section -->
            <div class="expert-analysis">
                <h2>Expert Category Analysis</h2>
                <div class="author-bio">
                    <p><strong><?= htmlspecialchars($author['name']) ?></strong> has been analyzing Canadian online casinos for <?= htmlspecialchars($author['experience']) ?>. <?= htmlspecialchars($author['bio']) ?></p>
                </div>
                
                <div class="analysis-content">
                    <h3>How We Choose Category Leaders</h3>
                    <p>Our category selections are based on rigorous testing and analysis across multiple criteria:</p>
                    
                    <div class="criteria-grid">
                        <div class="criteria-card">
                            <h4>💸 Real Money Excellence</h4>
                            <p>We evaluate payout percentages, withdrawal speeds, and overall value for money players.</p>
                        </div>
                        <div class="criteria-card">
                            <h4>🎰 Slot Game Quality</h4>
                            <p>Comprehensive slot libraries, exclusive titles, and progressive jackpot availability.</p>
                        </div>
                        <div class="criteria-card">
                            <h4>💰 Bonus Value</h4>
                            <p>Generous amounts, fair wagering requirements, and ongoing promotional value.</p>
                        </div>
                        <div class="criteria-card">
                            <h4>💳 Payment Flexibility</h4>
                            <p>Multiple payment options, fast processing, and minimal fees for Canadian players.</p>
                        </div>
                        <div class="criteria-card">
                            <h4>🎲 Live Casino Experience</h4>
                            <p>Professional dealers, game variety, and immersive gaming technology.</p>
                        </div>
                    </div>
                    
                    <h3>Category Methodology</h3>
                    <p>Each category winner is selected through a comprehensive evaluation process:</p>
                    <ul>
                        <li><strong>Data Analysis:</strong> Real-time RTP monitoring and payout verification</li>
                        <li><strong>Expert Testing:</strong> Hands-on evaluation by our team of casino professionals</li>
                        <li><strong>Player Feedback:</strong> Community reviews and satisfaction surveys</li>
                        <li><strong>Market Research:</strong> Competitive analysis and industry benchmarking</li>
                        <li><strong>Compliance Review:</strong> Licensing verification and regulatory compliance</li>
                    </ul>
                </div>
            </div>

            <!-- Detailed Category Breakdown -->
            <div class="category-breakdown">
                <h2>Detailed Category Analysis</h2>
                
                <?php foreach ($categories as $category): ?>
                    <div class="category-detail-card">
                        <div class="category-header">
                            <span class="category-icon"><?= $category['icon'] ?></span>
                            <h3><?= htmlspecialchars($category['category']) ?></h3>
                            <div class="winner-badge">Winner: <?= htmlspecialchars($category['casino_name']) ?></div>
                        </div>
                        
                        <div class="category-content">
                            <div class="expert-opinion">
                                <h4>Expert Opinion</h4>
                                <p><?= htmlspecialchars($category['expert_note']) ?></p>
                            </div>
                            
                            <div class="key-features">
                                <h4>Key Features</h4>
                                <ul>
                                    <?php foreach ($category['key_features'] as $feature): ?>
                                        <li><?= htmlspecialchars($feature) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- FAQ Section -->
            <div class="faq-section">
                <h2>Frequently Asked Questions</h2>
                
                <div class="faq-item">
                    <h3>How often are category leaders updated?</h3>
                    <p>We review and update our category leaders monthly, with real-time monitoring of key metrics like RTP and payout speeds.</p>
                </div>
                
                <div class="faq-item">
                    <h3>What makes a casino the "best" in a category?</h3>
                    <p>Category winners excel in specific areas while maintaining high standards across all evaluation criteria including safety, fairness, and customer service.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Are these recommendations specific to Canadian players?</h3>
                    <p>Yes, all recommendations are tailored for Canadian players, considering local regulations, payment methods, and currency support.</p>
                </div>
                
                <div class="faq-item">
                    <h3>How do you verify RTP percentages?</h3>
                    <p>We obtain RTP data directly from casino operators and cross-reference with independent testing laboratories and regulatory reports.</p>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="cta-section">
                <h2>Ready to Play at a Category Leader?</h2>
                <p>Start with any of our expert-recommended casinos and experience the best in Canadian online gaming.</p>
                <div class="cta-buttons">
                    <a href="/reviews" class="btn btn-primary">Read Detailed Reviews</a>
                    <a href="/bonuses" class="btn btn-secondary">Compare All Bonuses</a>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
