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
</head>
<body class="criteria-detail-page">
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

    <!-- Criteria Hero Section -->
    <section class="criteria-hero" style="background: linear-gradient(135deg, <?= $criteria['color'] ?>99 0%, <?= $criteria['color'] ?>cc 100%)">
        <div class="container">
            <span class="criteria-icon-large"><?= $criteria['icon'] ?></span>
            <h1><?= htmlspecialchars($criteria['name']) ?></h1>
            <div class="weight-display"><?= $criteria['weight'] ?>% of Total Score</div>
            <p class="subtitle">
                <?= htmlspecialchars($criteria['description']) ?>
            </p>
        </div>
    </section>

    <!-- Criteria Content -->
    <section class="criteria-content">
        <div class="container">
            
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/review-methodology">How We Review</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($criteria['name']) ?></li>
                </ol>
            </nav>

            <!-- Testing Methods Section -->
            <div class="testing-methods-section">
                <h3>How We Test <?= htmlspecialchars($criteria['name']) ?></h3>
                <p class="mb-4">
                    Our expert team uses the following comprehensive testing methods to evaluate this criteria:
                </p>
                <ul class="method-list">
                    <?php foreach ($criteria['testing_methods'] as $method): ?>
                    <li><?= htmlspecialchars($method) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Score Factors Section -->
            <div class="score-factors-section">
                <h3>What We Look For</h3>
                <p class="mb-4">
                    To achieve a high score in <?= htmlspecialchars($criteria['name']) ?>, a casino must demonstrate:
                </p>
                <ul class="factor-list">
                    <?php foreach ($criteria['score_factors'] as $factor): ?>
                    <li><?= htmlspecialchars($factor) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Other Criteria -->
            <div class="criteria-overview">
                <h3>Other Review Criteria</h3>
                <div class="criteria-grid">
                    <?php foreach ($all_criteria as $key => $other_criteria): ?>
                        <?php if ($key !== $criteria_slug): ?>
                        <div class="criteria-card" style="border-left: 4px solid <?= $other_criteria['color'] ?>">
                            <div class="criteria-header">
                                <span class="criteria-icon"><?= $other_criteria['icon'] ?></span>
                                <div class="criteria-info">
                                    <h4><?= htmlspecialchars($other_criteria['name']) ?></h4>
                                    <span class="criteria-weight"><?= $other_criteria['weight'] ?>% of total score</span>
                                </div>
                            </div>
                            <p class="criteria-description">
                                <?= htmlspecialchars($other_criteria['description']) ?>
                            </p>
                            <a href="/methodology/<?= $key ?>" class="learn-more-btn">
                                Learn More About This Criteria
                            </a>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Back to Methodology -->
            <div class="text-center mt-5">
                <a href="/review-methodology" class="btn btn-primary btn-lg">
                    ← Back to Complete Methodology
                </a>
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
