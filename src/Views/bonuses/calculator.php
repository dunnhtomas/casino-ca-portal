<?php 
    $pageTitle = $title ?? 'Casino Bonus Calculator';
    $pageDescription = $meta_description ?? 'Calculate the real value of casino bonuses';
?>

<div class="bonus-calculator-page">
    <!-- Hero Section -->
    <section class="calculator-hero">
        <div class="container">
            <h1 class="page-title">🧮 Casino Bonus Calculator</h1>
            <p class="page-subtitle">Calculate the real value of casino bonuses and understand exactly what you need to wager to withdraw your winnings</p>
        </div>
    </section>

    <!-- Calculator Tool -->
    <section class="calculator-section">
        <div class="container">
            <div class="calculator-layout">
                <!-- Input Form -->
                <div class="calculator-form">
                    <h2>Calculate Bonus Value</h2>
                    <form method="POST" action="/bonuses/calculator" id="calculatorForm">
                        <div class="form-group">
                            <label for="bonus_id">Select Bonus</label>
                            <select name="bonus_id" id="bonus_id" required>
                                <option value="">Choose a bonus...</option>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <option value="<?= $bonus->id ?>" 
                                            <?= ($selectedBonus && $selectedBonus->id == $bonus->id) ? 'selected' : '' ?>
                                            data-wagering="<?= $bonus->wagering_requirement ?>"
                                            data-min-deposit="<?= $bonus->min_deposit ?>"
                                            data-max-bonus="<?= $bonus->max_bonus ?>"
                                            data-percentage="<?= $bonus->bonus_percentage ?>"
                                            data-amount="<?= $bonus->bonus_amount ?>">
                                        <?= htmlspecialchars($bonus->title) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="deposit_amount">Your Deposit Amount ($)</label>
                            <input type="number" 
                                   name="deposit_amount" 
                                   id="deposit_amount" 
                                   value="<?= $_POST['deposit_amount'] ?? 100 ?>" 
                                   min="1" 
                                   max="10000" 
                                   step="1" 
                                   required>
                            <small class="help-text">Enter the amount you plan to deposit</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="game_rtp">Preferred Game RTP (%)</label>
                            <select name="game_rtp" id="game_rtp">
                                <option value="96.0" <?= ($_POST['game_rtp'] ?? 96.0) == 96.0 ? 'selected' : '' ?>>Slots (96% average)</option>
                                <option value="98.0" <?= ($_POST['game_rtp'] ?? 96.0) == 98.0 ? 'selected' : '' ?>>High RTP Slots (98%)</option>
                                <option value="99.5" <?= ($_POST['game_rtp'] ?? 96.0) == 99.5 ? 'selected' : '' ?>>Blackjack (99.5%)</option>
                                <option value="98.6" <?= ($_POST['game_rtp'] ?? 96.0) == 98.6 ? 'selected' : '' ?>>Baccarat (98.6%)</option>
                                <option value="97.3" <?= ($_POST['game_rtp'] ?? 96.0) == 97.3 ? 'selected' : '' ?>>Roulette (97.3%)</option>
                                <option value="95.0" <?= ($_POST['game_rtp'] ?? 96.0) == 95.0 ? 'selected' : '' ?>>Low RTP Games (95%)</option>
                            </select>
                            <small class="help-text">Higher RTP means better expected value</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-large">Calculate Bonus Value</button>
                    </form>
                </div>
                
                <!-- Results Panel -->
                <div class="calculator-results">
                    <?php if ($calculation && $selectedBonus): ?>
                        <div class="results-panel active">
                            <h3>📊 Calculation Results</h3>
                            
                            <div class="bonus-summary">
                                <h4><?= htmlspecialchars($selectedBonus->title) ?></h4>
                                <p><?= htmlspecialchars($selectedBonus->description) ?></p>
                            </div>
                            
                            <div class="results-grid">
                                <div class="result-card">
                                    <div class="result-label">Bonus Received</div>
                                    <div class="result-value positive">$<?= number_format($calculation['bonus_received'], 2) ?></div>
                                </div>
                                
                                <div class="result-card">
                                    <div class="result-label">Total to Wager</div>
                                    <div class="result-value">$<?= number_format($calculation['total_to_wager'], 2) ?></div>
                                </div>
                                
                                <div class="result-card">
                                    <div class="result-label">Expected Loss</div>
                                    <div class="result-value negative">-$<?= number_format($calculation['expected_loss'], 2) ?></div>
                                </div>
                                
                                <div class="result-card">
                                    <div class="result-label">Expected Value</div>
                                    <div class="result-value <?= $calculation['expected_value'] >= 0 ? 'positive' : 'negative' ?>">
                                        <?= $calculation['expected_value'] >= 0 ? '+' : '' ?>$<?= number_format($calculation['expected_value'], 2) ?>
                                    </div>
                                </div>
                                
                                <div class="result-card">
                                    <div class="result-label">Estimated Time</div>
                                    <div class="result-value"><?= $calculation['estimated_hours'] ?> hours</div>
                                </div>
                                
                                <div class="result-card">
                                    <div class="result-label">Risk Level</div>
                                    <div class="result-value risk-<?= strtolower($calculation['risk_level']) ?>">
                                        <?= $calculation['risk_level'] ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="recommendation-panel">
                                <h4>💡 Expert Recommendation</h4>
                                <p><?= $calculation['recommendation'] ?></p>
                            </div>
                            
                            <div class="action-buttons">
                                <a href="<?= $selectedBonus->affiliate_link ?>" class="btn btn-primary" target="_blank" rel="nofollow">
                                    Get This Bonus
                                </a>
                                <a href="/bonuses/<?= $selectedBonus->id ?>" class="btn btn-outline">
                                    View Details
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="results-panel placeholder">
                            <h3>📊 Calculation Results</h3>
                            <p>Select a bonus and enter your deposit amount to see detailed calculations including:</p>
                            <ul>
                                <li>✅ Exact bonus amount you'll receive</li>
                                <li>🎯 Total wagering requirements</li>
                                <li>💰 Expected value calculation</li>
                                <li>⏰ Estimated time to complete</li>
                                <li>🎲 Win probability analysis</li>
                                <li>💡 Personalized recommendations</li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Educational Content -->
    <section class="calculator-education">
        <div class="container">
            <h2>Understanding Bonus Calculations</h2>
            <div class="education-grid">
                <div class="education-card">
                    <h4>🧮 How We Calculate</h4>
                    <p>Our calculator uses mathematical models based on the house edge of different games to provide accurate expected value calculations.</p>
                    <ul>
                        <li>Bonus amount based on deposit and percentage</li>
                        <li>Total wagering = (deposit + bonus) × wagering requirement</li>
                        <li>Expected loss = total wagering × house edge</li>
                        <li>Expected value = bonus received - expected loss</li>
                    </ul>
                </div>
                
                <div class="education-card">
                    <h4>🎯 Expected Value</h4>
                    <p>Expected value tells you the average amount you can expect to win or lose from a bonus over the long term.</p>
                    <ul>
                        <li><strong>Positive (+):</strong> Bonus favors the player</li>
                        <li><strong>Near Zero:</strong> Break-even proposition</li>
                        <li><strong>Negative (-):</strong> House has advantage</li>
                    </ul>
                </div>
                
                <div class="education-card">
                    <h4>🎮 Game Selection Impact</h4>
                    <p>The games you choose to play significantly affect your bonus value:</p>
                    <ul>
                        <li><strong>High RTP Slots (98%+):</strong> Best for bonus clearing</li>
                        <li><strong>Blackjack:</strong> Highest RTP but may have restrictions</li>
                        <li><strong>Regular Slots (96%):</strong> Usually count 100% toward wagering</li>
                        <li><strong>Table Games:</strong> Often count less toward requirements</li>
                    </ul>
                </div>
                
                <div class="education-card">
                    <h4>⚠️ Important Considerations</h4>
                    <p>Our calculations are estimates based on mathematical expectations:</p>
                    <ul>
                        <li>Actual results will vary due to randomness</li>
                        <li>Variance can cause significant short-term deviations</li>
                        <li>Always read and understand bonus terms</li>
                        <li>Set loss limits and stick to them</li>
                    </ul>
                </div>
            </div>
            
            <div class="calculator-tips">
                <h3>💡 Pro Tips for Bonus Success</h3>
                <div class="tips-grid">
                    <div class="tip">
                        <strong>Choose High RTP Games:</strong> Games with 97%+ RTP give you the best chance to meet wagering requirements.
                    </div>
                    <div class="tip">
                        <strong>Manage Your Bankroll:</strong> Never deposit more than you can afford to lose, bonus or no bonus.
                    </div>
                    <div class="tip">
                        <strong>Read the Terms:</strong> Always check game restrictions, maximum bet limits, and cashout caps.
                    </div>
                    <div class="tip">
                        <strong>Time Management:</strong> Ensure you have enough time to complete wagering requirements before expiry.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Comparison -->
    <section class="quick-comparison">
        <div class="container">
            <h2>Quick Bonus Comparison</h2>
            <p>Compare some of our top-rated bonuses:</p>
            <div class="comparison-table">
                <table>
                    <thead>
                        <tr>
                            <th>Bonus</th>
                            <th>Value</th>
                            <th>Wagering</th>
                            <th>Expected Value*</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $featuredBonuses = array_slice(array_filter($bonuses, function($b) { 
                            return $b->featured; 
                        }), 0, 5);
                        ?>
                        <?php foreach ($featuredBonuses as $bonus): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($bonus->title) ?></strong>
                                </td>
                                <td>
                                    <?php if ($bonus->bonus_amount): ?>
                                        $<?= number_format($bonus->bonus_amount) ?>
                                    <?php endif; ?>
                                    <?php if ($bonus->bonus_percentage): ?>
                                        <?= $bonus->bonus_percentage ?>%
                                    <?php endif; ?>
                                </td>
                                <td><?= $bonus->wagering_requirement ?>x</td>
                                <td class="ev-calculation" data-bonus-id="<?= $bonus->id ?>">
                                    <span class="loading">Calculating...</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary calculate-btn" 
                                            data-bonus-id="<?= $bonus->id ?>">
                                        Calculate
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <small>*Expected Value calculated for $100 deposit on 96% RTP slots</small>
            </div>
        </div>
    </section>
</div>

<style>
/* Casino Bonus Calculator Styles */
.bonus-calculator-page {
    padding: 0;
}

.calculator-hero {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
    padding: 60px 0;
    text-align: center;
}

.page-title {
    font-size: 3rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.page-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.calculator-section {
    padding: 3rem 0;
}

.calculator-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
}

.calculator-form {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    height: fit-content;
}

.calculator-form h2 {
    margin-bottom: 2rem;
    color: #2c3e50;
}

.form-group {
    margin-bottom: 2rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #495057;
}

.form-group select,
.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 5px;
    font-size: 1rem;
}

.help-text {
    color: #6c757d;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

.btn-large {
    width: 100%;
    padding: 1rem;
    font-size: 1.1rem;
    font-weight: 700;
}

.calculator-results {
    position: sticky;
    top: 2rem;
}

.results-panel {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.results-panel.placeholder {
    text-align: center;
    color: #6c757d;
}

.results-panel.placeholder ul {
    text-align: left;
    max-width: 300px;
    margin: 1.5rem auto;
}

.bonus-summary {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.bonus-summary h4 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

.result-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    text-align: center;
}

.result-label {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.result-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
}

.result-value.positive {
    color: #28a745;
}

.result-value.negative {
    color: #dc3545;
}

.result-value.risk-low {
    color: #28a745;
}

.result-value.risk-medium {
    color: #ffc107;
}

.result-value.risk-high {
    color: #dc3545;
}

.recommendation-panel {
    background: #e3f2fd;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 2rem;
}

.recommendation-panel h4 {
    color: #1976d2;
    margin-bottom: 1rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

.action-buttons .btn {
    flex: 1;
}

.calculator-education {
    background: #f8f9fa;
    padding: 3rem 0;
}

.education-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.education-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.education-card h4 {
    color: #2c3e50;
    margin-bottom: 1rem;
}

.education-card ul {
    margin-top: 1rem;
}

.education-card li {
    margin-bottom: 0.5rem;
}

.calculator-tips {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.tip {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.quick-comparison {
    padding: 3rem 0;
}

.comparison-table {
    overflow-x: auto;
}

.comparison-table table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.comparison-table th,
.comparison-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
}

.comparison-table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.loading {
    color: #6c757d;
    font-style: italic;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .calculator-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .results-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .tips-grid {
        grid-template-columns: 1fr;
    }
    
    .education-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate when form values change
    const form = document.getElementById('calculatorForm');
    const bonusSelect = document.getElementById('bonus_id');
    const depositInput = document.getElementById('deposit_amount');
    
    // Update min deposit when bonus changes
    bonusSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const minDeposit = selectedOption.dataset.minDeposit;
        
        if (minDeposit) {
            depositInput.min = minDeposit;
            if (parseFloat(depositInput.value) < parseFloat(minDeposit)) {
                depositInput.value = minDeposit;
            }
        }
    });
    
    // Quick calculation for comparison table
    document.querySelectorAll('.calculate-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bonusId = this.dataset.bonusId;
            const evCell = document.querySelector(`.ev-calculation[data-bonus-id="${bonusId}"] .loading`);
            
            if (evCell) {
                evCell.textContent = 'Calculating...';
                
                // Simulate API call (replace with actual AJAX call)
                fetch(`/bonuses/api?action=calculate&bonus_id=${bonusId}&deposit_amount=100&game_rtp=96.0`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const ev = data.data.expected_value;
                            const className = ev >= 0 ? 'positive' : 'negative';
                            const sign = ev >= 0 ? '+' : '';
                            evCell.innerHTML = `<span class="${className}">${sign}$${ev.toFixed(2)}</span>`;
                        } else {
                            evCell.textContent = 'Error';
                        }
                    })
                    .catch(() => {
                        evCell.textContent = 'Error';
                    });
            }
        });
    });
    
    // Auto-submit form when values change (with debounce)
    let timeout;
    [bonusSelect, depositInput, document.getElementById('game_rtp')].forEach(input => {
        input.addEventListener('change', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                if (bonusSelect.value && depositInput.value) {
                    // Auto-submit could be added here
                    // form.submit();
                }
            }, 500);
        });
    });
});
</script>
