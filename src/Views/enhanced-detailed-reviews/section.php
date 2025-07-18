<!-- Enhanced Detailed Top 3 Casino Reviews Section -->
<section class="section enhanced-detailed-reviews-section">
    <div class="container">
        <div class="section-header">
            <h2>Expert Casino Reviews: Top 3 Canadian Picks</h2>
            <p class="section-description">In-depth analysis from our professional casino experts with comprehensive testing, mobile app evaluation, and detailed payment analysis</p>
            
            <div class="section-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= $statistics['total_casinos'] ?></span>
                    <span class="stat-label">Expert Reviews</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= number_format($statistics['total_games']) ?>+</span>
                    <span class="stat-label">Games Tested</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= $statistics['average_rating'] ?>/5</span>
                    <span class="stat-label">Avg Rating</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?= $statistics['combined_experience'] ?>+</span>
                    <span class="stat-label">Years Combined Experience</span>
                </div>
            </div>
        </div>
        
        <div class="enhanced-reviews-grid">
            <?php foreach ($reviews as $review): ?>
                <div class="enhanced-review-card" data-casino="<?= htmlspecialchars($review['casino_id']) ?>">
                    <!-- Casino Header -->
                    <div class="review-header">
                        <div class="casino-logo">
                            <img src="<?= htmlspecialchars($review['logo']) ?>" alt="<?= htmlspecialchars($review['name']) ?> Logo" loading="lazy">
                        </div>
                        <div class="casino-basic-info">
                            <h3 class="casino-name"><?= htmlspecialchars($review['name']) ?></h3>
                            <div class="casino-meta">
                                <span class="established">Est. <?= $review['established'] ?></span>
                                <span class="license"><?= htmlspecialchars($review['license']) ?></span>
                            </div>
                            <div class="expert-rating">
                                <div class="rating-stars">
                                    <?php 
                                    $rating = $review['expert_rating'];
                                    $fullStars = floor($rating);
                                    $halfStar = ($rating - $fullStars) >= 0.5;
                                    for ($i = 0; $i < $fullStars; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor;
                                    if ($halfStar): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php endif;
                                    for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++): ?>
                                        <i class="far fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-score"><?= number_format($review['expert_rating'], 1) ?>/5</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Key Metrics -->
                    <div class="key-metrics">
                        <div class="metric-item">
                            <span class="metric-label">RTP</span>
                            <span class="metric-value"><?= $review['rtp_average'] ?>%</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Games</span>
                            <span class="metric-value"><?= number_format($review['game_count']) ?>+</span>
                        </div>
                        <div class="metric-item">
                            <span class="metric-label">Payout</span>
                            <span class="metric-value"><?= htmlspecialchars($review['payout_speed']) ?></span>
                        </div>
                        <?php if (isset($review['mobile_app']['ios_rating'])): ?>
                        <div class="metric-item">
                            <span class="metric-label">Mobile</span>
                            <span class="metric-value"><?= $review['mobile_app']['ios_rating'] ?>/5</span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Bonus Information -->
                    <div class="bonus-showcase">
                        <div class="bonus-amount"><?= htmlspecialchars($review['bonus']['welcome_package']) ?></div>
                        <div class="bonus-details">
                            <span><?= htmlspecialchars($review['bonus']['free_spins']) ?></span>
                            <span class="wagering">Wagering: <?= htmlspecialchars($review['bonus']['wagering_requirement']) ?></span>
                        </div>
                    </div>
                    
                    <!-- Expert Commentary Preview -->
                    <div class="expert-commentary-preview">
                        <div class="expert-quote">
                            <i class="fas fa-quote-left"></i>
                            <p>"<?= htmlspecialchars(substr($review['expert_commentary']['main_quote'], 0, 120)) ?>..."</p>
                        </div>
                        <div class="expert-attribution">
                            <span class="expert-name"><?= htmlspecialchars($review['expert_commentary']['author']) ?></span>
                            <span class="expert-title"><?= htmlspecialchars($review['expert_commentary']['author_title']) ?></span>
                        </div>
                    </div>
                    
                    <!-- Category Ratings -->
                    <div class="category-ratings">
                        <h4>Expert Analysis</h4>
                        <div class="rating-bars">
                            <?php 
                            $categoryNames = [
                                'security' => 'Security & Fairness',
                                'games' => 'Games & Software',
                                'bonuses' => 'Bonuses & Promotions',
                                'mobile' => 'Mobile Experience',
                                'payments' => 'Banking & Payments',
                                'support' => 'Customer Support'
                            ];
                            foreach ($review['category_ratings'] as $category => $rating): 
                                $percentage = ($rating / 5) * 100;
                            ?>
                                <div class="rating-bar" title="<?= htmlspecialchars($categoryNames[$category]) ?>: <?= number_format($rating, 1) ?>/5">
                                    <span class="category-name"><?= htmlspecialchars($categoryNames[$category]) ?></span>
                                    <div class="bar-container">
                                        <div class="bar-fill" style="width: <?= $percentage ?>%"></div>
                                    </div>
                                    <span class="rating-value"><?= number_format($rating, 1) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Mobile App Showcase (if available) -->
                    <?php if ($review['mobile_app']['has_app'] ?? false): ?>
                    <div class="mobile-app-preview">
                        <h4>Mobile App</h4>
                        <div class="app-info">
                            <div class="app-ratings">
                                <span class="ios-rating">
                                    <i class="fab fa-apple"></i> <?= $review['mobile_app']['ios_rating'] ?>
                                </span>
                                <span class="android-rating">
                                    <i class="fab fa-google-play"></i> <?= $review['mobile_app']['android_rating'] ?>
                                </span>
                            </div>
                            <div class="app-details">
                                <span class="app-size"><?= htmlspecialchars($review['mobile_app']['app_size']) ?></span>
                                <span class="download-count"><?= htmlspecialchars($review['mobile_app']['download_count']) ?> downloads</span>
                            </div>
                        </div>
                        <div class="app-features">
                            <?php foreach (array_slice($review['mobile_app']['features'], 0, 3) as $feature): ?>
                                <span class="feature-tag"><?= htmlspecialchars($feature) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Pros & Cons Highlights -->
                    <div class="pros-cons-preview">
                        <div class="pros-preview">
                            <h4>Top Pros</h4>
                            <ul>
                                <?php foreach (array_slice($review['detailed_pros'], 0, 3) as $pro): ?>
                                    <li title="<?= htmlspecialchars($pro['explanation']) ?>">
                                        <i class="fas fa-check"></i>
                                        <?= htmlspecialchars($pro['point']) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="cons-preview">
                            <h4>Consider</h4>
                            <ul>
                                <?php foreach (array_slice($review['detailed_cons'], 0, 2) as $con): ?>
                                    <li title="<?= htmlspecialchars($con['explanation']) ?>">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <?= htmlspecialchars($con['point']) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Featured Games Preview -->
                    <div class="featured-games-preview">
                        <h4>Featured Games</h4>
                        <div class="games-list">
                            <?php foreach (array_slice($review['game_highlights']['featured_games'], 0, 3) as $game): ?>
                                <div class="game-item">
                                    <span class="game-name"><?= htmlspecialchars($game['name']) ?></span>
                                    <span class="game-rtp"><?= htmlspecialchars($game['rtp']) ?> RTP</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="review-actions">
                        <a href="/casino/<?= htmlspecialchars($review['slug']) ?>/play" class="btn btn-primary btn-large">
                            <i class="fas fa-gift"></i>
                            Get <?= htmlspecialchars($review['bonus']['welcome_package']) ?>
                        </a>
                        <a href="/casino/<?= htmlspecialchars($review['slug']) ?>" class="btn btn-secondary">
                            <i class="fas fa-info-circle"></i>
                            Full Review
                        </a>
                        <button class="btn btn-outline expand-review-btn" data-casino="<?= htmlspecialchars($review['casino_id']) ?>">
                            <i class="fas fa-expand"></i>
                            More Details
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Section Footer -->
        <div class="section-footer">
            <div class="expert-credentials">
                <div class="credentials-header">
                    <h3>Expert Review Standards</h3>
                    <p>Our reviews are conducted by licensed professionals with 10+ years in the casino industry</p>
                </div>
                <div class="credentials-list">
                    <div class="credential-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Security & License Verification</span>
                    </div>
                    <div class="credential-item">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Mobile App Testing</span>
                    </div>
                    <div class="credential-item">
                        <i class="fas fa-clock"></i>
                        <span>Payout Speed Testing</span>
                    </div>
                    <div class="credential-item">
                        <i class="fas fa-gamepad"></i>
                        <span>Game Portfolio Analysis</span>
                    </div>
                </div>
            </div>
            
            <div class="section-cta">
                <a href="/enhanced-casino-reviews" class="btn btn-outline btn-large">
                    <i class="fas fa-search"></i>
                    View All Expert Reviews
                </a>
                <a href="/casino-comparison" class="btn btn-secondary btn-large">
                    <i class="fas fa-balance-scale"></i>
                    Compare All Casinos
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Review Details Modal -->
<div id="reviewDetailsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detailed Casino Analysis</h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>
</div>

<script>
// Enhanced review interaction functionality
document.addEventListener('DOMContentLoaded', function() {
    // Expand review details
    document.querySelectorAll('.expand-review-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const casinoId = this.dataset.casino;
            loadReviewDetails(casinoId);
        });
    });
    
    // Rating bar hover effects
    document.querySelectorAll('.rating-bar').forEach(bar => {
        bar.addEventListener('mouseenter', function() {
            this.classList.add('highlight');
        });
        
        bar.addEventListener('mouseleave', function() {
            this.classList.remove('highlight');
        });
    });
    
    // Modal functionality
    const modal = document.getElementById('reviewDetailsModal');
    const closeModal = modal.querySelector('.close');
    
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});

function loadReviewDetails(casinoId) {
    const modal = document.getElementById('reviewDetailsModal');
    const modalBody = modal.querySelector('.modal-body');
    
    // Show loading state
    modalBody.innerHTML = '<div class="loading">Loading detailed analysis...</div>';
    modal.style.display = 'block';
    
    // Fetch detailed review data
    fetch(`/api/enhanced-reviews/${casinoId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderDetailedReview(data.casino_review, modalBody);
            } else {
                modalBody.innerHTML = '<div class="error">Failed to load review details.</div>';
            }
        })
        .catch(error => {
            modalBody.innerHTML = '<div class="error">Error loading review details.</div>';
        });
}

function renderDetailedReview(review, container) {
    container.innerHTML = `
        <div class="detailed-review-content">
            <div class="expert-analysis">
                <h4>Expert Analysis</h4>
                <blockquote class="expert-quote-full">
                    "${review.expert_commentary.detailed_analysis}"
                </blockquote>
                <div class="expert-signature">
                    <strong>${review.expert_commentary.author}</strong><br>
                    <em>${review.expert_commentary.author_title}</em>
                </div>
            </div>
            
            <div class="detailed-pros-cons">
                <div class="detailed-pros">
                    <h4>Detailed Pros</h4>
                    ${review.detailed_pros.map(pro => `
                        <div class="detailed-point">
                            <h5><i class="fas fa-check"></i> ${pro.point}</h5>
                            <p>${pro.explanation}</p>
                        </div>
                    `).join('')}
                </div>
                
                <div class="detailed-cons">
                    <h4>Areas for Improvement</h4>
                    ${review.detailed_cons.map(con => `
                        <div class="detailed-point">
                            <h5><i class="fas fa-exclamation-triangle"></i> ${con.point}</h5>
                            <p>${con.explanation}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <div class="payment-analysis">
                <h4>Payment Analysis</h4>
                <div class="payment-grid">
                    <div class="payment-times">
                        <h5>Processing Times</h5>
                        ${Object.entries(review.payment_analysis.processing_times).map(([method, time]) => `
                            <div class="payment-method">
                                <span class="method-name">${method}</span>
                                <span class="method-time">${time}</span>
                            </div>
                        `).join('')}
                    </div>
                    <div class="payment-limits">
                        <h5>Withdrawal Limits</h5>
                        <div class="limits-grid">
                            <div>Daily: ${review.payment_analysis.withdrawal_limits.daily}</div>
                            <div>Weekly: ${review.payment_analysis.withdrawal_limits.weekly}</div>
                            <div>Monthly: ${review.payment_analysis.withdrawal_limits.monthly}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}
</script>
