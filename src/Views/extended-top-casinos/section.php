<section class="extended-top-casinos" id="extended-top-casinos">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Top 15 Online Casinos in Canada 2025</h2>
            <p class="section-subtitle">Our experts have reviewed and ranked the best Canadian online casinos based on safety, game variety, bonuses, and payout speed</p>
        </div>

        <div class="casino-grid">
            <?php foreach ($casinos as $index => $casino): ?>
            <div class="casino-card" data-casino-id="<?= $casino['id'] ?>" data-rating="<?= $casino['rating'] ?>">
                <div class="casino-card-header">
                    <div class="casino-rank">#<?= $index + 1 ?></div>
                    <div class="casino-logo">
                        <img src="<?= htmlspecialchars($casino['logo_url']) ?>" alt="<?= htmlspecialchars($casino['name']) ?> Logo" loading="lazy">
                    </div>
                    <div class="casino-rating">
                        <div class="stars">
                            <?php
                            $fullStars = floor($casino['rating']);
                            $hasHalfStar = ($casino['rating'] - $fullStars) >= 0.5;
                            
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '<span class="star full">★</span>';
                            }
                            
                            if ($hasHalfStar) {
                                echo '<span class="star half">★</span>';
                            }
                            
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            for ($i = 0; $i < $emptyStars; $i++) {
                                echo '<span class="star empty">☆</span>';
                            }
                            ?>
                        </div>
                        <span class="rating-number"><?= number_format($casino['rating'], 1) ?>/5</span>
                    </div>
                </div>

                <div class="casino-card-body">
                    <h3 class="casino-name"><?= htmlspecialchars($casino['name']) ?></h3>
                    
                    <div class="casino-details">
                        <div class="detail-row">
                            <span class="detail-label">Established:</span>
                            <span class="detail-value"><?= $casino['established_year'] ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Average RTP:</span>
                            <span class="detail-value"><?= $casino['avg_rtp'] ?>%</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Payout Speed:</span>
                            <span class="detail-value"><?= htmlspecialchars($casino['payout_speed']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Games:</span>
                            <span class="detail-value"><?= number_format($casino['game_count']) ?>+</span>
                        </div>
                    </div>

                    <div class="welcome-bonus">
                        <div class="bonus-header">Welcome Bonus</div>
                        <div class="bonus-amount"><?= htmlspecialchars($casino['welcome_bonus']['amount']) ?></div>
                        <div class="bonus-details"><?= htmlspecialchars($casino['welcome_bonus']['details']) ?></div>
                    </div>

                    <div class="casino-features">
                        <?php if ($casino['mobile_compatibility']): ?>
                        <span class="feature-badge mobile">📱 Mobile Friendly</span>
                        <?php endif; ?>
                        
                        <?php if ($casino['live_chat_support']): ?>
                        <span class="feature-badge support">💬 24/7 Support</span>
                        <?php endif; ?>
                        
                        <?php if ($casino['canadian_friendly']): ?>
                        <span class="feature-badge canada">🍁 Canada Friendly</span>
                        <?php endif; ?>
                    </div>

                    <div class="security-badges">
                        <?php foreach (array_slice($casino['security_certifications'], 0, 2) as $cert): ?>
                        <span class="security-badge"><?= htmlspecialchars($cert) ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="trust-score">
                        <span class="trust-label">Trust Score:</span>
                        <span class="trust-value"><?= $casino['trust_score'] ?>/100</span>
                        <div class="trust-bar">
                            <div class="trust-fill" style="width: <?= $casino['trust_score'] ?>%"></div>
                        </div>
                    </div>
                </div>

                <div class="casino-card-footer">
                    <div class="casino-actions">
                        <a href="/casinos/<?= $casino['id'] ?>/review" class="btn btn-secondary">Read Review</a>
                        <a href="/casinos/<?= $casino['id'] ?>/play" class="btn btn-primary" target="_blank" rel="noopener">Play Now</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="section-footer">
            <div class="casino-stats">
                <div class="stat">
                    <span class="stat-number"><?= $stats['total_casinos'] ?></span>
                    <span class="stat-label">Casinos Reviewed</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?= $stats['average_rating'] ?></span>
                    <span class="stat-label">Average Rating</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?= number_format($stats['average_games']) ?></span>
                    <span class="stat-label">Average Games</span>
                </div>
                <div class="stat">
                    <span class="stat-number"><?= $stats['average_rtp'] ?>%</span>
                    <span class="stat-label">Average RTP</span>
                </div>
            </div>
            
            <div class="disclaimer">
                <p><strong>Disclaimer:</strong> Gambling can be addictive. Please play responsibly. All featured casinos are licensed and regulated for Canadian players. Must be 19+ to play (18+ in Alberta, Quebec).</p>
            </div>
        </div>
    </div>
</section>
