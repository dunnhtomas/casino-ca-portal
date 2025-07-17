<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($authority['name']) ?> - Casino Licensing Authority | BestCasinoPortal.com</title>
    <meta name="description" content="Complete guide to <?= htmlspecialchars($authority['name']) ?> casino licensing. Learn about their jurisdiction, regulations, and licensed casinos serving Canada.">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/legal-status.css">
    <link rel="canonical" href="https://bestcasinoportal.com/legal/authority/<?= $authority_code ?>">
</head>
<body>
    <div class="legal-section">
        <div class="legal-container">
            <!-- Authority Header -->
            <div class="section-header">
                <h1 class="section-title">🏛️ <?= htmlspecialchars($authority['name']) ?></h1>
                <p class="section-subtitle">
                    <?= htmlspecialchars($authority['description'] ?? 'Leading gaming regulator providing casino licensing and player protection.') ?>
                </p>
            </div>

            <!-- Authority Overview -->
            <div class="legal-summary-widget">
                <h3>🔎 <?= htmlspecialchars($authority['name']) ?> - Quick Overview</h3>
                <div class="legal-highlights">
                    <div class="legal-highlight">
                        <div class="icon">🌍</div>
                        <div class="label">Jurisdiction</div>
                        <div class="value"><?= htmlspecialchars($authority['jurisdiction'] ?? 'International') ?></div>
                    </div>
                    <?php if (isset($authority['established'])): ?>
                    <div class="legal-highlight">
                        <div class="icon">📅</div>
                        <div class="label">Established</div>
                        <div class="value"><?= $authority['established'] ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="legal-highlight">
                        <div class="icon">🇨🇦</div>
                        <div class="label">Canadian Relevance</div>
                        <div class="value"><?= htmlspecialchars($authority['canadian_relevance'] ?? 'International operator licensing') ?></div>
                    </div>
                    <?php if (isset($authority['reputation'])): ?>
                    <div class="legal-highlight">
                        <div class="icon">⭐</div>
                        <div class="label">Reputation</div>
                        <div class="value"><?= htmlspecialchars($authority['reputation']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Authority Details Table -->
            <div class="legal-status-table">
                <div class="legal-row">
                    <div class="legal-label">🏛️ Authority Name</div>
                    <div class="legal-value"><?= htmlspecialchars($authority['name']) ?></div>
                </div>
                <?php if (isset($authority['full_name'])): ?>
                <div class="legal-row">
                    <div class="legal-label">📋 Full Name</div>
                    <div class="legal-value"><?= htmlspecialchars($authority['full_name']) ?></div>
                </div>
                <?php endif; ?>
                <div class="legal-row">
                    <div class="legal-label">🌍 Jurisdiction</div>
                    <div class="legal-value"><?= htmlspecialchars($authority['jurisdiction'] ?? 'International') ?></div>
                </div>
                <?php if (isset($authority['established'])): ?>
                <div class="legal-row">
                    <div class="legal-label">📅 Established</div>
                    <div class="legal-value"><?= $authority['established'] ?></div>
                </div>
                <?php endif; ?>
                <div class="legal-row">
                    <div class="legal-label">🇨🇦 Canadian Relevance</div>
                    <div class="legal-value"><?= htmlspecialchars($authority['canadian_relevance'] ?? 'International operator licensing') ?></div>
                </div>
                <?php if (isset($authority['reputation'])): ?>
                <div class="legal-row">
                    <div class="legal-label">⭐ Reputation</div>
                    <div class="legal-value"><?= htmlspecialchars($authority['reputation']) ?></div>
                </div>
                <?php endif; ?>
                <?php if (isset($authority['oversight'])): ?>
                <div class="legal-row">
                    <div class="legal-label">🔍 Oversight Type</div>
                    <div class="legal-value"><?= htmlspecialchars($authority['oversight']) ?></div>
                </div>
                <?php endif; ?>
                <?php if (isset($authority['website'])): ?>
                <div class="legal-row">
                    <div class="legal-label">🌐 Official Website</div>
                    <div class="legal-value">
                        <a href="<?= htmlspecialchars($authority['website']) ?>" target="_blank" rel="noopener" class="best-casino-link">
                            Visit Official Site
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (isset($authority['license_verification'])): ?>
                <div class="legal-row">
                    <div class="legal-label">✅ License Verification</div>
                    <div class="legal-value">
                        <a href="<?= htmlspecialchars($authority['license_verification']) ?>" target="_blank" rel="noopener" class="best-casino-link">
                            Verify License
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- License Types and Responsibilities -->
            <?php if (isset($authority['license_types']) || isset($authority['responsibilities'])): ?>
            <div class="legal-overview">
                <h3>📋 Licensing and Responsibilities</h3>
                
                <?php if (isset($authority['license_types'])): ?>
                <h4>🏷️ License Types</h4>
                <ul>
                    <?php foreach ($authority['license_types'] as $license_type): ?>
                    <li><?= htmlspecialchars($license_type) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                
                <?php if (isset($authority['responsibilities'])): ?>
                <h4>🎯 Key Responsibilities</h4>
                <ul>
                    <?php foreach ($authority['responsibilities'] as $responsibility): ?>
                    <li><?= htmlspecialchars($responsibility) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Authority-Specific Information -->
            <div class="legal-overview">
                <h3>🔍 About <?= htmlspecialchars($authority['name']) ?></h3>
                
                <?php if ($authority_code === 'igo'): ?>
                <p>
                    iGaming Ontario (iGO) is a subsidiary of the Alcohol and Gaming Commission of Ontario (AGCO) that was established in 2022 
                    to conduct and manage Internet gaming in Ontario. This marked a significant shift in Canada's online gambling landscape, 
                    creating the first fully regulated provincial online gaming market.
                </p>
                <p>
                    <strong>Key Features of iGO Regulation:</strong>
                </p>
                <ul>
                    <li>Direct licensing of online casino and sports betting operators</li>
                    <li>Comprehensive player protection measures</li>
                    <li>Responsible gambling tools and resources</li>
                    <li>Revenue sharing agreements with operators</li>
                    <li>Regular compliance monitoring and enforcement</li>
                </ul>
                
                <?php elseif ($authority_code === 'mga'): ?>
                <p>
                    The Malta Gaming Authority (MGA) is widely regarded as one of the most prestigious gaming regulators in the world. 
                    Established under European Union law, the MGA provides licensing for online casinos, sports betting, and other gaming operators 
                    that serve international markets, including Canada.
                </p>
                <p>
                    <strong>Why MGA Licenses Matter for Canadians:</strong>
                </p>
                <ul>
                    <li>EU-level regulatory standards and player protection</li>
                    <li>Strict financial requirements for operators</li>
                    <li>Comprehensive game testing and fairness certification</li>
                    <li>Player fund segregation and protection</li>
                    <li>Dispute resolution mechanisms</li>
                </ul>
                
                <?php elseif ($authority_code === 'ukgc'): ?>
                <p>
                    The UK Gambling Commission (UKGC) sets the global gold standard for online gambling regulation. 
                    While primarily focused on the UK market, many UKGC-licensed operators also serve Canadian players, 
                    bringing the highest levels of consumer protection and regulatory oversight.
                </p>
                <p>
                    <strong>UKGC Standards for Player Protection:</strong>
                </p>
                <ul>
                    <li>Strictest responsible gambling requirements globally</li>
                    <li>Mandatory spending controls and loss limits</li>
                    <li>Advanced player verification and protection systems</li>
                    <li>Regular financial audits and compliance checks</li>
                    <li>Comprehensive dispute resolution processes</li>
                </ul>
                
                <?php elseif ($authority_code === 'curacao'): ?>
                <p>
                    Curaçao eGaming operates under the jurisdiction of Curaçao and provides licensing for online gambling operators 
                    serving international markets. Many online casinos accessible to Canadian players hold Curaçao licenses, 
                    making it an important regulatory body in the Canadian online gambling landscape.
                </p>
                <p>
                    <strong>Curaçao Licensing Benefits:</strong>
                </p>
                <ul>
                    <li>Established Caribbean jurisdiction with gaming expertise</li>
                    <li>Comprehensive licensing framework for international operators</li>
                    <li>Player protection measures and dispute resolution</li>
                    <li>Regular compliance monitoring and auditing</li>
                    <li>Integration with international gaming standards</li>
                </ul>
                
                <?php else: ?>
                <p>
                    <?= htmlspecialchars($authority['description'] ?? '') ?>
                </p>
                <p>
                    As a recognized gaming regulator, <?= htmlspecialchars($authority['name']) ?> plays an important role in ensuring 
                    fair gaming practices and player protection for operators serving Canadian players.
                </p>
                <?php endif; ?>
            </div>

            <!-- Licensed Casinos Section -->
            <div class="provincial-breakdown">
                <h3>🎰 Popular Casinos Licensed by <?= htmlspecialchars($authority['name']) ?></h3>
                <p>These reputable casinos hold licenses from <?= htmlspecialchars($authority['name']) ?> and serve Canadian players:</p>
                
                <div class="provincial-grid">
                    <div class="province-card">
                        <div class="province-name">🏆 Jackpot City Casino</div>
                        <div class="province-details">
                            <p><strong>License:</strong> <?= htmlspecialchars($authority['name']) ?></p>
                            <p><strong>Bonus:</strong> 100% up to $1,600</p>
                            <p><strong>Games:</strong> 500+ slots, live dealer</p>
                            <p><strong>Established:</strong> 1998</p>
                        </div>
                    </div>
                    
                    <div class="province-card">
                        <div class="province-name">🎮 Spin Casino</div>
                        <div class="province-details">
                            <p><strong>License:</strong> <?= htmlspecialchars($authority['name']) ?></p>
                            <p><strong>Bonus:</strong> 100% up to $1,000</p>
                            <p><strong>Games:</strong> 400+ slots, table games</p>
                            <p><strong>Established:</strong> 2001</p>
                        </div>
                    </div>
                    
                    <div class="province-card">
                        <div class="province-name">🃏 Ruby Fortune</div>
                        <div class="province-details">
                            <p><strong>License:</strong> <?= htmlspecialchars($authority['name']) ?></p>
                            <p><strong>Bonus:</strong> 100% up to $750</p>
                            <p><strong>Games:</strong> 450+ games, jackpots</p>
                            <p><strong>Established:</strong> 2003</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Authorities Quick Reference -->
            <div class="payment-methods-section">
                <h3>🏛️ Other Gaming Authorities</h3>
                <div class="payment-grid">
                    <?php foreach ($all_authorities as $code => $other_authority): ?>
                        <?php if ($code !== $authority_code): ?>
                        <div class="payment-card">
                            <div class="payment-icon">🏛️</div>
                            <div class="payment-name"><?= htmlspecialchars($other_authority['name']) ?></div>
                            <div class="payment-status"><?= htmlspecialchars($other_authority['jurisdiction'] ?? 'International') ?></div>
                            <div class="payment-details">
                                <p><strong>Relevance:</strong> <?= htmlspecialchars($other_authority['canadian_relevance'] ?? 'International operator licensing') ?></p>
                                <a href="/legal/authority/<?= $code ?>" style="color: #4299e1; text-decoration: none;">View Details →</a>
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
                    For comprehensive information about Canadian online gambling laws, provincial regulations, 
                    and all gaming authorities, visit our main legal information page.
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
        "@type": "GovernmentOrganization",
        "name": "<?= htmlspecialchars($authority['name']) ?>",
        "description": "<?= htmlspecialchars($authority['description'] ?? 'Gaming regulatory authority') ?>",
        <?php if (isset($authority['website'])): ?>
        "url": "<?= htmlspecialchars($authority['website']) ?>",
        <?php endif; ?>
        "areaServed": "<?= htmlspecialchars($authority['jurisdiction'] ?? 'International') ?>",
        "serviceType": "Gaming Regulation and Licensing",
        <?php if (isset($authority['established'])): ?>
        "foundingDate": "<?= $authority['established'] ?>",
        <?php endif; ?>
        "audience": {
            "@type": "Audience",
            "audienceType": "Online Casino Operators and Players"
        }
    }
    </script>
</body>
</html>
