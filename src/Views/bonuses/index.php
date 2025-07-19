<?php 
    $pageTitle = $title ?? 'Complete Bonus Database';
    $pageDescription = $meta_description ?? 'Discover the best Canadian casino bonuses';
?>

<div class="bonus-database-page">
    <!-- Hero Section -->
    <section class="bonus-hero">
        <div class="container">
            <h1 class="page-title">🎁 Complete Bonus Database</h1>
            <p class="page-subtitle">Discover <?= count($bonuses) ?>+ verified casino bonuses with comprehensive analysis, wagering requirements, and our exclusive bonus calculator</p>
            
            <!-- Quick Stats -->
            <div class="bonus-stats">
                <div class="stat-card">
                    <h4>Total Bonuses</h4>
                    <div class="stat-value"><?= $statistics['total_bonuses'] ?></div>
                </div>
                <div class="stat-card">
                    <h4>Average Wagering</h4>
                    <div class="stat-value"><?= $statistics['average_wagering'] ?>x</div>
                </div>
                <div class="stat-card">
                    <h4>Highest Bonus</h4>
                    <div class="stat-value">$<?= number_format($statistics['max_bonus_amount']) ?></div>
                </div>
                <div class="stat-card">
                    <h4>Featured Offers</h4>
                    <div class="stat-value"><?= $statistics['featured_count'] ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="bonus-filters">
        <div class="container">
            <form method="GET" action="/bonuses" class="filter-form">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="type">Bonus Type</label>
                        <select name="type" id="type">
                            <option value="">All Types</option>
                            <?php foreach ($bonusTypes as $type): ?>
                                <option value="<?= $type ?>" <?= ($filters['bonus_type'] ?? '') === $type ? 'selected' : '' ?>>
                                    <?= ucfirst(str_replace('_', ' ', $type)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="max_wagering">Max Wagering</label>
                        <select name="max_wagering" id="max_wagering">
                            <option value="">Any Wagering</option>
                            <?php foreach ($wageringOptions as $wagering): ?>
                                <option value="<?= $wagering ?>" <?= ($filters['max_wagering'] ?? '') == $wagering ? 'selected' : '' ?>>
                                    <?= $wagering ?>x or less
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="min_amount">Min Amount</label>
                        <select name="min_amount" id="min_amount">
                            <option value="">Any Amount</option>
                            <?php foreach ($amountOptions as $amount): ?>
                                <option value="<?= $amount ?>" <?= ($filters['min_amount'] ?? '') == $amount ? 'selected' : '' ?>>
                                    $<?= $amount ?>+
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="featured" <?= isset($filters['featured']) ? 'checked' : '' ?>>
                            Featured Only
                        </label>
                    </div>
                    
                    <div class="filter-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="exclusive" <?= isset($filters['exclusive']) ? 'checked' : '' ?>>
                            Exclusive Offers
                        </label>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="/bonuses" class="btn btn-outline">Clear All</a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Bonus Grid -->
    <section class="bonus-grid-section">
        <div class="container">
            <div class="section-header">
                <h2>Available Bonuses (<?= count($bonuses) ?>)</h2>
                <div class="view-controls">
                    <a href="/bonuses/compare" class="btn btn-outline">Compare Selected</a>
                    <a href="/bonuses/calculator" class="btn btn-secondary">Bonus Calculator</a>
                </div>
            </div>
            
            <div class="bonus-grid">
                <?php foreach ($bonuses as $bonus): ?>
                    <div class="bonus-card" data-bonus-id="<?= $bonus->id ?>">
                        <div class="bonus-header">
                            <?php if ($bonus->featured): ?>
                                <span class="badge featured">Featured</span>
                            <?php endif; ?>
                            <?php if ($bonus->exclusive): ?>
                                <span class="badge exclusive">Exclusive</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="bonus-content">
                            <h3 class="bonus-title"><?= htmlspecialchars($bonus->title) ?></h3>
                            <p class="bonus-description"><?= htmlspecialchars($bonus->description) ?></p>
                            
                            <div class="bonus-details">
                                <div class="detail-row">
                                    <span class="label">💰 Value:</span>
                                    <span class="value">
                                        <?php if ($bonus->bonus_amount): ?>
                                            $<?= number_format($bonus->bonus_amount) ?>
                                        <?php endif; ?>
                                        <?php if ($bonus->bonus_percentage): ?>
                                            <?= $bonus->bonus_percentage ?>%
                                        <?php endif; ?>
                                        <?php if ($bonus->free_spins_count): ?>
                                            + <?= $bonus->free_spins_count ?> Free Spins
                                        <?php endif; ?>
                                    </span>
                                </div>
                                
                                <div class="detail-row">
                                    <span class="label">🎯 Wagering:</span>
                                    <span class="value"><?= $bonus->wagering_requirement ?>x</span>
                                </div>
                                
                                <div class="detail-row">
                                    <span class="label">⏰ Time Limit:</span>
                                    <span class="value"><?= $bonus->time_limit_days ?> days</span>
                                </div>
                                
                                <div class="detail-row">
                                    <span class="label">💳 Min Deposit:</span>
                                    <span class="value">$<?= number_format($bonus->min_deposit) ?></span>
                                </div>
                                
                                <?php if ($bonus->bonus_code): ?>
                                    <div class="detail-row">
                                        <span class="label">🔑 Bonus Code:</span>
                                        <span class="value bonus-code"><?= $bonus->bonus_code ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="bonus-restrictions">
                                <small><?= htmlspecialchars($bonus->game_restrictions) ?></small>
                            </div>
                        </div>
                        
                        <div class="bonus-actions">
                            <div class="action-buttons">
                                <input type="checkbox" class="compare-checkbox" value="<?= $bonus->id ?>">
                                <label>Compare</label>
                                <a href="/bonuses/<?= $bonus->id ?>" class="btn btn-info">Details</a>
                                <a href="<?= $bonus->affiliate_link ?>" class="btn btn-primary" target="_blank" rel="nofollow">
                                    Get Bonus
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (empty($bonuses)): ?>
                <div class="no-results">
                    <h3>No bonuses found</h3>
                    <p>Try adjusting your filters to see more results.</p>
                    <a href="/bonuses" class="btn btn-primary">Clear Filters</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Educational Content -->
    <section class="bonus-education">
        <div class="container">
            <h2>Understanding Casino Bonuses</h2>
            <div class="education-grid">
                <div class="education-card">
                    <h4>📚 Wagering Requirements</h4>
                    <p>The number of times you must wager the bonus amount before you can withdraw winnings. Lower is better for players.</p>
                </div>
                <div class="education-card">
                    <h4>⏰ Time Limits</h4>
                    <p>How long you have to meet the wagering requirements. More time gives you better chances of success.</p>
                </div>
                <div class="education-card">
                    <h4>🎮 Game Restrictions</h4>
                    <p>Which games count toward wagering requirements. Slots usually count 100%, table games often count less.</p>
                </div>
                <div class="education-card">
                    <h4>💰 Maximum Cashout</h4>
                    <p>The maximum amount you can withdraw from bonus winnings. Important for no deposit bonuses.</p>
                </div>
            </div>
            
            <div class="cta-section">
                <h3>Want to learn more?</h3>
                <p>Check out our comprehensive guides on bonus types and strategies.</p>
                <a href="/bonuses/types" class="btn btn-primary">Bonus Types Guide</a>
                <a href="/bonuses/calculator" class="btn btn-secondary">Try Our Calculator</a>
            </div>
        </div>
    </section>
</div>

<style>
/* Enhanced Bonus Database Styles */
.bonus-database-page {
    padding: 0;
}

.bonus-hero {
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
    margin-bottom: 2rem;
    opacity: 0.9;
}

.bonus-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    max-width: 800px;
    margin: 0 auto;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    padding: 1.5rem;
    border-radius: 10px;
    backdrop-filter: blur(10px);
}

.stat-card h4 {
    margin: 0 0 0.5rem 0;
    font-size: 0.9rem;
    opacity: 0.8;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
}

.bonus-filters {
    background: #f8f9fa;
    padding: 2rem 0;
    border-bottom: 1px solid #e9ecef;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #495057;
}

.filter-group select {
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-size: 0.9rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.checkbox-label input {
    margin-right: 0.5rem;
}

.filter-actions {
    display: flex;
    gap: 1rem;
}

.bonus-grid-section {
    padding: 3rem 0;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.view-controls {
    display: flex;
    gap: 1rem;
}

.bonus-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
}

.bonus-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.bonus-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.bonus-header {
    padding: 1rem;
    display: flex;
    gap: 0.5rem;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge.featured {
    background: #ffd700;
    color: #333;
}

.badge.exclusive {
    background: #dc3545;
    color: white;
}

.bonus-content {
    padding: 0 1.5rem;
}

.bonus-title {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.bonus-description {
    color: #6c757d;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.bonus-details {
    margin-bottom: 1rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.detail-row .label {
    color: #6c757d;
}

.detail-row .value {
    font-weight: 600;
    color: #2c3e50;
}

.bonus-code {
    background: #e9ecef;
    padding: 0.25rem 0.5rem;
    border-radius: 3px;
    font-family: monospace;
}

.bonus-restrictions {
    font-size: 0.8rem;
    color: #868e96;
    margin-bottom: 1rem;
}

.bonus-actions {
    padding: 1.5rem;
    background: #f8f9fa;
}

.action-buttons {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.compare-checkbox {
    margin-right: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-block;
    text-align: center;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-outline {
    background: transparent;
    border: 1px solid #ced4da;
    color: #495057;
}

.btn-info {
    background: #17a2b8;
    color: white;
}

.no-results {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.bonus-education {
    background: #f8f9fa;
    padding: 3rem 0;
}

.education-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.education-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.education-card h4 {
    margin-bottom: 1rem;
    color: #2c3e50;
}

.cta-section {
    text-align: center;
    padding: 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .bonus-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-grid {
        grid-template-columns: 1fr;
    }
    
    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .view-controls {
        justify-content: center;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .bonus-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compare functionality
    const compareButton = document.querySelector('[href="/bonuses/compare"]');
    const checkboxes = document.querySelectorAll('.compare-checkbox');
    
    function updateCompareButton() {
        const selectedIds = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
            
        if (selectedIds.length > 0) {
            compareButton.href = `/bonuses/compare?ids=${selectedIds.join(',')}`;
            compareButton.textContent = `Compare Selected (${selectedIds.length})`;
            compareButton.style.display = 'block';
        } else {
            compareButton.textContent = 'Compare Selected';
        }
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateCompareButton);
    });
    
    // Copy bonus code functionality
    document.querySelectorAll('.bonus-code').forEach(code => {
        code.addEventListener('click', function() {
            navigator.clipboard.writeText(this.textContent);
            this.style.background = '#d4edda';
            setTimeout(() => {
                this.style.background = '#e9ecef';
            }, 1000);
        });
    });
});
</script>
