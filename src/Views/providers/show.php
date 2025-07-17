<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="provider-hero">
    <div class="provider-hero-content">
        <h1><?= htmlspecialchars($data['provider']['name']) ?></h1>
        <p class="subtitle"><?= htmlspecialchars($data['provider']['tagline']) ?></p>
        
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="number"><?= $data['provider']['game_count'] ?>+</span>
                <span class="label">Games</span>
            </div>
            <div class="hero-stat">
                <span class="number"><?= $data['provider']['rating'] ?></span>
                <span class="label">Rating</span>
            </div>
            <div class="hero-stat">
                <span class="number"><?= $data['provider']['casino_count'] ?>+</span>
                <span class="label">Casinos</span>
            </div>
            <div class="hero-stat">
                <span class="number"><?= $data['provider']['founded'] ?></span>
                <span class="label">Established</span>
            </div>
        </div>
    </div>
</div>

<div class="provider-content">
    <div class="content-grid">
        <div class="main-content">
            <section class="provider-overview">
                <h2>About <?= htmlspecialchars($data['provider']['name']) ?></h2>
                <p><?= nl2br(htmlspecialchars($data['provider']['full_description'])) ?></p>
            </section>

            <section class="provider-features">
                <h3>Key Features & Innovations</h3>
                <ul class="feature-list">
                    <?php foreach ($data['provider']['features'] as $feature): ?>
                        <li><?= htmlspecialchars($feature) ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <section class="popular-games">
                <h3>Popular Games by <?= htmlspecialchars($data['provider']['name']) ?></h3>
                <div class="games-list">
                    <?php foreach ($data['provider']['popular_games'] as $game): ?>
                        <div class="game-item"><?= htmlspecialchars($game) ?></div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="game-types">
                <h3>Game Specialties</h3>
                <div class="specialties-grid">
                    <?php foreach ($data['provider']['specialties'] as $specialty): ?>
                        <div class="specialty-card">
                            <h4><?= htmlspecialchars($specialty) ?></h4>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

        <div class="sidebar">
            <section class="provider-quick-facts">
                <h3>Quick Facts</h3>
                <div class="fact-list">
                    <div class="fact-item">
                        <span class="fact-label">Founded:</span>
                        <span class="fact-value"><?= $data['provider']['founded'] ?></span>
                    </div>
                    <div class="fact-item">
                        <span class="fact-label">Headquarters:</span>
                        <span class="fact-value"><?= htmlspecialchars($data['provider']['headquarters']) ?></span>
                    </div>
                    <div class="fact-item">
                        <span class="fact-label">License:</span>
                        <span class="fact-value"><?= htmlspecialchars($data['provider']['license']) ?></span>
                    </div>
                    <div class="fact-item">
                        <span class="fact-label">Game Types:</span>
                        <span class="fact-value"><?= implode(', ', $data['provider']['game_types']) ?></span>
                    </div>
                    <div class="fact-item">
                        <span class="fact-label">RTP Range:</span>
                        <span class="fact-value"><?= $data['provider']['rtp_range'] ?></span>
                    </div>
                </div>
            </section>

            <section class="featured-casinos">
                <h3>Play <?= htmlspecialchars($data['provider']['name']) ?> Games</h3>
                <p>Top Canadian casinos featuring <?= htmlspecialchars($data['provider']['name']) ?> games:</p>
                
                <?php foreach ($data['featured_casinos'] as $casino): ?>
                    <div class="casino-item">
                        <div class="casino-info">
                            <h4><?= htmlspecialchars($casino['name']) ?></h4>
                            <div class="rating">★★★★★ <?= $casino['rating'] ?>/5</div>
                            <div class="casino-bonus"><?= htmlspecialchars($casino['bonus']) ?></div>
                        </div>
                        <a href="<?= htmlspecialchars($casino['affiliate_url']) ?>" 
                           class="btn-play-now" 
                           target="_blank" 
                           rel="noopener sponsored">
                            Play Now
                        </a>
                    </div>
                <?php endforeach; ?>
            </section>

            <section class="provider-certifications">
                <h3>Certifications & Compliance</h3>
                <div class="cert-list">
                    <?php foreach ($data['provider']['certifications'] as $cert): ?>
                        <div class="cert-item"><?= htmlspecialchars($cert) ?></div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>
</div>

<style>
/* Critical CSS for provider detail page */
.provider-hero {
    background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}
.provider-hero h1 {
    font-size: 3rem;
    margin-bottom: 20px;
    font-weight: 700;
}
.content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    padding: 0 20px;
}
.main-content,
.sidebar {
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.fact-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e2e8f0;
}
.fact-label {
    font-weight: 600;
    color: #4a5568;
}
.fact-value {
    color: #2d3748;
}
.casino-item {
    padding: 20px;
    margin-bottom: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}
.btn-play-now {
    background: #38a169;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    display: inline-block;
    margin-top: 10px;
}
.specialties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 15px;
}
.specialty-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #e2e8f0;
}
.cert-item {
    background: #e6fffa;
    color: #234e52;
    padding: 8px 12px;
    border-radius: 6px;
    margin-bottom: 8px;
    font-size: 0.9rem;
    font-weight: 500;
}
</style>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
