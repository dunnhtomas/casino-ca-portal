<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<link rel="stylesheet" href="/css/problem-gambling.css">

<div class="problem-gambling-section">
    <!-- Emergency Banner -->
    <div class="emergency-banner">
        <div class="emergency-content">
            <h2>Need Immediate Help?</h2>
            <div class="crisis-contacts">
                <div class="contact-item primary">
                    <span class="contact-type">24/7 Crisis Line</span>
                    <a href="tel:<?= $emergencyContacts['crisis_lines']['immediate_help'] ?>" class="contact-number"><?= $emergencyContacts['crisis_lines']['immediate_help'] ?></a>
                    <span class="contact-desc">Crisis Services Canada</span>
                </div>
                <div class="contact-item">
                    <span class="contact-type">Gambling Help</span>
                    <a href="tel:<?= $emergencyContacts['crisis_lines']['gambling_specific'] ?>" class="contact-number"><?= $emergencyContacts['crisis_lines']['gambling_specific'] ?></a>
                    <span class="contact-desc">24/7 Support & Live Chat</span>
                </div>
                <div class="contact-item">
                    <span class="contact-type">Text Support</span>
                    <a href="sms:<?= $emergencyContacts['crisis_lines']['text_support'] ?>" class="contact-number"><?= $emergencyContacts['crisis_lines']['text_support'] ?></a>
                    <span class="contact-desc">Text for help</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Resources Content -->
    <div class="resources-content">
        <div class="section-header">
            <h1 class="section-title">Problem Gambling Resources & Support</h1>
            <p class="section-subtitle">
                Comprehensive support and resources for Canadian players experiencing gambling-related difficulties. 
                Get immediate help, assessment tools, and professional treatment options.
            </p>
        </div>

        <!-- National Resources -->
        <div class="resources-grid">
            <div class="resource-category">
                <div class="category-header">
                    <span class="category-icon">🆘</span>
                    <h3 class="category-title">National Crisis Support</h3>
                </div>
                <div class="resource-list">
                    <?php foreach ($resources['crisis_resources']['national_hotlines'] as $hotline): ?>
                    <div class="resource-item">
                        <div class="resource-name"><?= htmlspecialchars($hotline['name']) ?></div>
                        <a href="tel:<?= $hotline['phone'] ?>" class="resource-phone"><?= $hotline['phone'] ?></a>
                        <div class="resource-details">
                            <?= htmlspecialchars($hotline['description']) ?><br>
                            <strong>Available:</strong> <?= $hotline['availability'] ?><br>
                            <strong>Languages:</strong> <?= implode(', ', $hotline['languages']) ?><br>
                            <a href="<?= $hotline['website'] ?>" class="resource-website" target="_blank">Visit Website</a>
                            <?php if (isset($hotline['text_option'])): ?>
                            <br><strong>Text Option:</strong> <a href="sms:<?= $hotline['text_option'] ?>"><?= $hotline['text_option'] ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="resource-category">
                <div class="category-header">
                    <span class="category-icon">🏥</span>
                    <h3 class="category-title">Support Organizations</h3>
                </div>
                <div class="resource-list">
                    <?php foreach ($resources['support_organizations'] as $org): ?>
                    <div class="resource-item">
                        <div class="resource-name"><?= htmlspecialchars($org['name']) ?></div>
                        <a href="tel:<?= $org['phone'] ?>" class="resource-phone"><?= $org['phone'] ?></a>
                        <div class="resource-details">
                            <?= htmlspecialchars($org['description'] ?? '') ?><br>
                            <?php if (isset($org['services'])): ?>
                            <strong>Services:</strong> <?= implode(', ', $org['services']) ?><br>
                            <?php endif; ?>
                            <a href="<?= $org['website'] ?>" class="resource-website" target="_blank">Visit Website</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Provincial Resources -->
        <div class="provincial-resources">
            <div class="section-header">
                <h2 class="section-title">Provincial Resources</h2>
                <p class="section-subtitle">Find local support specific to your province</p>
            </div>
            <div class="provinces-grid">
                <?php foreach ($resources['crisis_resources']['provincial_resources'] as $provinceKey => $province): ?>
                <div class="province-card" onclick="window.location.href='/problem-gambling/<?= $provinceKey ?>'">
                    <div class="province-name"><?= ucwords(str_replace('_', ' ', $provinceKey)) ?></div>
                    <a href="tel:<?= $province['phone'] ?>" class="province-contact" onclick="event.stopPropagation()"><?= $province['phone'] ?></a>
                    <div class="province-services"><?= htmlspecialchars($province['name']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Self-Assessment Section -->
        <div class="self-assessment-section">
            <div class="section-header">
                <h2 class="section-title">Self-Assessment Tools</h2>
                <p class="section-subtitle">Evaluate your gambling behavior with confidential assessment tools</p>
            </div>
            
            <div class="assessment-intro">
                <div class="assessment-disclaimer">
                    <strong>Disclaimer:</strong> This self-assessment is for informational purposes only and is not a substitute for professional diagnosis or treatment. If you score in the moderate or high-risk categories, please consider speaking with a healthcare professional.
                </div>
                
                <a href="/problem-gambling/assessment" class="assessment-btn">Take Self-Assessment (PGSI)</a>
            </div>
        </div>

        <!-- Warning Signs -->
        <div class="warning-signs-section">
            <div class="section-header">
                <h2 class="section-title">Warning Signs of Problem Gambling</h2>
                <p class="section-subtitle">Recognize the signs and seek help early</p>
            </div>
            
            <div class="warning-signs-grid">
                <?php foreach ($warningSigns as $category => $signs): ?>
                <div class="warning-category">
                    <h4><?= ucwords($category) ?> Signs</h4>
                    <ul class="warning-list">
                        <?php foreach ($signs as $sign): ?>
                        <li><?= htmlspecialchars($sign) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Responsible Gambling Tools -->
        <div class="tools-section">
            <div class="section-header">
                <h2 class="section-title" style="color: white;">Responsible Gambling Tools</h2>
                <p class="section-subtitle" style="color: rgba(255,255,255,0.9);">Take control of your gambling with these prevention tools</p>
            </div>
            
            <div class="tools-grid">
                <div class="tool-card">
                    <span class="tool-icon">💰</span>
                    <h4 class="tool-title">Deposit Limits</h4>
                    <p class="tool-description">Set daily, weekly, or monthly deposit limits to control your spending</p>
                </div>
                <div class="tool-card">
                    <span class="tool-icon">⏰</span>
                    <h4 class="tool-title">Time Limits</h4>
                    <p class="tool-description">Control your playing time with session limits and reality checks</p>
                </div>
                <div class="tool-card">
                    <span class="tool-icon">🚫</span>
                    <h4 class="tool-title">Self-Exclusion</h4>
                    <p class="tool-description">Temporarily or permanently exclude yourself from gambling sites</p>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="/problem-gambling/tools" class="assessment-btn">Learn About All Tools</a>
            </div>
        </div>

        <!-- Treatment Options -->
        <div class="treatment-options">
            <div class="section-header">
                <h2 class="section-title">Treatment & Recovery Options</h2>
                <p class="section-subtitle">Professional help and support for gambling addiction recovery</p>
            </div>
            
            <div class="treatment-categories">
                <div class="treatment-category">
                    <h3 class="treatment-title">Professional Counseling</h3>
                    <div class="treatment-options-list">
                        <div class="treatment-option">
                            <div class="option-name">Cognitive Behavioral Therapy (CBT)</div>
                            <div class="option-description">Evidence-based therapy addressing thought patterns and behaviors related to gambling</div>
                        </div>
                        <div class="treatment-option">
                            <div class="option-name">Individual Therapy</div>
                            <div class="option-description">One-on-one counseling with addiction specialists</div>
                        </div>
                        <div class="treatment-option">
                            <div class="option-name">Group Therapy</div>
                            <div class="option-description">Support groups led by professional counselors</div>
                        </div>
                    </div>
                </div>
                
                <div class="treatment-category">
                    <h3 class="treatment-title">Support Groups</h3>
                    <div class="treatment-options-list">
                        <div class="treatment-option">
                            <div class="option-name">Gamblers Anonymous</div>
                            <div class="option-description">12-step program with meetings across Canada</div>
                        </div>
                        <div class="treatment-option">
                            <div class="option-name">Gam-Anon</div>
                            <div class="option-description">Support for family and friends of problem gamblers</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="/problem-gambling/treatment" class="assessment-btn">View All Treatment Options</a>
            </div>
        </div>
    </div>
</div>

<style>
.assessment-btn {
    display: inline-block;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    padding: 15px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.assessment-btn:hover {
    background: linear-gradient(135deg, #c82333 0%, #b21e2b 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    color: white;
    text-decoration: none;
}
</style>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
