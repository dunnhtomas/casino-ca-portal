<?php
$methodology = $data['overview'] ?? $this->methodologyService->getMethodologyOverview();
$criteria = $data['criteria'] ?? $this->methodologyService->getScoringCriteria();
$experts = $data['experts'] ?? $this->methodologyService->getExpertTeam();
$process = $data['process'] ?? $this->methodologyService->getTestingProcess();
?>

<section class="methodology-section">
    <div class="container">
        <!-- Header -->
        <div class="methodology-header">
            <h2>How We Review Online Casinos</h2>
            <p class="methodology-subtitle">Our Transparent 7-Step Professional Evaluation Process</p>
            <p class="methodology-intro">
                At Best Casino Portal, we believe in complete transparency. Our team of Canadian casino experts 
                follows a rigorous methodology to evaluate every online casino, ensuring you receive honest, 
                unbiased, and comprehensive reviews.
            </p>
        </div>

        <!-- Statistics -->
        <div class="methodology-stats">
            <div class="stat-item">
                <span class="stat-number"><?php echo $methodology['total_criteria'] ?? '7'; ?></span>
                <span class="stat-label">Evaluation Criteria</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $methodology['expert_reviewers'] ?? '3'; ?></span>
                <span class="stat-label">Expert Reviewers</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $methodology['annual_reviews'] ?? '200+'; ?></span>
                <span class="stat-label">Annual Reviews</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $methodology['testing_duration'] ?? '14-21'; ?></span>
                <span class="stat-label">Days Per Review</span>
            </div>
        </div>

        <!-- Process Steps -->
        <div class="methodology-process">
            <div class="process-header">
                <h3>Our 5-Phase Testing Process</h3>
                <p>Each casino undergoes the same rigorous evaluation process</p>
            </div>
            
            <div class="process-steps">
                <?php if (isset($process) && is_array($process)): ?>
                    <?php $stepNumber = 1; ?>
                    <?php foreach ($process as $phaseKey => $phase): ?>
                        <div class="process-step">
                            <div class="step-number"><?php echo $stepNumber; ?></div>
                            <h4 class="step-title"><?php echo htmlspecialchars($phase['name']); ?></h4>
                            <span class="step-duration"><?php echo htmlspecialchars($phase['duration']); ?></span>
                            
                            <?php if (isset($phase['activities']) && is_array($phase['activities'])): ?>
                                <ul class="step-activities">
                                    <?php foreach (array_slice($phase['activities'], 0, 3) as $activity): ?>
                                        <li><?php echo htmlspecialchars($activity); ?></li>
                                    <?php endforeach; ?>
                                    <?php if (count($phase['activities']) > 3): ?>
                                        <li><em>And <?php echo count($phase['activities']) - 3; ?> more activities...</em></li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <?php $stepNumber++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Evaluation Criteria -->
        <div class="methodology-criteria">
            <div class="criteria-header">
                <h3>What We Evaluate</h3>
                <p>Six key criteria with weighted importance scores</p>
            </div>
            
            <div class="criteria-grid">
                <?php if (isset($criteria) && is_array($criteria)): ?>
                    <?php foreach ($criteria as $criteriaKey => $item): ?>
                        <div class="criteria-item" style="--criteria-color: <?php echo $item['color'] ?? '#3182ce'; ?>;">
                            <div class="criteria-header-content">
                                <div class="criteria-icon"><?php echo $item['icon'] ?? '📊'; ?></div>
                                <div class="criteria-title-weight">
                                    <h4 class="criteria-title"><?php echo htmlspecialchars($item['name']); ?></h4>
                                    <span class="criteria-weight"><?php echo $item['weight']; ?>% Weight</span>
                                </div>
                            </div>
                            
                            <p class="criteria-description">
                                <?php echo htmlspecialchars($item['description']); ?>
                            </p>
                            
                            <?php if (isset($item['score_factors']) && is_array($item['score_factors'])): ?>
                                <ul class="criteria-factors">
                                    <?php foreach (array_slice($item['score_factors'], 0, 3) as $factor): ?>
                                        <li><?php echo htmlspecialchars($factor); ?></li>
                                    <?php endforeach; ?>
                                    <?php if (count($item['score_factors']) > 3): ?>
                                        <li><em>+ <?php echo count($item['score_factors']) - 3; ?> more factors</em></li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Expert Team Preview -->
        <div class="methodology-experts">
            <div class="experts-header">
                <h3>Meet Our Expert Review Team</h3>
                <p>Experienced professionals with deep casino industry knowledge</p>
            </div>
            
            <div class="experts-grid">
                <?php if (isset($experts) && is_array($experts)): ?>
                    <?php $displayExperts = array_slice($experts, 0, 3); ?>
                    <?php foreach ($displayExperts as $expertKey => $expert): ?>
                        <div class="expert-card">
                            <div class="expert-photo">
                                <?php echo strtoupper(substr($expert['name'], 0, 1) . substr(explode(' ', $expert['name'])[1] ?? '', 0, 1)); ?>
                            </div>
                            <h4 class="expert-name"><?php echo htmlspecialchars($expert['name']); ?></h4>
                            <p class="expert-title"><?php echo htmlspecialchars($expert['title']); ?></p>
                            <span class="expert-specialty"><?php echo htmlspecialchars($expert['specialty']); ?></span>
                            <p class="expert-experience"><?php echo htmlspecialchars($expert['experience']); ?> Experience</p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="methodology-cta">
            <h3>Ready to Find Your Perfect Casino?</h3>
            <p>Browse our expertly reviewed casinos, all evaluated using this transparent methodology</p>
            <a href="/methodology" class="cta-button">View Full Methodology</a>
        </div>
    </div>
</section>

<style>
<?php include __DIR__ . '/../../../public/css/methodology.css'; ?>
</style>
