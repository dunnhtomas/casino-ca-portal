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
                    <a href="tel:1-833-456-4566" class="contact-number">1-833-456-4566</a>
                    <span class="contact-desc">Crisis Services Canada</span>
                </div>
                <div class="contact-item">
                    <span class="contact-type">Gambling Help</span>
                    <a href="tel:1-888-391-1111" class="contact-number">1-888-391-1111</a>
                    <span class="contact-desc">24/7 Support & Live Chat</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Assessment Content -->
    <div class="resources-content">
        <div class="section-header">
            <h1 class="section-title">Problem Gambling Self-Assessment (PGSI)</h1>
            <p class="section-subtitle">
                The Problem Gambling Severity Index (PGSI) is a validated tool to assess gambling behavior. 
                Answer honestly for an accurate assessment of your gambling risk level.
            </p>
        </div>

        <!-- Self-Assessment Section -->
        <div class="self-assessment-section">
            <div class="assessment-disclaimer">
                <strong>Confidential Assessment:</strong> This assessment is completely confidential and is not stored or shared. 
                Results are for informational purposes only and are not a substitute for professional diagnosis or treatment.
            </div>

            <div class="questionnaire">
                <form id="pgsi-assessment">
                    <?php foreach ($assessment['questions'] as $index => $question): ?>
                    <div class="question-item">
                        <div class="question-text">
                            <?= ($index + 1) ?>. <?= htmlspecialchars($question) ?>
                        </div>
                        <div class="answer-options">
                            <?php foreach ($assessment['scoring'] as $option => $score): ?>
                            <label class="answer-option">
                                <input type="radio" name="question_<?= $index ?>" value="<?= $option ?>" required>
                                <span><?= ucwords(str_replace('_', ' ', $option)) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div style="text-align: center; margin-top: 30px;">
                        <button type="submit" class="assessment-btn">Calculate My Risk Level</button>
                    </div>
                </form>

                <!-- Results Section -->
                <div id="assessment-result" class="assessment-result">
                    <h3 id="result-title"></h3>
                    <p id="result-message"></p>
                    <div id="result-recommendations"></div>
                </div>
            </div>
        </div>

        <!-- Warning Signs Section -->
        <div class="warning-signs-section" style="margin-top: 60px;">
            <div class="section-header">
                <h2 class="section-title">Additional Warning Signs</h2>
                <p class="section-subtitle">These behaviors may indicate a developing gambling problem</p>
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

        <!-- Next Steps Section -->
        <div class="next-steps-section" style="background: white; border-radius: 12px; padding: 40px; margin-top: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="section-header">
                <h2 class="section-title">What to Do Next</h2>
            </div>
            
            <div class="next-steps-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
                <div class="step-card" style="background: #f8f9fa; padding: 25px; border-radius: 8px; border-left: 4px solid #28a745;">
                    <h4 style="color: #28a745; margin-bottom: 10px;">Low Risk</h4>
                    <p>Continue enjoying gambling responsibly. Set limits and stick to them. Monitor your behavior regularly.</p>
                </div>
                <div class="step-card" style="background: #f8f9fa; padding: 25px; border-radius: 8px; border-left: 4px solid #ffc107;">
                    <h4 style="color: #ffc107; margin-bottom: 10px;">Moderate Risk</h4>
                    <p>Consider setting stricter limits or taking a break. Talk to someone you trust about your gambling.</p>
                </div>
                <div class="step-card" style="background: #f8f9fa; padding: 25px; border-radius: 8px; border-left: 4px solid #dc3545;">
                    <h4 style="color: #dc3545; margin-bottom: 10px;">High Risk</h4>
                    <p>Seek professional help immediately. Contact a counselor or call the gambling helpline for support.</p>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="/problem-gambling" class="assessment-btn">Back to Resources</a>
                <a href="/problem-gambling/treatment" class="assessment-btn" style="margin-left: 15px;">Find Treatment</a>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('pgsi-assessment').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const answers = [];
    
    // Collect all answers
    for (let i = 0; i < <?= count($assessment['questions']) ?>; i++) {
        const answer = formData.get(`question_${i}`);
        if (!answer) {
            alert('Please answer all questions');
            return;
        }
        answers.push(answer);
    }
    
    // Calculate score
    const scoring = <?= json_encode($assessment['scoring']) ?>;
    let totalScore = 0;
    
    answers.forEach(answer => {
        totalScore += scoring[answer];
    });
    
    // Determine risk level and message
    let level, message, recommendations;
    
    if (totalScore === 0) {
        level = 'No Problem';
        message = 'Your responses suggest you are not experiencing problems with gambling.';
        recommendations = '<strong>Recommendations:</strong> Continue to gamble responsibly and set limits for yourself.';
        document.getElementById('assessment-result').className = 'assessment-result result-low-risk';
    } else if (totalScore <= 2) {
        level = 'Low Risk';
        message = 'Your responses suggest a low level of problems with gambling.';
        recommendations = '<strong>Recommendations:</strong> Be aware of your gambling habits and consider setting stricter limits.';
        document.getElementById('assessment-result').className = 'assessment-result result-low-risk';
    } else if (totalScore <= 7) {
        level = 'Moderate Risk';
        message = 'Your responses suggest a moderate level of problems with gambling.';
        recommendations = '<strong>Recommendations:</strong> Consider seeking help from a counselor or calling a gambling helpline. Take a break from gambling.';
        document.getElementById('assessment-result').className = 'assessment-result result-moderate-risk';
    } else {
        level = 'High Risk';
        message = 'Your responses suggest gambling is causing significant problems in your life.';
        recommendations = '<strong>Urgent Recommendations:</strong> Seek professional help immediately. Contact a gambling counselor or call 1-888-391-1111 for immediate support.';
        document.getElementById('assessment-result').className = 'assessment-result result-high-risk';
    }
    
    // Display results
    document.getElementById('result-title').textContent = `Your Risk Level: ${level} (Score: ${totalScore}/27)`;
    document.getElementById('result-message').textContent = message;
    document.getElementById('result-recommendations').innerHTML = recommendations;
    
    // Show results
    document.getElementById('assessment-result').style.display = 'block';
    
    // Scroll to results
    document.getElementById('assessment-result').scrollIntoView({ behavior: 'smooth' });
});
</script>

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
    border: none;
    cursor: pointer;
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
