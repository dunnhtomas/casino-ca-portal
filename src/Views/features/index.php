<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : '5 Key Features - Best Casino Portal' ?></title>
    <meta name="description" content="<?= isset($metaDescription) ? htmlspecialchars($metaDescription) : 'Discover why our casino review platform is the best choice for Canadian players.' ?>">
    
    <!-- SEO Meta Tags -->
    <meta name="keywords" content="Canadian casino features, online casino benefits, casino reviews Canada, premium casino games, CAD bonuses, mobile gaming">
    <meta name="author" content="Best Casino Portal">
    <meta property="og:title" content="5 Key Features - Why Choose Our Casino Reviews">
    <meta property="og:description" content="Premium games, CAD bonuses, local payments, mobile gaming, and bank-level security for Canadian players.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://bestcasinoportal.com/features">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/features.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-dice"></i> Best Casino Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="/casinos">Casinos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/bonuses">Bonuses</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="features-hero bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold">5 Key Features That Set Us Apart</h1>
                    <p class="lead">Discover why millions of Canadian players trust our casino reviews to find the best online gambling experiences.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">21,500+</span>
                            <span class="stat-label">Casino Games</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">$20,000</span>
                            <span class="stat-label">Max Bonus CAD</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-detailed py-5">
        <div class="container">
            <?php if (isset($features) && is_array($features)): ?>
                <?php foreach ($features as $index => $feature): ?>
                    <div class="feature-row <?= $index % 2 === 0 ? 'row' : 'row flex-row-reverse' ?> align-items-center mb-5">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="feature-icon-large <?= htmlspecialchars($feature['color_scheme'] ?? 'blue') ?>">
                                <i class="<?= htmlspecialchars($feature['icon_class'] ?? 'fas fa-star') ?>"></i>
                            </div>
                            <h2 class="feature-title-large"><?= htmlspecialchars($feature['title'] ?? '') ?></h2>
                            <p class="feature-description-large"><?= htmlspecialchars($feature['description'] ?? '') ?></p>
                            
                            <?php if (!empty($feature['keywords'])): ?>
                                <div class="feature-keywords">
                                    <strong>Key Features:</strong>
                                    <?php foreach ($feature['keywords'] as $keyword): ?>
                                        <span class="keyword-tag"><?= htmlspecialchars($keyword) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($feature['canadian_focus'])): ?>
                                <div class="canadian-focus">
                                    <i class="fas fa-maple-leaf text-danger me-2"></i>
                                    <strong>Canadian Focus:</strong> <?= htmlspecialchars($feature['canadian_focus']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="feature-visual">
                                <div class="stat-card">
                                    <div class="stat-value-large"><?= htmlspecialchars($feature['stat_value'] ?? '') ?></div>
                                    <div class="stat-label-large"><?= htmlspecialchars($feature['stat_label'] ?? '') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ($index < count($features) - 1): ?>
                        <hr class="feature-divider">
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Canadian Focus Section -->
    <?php if (isset($canadianFocus) && is_array($canadianFocus)): ?>
    <section class="canadian-focus-section bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">
                        <i class="fas fa-maple-leaf text-danger me-3"></i>
                        Built Specifically for Canadian Players
                    </h2>
                    <p class="section-subtitle">Every feature is designed with Canadian gambling preferences and regulations in mind.</p>
                </div>
            </div>
            
            <div class="row mt-4">
                <?php foreach ($canadianFocus as $focus): ?>
                    <div class="col-lg-6 mb-3">
                        <div class="focus-item">
                            <h5><?= htmlspecialchars($focus['title']) ?></h5>
                            <p class="text-muted"><?= htmlspecialchars($focus['canadian_focus']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="features-cta bg-primary text-white py-5">
        <div class="container text-center">
            <h2 class="mb-4">Ready to Experience These Features?</h2>
            <p class="lead mb-4">Join thousands of Canadian players who trust our casino reviews to find the best gaming experiences.</p>
            <div class="cta-buttons">
                <a href="/" class="btn btn-light btn-lg me-3">
                    <i class="fas fa-home me-2"></i>Back to Homepage
                </a>
                <a href="/casinos" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-dice me-2"></i>Browse Casinos
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2025 Best Casino Portal. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <small>Licensed casino reviews for Canadian players</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Schema.org structured data -->
    <?php if (isset($schema)): ?>
    <script type="application/ld+json">
    <?= json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>
    </script>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Feature card hover effects
        document.querySelectorAll('.feature-card').forEach(card => {
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
