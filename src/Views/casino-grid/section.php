<!-- Interactive Casino Grid Section (PRD #31) -->
<link rel="stylesheet" href="/css/casino-grid.css">

<section class="casino-grid-section">
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-th-large"></i>
            Interactive Casino Grid
        </h2>
        <p class="section-subtitle">
            Explore our complete database of 90+ Canadian-friendly online casinos. Use our interactive grid to compare bonuses, ratings, game selections, and find your perfect casino match.
        </p>
    </div>

    <!-- Grid Statistics -->
    <div class="grid-statistics">
        <div class="stat-cards">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $statistics['total_casinos'] ?></div>
                    <div class="stat-label">Licensed Casinos</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= $statistics['total_categories'] ?></div>
                    <div class="stat-label">Casino Categories</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?= number_format($statistics['avg_rating'], 1) ?></div>
                    <div class="stat-label">Average Rating</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">$<?= number_format($statistics['max_bonus']) ?></div>
                    <div class="stat-label">Highest Bonus</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="grid-controls">
        <div class="search-container">
            <div class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search casinos by name, bonus, features..." id="casinoSearch">
                <div class="search-suggestions" id="searchSuggestions"></div>
            </div>
        </div>
        
        <div class="filter-controls">
            <button class="filter-toggle" id="filterToggle">
                <i class="fas fa-filter"></i>
                Advanced Filters
                <span class="filter-count" id="filterCount" style="display: none;">0</span>
            </button>
            
            <button class="compare-toggle" id="compareToggle" style="display: none;">
                <i class="fas fa-balance-scale"></i>
                Compare Selected (<span id="compareCount">0</span>)
            </button>
            
            <select class="sort-select" id="sortSelect">
                <option value="rating_desc">Highest Rated</option>
                <option value="bonus_desc">Best Bonus</option>
                <option value="newest">Newest Casinos</option>
                <option value="name_asc">A-Z</option>
                <option value="established_desc">Most Established</option>
            </select>
        </div>
    </div>

    <!-- Filter Panel (Hidden by default) -->
    <div class="filter-panel" id="filterPanel" style="display: none;">
        <div class="filter-panel-content">
            <div class="filter-section">
                <h4>Minimum Rating</h4>
                <div class="rating-filter">
                    <input type="range" min="1" max="5" step="0.1" value="1" class="slider" id="ratingRange">
                    <div class="slider-labels">
                        <span>1.0</span>
                        <span>2.5</span>
                        <span>4.0</span>
                        <span>5.0</span>
                    </div>
                </div>
            </div>
            
            <div class="filter-section">
                <h4>Casino Categories</h4>
                <div class="category-filters">
                    <?php foreach ($categories as $category): ?>
                    <label>
                        <input type="checkbox" name="categories[]" value="<?= htmlspecialchars($category['slug']) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="filter-section">
                <h4>License Jurisdictions</h4>
                <div class="license-filters">
                    <?php foreach ($licenses as $license): ?>
                    <label>
                        <input type="checkbox" name="licenses[]" value="<?= htmlspecialchars($license['code']) ?>">
                        <?= htmlspecialchars($license['name']) ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="filter-section">
                <h4>Established</h4>
                <div class="established-filters">
                    <label>
                        <input type="checkbox" name="established[]" value="2020-2024">
                        New (2020-2024)
                    </label>
                    <label>
                        <input type="checkbox" name="established[]" value="2015-2019">
                        Recent (2015-2019)
                    </label>
                    <label>
                        <input type="checkbox" name="established[]" value="2010-2014">
                        Established (2010-2014)
                    </label>
                    <label>
                        <input type="checkbox" name="established[]" value="2000-2009">
                        Veteran (2000-2009)
                    </label>
                </div>
            </div>
            
            <div class="filter-actions">
                <button class="btn btn-primary" id="applyFilters">
                    <i class="fas fa-check"></i>
                    Apply Filters
                </button>
                <button class="btn btn-secondary" id="clearFilters">
                    <i class="fas fa-times"></i>
                    Clear All
                </button>
            </div>
        </div>
    </div>

    <!-- Casino Grid Preview -->
    <div class="casino-grid-preview">
        <div class="casino-grid-cards" id="casinoGridCards">
            <?php foreach (array_slice($casinos, 0, 6) as $casino): ?>
            <div class="casino-grid-card" data-casino-id="<?= $casino['id'] ?>">
                <div class="card-header">
                    <div class="casino-logo">
                        <?= strtoupper(substr($casino['name'], 0, 2)) ?>
                    </div>
                    <div class="casino-rating">
                        <div class="rating-stars">
                            <?php 
                            $rating = $casino['rating'];
                            for ($i = 1; $i <= 5; $i++): 
                                if ($i <= $rating): ?>
                                    <i class="fas fa-star"></i>
                                <?php elseif ($i - 0.5 <= $rating): ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif;
                            endfor; ?>
                        </div>
                        <div class="rating-number"><?= number_format($rating, 1) ?>/5</div>
                    </div>
                    <div class="comparison-checkbox">
                        <input type="checkbox" class="compare-checkbox" value="<?= $casino['id'] ?>">
                    </div>
                </div>
                
                <div class="card-body">
                    <h3 class="casino-name"><?= htmlspecialchars($casino['name']) ?></h3>
                    
                    <div class="casino-meta">
                        <span>Est. <?= $casino['established'] ?></span>
                        <span><?= htmlspecialchars($casino['license']) ?></span>
                    </div>
                    
                    <div class="casino-highlights">
                        <div class="highlight-item">
                            <i class="fas fa-gift"></i>
                            Welcome Bonus: <?= htmlspecialchars($casino['welcome_bonus']) ?>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-gamepad"></i>
                            <?= number_format($casino['game_count']) ?>+ Games
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-mobile-alt"></i>
                            <?= $casino['mobile_optimized'] ? 'Mobile Optimized' : 'Desktop Only' ?>
                        </div>
                    </div>
                    
                    <div class="casino-categories">
                        <?php foreach (array_slice($casino['categories'], 0, 3) as $category): ?>
                        <span class="category-badge category-<?= $category['slug'] ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="card-actions">
                        <a href="<?= $casino['affiliate_url'] ?>" class="btn btn-primary" target="_blank">
                            Play Now
                        </a>
                        <button class="btn quick-stats-btn" onclick="showQuickStats(<?= $casino['id'] ?>)">
                            Quick Stats
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Grid Actions -->
    <div class="grid-actions">
        <a href="/casino-grid" class="btn btn-primary btn-lg view-all-casinos">
            <i class="fas fa-th-large"></i>
            View All <?= $statistics['total_casinos'] ?> Casinos
        </a>
        <p class="grid-info">
            Updated daily with the latest bonuses, ratings, and casino information
        </p>
    </div>
</section>

<!-- Comparison Modal (Hidden by default) -->
<div class="comparison-modal" id="comparisonModal" style="display: none;">
    <div class="modal-backdrop" onclick="closeComparisonModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Casino Comparison</h3>
            <button class="modal-close" onclick="closeComparisonModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="comparisonContent">
            <!-- Comparison content will be loaded here -->
        </div>
    </div>
</div>

<script>
// Interactive Grid JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('casinoSearch');
    const searchSuggestions = document.getElementById('searchSuggestions');
    
    searchInput.addEventListener('input', debounce(function() {
        const query = this.value.trim();
        if (query.length >= 2) {
            performSearch(query);
        } else {
            hideSuggestions();
        }
    }, 300));
    
    // Filter toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterPanel = document.getElementById('filterPanel');
    
    filterToggle.addEventListener('click', function() {
        const isVisible = filterPanel.style.display !== 'none';
        filterPanel.style.display = isVisible ? 'none' : 'block';
        this.classList.toggle('active', !isVisible);
    });
    
    // Sort functionality
    document.getElementById('sortSelect').addEventListener('change', function() {
        applySorting(this.value);
    });
    
    // Filter actions
    document.getElementById('applyFilters').addEventListener('click', applyFilters);
    document.getElementById('clearFilters').addEventListener('click', clearFilters);
    
    // Comparison functionality
    const compareCheckboxes = document.querySelectorAll('.compare-checkbox');
    compareCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateComparisonState);
    });
});

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function performSearch(query) {
    fetch(`/api/casino-grid/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            showSuggestions(data.suggestions);
        })
        .catch(error => console.error('Search error:', error));
}

function showSuggestions(suggestions) {
    const container = document.getElementById('searchSuggestions');
    container.innerHTML = suggestions.map(suggestion => 
        `<div class="search-suggestion" onclick="selectSuggestion('${suggestion.name}')">${suggestion.name}</div>`
    ).join('');
    container.style.display = 'block';
}

function hideSuggestions() {
    document.getElementById('searchSuggestions').style.display = 'none';
}

function selectSuggestion(name) {
    document.getElementById('casinoSearch').value = name;
    hideSuggestions();
    performFullSearch(name);
}

function applySorting(sortBy) {
    // Implement sorting logic
    console.log('Sorting by:', sortBy);
}

function applyFilters() {
    // Collect filter values and apply
    const filters = collectFilterValues();
    console.log('Applying filters:', filters);
}

function clearFilters() {
    // Clear all filter inputs
    document.querySelectorAll('.filter-panel input').forEach(input => {
        if (input.type === 'checkbox') {
            input.checked = false;
        } else if (input.type === 'range') {
            input.value = input.min;
        }
    });
    updateFilterCount();
}

function collectFilterValues() {
    const filters = {};
    
    // Rating filter
    filters.minRating = document.getElementById('ratingRange').value;
    
    // Category filters
    filters.categories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked'))
        .map(input => input.value);
    
    // License filters
    filters.licenses = Array.from(document.querySelectorAll('input[name="licenses[]"]:checked'))
        .map(input => input.value);
    
    // Established filters
    filters.established = Array.from(document.querySelectorAll('input[name="established[]"]:checked'))
        .map(input => input.value);
    
    return filters;
}

function updateFilterCount() {
    const filters = collectFilterValues();
    let count = 0;
    
    if (filters.minRating > 1) count++;
    count += filters.categories.length;
    count += filters.licenses.length;
    count += filters.established.length;
    
    const filterCount = document.getElementById('filterCount');
    if (count > 0) {
        filterCount.textContent = count;
        filterCount.style.display = 'inline';
    } else {
        filterCount.style.display = 'none';
    }
}

function updateComparisonState() {
    const checkedBoxes = document.querySelectorAll('.compare-checkbox:checked');
    const compareToggle = document.getElementById('compareToggle');
    const compareCount = document.getElementById('compareCount');
    
    compareCount.textContent = checkedBoxes.length;
    
    if (checkedBoxes.length > 0) {
        compareToggle.style.display = 'flex';
    } else {
        compareToggle.style.display = 'none';
    }
    
    if (checkedBoxes.length >= 2) {
        compareToggle.onclick = showComparison;
    }
}

function showComparison() {
    const selectedCasinos = Array.from(document.querySelectorAll('.compare-checkbox:checked'))
        .map(checkbox => checkbox.value);
    
    if (selectedCasinos.length >= 2) {
        loadComparisonData(selectedCasinos);
    }
}

function loadComparisonData(casinoIds) {
    const params = new URLSearchParams({ casinos: casinoIds.join(',') });
    
    fetch(`/api/casino-grid/compare?${params}`)
        .then(response => response.json())
        .then(data => {
            displayComparison(data);
        })
        .catch(error => console.error('Comparison error:', error));
}

function displayComparison(data) {
    const modal = document.getElementById('comparisonModal');
    const content = document.getElementById('comparisonContent');
    
    content.innerHTML = generateComparisonHTML(data);
    modal.style.display = 'block';
}

function generateComparisonHTML(data) {
    // Generate comparison table HTML
    return '<p>Comparison feature coming soon...</p>';
}

function closeComparisonModal() {
    document.getElementById('comparisonModal').style.display = 'none';
}

function showQuickStats(casinoId) {
    // Show quick stats popup
    console.log('Showing quick stats for casino:', casinoId);
}
</script>
