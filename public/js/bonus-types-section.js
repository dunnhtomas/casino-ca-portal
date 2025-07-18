/**
 * Bonus Types Guide JavaScript
 * 
 * Interactive functionality for the bonus types educational section
 * including calculator, player type selection, and dynamic content.
 * 
 * @package Casino Portal
 * @version 2.0.0
 * @since 2025-01-20
 */

class BonusTypesManager {
    constructor() {
        this.calculator = null;
        this.currentPlayerType = 'beginner';
        this.init();
    }

    /**
     * Initialize the bonus types manager
     */
    init() {
        this.initCalculator();
        this.initPlayerTypeSelector();
        this.initBonusCards();
        this.initTermsCards();
        this.bindEvents();
    }

    /**
     * Initialize the bonus calculator
     */
    initCalculator() {
        this.calculator = {
            deposit: document.getElementById('calc-deposit'),
            percentage: document.getElementById('calc-percentage'),
            wagering: document.getElementById('calc-wagering'),
            maxBet: document.getElementById('calc-max-bet'),
            calculateBtn: document.getElementById('calculate-bonus'),
            resultsContainer: document.getElementById('calculator-results')
        };

        // Set default values
        if (this.calculator.deposit) {
            this.calculator.deposit.value = 100;
        }
        if (this.calculator.percentage) {
            this.calculator.percentage.value = 100;
        }
        if (this.calculator.wagering) {
            this.calculator.wagering.value = 35;
        }
        if (this.calculator.maxBet) {
            this.calculator.maxBet.value = 5;
        }
    }

    /**
     * Initialize player type selector
     */
    initPlayerTypeSelector() {
        const buttons = document.querySelectorAll('.player-type-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.selectPlayerType(e.target.dataset.type);
            });
        });
    }

    /**
     * Initialize bonus cards with expand functionality
     */
    initBonusCards() {
        const expandBtns = document.querySelectorAll('.expand-bonus-btn');
        expandBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.expandBonusCard(e.target.dataset.bonus);
            });
        });
    }

    /**
     * Initialize terms cards with click functionality
     */
    initTermsCards() {
        const termCards = document.querySelectorAll('.term-card');
        termCards.forEach(card => {
            card.addEventListener('click', () => {
                this.toggleTermCard(card);
            });
        });
    }

    /**
     * Bind all event listeners
     */
    bindEvents() {
        // Calculator events
        if (this.calculator.calculateBtn) {
            this.calculator.calculateBtn.addEventListener('click', () => {
                this.calculateBonus();
            });
        }

        // Real-time input validation
        Object.values(this.calculator).forEach(input => {
            if (input && input.tagName === 'INPUT') {
                input.addEventListener('input', () => {
                    this.validateInput(input);
                });

                input.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        this.calculateBonus();
                    }
                });
            }
        });

        // Keyboard navigation for cards
        document.addEventListener('keydown', (e) => {
            this.handleKeyboardNavigation(e);
        });

        // Scroll animations
        this.initScrollAnimations();
    }

    /**
     * Calculate bonus value using the API
     */
    async calculateBonus() {
        try {
            // Validate inputs
            const deposit = parseFloat(this.calculator.deposit.value);
            const percentage = parseFloat(this.calculator.percentage.value);
            const wagering = parseFloat(this.calculator.wagering.value);
            const maxBet = parseFloat(this.calculator.maxBet.value);

            if (!this.validateCalculatorInputs(deposit, percentage, wagering, maxBet)) {
                return;
            }

            // Show loading state
            this.showCalculatorLoading();

            // Prepare request data
            const requestData = {
                deposit: deposit,
                terms: {
                    percentage: percentage,
                    wagering: wagering,
                    max_bet: maxBet,
                    time_limit: 30,
                    game_contribution: 100
                }
            };

            // Make API request
            const response = await fetch('/api/bonus-types/calculator', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(requestData)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                this.displayCalculatorResults(data.calculation);
                this.trackCalculatorUsage(data.calculation);
            } else {
                throw new Error(data.error || 'Calculation failed');
            }

        } catch (error) {
            console.error('Calculator error:', error);
            this.showCalculatorError(error.message);
        }
    }

    /**
     * Validate calculator inputs
     */
    validateCalculatorInputs(deposit, percentage, wagering, maxBet) {
        if (isNaN(deposit) || deposit <= 0) {
            this.showInputError('calc-deposit', 'Please enter a valid deposit amount');
            return false;
        }

        if (isNaN(percentage) || percentage < 0 || percentage > 500) {
            this.showInputError('calc-percentage', 'Bonus percentage must be between 0% and 500%');
            return false;
        }

        if (isNaN(wagering) || wagering < 1 || wagering > 100) {
            this.showInputError('calc-wagering', 'Wagering requirement must be between 1x and 100x');
            return false;
        }

        if (isNaN(maxBet) || maxBet <= 0 || maxBet > 50) {
            this.showInputError('calc-max-bet', 'Maximum bet must be between $0.10 and $50');
            return false;
        }

        return true;
    }

    /**
     * Display calculator results
     */
    displayCalculatorResults(calculation) {
        const results = this.calculator.resultsContainer;
        if (!results) return;

        // Update result values
        this.updateResultValue('result-bonus-amount', `$${calculation.bonus_amount}`);
        this.updateResultValue('result-total-funds', `$${calculation.total_funds}`);
        this.updateResultValue('result-wagering-required', `$${calculation.wagering_required}`);
        this.updateResultValue('result-time-required', `${calculation.estimated_hours} hours`);
        this.updateResultValue('result-real-value', `$${calculation.real_value}`);
        
        // Update risk level with color coding
        const riskElement = document.getElementById('result-risk-level');
        if (riskElement) {
            riskElement.textContent = calculation.risk_level;
            riskElement.className = `result-value risk-indicator ${calculation.risk_level}`;
        }

        // Update recommendation
        const recommendationElement = document.getElementById('recommendation-text');
        if (recommendationElement) {
            recommendationElement.textContent = calculation.recommendation;
        }

        // Show results with animation
        results.style.display = 'block';
        results.classList.add('fade-in-up');

        // Scroll to results
        results.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Update a single result value
     */
    updateResultValue(elementId, value) {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = value;
        }
    }

    /**
     * Show calculator loading state
     */
    showCalculatorLoading() {
        const btn = this.calculator.calculateBtn;
        if (btn) {
            btn.textContent = 'Calculating...';
            btn.disabled = true;
        }
    }

    /**
     * Show calculator error
     */
    showCalculatorError(message) {
        const btn = this.calculator.calculateBtn;
        if (btn) {
            btn.textContent = 'Calculate Value';
            btn.disabled = false;
        }

        // Show error message
        this.showNotification('Error calculating bonus: ' + message, 'error');
    }

    /**
     * Show input validation error
     */
    showInputError(inputId, message) {
        const input = document.getElementById(inputId);
        if (input) {
            input.style.borderColor = '#dc3545';
            input.focus();
        }
        this.showNotification(message, 'warning');
    }

    /**
     * Validate individual input
     */
    validateInput(input) {
        const value = parseFloat(input.value);
        const min = parseFloat(input.min);
        const max = parseFloat(input.max);

        if (isNaN(value) || value < min || value > max) {
            input.style.borderColor = '#dc3545';
        } else {
            input.style.borderColor = '#28a745';
        }
    }

    /**
     * Select player type and update strategies
     */
    async selectPlayerType(playerType) {
        // Update button states
        document.querySelectorAll('.player-type-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        const selectedBtn = document.querySelector(`[data-type="${playerType}"]`);
        if (selectedBtn) {
            selectedBtn.classList.add('active');
        }

        // Update strategy cards
        document.querySelectorAll('.strategy-card').forEach(card => {
            card.style.display = 'none';
        });

        const targetCard = document.querySelector(`[data-player-type="${playerType}"]`);
        if (targetCard) {
            targetCard.style.display = 'block';
            targetCard.classList.add('fade-in-up');
        }

        this.currentPlayerType = playerType;

        // Track player type selection
        this.trackPlayerTypeSelection(playerType);
    }

    /**
     * Expand bonus card with additional details
     */
    expandBonusCard(bonusType) {
        // This would typically open a modal or expand the card
        // For now, we'll scroll to the top and highlight
        const card = document.querySelector(`[data-bonus-type="${bonusType}"]`);
        if (card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            card.classList.add('highlighted');
            
            setTimeout(() => {
                card.classList.remove('highlighted');
            }, 3000);
        }

        // Track bonus card interaction
        this.trackBonusCardExpansion(bonusType);
    }

    /**
     * Toggle term card expansion
     */
    toggleTermCard(card) {
        card.classList.toggle('expanded');
        
        // Track terms card interaction
        const termType = card.dataset.term;
        this.trackTermsInteraction(termType);
    }

    /**
     * Handle keyboard navigation
     */
    handleKeyboardNavigation(e) {
        // Tab navigation for cards
        if (e.key === 'Tab') {
            // Let default behavior handle it
            return;
        }

        // Arrow key navigation for player type buttons
        if (e.target.classList.contains('player-type-btn')) {
            const buttons = Array.from(document.querySelectorAll('.player-type-btn'));
            const currentIndex = buttons.indexOf(e.target);

            if (e.key === 'ArrowLeft' && currentIndex > 0) {
                e.preventDefault();
                buttons[currentIndex - 1].focus();
                buttons[currentIndex - 1].click();
            } else if (e.key === 'ArrowRight' && currentIndex < buttons.length - 1) {
                e.preventDefault();
                buttons[currentIndex + 1].focus();
                buttons[currentIndex + 1].click();
            }
        }
    }

    /**
     * Initialize scroll animations
     */
    initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, observerOptions);

        // Observe cards for animation
        document.querySelectorAll('.bonus-type-card, .term-card, .strategy-card').forEach(card => {
            observer.observe(card);
        });
    }

    /**
     * Show notification to user
     */
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;

        // Style the notification
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '12px 20px',
            borderRadius: '8px',
            color: '#fff',
            fontWeight: '600',
            zIndex: '9999',
            maxWidth: '300px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)'
        });

        // Set background color based on type
        const colors = {
            info: '#007bff',
            success: '#28a745',
            warning: '#ffc107',
            error: '#dc3545'
        };
        notification.style.backgroundColor = colors[type] || colors.info;

        // Add to page
        document.body.appendChild(notification);

        // Remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    /**
     * Track calculator usage for analytics
     */
    trackCalculatorUsage(calculation) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'bonus_calculator_used', {
                event_category: 'engagement',
                event_label: 'bonus_types_guide',
                value: calculation.real_value
            });
        }

        // Track to local storage for analytics
        const usage = {
            timestamp: Date.now(),
            deposit: calculation.deposit_amount,
            bonus_amount: calculation.bonus_amount,
            risk_level: calculation.risk_level,
            real_value: calculation.real_value
        };

        const stored = localStorage.getItem('bonus_calculator_usage') || '[]';
        const usageHistory = JSON.parse(stored);
        usageHistory.push(usage);

        // Keep only last 10 calculations
        if (usageHistory.length > 10) {
            usageHistory.shift();
        }

        localStorage.setItem('bonus_calculator_usage', JSON.stringify(usageHistory));
    }

    /**
     * Track player type selection
     */
    trackPlayerTypeSelection(playerType) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'player_type_selected', {
                event_category: 'engagement',
                event_label: playerType,
                custom_map: { player_type: playerType }
            });
        }
    }

    /**
     * Track bonus card expansion
     */
    trackBonusCardExpansion(bonusType) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'bonus_card_expanded', {
                event_category: 'engagement',
                event_label: bonusType
            });
        }
    }

    /**
     * Track terms interaction
     */
    trackTermsInteraction(termType) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'terms_card_clicked', {
                event_category: 'engagement',
                event_label: termType
            });
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.bonusTypesManager = new BonusTypesManager();
});

// Add CSS for highlighted cards
const style = document.createElement('style');
style.textContent = `
    .bonus-type-card.highlighted {
        transform: scale(1.02);
        box-shadow: 0 0 20px rgba(0, 123, 255, 0.3);
        border-color: #007bff;
    }

    .term-card.expanded {
        transform: scale(1.02);
        z-index: 10;
    }

    .notification {
        transition: all 0.3s ease;
        animation: slideInRight 0.3s ease;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
