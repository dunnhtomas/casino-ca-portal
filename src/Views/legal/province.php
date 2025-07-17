<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Gambling Laws in <?= htmlspecialchars($province['name']) ?> 2025 | BestCasinoPortal.com</title>
    <meta name="description" content="Complete guide to online gambling laws in <?= htmlspecialchars($province['name']) ?>. Age requirements, regulations, legal casinos, and player protection.">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/legal-status.css">
    <link rel="canonical" href="https://bestcasinoportal.com/legal/<?= $province_code ?>">
</head>
<body>
    <div class="legal-section">
        <div class="legal-container">
            <!-- Province Header -->
            <div class="section-header">
                <h1 class="section-title">🏛️ Online Gambling Laws in <?= htmlspecialchars($province['name']) ?></h1>
                <p class="section-subtitle">
                    Complete legal guide for <?= htmlspecialchars($province['name']) ?> residents. 
                    Age requirements, licensing authorities, and legal casino recommendations.
                </p>
            </div>

            <!-- Province Legal Summary -->
            <div class="legal-summary-widget">
                <h3>⚖️ <?= htmlspecialchars($province['name']) ?> Gambling Laws - Quick Overview</h3>
                <div class="legal-highlights">
                    <div class="legal-highlight">
                        <div class="icon">✅</div>
                        <div class="label">Legal Status</div>
                        <div class="value"><?= htmlspecialchars($province['status']) ?></div>
                    </div>
                    <div class="legal-highlight">
                        <div class="icon">🎂</div>
                        <div class="label">Min Age</div>
                        <div class="value"><?= $province['age_requirement'] ?>+</div>
                    </div>
                    <div class="legal-highlight">
                        <div class="icon">🏛️</div>
                        <div class="label">Regulator</div>
                        <div class="value"><?= htmlspecialchars($province['regulator']) ?></div>
                    </div>
                    <div class="legal-highlight">
                        <div class="icon">🌐</div>
                        <div class="label">International Access</div>
                        <div class="value"><?= htmlspecialchars($province['international_access']) ?></div>
                    </div>
                </div>
            </div>

            <!-- Detailed Province Information -->
            <div class="legal-status-table">
                <div class="legal-row">
                    <div class="legal-label">🏛️ Province</div>
                    <div class="legal-value"><?= htmlspecialchars($province['name']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">⚖️ Legal Status</div>
                    <div class="legal-value legal-status-legal"><?= htmlspecialchars($province['status']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🎂 Minimum Age</div>
                    <div class="legal-value"><?= $province['age_requirement'] ?> years old</div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🔎 Regulator</div>
                    <div class="legal-value"><?= htmlspecialchars($province['regulator']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🏢 Local Operators</div>
                    <div class="legal-value"><?= htmlspecialchars($province['local_operators']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🌐 International Access</div>
                    <div class="legal-value"><?= htmlspecialchars($province['international_access']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">💰 Tax Implications</div>
                    <div class="legal-value"><?= htmlspecialchars($province['tax_implications']) ?></div>
                </div>
                <?php if (isset($province['population'])): ?>
                <div class="legal-row">
                    <div class="legal-label">👥 Population</div>
                    <div class="legal-value"><?= htmlspecialchars($province['population']) ?></div>
                </div>
                <?php endif; ?>
                <?php if (isset($province['key_legislation'])): ?>
                <div class="legal-row">
                    <div class="legal-label">📋 Key Legislation</div>
                    <div class="legal-value"><?= htmlspecialchars($province['key_legislation']) ?></div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Province-Specific Legal Details -->
            <div class="legal-overview">
                <h3>🏛️ <?= htmlspecialchars($province['name']) ?> Gambling Regulations</h3>
                
                <?php if ($province_code === 'ontario'): ?>
                <p>
                    Ontario has the most comprehensive online gambling framework in Canada with the launch of iGaming Ontario (iGO) in 2022. 
                    The province operates a regulated market where licensed operators can offer casino games, sports betting, and poker to Ontario residents aged 19 and over.
                </p>
                <p>
                    <strong>Key Features:</strong>
                </p>
                <ul>
                    <li>Regulated market with licensed operators</li>
                    <li>Consumer protection measures</li>
                    <li>Responsible gambling tools</li>
                    <li>Revenue sharing with the province</li>
                </ul>
                
                <?php elseif ($province_code === 'quebec'): ?>
                <p>
                    Quebec operates its own online gambling platform, Espacejeux.com, managed by Loto-Québec. 
                    The province has exclusive rights to offer online gambling to Quebec residents aged 18 and over.
                </p>
                <p>
                    <strong>Key Features:</strong>
                </p>
                <ul>
                    <li>Provincial monopoly through Loto-Québec</li>
                    <li>Espacejeux.com as the official platform</li>
                    <li>French and English language support</li>
                    <li>Revenue supports provincial programs</li>
                </ul>
                
                <?php elseif ($province_code === 'alberta'): ?>
                <p>
                    Alberta operates PlayAlberta.ca as its official online gambling site, managed by the Alberta Gaming, Liquor and Cannabis commission. 
                    Residents aged 18 and over can access casino games and sports betting.
                </p>
                <p>
                    <strong>Key Features:</strong>
                </p>
                <ul>
                    <li>PlayAlberta.ca as the official platform</li>
                    <li>Casino games and sports betting available</li>
                    <li>Proceeds support provincial programs</li>
                    <li>Responsible gambling measures in place</li>
                </ul>
                
                <?php elseif ($province_code === 'british_columbia'): ?>
                <p>
                    British Columbia operates PlayNow.com through the British Columbia Lottery Corporation (BCLC). 
                    The platform offers casino games, sports betting, and lottery products to residents aged 19 and over.
                </p>
                <p>
                    <strong>Key Features:</strong>
                </p>
                <ul>
                    <li>PlayNow.com as the official platform</li>
                    <li>Comprehensive gaming options</li>
                    <li>Strong responsible gambling programs</li>
                    <li>Revenue supports community programs</li>
                </ul>
                
                <?php else: ?>
                <p>
                    <?= htmlspecialchars($province['name']) ?> follows federal gambling regulations while maintaining provincial oversight 
                    through <?= htmlspecialchars($province['regulator']) ?>. Residents aged <?= $province['age_requirement'] ?> and over 
                    can legally access licensed online casinos.
                </p>
                <p>
                    <strong>Key Regulations:</strong>
                </p>
                <ul>
                    <li>Minimum age requirement: <?= $province['age_requirement'] ?> years</li>
                    <li>Licensed international operators welcome</li>
                    <li>No provincial taxes on casual gambling winnings</li>
                    <li>Consumer protection through federal oversight</li>
                </ul>
                <?php endif; ?>
            </div>

            <!-- Recommended Casinos for This Province -->
            <div class="provincial-breakdown">
                <h3>🎰 Recommended Legal Casinos for <?= htmlspecialchars($province['name']) ?> Residents</h3>
                <p>These licensed casinos are legally accessible to residents of <?= htmlspecialchars($province['name']) ?>:</p>
                
                <div class="provincial-grid">
                    <!-- Casino recommendations would go here -->
                    <div class="province-card">
                        <div class="province-name">🏆 Jackpot City Casino</div>
                        <div class="province-details">
                            <p><strong>License:</strong> Malta Gaming Authority</p>
                            <p><strong>Bonus:</strong> 100% up to $1,600</p>
                            <p><strong>Games:</strong> 500+ slots, live dealer</p>
                            <p><strong>Age Verified:</strong> ✅ <?= $province['age_requirement'] ?>+ required</p>
                        </div>
                    </div>
                    
                    <div class="province-card">
                        <div class="province-name">🎮 Spin Casino</div>
                        <div class="province-details">
                            <p><strong>License:</strong> Malta Gaming Authority</p>
                            <p><strong>Bonus:</strong> 100% up to $1,000</p>
                            <p><strong>Games:</strong> 400+ slots, table games</p>
                            <p><strong>Age Verified:</strong> ✅ <?= $province['age_requirement'] ?>+ required</p>
                        </div>
                    </div>
                    
                    <div class="province-card">
                        <div class="province-name">🃏 Ruby Fortune</div>
                        <div class="province-details">
                            <p><strong>License:</strong> Malta Gaming Authority</p>
                            <p><strong>Bonus:</strong> 100% up to $750</p>
                            <p><strong>Games:</strong> 450+ games, jackpots</p>
                            <p><strong>Age Verified:</strong> ✅ <?= $province['age_requirement'] ?>+ required</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Provinces Quick Reference -->
            <div class="payment-methods-section">
                <h3>🍁 Other Canadian Provinces</h3>
                <div class="payment-grid">
                    <?php foreach ($all_provinces as $code => $other_province): ?>
                        <?php if ($code !== $province_code): ?>
                        <div class="payment-card">
                            <div class="payment-icon">🏛️</div>
                            <div class="payment-name"><?= htmlspecialchars($other_province['name']) ?></div>
                            <div class="payment-status">Age: <?= $other_province['age_requirement'] ?>+</div>
                            <div class="payment-details">
                                <p><strong>Status:</strong> <?= htmlspecialchars($other_province['status']) ?></p>
                                <a href="/legal/<?= $code ?>" style="color: #4299e1; text-decoration: none;">View Details →</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Back to Main Legal Page -->
            <div class="legal-overview">
                <h3>📚 More Legal Information</h3>
                <p>
                    For comprehensive information about Canadian online gambling laws, regulatory authorities, 
                    and payment method regulations, visit our main legal information page.
                </p>
                <p>
                    <a href="/legal-status" class="best-casino-link">← Back to Complete Legal Guide</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "GovernmentService",
        "name": "<?= htmlspecialchars($province['name']) ?> Online Gambling Legal Information",
        "description": "Legal guide for online gambling in <?= htmlspecialchars($province['name']) ?>",
        "provider": {
            "@type": "Organization",
            "name": "BestCasinoPortal.com"
        },
        "areaServed": {
            "@type": "State",
            "name": "<?= htmlspecialchars($province['name']) ?>",
            "containedInPlace": {
                "@type": "Country",
                "name": "Canada"
            }
        },
        "serviceType": "Legal Information",
        "audience": {
            "@type": "Audience",
            "audienceType": "<?= htmlspecialchars($province['name']) ?> Online Casino Players"
        }
    }
    </script>
</body>
</html>
