<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/review-methodology.css">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "<?= htmlspecialchars($title) ?>",
        "description": "<?= htmlspecialchars($description) ?>",
        "author": {
            "@type": "Organization",
            "name": "Best Casino Portal",
            "url": "https://bestcasinoportal.com"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Best Casino Portal",
            "logo": {
                "@type": "ImageObject",
                "url": "https://bestcasinoportal.com/images/logo.png"
            }
        },
        "datePublished": "2025-01-15",
        "dateModified": "<?= date('Y-m-d') ?>",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?= htmlspecialchars($canonical) ?>"
        }
    }
    </script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <strong>Best Casino Portal</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/casinos">Casinos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/review-methodology">How We Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bonuses">Bonuses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/games">Games</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Methodology Hero Section -->
    <section class="methodology-hero">
        <div class="container">
            <h1>How We Review Online Casinos</h1>
            <p class="subtitle">
                Our expert team follows a rigorous 7-point methodology to evaluate every aspect of online casinos, 
                ensuring you get honest, unbiased reviews you can trust.
            </p>
            
            <!-- Trust Indicators -->
            <div class="trust-indicators">
                <div class="trust-indicator">
                    <span class="number"><?= $methodology['methodology_overview']['total_criteria'] ?></span>
                    <span class="label">Review Criteria</span>
                </div>
                <div class="trust-indicator">
                    <span class="number"><?= $methodology['methodology_overview']['expert_reviewers'] ?></span>
                    <span class="label">Expert Reviewers</span>
                </div>
                <div class="trust-indicator">
                    <span class="number"><?= $methodology['methodology_overview']['annual_reviews'] ?></span>
                    <span class="label">Annual Reviews</span>
                </div>
                <div class="trust-indicator">
                    <span class="number"><?= explode('-', $methodology['methodology_overview']['testing_duration'])[0] ?>+</span>
                    <span class="label">Days Per Review</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="methodology-section">
        <div class="methodology-breakdown">
            
            <!-- Section Header -->
            <div class="section-header">
                <h2 class="section-title">Our 7-Point Review System</h2>
                <p class="section-subtitle">
                    Every casino is evaluated using our comprehensive scoring system, with each criterion weighted 
                    based on its importance to Canadian players.
                </p>
            </div>

            <!-- Criteria Overview -->
            <div class="criteria-overview">
                <h3>Review Criteria Breakdown</h3>
                <div class="criteria-grid">
                    <?php foreach ($methodology['scoring_criteria'] as $key => $criteria): ?>
                    <div class="criteria-card" style="border-left: 4px solid <?= $criteria['color'] ?>">
                        <div class="criteria-header">
                            <span class="criteria-icon"><?= $criteria['icon'] ?></span>
                            <div class="criteria-info">
                                <h4><?= htmlspecialchars($criteria['name']) ?></h4>
                                <span class="criteria-weight"><?= $criteria['weight'] ?>% of total score</span>
                            </div>
                        </div>
                        <p class="criteria-description">
                            <?= htmlspecialchars($criteria['description']) ?>
                        </p>
                        <a href="/methodology/<?= $key ?>" class="learn-more-btn">
                            Learn More About This Criteria
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Scoring Visualization -->
            <div class="scoring-visualization">
                <div class="section-header">
                    <h3 class="section-title">Score Breakdown</h3>
                    <p class="section-subtitle">
                        See how each criteria contributes to the overall casino rating
                    </p>
                </div>
                
                <div class="score-breakdown">
                    <?php foreach ($methodology['scoring_criteria'] as $key => $criteria): ?>
                    <div class="score-item">
                        <div class="score-color" style="background-color: <?= $criteria['color'] ?>"></div>
                        <div class="score-details">
                            <div class="score-name"><?= htmlspecialchars($criteria['name']) ?></div>
                            <div class="score-percentage"><?= $criteria['weight'] ?>% Weight</div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Testing Process -->
            <div class="testing-process">
                <div class="section-header">
                    <h3 class="section-title">Our Testing Process</h3>
                    <p class="section-subtitle">
                        Each casino undergoes a comprehensive <?= $methodology['methodology_overview']['testing_duration'] ?> 
                        evaluation across 5 distinct phases
                    </p>
                </div>
                
                <div class="process-timeline">
                    <?php $phaseNumber = 1; foreach ($methodology['testing_process'] as $phase): ?>
                    <div class="process-step">
                        <div class="step-number"><?= $phaseNumber ?></div>
                        <div class="step-content">
                            <h4><?= htmlspecialchars($phase['name']) ?></h4>
                            <div class="step-duration">Duration: <?= htmlspecialchars($phase['duration']) ?></div>
                            <div class="step-activities">
                                <ul>
                                    <?php foreach ($phase['activities'] as $activity): ?>
                                    <li><?= htmlspecialchars($activity) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php $phaseNumber++; endforeach; ?>
                </div>
            </div>

            <!-- Expert Team -->
            <div class="expert-team-section">
                <div class="section-header">
                    <h3 class="section-title">Our Expert Review Team</h3>
                    <p class="section-subtitle">
                        Meet the qualified professionals who conduct our casino evaluations
                    </p>
                </div>
                
                <div class="experts-grid">
                    <?php foreach ($methodology['expert_team'] as $expert): ?>
                    <div class="expert-card">
                        <div class="expert-avatar">
                            <?= strtoupper(substr($expert['name'], 0, 1)) ?>
                        </div>
                        <div class="expert-name"><?= htmlspecialchars($expert['name']) ?></div>
                        <div class="expert-title"><?= htmlspecialchars($expert['title']) ?></div>
                        <div class="expert-experience"><?= htmlspecialchars($expert['experience']) ?> Experience</div>
                        <div class="expert-focus">
                            <strong>Specialty:</strong> <?= htmlspecialchars($expert['specialty']) ?><br>
                            <strong>Focus:</strong> <?= htmlspecialchars($expert['review_focus']) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Transparency Section -->
            <div class="transparency-section">
                <div class="section-header">
                    <h3 style="color: white;">Our Transparency Commitments</h3>
                    <p style="color: rgba(255,255,255,0.9);">
                        We maintain the highest standards of editorial independence and review integrity
                    </p>
                </div>
                
                <div class="transparency-commitments">
                    <?php 
                    $commitmentTitles = [
                        'independence' => 'Editorial Independence',
                        'unbiased_testing' => 'Unbiased Testing',
                        'regular_updates' => 'Regular Updates',
                        'real_money_testing' => 'Real Money Testing',
                        'no_pay_for_play' => 'No Pay-for-Play'
                    ];
                    
                    foreach ($methodology['transparency_commitments'] as $key => $commitment): 
                    ?>
                    <div class="commitment-item">
                        <h4><?= htmlspecialchars($commitmentTitles[$key]) ?></h4>
                        <p><?= htmlspecialchars($commitment) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="methodology-navigation">
                <div class="section-header">
                    <h3 class="section-title">Explore More</h3>
                    <p class="section-subtitle">
                        Dive deeper into specific aspects of our review methodology
                    </p>
                </div>
                
                <div class="nav-grid">
                    <a href="/expert-team" class="nav-item">
                        <h4>Meet Our Experts</h4>
                        <p>Learn about the qualifications and experience of our review team</p>
                    </a>
                    <a href="/testing-process" class="nav-item">
                        <h4>Testing Process</h4>
                        <p>Detailed breakdown of our 5-phase casino evaluation timeline</p>
                    </a>
                    <a href="/casinos" class="nav-item">
                        <h4>View Our Reviews</h4>
                        <p>See our methodology in action with detailed casino reviews</p>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Best Casino Portal</h5>
                    <p>Canada's most trusted source for online casino reviews and expert gambling insights.</p>
                </div>
                <div class="col-md-2">
                    <h6>Reviews</h6>
                    <ul class="list-unstyled">
                        <li><a href="/casinos" class="text-light">Casino Reviews</a></li>
                        <li><a href="/bonuses" class="text-light">Bonus Reviews</a></li>
                        <li><a href="/games" class="text-light">Game Reviews</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>About</h6>
                    <ul class="list-unstyled">
                        <li><a href="/review-methodology" class="text-light">How We Review</a></li>
                        <li><a href="/expert-team" class="text-light">Expert Team</a></li>
                        <li><a href="/contact" class="text-light">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Legal</h6>
                    <ul class="list-unstyled">
                        <li><a href="/privacy" class="text-light">Privacy Policy</a></li>
                        <li><a href="/terms" class="text-light">Terms of Service</a></li>
                        <li><a href="/responsible-gambling" class="text-light">Responsible Gambling</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6>Connect</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">Newsletter</a></li>
                        <li><a href="#" class="text-light">RSS Feed</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p>&copy; 2025 Best Casino Portal. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>18+ | Play Responsibly | BeGambleAware.org</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
