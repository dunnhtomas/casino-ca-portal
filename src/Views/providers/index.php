<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="providers-section">
    <div class="section-header">
        <h1 class="section-title">Top Casino Software Providers</h1>
        <p class="section-subtitle">
            Discover the world's leading casino software providers powering Canada's most trusted online casinos. 
            From innovative slot games to cutting-edge live dealer experiences, these industry giants deliver 
            the highest quality gaming entertainment with unmatched reliability and fairness.
        </p>
    </div>

    <div class="providers-overview">
        <div class="overview-stats">
            <div class="overview-stat">
                <span class="number"><?= $data['total_providers'] ?></span>
                <span class="label">Licensed Providers</span>
            </div>
            <div class="overview-stat">
                <span class="number"><?= $data['total_games'] ?>+</span>
                <span class="label">Games Available</span>
            </div>
            <div class="overview-stat">
                <span class="number"><?= count($data['categories']) ?></span>
                <span class="label">Game Categories</span>
            </div>
            <div class="overview-stat">
                <span class="number"><?= $data['casino_partnerships'] ?>+</span>
                <span class="label">Casino Partnerships</span>
            </div>
        </div>
        
        <div class="provider-categories">
            <a href="/providers" class="category-filter <?= !isset($_GET['category']) ? 'active' : '' ?>">All Providers</a>
            <?php foreach ($data['categories'] as $category): ?>
                <a href="/providers?category=<?= urlencode($category) ?>" 
                   class="category-filter <?= (isset($_GET['category']) && $_GET['category'] === $category) ? 'active' : '' ?>">
                    <?= htmlspecialchars($category) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="providers-container">
        <div class="providers-grid">
            <?php foreach ($data['providers'] as $provider): ?>
                <div class="provider-card">
                    <div class="provider-header">
                        <img src="/images/providers/<?= strtolower(str_replace([' ', '.'], '-', $provider['name'])) ?>.svg" 
                             alt="<?= htmlspecialchars($provider['name']) ?> Logo" 
                             class="provider-logo">
                        <div class="provider-info">
                            <h3><?= htmlspecialchars($provider['name']) ?></h3>
                            <p class="founded">Founded <?= $provider['founded'] ?></p>
                        </div>
                    </div>

                    <div class="provider-stats">
                        <div class="stat">
                            <span class="label">Games</span>
                            <span class="value"><?= $provider['game_count'] ?>+</span>
                        </div>
                        <div class="stat">
                            <span class="label">Rating</span>
                            <span class="value"><?= $provider['rating'] ?>/5</span>
                        </div>
                        <div class="stat">
                            <span class="label">Casinos</span>
                            <span class="value"><?= $provider['casino_count'] ?>+</span>
                        </div>
                    </div>

                    <div class="provider-specialties">
                        <?php foreach ($provider['specialties'] as $specialty): ?>
                            <span class="specialty-tag"><?= htmlspecialchars($specialty) ?></span>
                        <?php endforeach; ?>
                    </div>

                    <p class="provider-description">
                        <?= htmlspecialchars($provider['description']) ?>
                    </p>

                    <a href="/providers/<?= strtolower(str_replace([' ', '.'], '-', $provider['name'])) ?>" 
                       class="btn-view-provider">
                        View Provider Details
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
/* Inline critical CSS for better loading performance */
.providers-section { 
    padding: 60px 0; 
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); 
}
.section-header { 
    text-align: center; 
    margin-bottom: 50px; 
}
.section-title { 
    font-size: 2.5rem; 
    color: #1a365d; 
    margin-bottom: 15px; 
    font-weight: 700; 
}
.providers-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); 
    gap: 30px; 
}
.provider-card { 
    background: white; 
    border-radius: 12px; 
    padding: 30px; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    transition: all 0.3s ease; 
}
.provider-card:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15); 
}
</style>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
