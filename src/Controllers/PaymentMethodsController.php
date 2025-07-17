<?php

namespace App\Controllers;

use App\Services\PaymentMethodsService;

/**
 * Payment Methods Controller
 * Handles payment method display and API endpoints for Canadian online casinos
 * 
 * PRD #12: Payment Methods Guide Section
 * Manages homepage integration and dedicated payment method pages
 */
class PaymentMethodsController
{
    private PaymentMethodsService $paymentMethodsService;

    public function __construct()
    {
        $this->paymentMethodsService = new PaymentMethodsService();
    }

    /**
     * Display payment methods page
     */
    public function index(): string
    {
        $paymentData = $this->paymentMethodsService->getPaymentMethods();
        
        return $this->renderPaymentMethodsPage($paymentData);
    }

    /**
     * Get payment methods data for API consumption
     */
    public function getApiData(): string
    {
        header('Content-Type: application/json');
        
        $paymentData = $this->paymentMethodsService->getPaymentMethods();
        
        return json_encode($paymentData, JSON_PRETTY_PRINT);
    }

    /**
     * Get payment methods filtered by category
     */
    public function getMethodsByCategory(string $category): string
    {
        header('Content-Type: application/json');
        
        $categoryData = $this->paymentMethodsService->getMethodsByCategory($category);
        
        return json_encode($categoryData, JSON_PRETTY_PRINT);
    }

    /**
     * Show individual payment method details
     */
    public function showMethodDetails(string $methodId): string
    {
        $methodDetails = $this->paymentMethodsService->getMethodDetails($methodId);
        
        if (!$methodDetails) {
            http_response_code(404);
            return 'Payment method not found';
        }
        
        return $this->renderMethodDetailsPage($methodDetails);
    }

    /**
     * Get Canadian-specific banking options
     */
    public function getCanadianBankingOptions(): string
    {
        header('Content-Type: application/json');
        
        $canadianOptions = $this->paymentMethodsService->getCanadianBankingOptions();
        
        return json_encode($canadianOptions, JSON_PRETTY_PRINT);
    }

    /**
     * Get payment method data for homepage integration
     */
    public function getHomepageData(): array
    {
        return $this->paymentMethodsService->getPaymentMethods();
    }

    /**
     * Render full payment methods page
     */
    private function renderPaymentMethodsPage(array $paymentData): string
    {
        $methods = $paymentData['methods'];
        $statistics = $paymentData['statistics'];
        $categories = $paymentData['categories'];
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Methods Guide - Best Casino Portal</title>
            <meta name="description" content="Complete guide to payment methods for Canadian online casinos. Compare processing times, fees, and security features for credit cards, e-wallets, bank transfers, and crypto.">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <link rel="stylesheet" href="/css/payment-methods.css">
        </head>
        <body>
            <div class="container">
                <header class="payment-header">
                    <h1>🏦 Payment Methods Guide</h1>
                    <p class="payment-subtitle">
                        Complete guide to secure payment options for Canadian online casino players. 
                        Compare processing times, fees, and security features to choose the best method for you.
                    </p>
                    
                    <div class="payment-stats">
                        <div class="payment-stat-item">
                            <span class="payment-stat-number"><?= $statistics['total_methods'] ?></span>
                            <span class="payment-stat-label">Payment Methods</span>
                        </div>
                        <div class="payment-stat-item">
                            <span class="payment-stat-number"><?= $statistics['instant_methods'] ?></span>
                            <span class="payment-stat-label">Instant Methods</span>
                        </div>
                        <div class="payment-stat-item">
                            <span class="payment-stat-number"><?= $statistics['free_methods'] ?></span>
                            <span class="payment-stat-label">Free Methods</span>
                        </div>
                        <div class="payment-stat-item">
                            <span class="payment-stat-number"><?= $statistics['canadian_methods'] ?></span>
                            <span class="payment-stat-label">Canadian Methods</span>
                        </div>
                    </div>
                </header>

                <div class="category-tabs">
                    <button class="category-tab active" data-category="all">All Methods</button>
                    <?php foreach ($categories as $categoryKey => $categoryName): ?>
                        <button class="category-tab" data-category="<?= $categoryKey ?>"><?= $categoryName ?></button>
                    <?php endforeach; ?>
                </div>

                <div class="payment-methods-grid">
                    <?php foreach ($methods as $method): ?>
                        <div class="payment-method-card" data-category="<?= $method['category'] ?>">
                            <div class="payment-method-header">
                                <div class="payment-logo">
                                    <img src="<?= $method['logo'] ?>" alt="<?= $method['name'] ?>" loading="lazy">
                                </div>
                                <div class="payment-name">
                                    <h3><?= $method['name'] ?></h3>
                                    <?php if ($method['canadian_specific']): ?>
                                        <span class="canadian-badge">🍁 Canadian</span>
                                    <?php endif; ?>
                                </div>
                                <div class="trust-rating">
                                    <span class="rating-score"><?= $method['trust_rating'] ?></span>
                                    <div class="rating-stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?= $i <= floor($method['trust_rating']) ? 'active' : '' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="payment-method-info">
                                <p class="payment-description"><?= $method['description'] ?></p>
                                
                                <div class="payment-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Deposit Time:</span>
                                        <span class="detail-value processing-time"><?= $method['processing_time']['deposit'] ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Withdrawal Time:</span>
                                        <span class="detail-value processing-time"><?= $method['processing_time']['withdrawal'] ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Deposit Fee:</span>
                                        <span class="detail-value fee"><?= $method['fees']['deposit'] ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Withdrawal Fee:</span>
                                        <span class="detail-value fee"><?= $method['fees']['withdrawal'] ?></span>
                                    </div>
                                </div>
                                
                                <div class="payment-limits">
                                    <h4>Transaction Limits</h4>
                                    <div class="limits-grid">
                                        <div class="limit-item">
                                            <span class="limit-label">Min Deposit:</span>
                                            <span class="limit-value">$<?= number_format($method['limits']['min_deposit']) ?></span>
                                        </div>
                                        <div class="limit-item">
                                            <span class="limit-label">Max Deposit:</span>
                                            <span class="limit-value">$<?= number_format($method['limits']['max_deposit']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="payment-features">
                                    <h4>Key Features</h4>
                                    <ul class="features-list">
                                        <?php foreach (array_slice($method['features'], 0, 3) as $feature): ?>
                                            <li><i class="fas fa-check"></i> <?= $feature ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                
                                <div class="security-certifications">
                                    <?php foreach ($method['security_certifications'] as $cert): ?>
                                        <span class="security-badge"><?= $cert ?></span>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="payment-actions">
                                    <button class="learn-more-btn" onclick="viewMethodDetails('<?= $method['id'] ?>')">
                                        <i class="fas fa-info-circle"></i> Learn More
                                    </button>
                                    <button class="use-method-btn" onclick="usePaymentMethod('<?= $method['id'] ?>')">
                                        <i class="fas fa-credit-card"></i> Use This Method
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
                // Category filtering functionality
                document.querySelectorAll('.category-tab').forEach(tab => {
                    tab.addEventListener('click', function() {
                        const category = this.dataset.category;
                        
                        // Update active tab
                        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        
                        // Filter payment methods
                        document.querySelectorAll('.payment-method-card').forEach(card => {
                            if (category === 'all' || card.dataset.category === category) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });

                function viewMethodDetails(methodId) {
                    window.location.href = `/payment-methods/${methodId}`;
                }

                function usePaymentMethod(methodId) {
                    // Redirect to casinos that accept this payment method
                    window.location.href = `/casinos?payment_method=${methodId}`;
                }
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }

    /**
     * Render individual payment method details page
     */
    private function renderMethodDetailsPage(array $method): string
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= $method['name'] ?> Payment Method Guide - Best Casino Portal</title>
            <meta name="description" content="Complete guide to <?= $method['name'] ?> for Canadian online casinos. Processing times, fees, security features, and step-by-step instructions.">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <link rel="stylesheet" href="/css/payment-methods.css">
        </head>
        <body>
            <div class="container">
                <div class="method-detail-page">
                    <header class="method-header">
                        <div class="method-logo-large">
                            <img src="<?= $method['logo'] ?>" alt="<?= $method['name'] ?>">
                        </div>
                        <div class="method-title">
                            <h1><?= $method['name'] ?> Payment Guide</h1>
                            <p class="method-description"><?= $method['description'] ?></p>
                            <?php if ($method['canadian_specific']): ?>
                                <div class="canadian-highlight">
                                    <i class="fas fa-maple-leaf"></i> Canadian-Specific Payment Method
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="method-rating">
                            <div class="rating-score"><?= $method['trust_rating'] ?>/10</div>
                            <div class="rating-label">Trust Rating</div>
                        </div>
                    </header>

                    <div class="method-details-grid">
                        <div class="detail-section">
                            <h2>Processing Times & Fees</h2>
                            <!-- Detailed processing and fee information -->
                        </div>
                        
                        <div class="detail-section">
                            <h2>Pros & Cons</h2>
                            <div class="pros-cons-grid">
                                <div class="pros-section">
                                    <h3><i class="fas fa-thumbs-up"></i> Pros</h3>
                                    <ul>
                                        <?php foreach ($method['pros'] as $pro): ?>
                                            <li><?= $pro ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="cons-section">
                                    <h3><i class="fas fa-thumbs-down"></i> Cons</h3>
                                    <ul>
                                        <?php foreach ($method['cons'] as $con): ?>
                                            <li><?= $con ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}
