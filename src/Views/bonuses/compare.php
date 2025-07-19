<?php 
    $pageTitle = $title ?? 'Casino Bonus Comparison';
    $pageDescription = $meta_description ?? 'Compare casino bonuses side-by-side';
?>

<div class="bonus-comparison-page">
    <!-- Hero Section -->
    <section class="comparison-hero">
        <div class="container">
            <h1 class="page-title">📊 Casino Bonus Comparison Tool</h1>
            <p class="page-subtitle">Compare casino bonuses side-by-side to find the best deal for your playing style</p>
            
            <?php if (count($bonuses) > 0): ?>
                <div class="comparison-summary">
                    Comparing <strong><?= count($bonuses) ?></strong> bonus<?= count($bonuses) > 1 ? 'es' : '' ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php if (count($bonuses) === 0): ?>
        <!-- Empty State -->
        <section class="empty-state">
            <div class="container">
                <div class="empty-content">
                    <h2>No Bonuses Selected</h2>
                    <p>You haven't selected any bonuses to compare yet. Choose bonuses from our database to see a detailed side-by-side comparison.</p>
                    <div class="empty-actions">
                        <a href="/bonuses" class="btn btn-primary">Browse All Bonuses</a>
                        <a href="/bonuses/calculator" class="btn btn-outline">Try Calculator</a>
                    </div>
                </div>
                
                <div class="comparison-features">
                    <h3>What You Can Compare</h3>
                    <div class="features-grid">
                        <div class="feature">
                            <div class="feature-icon">💰</div>
                            <h4>Bonus Values</h4>
                            <p>Compare bonus amounts, percentages, and free spins</p>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">🎯</div>
                            <h4>Wagering Requirements</h4>
                            <p>See which bonuses have the most favorable terms</p>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">⏰</div>
                            <h4>Time Limits</h4>
                            <p>Compare how long you have to complete wagering</p>
                        </div>
                        <div class="feature">
                            <div class="feature-icon">🎮</div>
                            <h4>Game Restrictions</h4>
                            <p>Understand which games count toward requirements</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php else: ?>
        <!-- Comparison Table -->
        <section class="comparison-section">
            <div class="container">
                <div class="comparison-controls">
                    <div class="controls-left">
                        <button id="addMoreBtn" class="btn btn-outline">+ Add More Bonuses</button>
                        <button id="clearAllBtn" class="btn btn-outline">Clear All</button>
                    </div>
                    <div class="controls-right">
                        <button id="shareComparisonBtn" class="btn btn-secondary">Share Comparison</button>
                        <button id="printComparisonBtn" class="btn btn-outline">Print</button>
                    </div>
                </div>
                
                <div class="comparison-table-container">
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th class="feature-column">Features</th>
                                <?php foreach ($bonuses as $index => $bonus): ?>
                                    <th class="bonus-column">
                                        <div class="bonus-header">
                                            <button class="remove-bonus" data-bonus-id="<?= $bonus->id ?>">×</button>
                                            <div class="casino-info">
                                                <?php if (isset($bonus->casino_logo)): ?>
                                                    <img src="<?= $bonus->casino_logo ?>" alt="<?= $bonus->casino_name ?>" class="casino-logo">
                                                <?php endif; ?>
                                                <span class="casino-name"><?= $bonus->casino_name ?? 'Casino' ?></span>
                                            </div>
                                        </div>
                                    </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Bonus Title -->
                            <tr class="feature-row">
                                <td class="feature-label">Bonus Offer</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <strong><?= htmlspecialchars($bonus->title) ?></strong>
                                        <?php if ($bonus->featured): ?>
                                            <span class="badge featured">Featured</span>
                                        <?php endif; ?>
                                        <?php if ($bonus->exclusive): ?>
                                            <span class="badge exclusive">Exclusive</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Bonus Type -->
                            <tr class="feature-row">
                                <td class="feature-label">Bonus Type</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <span class="bonus-type"><?= ucfirst(str_replace('_', ' ', $bonus->bonus_type)) ?></span>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Bonus Value -->
                            <tr class="feature-row highlight">
                                <td class="feature-label">💰 Bonus Value</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <div class="value-breakdown">
                                            <?php if ($bonus->bonus_amount): ?>
                                                <div class="amount">Up to $<?= number_format($bonus->bonus_amount) ?></div>
                                            <?php endif; ?>
                                            <?php if ($bonus->bonus_percentage): ?>
                                                <div class="percentage"><?= $bonus->bonus_percentage ?>% Match</div>
                                            <?php endif; ?>
                                            <?php if ($bonus->free_spins_count): ?>
                                                <div class="free-spins"><?= $bonus->free_spins_count ?> Free Spins</div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Wagering Requirements -->
                            <tr class="feature-row highlight">
                                <td class="feature-label">🎯 Wagering Requirement</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <div class="wagering-info">
                                            <span class="wagering-amount"><?= $bonus->wagering_requirement ?>x</span>
                                            <?php
                                            $wageringLevel = 'medium';
                                            if ($bonus->wagering_requirement <= 25) $wageringLevel = 'good';
                                            elseif ($bonus->wagering_requirement >= 40) $wageringLevel = 'high';
                                            ?>
                                            <span class="wagering-level <?= $wageringLevel ?>">
                                                <?= $wageringLevel === 'good' ? 'Low' : ($wageringLevel === 'high' ? 'High' : 'Medium') ?>
                                            </span>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Min Deposit -->
                            <tr class="feature-row">
                                <td class="feature-label">💳 Minimum Deposit</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <span class="min-deposit">$<?= number_format($bonus->min_deposit) ?></span>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Time Limit -->
                            <tr class="feature-row">
                                <td class="feature-label">⏰ Time Limit</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <span class="time-limit"><?= $bonus->time_limit_days ?> days</span>
                                        <?php if ($bonus->time_limit_days >= 14): ?>
                                            <span class="time-level good">Generous</span>
                                        <?php elseif ($bonus->time_limit_days >= 7): ?>
                                            <span class="time-level medium">Standard</span>
                                        <?php else: ?>
                                            <span class="time-level high">Limited</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Game Restrictions -->
                            <tr class="feature-row">
                                <td class="feature-label">🎮 Game Restrictions</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <span class="game-restrictions"><?= htmlspecialchars($bonus->game_restrictions) ?></span>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Bonus Code -->
                            <tr class="feature-row">
                                <td class="feature-label">🔑 Bonus Code</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <?php if ($bonus->bonus_code): ?>
                                            <code class="bonus-code" onclick="copyCode(this)"><?= $bonus->bonus_code ?></code>
                                        <?php else: ?>
                                            <span class="no-code">No code required</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Overall Rating -->
                            <tr class="feature-row highlight">
                                <td class="feature-label">⭐ Overall Rating</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <?php
                                        // Calculate a simple rating based on various factors
                                        $rating = 3; // Base rating
                                        if ($bonus->wagering_requirement <= 25) $rating += 1;
                                        if ($bonus->wagering_requirement <= 20) $rating += 0.5;
                                        if ($bonus->time_limit_days >= 14) $rating += 0.5;
                                        if ($bonus->featured) $rating += 0.5;
                                        if ($bonus->exclusive) $rating += 0.5;
                                        if ($bonus->min_deposit <= 10) $rating += 0.5;
                                        $rating = min(5, $rating); // Cap at 5
                                        ?>
                                        <div class="rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="star <?= $i <= $rating ? 'filled' : '' ?>">★</span>
                                            <?php endfor; ?>
                                            <span class="rating-value"><?= number_format($rating, 1) ?>/5</span>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            
                            <!-- Action Buttons -->
                            <tr class="action-row">
                                <td class="feature-label">Actions</td>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <td class="bonus-value">
                                        <div class="bonus-actions">
                                            <a href="/bonuses/calculator?bonus_id=<?= $bonus->id ?>" 
                                               class="btn btn-sm btn-secondary">Calculate Value</a>
                                            <a href="<?= $bonus->affiliate_link ?>" 
                                               class="btn btn-sm btn-primary" 
                                               target="_blank" 
                                               rel="nofollow">Get Bonus</a>
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Comparison Summary -->
                <div class="comparison-summary-section">
                    <h3>🎯 Comparison Summary</h3>
                    <div class="summary-cards">
                        <?php if (count($bonuses) >= 2): ?>
                            <?php
                            // Find best in each category
                            $bestValue = null;
                            $bestWagering = null;
                            $bestTime = null;
                            $bestMinDeposit = null;
                            
                            foreach ($bonuses as $bonus) {
                                if (!$bestValue || ($bonus->bonus_amount > $bestValue->bonus_amount)) {
                                    $bestValue = $bonus;
                                }
                                if (!$bestWagering || ($bonus->wagering_requirement < $bestWagering->wagering_requirement)) {
                                    $bestWagering = $bonus;
                                }
                                if (!$bestTime || ($bonus->time_limit_days > $bestTime->time_limit_days)) {
                                    $bestTime = $bonus;
                                }
                                if (!$bestMinDeposit || ($bonus->min_deposit < $bestMinDeposit->min_deposit)) {
                                    $bestMinDeposit = $bonus;
                                }
                            }
                            ?>
                            
                            <div class="summary-card">
                                <h4>💰 Highest Value</h4>
                                <p><strong><?= htmlspecialchars($bestValue->title) ?></strong></p>
                                <p>$<?= number_format($bestValue->bonus_amount) ?></p>
                            </div>
                            
                            <div class="summary-card">
                                <h4>🎯 Best Wagering</h4>
                                <p><strong><?= htmlspecialchars($bestWagering->title) ?></strong></p>
                                <p><?= $bestWagering->wagering_requirement ?>x requirement</p>
                            </div>
                            
                            <div class="summary-card">
                                <h4>⏰ Most Time</h4>
                                <p><strong><?= htmlspecialchars($bestTime->title) ?></strong></p>
                                <p><?= $bestTime->time_limit_days ?> days to complete</p>
                            </div>
                            
                            <div class="summary-card">
                                <h4>💳 Lowest Deposit</h4>
                                <p><strong><?= htmlspecialchars($bestMinDeposit->title) ?></strong></p>
                                <p>$<?= number_format($bestMinDeposit->min_deposit) ?> minimum</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="expert-recommendation">
                        <h4>💡 Expert Recommendation</h4>
                        <?php if (count($bonuses) >= 2): ?>
                            <p>Based on our analysis, we recommend considering the <strong><?= htmlspecialchars($bestWagering->title) ?></strong> 
                            for its favorable <?= $bestWagering->wagering_requirement ?>x wagering requirement, which gives you the best chance 
                            of successfully completing the bonus requirements.</p>
                        <?php else: ?>
                            <p>Add more bonuses to get personalized recommendations based on your playing preferences.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Related Tools -->
    <section class="related-tools">
        <div class="container">
            <h2>Bonus Analysis Tools</h2>
            <div class="tools-grid">
                <div class="tool-card">
                    <h4>🧮 Bonus Calculator</h4>
                    <p>Calculate the exact value and expected return of any casino bonus.</p>
                    <a href="/bonuses/calculator" class="btn btn-primary">Use Calculator</a>
                </div>
                <div class="tool-card">
                    <h4>📚 Bonus Guide</h4>
                    <p>Learn about different types of bonuses and how to maximize their value.</p>
                    <a href="/bonuses/types" class="btn btn-outline">Read Guide</a>
                </div>
                <div class="tool-card">
                    <h4>🎰 All Bonuses</h4>
                    <p>Browse our complete database of verified casino bonuses.</p>
                    <a href="/bonuses" class="btn btn-outline">Browse All</a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Bonus Comparison Styles */
.bonus-comparison-page {
    padding: 0;
}

.comparison-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 60px 0;
    text-align: center;
}

.page-title {
    font-size: 3rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.page-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 1rem;
}

.comparison-summary {
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem 2rem;
    border-radius: 25px;
    display: inline-block;
    margin-top: 1rem;
}

/* Empty State */
.empty-state {
    padding: 4rem 0;
    text-align: center;
}

.empty-content h2 {
    color: #2c3e50;
    margin-bottom: 1rem;
}

.empty-actions {
    margin: 2rem 0;
}

.empty-actions .btn {
    margin: 0 0.5rem;
}

.comparison-features {
    margin-top: 3rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.feature {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.feature-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

/* Comparison Section */
.comparison-section {
    padding: 3rem 0;
}

.comparison-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
}

.controls-left,
.controls-right {
    display: flex;
    gap: 1rem;
}

.comparison-table-container {
    overflow-x: auto;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.comparison-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

.comparison-table th,
.comparison-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
    vertical-align: top;
}

.feature-column {
    background: #f8f9fa;
    font-weight: 600;
    color: #495057;
    width: 200px;
    position: sticky;
    left: 0;
    z-index: 10;
}

.bonus-column {
    background: #f8f9fa;
    text-align: center;
    width: 250px;
}

.bonus-header {
    position: relative;
}

.remove-bonus {
    position: absolute;
    top: -0.5rem;
    right: -0.5rem;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    cursor: pointer;
    font-size: 1rem;
    line-height: 1;
}

.casino-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.casino-logo {
    width: 60px;
    height: 40px;
    object-fit: contain;
}

.casino-name {
    font-weight: 600;
    font-size: 0.9rem;
}

.feature-row.highlight {
    background: #f8f9fa;
}

.feature-label {
    font-weight: 600;
    color: #495057;
}

.bonus-value {
    text-align: center;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-left: 0.5rem;
}

.badge.featured {
    background: #ffd700;
    color: #333;
}

.badge.exclusive {
    background: #dc3545;
    color: white;
}

.bonus-type {
    background: #e3f2fd;
    color: #1976d2;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.value-breakdown {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.amount {
    font-size: 1.2rem;
    font-weight: 700;
    color: #28a745;
}

.percentage {
    font-size: 0.9rem;
    color: #007bff;
}

.free-spins {
    font-size: 0.9rem;
    color: #6f42c1;
}

.wagering-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.wagering-amount {
    font-size: 1.2rem;
    font-weight: 700;
}

.wagering-level,
.time-level {
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.wagering-level.good,
.time-level.good {
    background: #d4edda;
    color: #155724;
}

.wagering-level.medium,
.time-level.medium {
    background: #fff3cd;
    color: #856404;
}

.wagering-level.high,
.time-level.high {
    background: #f8d7da;
    color: #721c24;
}

.bonus-code {
    background: #e9ecef;
    padding: 0.5rem;
    border-radius: 5px;
    font-family: monospace;
    cursor: pointer;
    transition: background 0.3s ease;
}

.bonus-code:hover {
    background: #dee2e6;
}

.no-code {
    color: #6c757d;
    font-style: italic;
}

.rating {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
}

.star {
    color: #ddd;
    font-size: 1.2rem;
}

.star.filled {
    color: #ffc107;
}

.rating-value {
    margin-left: 0.5rem;
    font-weight: 600;
    color: #495057;
}

.bonus-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
}

/* Comparison Summary */
.comparison-summary-section {
    margin-top: 3rem;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 15px;
}

.summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.summary-card {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.summary-card h4 {
    color: #2c3e50;
    margin-bottom: 1rem;
}

.expert-recommendation {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    margin-top: 2rem;
}

.expert-recommendation h4 {
    color: #2c3e50;
    margin-bottom: 1rem;
}

/* Related Tools */
.related-tools {
    padding: 3rem 0;
    background: #f8f9fa;
}

.tools-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.tool-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.tool-card h4 {
    color: #2c3e50;
    margin-bottom: 1rem;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .comparison-controls {
        flex-direction: column;
        gap: 1rem;
    }
    
    .controls-left,
    .controls-right {
        justify-content: center;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .summary-cards {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .tools-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy bonus code functionality
    window.copyCode = function(element) {
        const code = element.textContent;
        navigator.clipboard.writeText(code).then(() => {
            element.style.background = '#d4edda';
            element.style.color = '#155724';
            setTimeout(() => {
                element.style.background = '#e9ecef';
                element.style.color = 'inherit';
            }, 1500);
        });
    };
    
    // Remove bonus functionality
    document.querySelectorAll('.remove-bonus').forEach(button => {
        button.addEventListener('click', function() {
            const bonusId = this.dataset.bonusId;
            const currentIds = new URLSearchParams(window.location.search).get('ids') || '';
            const idsArray = currentIds.split(',').filter(id => id !== bonusId);
            
            if (idsArray.length > 0) {
                window.location.href = `/bonuses/compare?ids=${idsArray.join(',')}`;
            } else {
                window.location.href = `/bonuses/compare`;
            }
        });
    });
    
    // Clear all functionality
    document.getElementById('clearAllBtn')?.addEventListener('click', function() {
        window.location.href = '/bonuses/compare';
    });
    
    // Add more bonuses functionality
    document.getElementById('addMoreBtn')?.addEventListener('click', function() {
        window.location.href = '/bonuses';
    });
    
    // Share comparison functionality
    document.getElementById('shareComparisonBtn')?.addEventListener('click', function() {
        const url = window.location.href;
        if (navigator.share) {
            navigator.share({
                title: 'Casino Bonus Comparison',
                url: url
            });
        } else {
            navigator.clipboard.writeText(url).then(() => {
                this.textContent = 'Link Copied!';
                setTimeout(() => {
                    this.textContent = 'Share Comparison';
                }, 2000);
            });
        }
    });
    
    // Print functionality
    document.getElementById('printComparisonBtn')?.addEventListener('click', function() {
        window.print();
    });
});
</script>
