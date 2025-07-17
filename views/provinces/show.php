<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? $province['name'] . ' Online Casinos') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'Complete guide to online casinos in ' . $province['name']) ?>">
    <link rel="stylesheet" href="/css/provinces-section.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="province-hero">
        <div class="province-hero-content">
            <h1><?= htmlspecialchars($province['name']) ?> Online Casinos</h1>
            <p class="subtitle">
                Complete guide to legal online gambling in <?= htmlspecialchars($province['name']) ?>
            </p>
            
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="number"><?= $province['gambling_age'] ?>+</span>
                    <span class="label">Legal Age</span>
                </div>
                <div class="hero-stat">
                    <span class="number"><?= $province['local_casinos'] ?></span>
                    <span class="label">Local Casinos</span>
                </div>
                <div class="hero-stat">
                    <span class="number"><?= htmlspecialchars($province['population']) ?></span>
                    <span class="label">Population</span>
                </div>
                <div class="hero-stat">
                    <span class="number status-<?= strtolower($province['legal_status']) ?>"><?= htmlspecialchars($province['legal_status']) ?></span>
                    <span class="label">Status</span>
                </div>
            </div>
        </div>
    </div>

    <div class="province-content">
        <div class="content-grid">
            <div class="main-content">
                <h2>Online Gambling in <?= htmlspecialchars($province['name']) ?></h2>
                <p><?= htmlspecialchars($province['description']) ?></p>
                
                <h3>Regulatory Information</h3>
                <p><strong>Regulatory Body:</strong> <?= htmlspecialchars($province['regulatory_body']) ?></p>
                <p><strong>Legal Gambling Age:</strong> <?= $province['gambling_age'] ?> years old</p>
                <p><strong>Legal Status:</strong> <?= htmlspecialchars($province['legal_status']) ?></p>
                
                <?php if (!empty($recommendedCasinos)): ?>
                <h3 id="casinos">Recommended Online Casinos for <?= htmlspecialchars($province['name']) ?></h3>
                <div class="recommended-casinos">
                    <?php foreach ($recommendedCasinos as $casino): ?>
                    <div class="casino-recommendation">
                        <div class="casino-info">
                            <img src="/images/casinos/<?= htmlspecialchars($casino['slug']) ?>.png" 
                                 alt="<?= htmlspecialchars($casino['name']) ?> logo"
                                 onerror="this.src='/images/placeholder.svg'">
                            <div>
                                <h4><?= htmlspecialchars($casino['name']) ?></h4>
                                <p><?= htmlspecialchars($casino['description'] ?? 'Top-rated online casino') ?></p>
                            </div>
                        </div>
                        <div class="casino-actions">
                            <a href="/casinos/<?= htmlspecialchars($casino['slug']) ?>" class="btn-view-details">
                                View Review
                            </a>
                            <a href="<?= htmlspecialchars($casino['affiliate_url'] ?? '#') ?>" 
                               class="btn-casinos" target="_blank" rel="noopener">
                                Play Now
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <h3>Gambling Laws & Regulations</h3>
                <p>
                    <?= htmlspecialchars($province['name']) ?> follows Canadian federal gambling laws while maintaining 
                    provincial jurisdiction over gaming activities. The minimum legal gambling age is 
                    <?= $province['gambling_age'] ?> years old.
                </p>
                
                <h3>Responsible Gambling</h3>
                <p>
                    All recommended casinos promote responsible gambling and provide tools for self-exclusion, 
                    deposit limits, and reality checks. If you need help with gambling addiction, contact 
                    the Canadian Problem Gambling Helpline at 1-888-795-6111.
                </p>
            </div>
            
            <div class="sidebar">
                <div class="key-facts">
                    <h3>Quick Facts</h3>
                    <ul class="fact-list">
                        <?php foreach ($province['key_facts'] as $fact): ?>
                        <li><?= htmlspecialchars($fact) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="province-navigation">
                    <h3>Other Provinces</h3>
                    <div class="province-links">
                        <a href="/provinces/on" class="province-link">Ontario</a>
                        <a href="/provinces/bc" class="province-link">British Columbia</a>
                        <a href="/provinces/qc" class="province-link">Quebec</a>
                        <a href="/provinces/ab" class="province-link">Alberta</a>
                        <a href="/provinces" class="province-link">View All Provinces</a>
                    </div>
                </div>
                
                <div class="help-section">
                    <h3>Need Help?</h3>
                    <p>Questions about online gambling in <?= htmlspecialchars($province['name']) ?>?</p>
                    <a href="/contact" class="btn-view-details">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .recommended-casinos {
            margin: 20px 0;
        }
        
        .casino-recommendation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .casino-info {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .casino-info img {
            width: 60px;
            height: 60px;
            margin-right: 15px;
            border-radius: 6px;
            object-fit: contain;
        }
        
        .casino-info h4 {
            margin: 0 0 5px 0;
            color: #2d3748;
        }
        
        .casino-info p {
            margin: 0;
            color: #4a5568;
            font-size: 0.9rem;
        }
        
        .casino-actions {
            display: flex;
            gap: 10px;
        }
        
        .casino-actions a {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .province-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .province-link {
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 6px;
            text-decoration: none;
            color: #4a5568;
            transition: all 0.3s ease;
        }
        
        .province-link:hover {
            background: #e2e8f0;
            color: #2d3748;
        }
        
        .help-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .casino-recommendation {
                flex-direction: column;
                gap: 15px;
            }
            
            .casino-actions {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</body>
</html>
