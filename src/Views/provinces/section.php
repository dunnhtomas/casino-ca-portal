<section class="provinces-section" id="canadian-provinces">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header">
            <h2 class="section-title">Canadian Provinces & Territories</h2>
            <p class="section-subtitle">
                Explore online casino options across all <?php echo $statistics['total_provinces']; ?> provinces and <?php echo $statistics['total_territories']; ?> territories. 
                Find region-specific regulations, legal gambling age requirements, and top casino recommendations for your location.
            </p>
            <div class="provinces-stats">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $statistics['total_population'] ? number_format($statistics['total_population'] / 1000000, 1) . 'M' : '38M+'; ?></div>
                    <div class="stat-label">Total Population</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $statistics['total_casinos'] ?? '200+'; ?></div>
                    <div class="stat-label">Available Casinos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $statistics['avg_gambling_age'] ?? '18.5'; ?>+</div>
                    <div class="stat-label">Avg Legal Age</div>
                </div>
            </div>
        </div>

        <!-- Province Cards Grid -->
        <div class="provinces-grid">
            <?php foreach ($provinces as $province): ?>
            <div class="province-card" data-province="<?php echo strtolower($province['code']); ?>">
                <div class="province-header">
                    <div class="province-flag">
                        <img src="/images/flags/<?php echo strtolower($province['code']); ?>.svg" 
                             alt="<?php echo htmlspecialchars($province['name']); ?> Flag"
                             onerror="this.src='/images/flags/ca.svg'">
                    </div>
                    <div class="province-info">
                        <h3 class="province-name"><?php echo htmlspecialchars($province['name']); ?></h3>
                        <div class="province-type"><?php echo ucfirst($province['type']); ?></div>
                    </div>
                </div>

                <div class="province-stats">
                    <div class="stat-row">
                        <div class="stat-item">
                            <span class="stat-icon">🎰</span>
                            <span class="stat-label">Casinos:</span>
                            <span class="stat-value"><?php echo $province['casino_count']; ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">🔞</span>
                            <span class="stat-label">Legal Age:</span>
                            <span class="stat-value"><?php echo $province['gambling_age']; ?>+</span>
                        </div>
                    </div>
                    <div class="stat-row">
                        <div class="stat-item population">
                            <span class="stat-icon">👥</span>
                            <span class="stat-label">Population:</span>
                            <span class="stat-value">
                                <?php 
                                if ($province['population'] >= 1000000) {
                                    echo number_format($province['population'] / 1000000, 1) . 'M';
                                } else {
                                    echo number_format($province['population'] / 1000) . 'K';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="stat-item region">
                            <span class="stat-icon">📍</span>
                            <span class="stat-label">Region:</span>
                            <span class="stat-value"><?php echo $province['region']; ?></span>
                        </div>
                    </div>
                </div>

                <div class="top-casino">
                    <h4 class="casino-title">Top Recommendation</h4>
                    <div class="casino-info">
                        <div class="casino-name"><?php echo htmlspecialchars($province['top_casino']); ?></div>
                        <div class="casino-rating">
                            <div class="stars">
                                <?php 
                                $rating = $province['top_casino_rating'];
                                $fullStars = floor($rating);
                                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                
                                for ($i = 0; $i < $fullStars; $i++) {
                                    echo '⭐';
                                }
                                if ($hasHalfStar) {
                                    echo '⭐';
                                }
                                ?>
                            </div>
                            <span class="rating-number"><?php echo number_format($rating, 1); ?>/5</span>
                        </div>
                    </div>
                    <div class="casino-bonus">
                        Welcome Bonus Available
                    </div>
                </div>

                <div class="legal-status">
                    <div class="status-indicator <?php echo $province['gambling_age'] <= 18 ? 'legal' : 'regulated'; ?>"></div>
                    <div class="status-text">
                        <?php 
                        $status = $province['legal_status'];
                        if (strlen($status) > 50) {
                            echo htmlspecialchars(substr($status, 0, 47)) . '...';
                        } else {
                            echo htmlspecialchars($status);
                        }
                        ?>
                    </div>
                </div>

                <div class="province-actions">
                    <a href="/provinces/<?php echo strtolower($province['code']); ?>" 
                       class="btn btn-primary">
                        View Details
                    </a>
                    <a href="/provinces/<?php echo strtolower($province['code']); ?>/casinos" 
                       class="btn btn-secondary">
                        Browse Casinos
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- View All Button -->
        <div class="section-footer">
            <a href="/provinces" class="btn btn-outline btn-large">
                View All <?php echo $statistics['total_provinces'] + $statistics['total_territories']; ?> Provinces & Territories
            </a>
            <p class="disclaimer">
                Online gambling laws vary by province. Please ensure you comply with your local regulations. 
                Must be <?php echo $statistics['avg_gambling_age']; ?>+ years old to participate.
            </p>
        </div>
    </div>
</section>

<!-- Province Quick Search -->
<div class="province-search-overlay" id="provinceSearch" style="display: none;">
    <div class="search-modal">
        <div class="search-header">
            <h3>Find Your Province</h3>
            <button class="close-search" onclick="closeProvinceSearch()">✕</button>
        </div>
        <div class="search-body">
            <input type="text" id="provinceSearchInput" placeholder="Search provinces..." class="search-input">
            <div class="search-results" id="provinceSearchResults"></div>
        </div>
    </div>
</div>

<script>
// Province search functionality
function openProvinceSearch() {
    document.getElementById('provinceSearch').style.display = 'block';
    document.getElementById('provinceSearchInput').focus();
}

function closeProvinceSearch() {
    document.getElementById('provinceSearch').style.display = 'none';
}

// Search input handler
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('provinceSearchInput');
    const searchResults = document.getElementById('provinceSearchResults');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            if (query.length >= 2) {
                fetch(`/api/provinces/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displaySearchResults(data.data.provinces);
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            } else {
                searchResults.innerHTML = '';
            }
        });
    }
});

function displaySearchResults(provinces) {
    const resultsContainer = document.getElementById('provinceSearchResults');
    
    if (provinces.length === 0) {
        resultsContainer.innerHTML = '<div class="no-results">No provinces found</div>';
        return;
    }
    
    const resultsHTML = provinces.map(province => `
        <div class="search-result-item" onclick="window.location.href='/provinces/${province.code.toLowerCase()}'">
            <div class="result-name">${province.name}</div>
            <div class="result-details">${province.type} • ${province.casino_count} casinos • ${province.gambling_age}+ legal age</div>
        </div>
    `).join('');
    
    resultsContainer.innerHTML = resultsHTML;
}

// Province card interactions
document.addEventListener('DOMContentLoaded', function() {
    const provinceCards = document.querySelectorAll('.province-card');
    
    provinceCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
