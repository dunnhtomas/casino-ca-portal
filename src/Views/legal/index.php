<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Gambling Legal Status in Canada 2025 | BestCasinoPortal.com</title>
    <meta name="description" content="Complete guide to online gambling laws in Canada. Learn about regulations, licensing authorities, provincial laws, and legal casino recommendations for 2025.">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/legal-status.css">
    <link rel="canonical" href="https://bestcasinoportal.com/legal-status">
</head>
<body>
    <div class="legal-section">
        <div class="legal-container">
            <!-- Header Section -->
            <div class="section-header">
                <h1 class="section-title">🏛️ Legal Status & Regulation in Canada</h1>
                <p class="section-subtitle">
                    Complete transparency about online gambling laws, regulations, and licensing authorities in Canada. 
                    Understand the legal framework that protects Canadian players and ensures safe gaming.
                </p>
            </div>

            <!-- Legal Summary Widget -->
            <div class="legal-summary-widget">
                <h3>⚖️ Canadian Online Gambling - Quick Legal Overview</h3>
                <div class="legal-highlights">
                    <div class="legal-highlight">
                        <div class="icon">✅</div>
                        <div class="label">Legal Status</div>
                        <div class="value">Legal</div>
                    </div>
                    <div class="legal-highlight">
                        <div class="icon">🎰</div>
                        <div class="label">Licensed Casinos</div>
                        <div class="value"><?= $legal_summary['total_casinos'] ?>+</div>
                    </div>
                    <div class="legal-highlight">
                        <div class="icon">🏢</div>
                        <div class="label">Local Casinos</div>
                        <div class="value"><?= $legal_summary['local_casinos'] ?></div>
                    </div>
                    <div class="legal-highlight">
                        <div class="icon">🎂</div>
                        <div class="label">Min Age</div>
                        <div class="value"><?= $legal_summary['gambling_age'] ?></div>
                    </div>
                </div>
            </div>

            <!-- Comprehensive Legal Status Table -->
            <div class="legal-status-table">
                <div class="legal-row">
                    <div class="legal-label">⚖️ Legal Status</div>
                    <div class="legal-value legal-status-legal"><?= htmlspecialchars($legal_summary['status']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🎰 Number of Casinos</div>
                    <div class="legal-value"><?= $legal_summary['total_casinos'] ?>+</div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🔎 Authorities</div>
                    <div class="legal-value">
                        <?php foreach ($legal_summary['authorities'] as $authority): ?>
                        <span class="authority-tag"><?= htmlspecialchars($authority) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🏢 Local Casinos</div>
                    <div class="legal-value"><?= $legal_summary['local_casinos'] ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">💰 Min Deposit</div>
                    <div class="legal-value"><?= htmlspecialchars($legal_summary['min_deposit']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">💳 Payment Methods</div>
                    <div class="legal-value"><?= implode(', ', $legal_summary['payment_methods']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🎮 Popular Games</div>
                    <div class="legal-value"><?= implode(', ', $legal_summary['popular_games']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🏆 Best Casino</div>
                    <div class="legal-value">
                        <a href="/casinos/jackpot-city" class="best-casino-link"><?= htmlspecialchars($legal_summary['best_casino']) ?></a>
                    </div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🎁 Biggest Bonus</div>
                    <div class="legal-value"><?= htmlspecialchars($legal_summary['biggest_bonus']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">🎂 Gambling Age</div>
                    <div class="legal-value"><?= htmlspecialchars($legal_summary['gambling_age']) ?></div>
                </div>
                <div class="legal-row">
                    <div class="legal-label">💰 Tax</div>
                    <div class="legal-value"><?= htmlspecialchars($legal_summary['tax_info']) ?></div>
                </div>
            </div>

            <!-- Regulatory Authorities Section -->
            <div class="section-header">
                <h2 class="section-title">🏛️ Regulatory Authorities</h2>
                <p class="section-subtitle">
                    Key licensing bodies that regulate online casinos serving Canadian players
                </p>
            </div>

            <div class="regulatory-authorities">
                <?php foreach ($authorities as $code => $authority): ?>
                <div class="authority-card">
                    <div class="authority-header">
                        <div class="authority-logo"><?= strtoupper(substr($authority['name'], 0, 3)) ?></div>
                        <h3 class="authority-name"><?= htmlspecialchars($authority['name']) ?></h3>
                    </div>
                    <div class="authority-details">
                        <p><strong>Jurisdiction:</strong> <?= htmlspecialchars($authority['jurisdiction'] ?? 'N/A') ?></p>
                        <p><strong>Canadian Relevance:</strong> <?= htmlspecialchars($authority['canadian_relevance'] ?? 'N/A') ?></p>
                        <p><?= htmlspecialchars($authority['description'] ?? '') ?></p>
                    </div>
                    <?php if (isset($authority['website'])): ?>
                    <a href="<?= htmlspecialchars($authority['website']) ?>" target="_blank" rel="noopener" class="authority-link">
                        Visit Official Site
                    </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Provincial Breakdown Section -->
            <div class="provincial-breakdown">
                <div class="section-header">
                    <h2 class="section-title">🍁 Provincial Laws & Regulations</h2>
                    <p class="section-subtitle">
                        Gambling laws vary by province. Here's what you need to know for each jurisdiction.
                    </p>
                </div>

                <div class="provincial-grid">
                    <?php foreach ($provinces as $code => $province): ?>
                    <div class="province-card">
                        <div class="province-name">
                            🏛️ <?= htmlspecialchars($province['name']) ?>
                        </div>
                        <div class="province-details">
                            <p><strong>Status:</strong> <?= htmlspecialchars($province['status']) ?></p>
                            <p><strong>Age Requirement:</strong> <?= $province['age_requirement'] ?>+</p>
                            <p><strong>Regulator:</strong> <?= htmlspecialchars($province['regulator']) ?></p>
                            <p><strong>Local Operators:</strong> <?= htmlspecialchars($province['local_operators']) ?></p>
                            <p><strong>International Access:</strong> <?= htmlspecialchars($province['international_access']) ?></p>
                            <p><strong>Tax Implications:</strong> <?= htmlspecialchars($province['tax_implications']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Payment Methods Regulations -->
            <div class="payment-methods-section">
                <div class="section-header">
                    <h2 class="section-title">💳 Payment Method Regulations</h2>
                    <p class="section-subtitle">
                        Legal payment options for Canadian online casino players
                    </p>
                </div>

                <div class="payment-grid">
                    <?php foreach ($payment_methods as $method_code => $method): ?>
                    <div class="payment-card">
                        <div class="payment-icon">
                            <?php 
                            $icons = [
                                'interac' => '🏦',
                                'visa_mastercard' => '💳',
                                'cryptocurrency' => '₿',
                                'muchbetter' => '📱'
                            ];
                            echo $icons[$method_code] ?? '💰';
                            ?>
                        </div>
                        <div class="payment-name"><?= htmlspecialchars($method['name']) ?></div>
                        <div class="payment-status <?= strpos($method['status'], 'restriction') !== false ? 'restricted' : '' ?>">
                            <?= htmlspecialchars($method['status']) ?>
                        </div>
                        <div class="payment-details">
                            <p><strong>Processing:</strong> <?= htmlspecialchars($method['processing_time']) ?></p>
                            <p><strong>Limits:</strong> <?= htmlspecialchars($method['limits']) ?></p>
                            <?php if (isset($method['notes'])): ?>
                            <p><strong>Notes:</strong> <?= htmlspecialchars($method['notes']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Legal Disclaimer -->
            <div class="legal-overview">
                <h3>⚠️ Legal Disclaimer</h3>
                <p>
                    This information is provided for educational purposes and reflects the current legal landscape as of 
                    <?= date('F Y') ?>. Laws and regulations may change, and this should not be considered legal advice. 
                    Always verify current regulations with official sources and consult with legal professionals if needed.
                </p>
                <p>
                    <strong>Last Updated:</strong> <?= $legal_data['legal_overview']['last_updated'] ?? date('Y-m-d') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "GovernmentService",
        "name": "Canadian Online Gambling Legal Information",
        "description": "Complete guide to online gambling laws and regulations in Canada",
        "provider": {
            "@type": "Organization",
            "name": "BestCasinoPortal.com"
        },
        "areaServed": {
            "@type": "Country",
            "name": "Canada"
        },
        "serviceType": "Legal Information",
        "audience": {
            "@type": "Audience",
            "audienceType": "Canadian Online Casino Players"
        }
    }
    </script>
</body>
</html>
