<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Canadian Provinces Casino Guide') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'Complete guide to online casinos across all Canadian provinces and territories.') ?>">
    <link rel="stylesheet" href="/css/provinces-section.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="provinces-section">
        <div class="section-header">
            <h1 class="section-title">Canadian Provinces Casino Guide</h1>
            <p class="section-subtitle">
                Discover the best online casinos available in your province. From coast to coast, 
                we cover all 13 provinces and territories with detailed information about local 
                gambling laws, age restrictions, and top casino recommendations.
            </p>
        </div>

        <div class="canada-overview">
            <h2 style="text-align: center; color: #2d3748; margin-bottom: 25px;">Canada Gaming Overview</h2>
            <div class="overview-stats">
                <div class="overview-stat">
                    <span class="number">13</span>
                    <span class="label">Provinces & Territories</span>
                </div>
                <div class="overview-stat">
                    <span class="number"><?= $totalCasinos ?? 103 ?></span>
                    <span class="label">Local Casinos</span>
                </div>
                <div class="overview-stat">
                    <span class="number">38M+</span>
                    <span class="label">Canadian Population</span>
                </div>
                <div class="overview-stat">
                    <span class="number">18+</span>
                    <span class="label">Minimum Age</span>
                </div>
            </div>
        </div>

        <div class="regions-container">
            <?php foreach ($provincesByRegion as $regionName => $regionProvinces): ?>
            <div class="region-section">
                <h2 class="region-title"><?= htmlspecialchars($regionName) ?></h2>
                <div class="provinces-grid">
                    <?php foreach ($regionProvinces as $code => $province): ?>
                    <div class="province-card" data-province="<?= $code ?>">
                        <div class="province-header">
                            <img src="<?= htmlspecialchars($province['flag_url']) ?>" 
                                 alt="<?= htmlspecialchars($province['name']) ?> flag" 
                                 class="province-flag"
                                 onerror="this.src='/images/placeholder.svg'">
                            <h3><?= htmlspecialchars($province['name']) ?></h3>
                        </div>
                        
                        <div class="province-stats">
                            <div class="stat">
                                <span class="label">Gambling Age:</span>
                                <span class="value"><?= $province['gambling_age'] ?>+</span>
                            </div>
                            <div class="stat">
                                <span class="label">Local Casinos:</span>
                                <span class="value"><?= $province['local_casinos'] ?></span>
                            </div>
                            <div class="stat">
                                <span class="label">Population:</span>
                                <span class="value"><?= htmlspecialchars($province['population']) ?></span>
                            </div>
                            <div class="stat">
                                <span class="label">Status:</span>
                                <span class="value status-<?= strtolower($province['legal_status']) ?>">
                                    <?= htmlspecialchars($province['legal_status']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="province-description">
                            <?= htmlspecialchars($province['description']) ?>
                        </div>
                        
                        <div class="province-actions">
                            <a href="/provinces/<?= strtolower($code) ?>" class="btn-view-details">
                                View Details
                            </a>
                            <a href="/provinces/<?= strtolower($code) ?>#casinos" class="btn-casinos">
                                Top Casinos
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Add interactive hover effects
        document.querySelectorAll('.province-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Track province card clicks for analytics
        document.querySelectorAll('.province-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.tagName !== 'A') {
                    const province = this.dataset.province;
                    // Analytics tracking code here
                    console.log('Province card clicked:', province);
                }
            });
        });
    </script>
</body>
</html>
