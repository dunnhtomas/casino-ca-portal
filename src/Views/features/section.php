<section class="key-features-section" id="key-features">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">Why Choose Our Casino Reviews</h2>
            <p class="section-subtitle">Discover the 5 key advantages that make us Canada's trusted casino review platform</p>
        </div>
        
        <div class="features-grid">
            <?php if (isset($features) && is_array($features)): ?>
                <?php foreach ($features as $feature): ?>
                    <div class="feature-card" data-feature-id="<?= htmlspecialchars($feature['id'] ?? '') ?>">
                        <div class="feature-icon <?= htmlspecialchars($feature['color_scheme'] ?? 'blue') ?>">
                            <i class="<?= htmlspecialchars($feature['icon_class'] ?? 'fas fa-star') ?>"></i>
                        </div>
                        
                        <div class="feature-content">
                            <h3 class="feature-title"><?= htmlspecialchars($feature['title'] ?? '') ?></h3>
                            <p class="feature-description"><?= htmlspecialchars($feature['description'] ?? '') ?></p>
                            
                            <?php if (!empty($feature['stat_value']) && !empty($feature['stat_label'])): ?>
                                <div class="feature-stat">
                                    <span class="stat-value"><?= htmlspecialchars($feature['stat_value']) ?></span>
                                    <span class="stat-label"><?= htmlspecialchars($feature['stat_label']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback content if features data is not available -->
                <div class="feature-card">
                    <div class="feature-icon blue">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Premium Casino Games</h3>
                        <p class="feature-description">Access 21,500+ games from leading providers like NetEnt, Microgaming, and Evolution Gaming.</p>
                        <div class="feature-stat">
                            <span class="stat-value">21,500+</span>
                            <span class="stat-label">Games Available</span>
                        </div>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon red">
                        <i class="fas fa-maple-leaf"></i>
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Canadian Dollar Bonuses</h3>
                        <p class="feature-description">Welcome bonuses up to $20,000 CAD with no currency conversion fees or confusion.</p>
                        <div class="feature-stat">
                            <span class="stat-value">$20,000</span>
                            <span class="stat-label">Max Bonus CAD</span>
                        </div>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon green">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Local Payment Methods</h3>
                        <p class="feature-description">Interac e-Transfer, Visa, Mastercard, and crypto with instant deposit times.</p>
                        <div class="feature-stat">
                            <span class="stat-value">Instant</span>
                            <span class="stat-label">Deposit Times</span>
                        </div>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon purple">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Mobile Gaming Excellence</h3>
                        <p class="feature-description">100% mobile compatible casinos with touch-optimized interfaces for iOS and Android.</p>
                        <div class="feature-stat">
                            <span class="stat-value">100%</span>
                            <span class="stat-label">Mobile Compatible</span>
                        </div>
                    </div>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon orange">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3 class="feature-title">Bank-Level Security</h3>
                        <p class="feature-description">256-bit SSL encryption protecting your data with Canadian banking standards.</p>
                        <div class="feature-stat">
                            <span class="stat-value">256-bit</span>
                            <span class="stat-label">SSL Security</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="features-cta text-center">
            <p class="cta-text">Ready to find your perfect Canadian casino?</p>
            <a href="#casino-grid" class="btn btn-primary btn-lg">Explore Top Casinos</a>
        </div>
    </div>
    
    <!-- Schema.org structured data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "Key Casino Features for Canadian Players",
        "description": "Top 5 features that make our casino reviews platform the best choice for Canadian gamblers",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "item": {
                    "@type": "Service",
                    "name": "Premium Casino Games from Leading Providers",
                    "description": "Access 21,500+ games from top developers"
                }
            },
            {
                "@type": "ListItem",
                "position": 2,
                "item": {
                    "@type": "Service",
                    "name": "Generous Welcome Bonuses in Canadian Dollars",
                    "description": "Welcome bonuses up to $20,000 CAD with favorable terms"
                }
            },
            {
                "@type": "ListItem",
                "position": 3,
                "item": {
                    "@type": "Service",
                    "name": "Popular Canadian Payment Options",
                    "description": "Interac e-Transfer, Visa, Mastercard, and cryptocurrency"
                }
            },
            {
                "@type": "ListItem",
                "position": 4,
                "item": {
                    "@type": "Service",
                    "name": "Seamless Mobile Gaming Experience",
                    "description": "100% mobile compatible with optimized interfaces"
                }
            },
            {
                "@type": "ListItem",
                "position": 5,
                "item": {
                    "@type": "Service",
                    "name": "Bank-Like Security with SSL Encryption",
                    "description": "256-bit SSL encryption with Canadian banking standards"
                }
            }
        ]
    }
    </script>
</section>
