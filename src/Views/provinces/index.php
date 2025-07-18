<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/provinces.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1><?php echo $page_title; ?></h1>
            <p class="header-subtitle"><?php echo $meta_description; ?></p>
        </div>
    </header>

    <!-- Statistics Overview -->
    <section class="stats-overview">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $statistics['total_provinces']; ?></div>
                    <div class="stat-label">Provinces</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $statistics['total_territories']; ?></div>
                    <div class="stat-label">Territories</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo number_format($statistics['total_population'] / 1000000, 1); ?>M</div>
                    <div class="stat-label">Total Population</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $statistics['total_casinos']; ?></div>
                    <div class="stat-label">Available Casinos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $statistics['avg_gambling_age']; ?>+</div>
                    <div class="stat-label">Avg Legal Age</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Provinces -->
    <section class="top-provinces">
        <div class="container">
            <h2>Top Provinces by Casino Count</h2>
            <div class="provinces-grid">
                <?php foreach ($top_provinces as $province): ?>
                <div class="province-highlight">
                    <div class="province-header">
                        <img src="/images/flags/<?php echo strtolower($province['code']); ?>.svg" 
                             alt="<?php echo htmlspecialchars($province['name']); ?> Flag"
                             onerror="this.src='/images/flags/ca.svg'">
                        <h3><?php echo htmlspecialchars($province['name']); ?></h3>
                        <span class="province-type"><?php echo ucfirst($province['type']); ?></span>
                    </div>
                    <div class="province-stats">
                        <div class="stat">
                            <span class="label">Casinos:</span>
                            <span class="value"><?php echo $province['casino_count']; ?></span>
                        </div>
                        <div class="stat">
                            <span class="label">Legal Age:</span>
                            <span class="value"><?php echo $province['gambling_age']; ?>+</span>
                        </div>
                        <div class="stat">
                            <span class="label">Population:</span>
                            <span class="value">
                                <?php 
                                if ($province['population'] >= 1000000) {
                                    echo number_format($province['population'] / 1000000, 1) . 'M';
                                } else {
                                    echo number_format($province['population'] / 1000) . 'K';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="top-recommendation">
                        <h4>Top Casino</h4>
                        <div class="casino-name"><?php echo htmlspecialchars($province['top_casino']); ?></div>
                        <div class="casino-rating">
                            <?php 
                            $rating = $province['top_casino_rating'];
                            $fullStars = floor($rating);
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '⭐';
                            }
                            ?>
                            <span><?php echo number_format($rating, 1); ?>/5</span>
                        </div>
                    </div>
                    <a href="/provinces/<?php echo strtolower($province['code']); ?>" class="btn btn-primary">
                        View Details
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- All Provinces & Territories -->
    <section class="all-provinces">
        <div class="container">
            <h2>All Canadian Provinces & Territories</h2>
            
            <!-- Search and Filter -->
            <div class="province-controls">
                <div class="search-box">
                    <input type="text" id="provinceSearch" placeholder="Search provinces..." class="search-input">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <div class="filter-tabs">
                    <button class="filter-tab active" data-filter="all">All (<?php echo count($provinces); ?>)</button>
                    <button class="filter-tab" data-filter="province">Provinces (<?php echo $statistics['total_provinces']; ?>)</button>
                    <button class="filter-tab" data-filter="territory">Territories (<?php echo $statistics['total_territories']; ?>)</button>
                </div>
            </div>

            <!-- Provinces Grid -->
            <div class="provinces-listing">
                <?php foreach ($provinces as $province): ?>
                <div class="province-card" data-type="<?php echo $province['type']; ?>" data-name="<?php echo strtolower($province['name']); ?>">
                    <div class="province-header">
                        <div class="province-flag">
                            <img src="/images/flags/<?php echo strtolower($province['code']); ?>.svg" 
                                 alt="<?php echo htmlspecialchars($province['name']); ?> Flag"
                                 onerror="this.src='/images/flags/ca.svg'">
                        </div>
                        <div class="province-info">
                            <h3 class="province-name"><?php echo htmlspecialchars($province['name']); ?></h3>
                            <div class="province-type"><?php echo ucfirst($province['type']); ?></div>
                            <div class="province-region"><?php echo $province['region']; ?></div>
                        </div>
                    </div>

                    <div class="province-details">
                        <div class="detail-row">
                            <span class="detail-label">Capital:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($province['capital']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Population:</span>
                            <span class="detail-value">
                                <?php 
                                if ($province['population'] >= 1000000) {
                                    echo number_format($province['population'] / 1000000, 1) . 'M';
                                } else {
                                    echo number_format($province['population'] / 1000) . 'K';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Legal Age:</span>
                            <span class="detail-value"><?php echo $province['gambling_age']; ?>+ years</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Casinos:</span>
                            <span class="detail-value"><?php echo $province['casino_count']; ?> available</span>
                        </div>
                    </div>

                    <div class="legal-status">
                        <h4>Legal Status</h4>
                        <p><?php echo htmlspecialchars($province['legal_status']); ?></p>
                    </div>

                    <div class="top-casino">
                        <h4>Top Recommendation</h4>
                        <div class="casino-info">
                            <div class="casino-name"><?php echo htmlspecialchars($province['top_casino']); ?></div>
                            <div class="casino-rating">
                                <?php 
                                $rating = $province['top_casino_rating'];
                                $fullStars = floor($rating);
                                for ($i = 0; $i < $fullStars; $i++) {
                                    echo '⭐';
                                }
                                ?>
                                <span><?php echo number_format($rating, 1); ?>/5</span>
                            </div>
                        </div>
                    </div>

                    <div class="province-actions">
                        <a href="/provinces/<?php echo strtolower($province['code']); ?>" class="btn btn-primary">
                            View Details
                        </a>
                        <a href="/provinces/<?php echo strtolower($province['code']); ?>/casinos" class="btn btn-secondary">
                            Browse Casinos
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2025 Best Casino Portal. All rights reserved. Gambling can be addictive. Please play responsibly.</p>
        </div>
    </footer>

    <script>
    // Search functionality
    document.getElementById('provinceSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('.province-card');
        
        cards.forEach(card => {
            const name = card.dataset.name;
            const visible = name.includes(query);
            card.style.display = visible ? 'block' : 'none';
        });
    });

    // Filter functionality
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter cards
            const filter = this.dataset.filter;
            const cards = document.querySelectorAll('.province-card');
            
            cards.forEach(card => {
                const type = card.dataset.type;
                const visible = filter === 'all' || type === filter;
                card.style.display = visible ? 'block' : 'none';
            });
        });
    });

    // Card hover effects
    document.querySelectorAll('.province-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    </script>
</body>
</html>
