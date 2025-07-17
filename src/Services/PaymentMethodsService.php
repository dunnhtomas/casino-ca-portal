<?php

namespace App\Services;

/**
 * Payment Methods Service
 * Manages comprehensive payment method data for Canadian online casinos
 * 
 * PRD #12: Payment Methods Guide Section
 * Provides detailed information about all payment options available to Canadian players
 */
class PaymentMethodsService
{
    private array $paymentMethods;
    private array $securityFeatures;
    private array $processingTimes;

    public function __construct()
    {
        $this->initializePaymentMethods();
        $this->initializeSecurityFeatures();
        $this->initializeProcessingTimes();
    }

    /**
     * Get all payment methods for homepage display
     */
    public function getPaymentMethods(): array
    {
        return [
            'statistics' => [
                'total_methods' => count($this->paymentMethods),
                'instant_methods' => count(array_filter($this->paymentMethods, fn($method) => $method['processing_time']['deposit'] === 'Instant')),
                'free_methods' => count(array_filter($this->paymentMethods, fn($method) => $method['fees']['deposit'] === 'Free')),
                'canadian_methods' => count(array_filter($this->paymentMethods, fn($method) => $method['canadian_specific'] === true)),
                'security_certified' => count(array_filter($this->paymentMethods, fn($method) => !empty($method['security_certifications'])))
            ],
            'methods' => $this->paymentMethods,
            'categories' => $this->getMethodCategories(),
            'security_features' => $this->securityFeatures,
            'processing_times' => $this->processingTimes
        ];
    }

    /**
     * Get payment methods filtered by category
     */
    public function getMethodsByCategory(string $category = null): array
    {
        if (!$category) {
            return $this->getPaymentMethods();
        }

        $filteredMethods = array_filter(
            $this->paymentMethods,
            fn($method) => $method['category'] === $category
        );

        return [
            'category' => $category,
            'methods' => $filteredMethods,
            'count' => count($filteredMethods)
        ];
    }

    /**
     * Get detailed information for a specific payment method
     */
    public function getMethodDetails(string $methodId): array
    {
        return $this->paymentMethods[$methodId] ?? null;
    }

    /**
     * Get security features and certifications
     */
    public function getSecurityFeatures(): array
    {
        return $this->securityFeatures;
    }

    /**
     * Get processing time information
     */
    public function getProcessingTimes(): array
    {
        return $this->processingTimes;
    }

    /**
     * Get Canadian-specific banking options
     */
    public function getCanadianBankingOptions(): array
    {
        return array_filter(
            $this->paymentMethods,
            fn($method) => $method['canadian_specific'] === true
        );
    }

    /**
     * Get payment method categories
     */
    private function getMethodCategories(): array
    {
        return [
            'credit_debit' => 'Credit & Debit Cards',
            'bank_transfer' => 'Bank Transfers',
            'e_wallet' => 'E-Wallets',
            'prepaid' => 'Prepaid Cards',
            'mobile' => 'Mobile Payments',
            'crypto' => 'Cryptocurrency'
        ];
    }

    /**
     * Initialize comprehensive payment methods data
     */
    private function initializePaymentMethods(): void
    {
        $this->paymentMethods = [
            'visa' => [
                'id' => 'visa',
                'name' => 'Visa',
                'category' => 'credit_debit',
                'logo' => '/images/payments/visa.png',
                'description' => 'The world\'s most widely accepted credit and debit card for secure online casino transactions.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => '1-3 business days'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'Free'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 5000,
                    'min_withdrawal' => 20,
                    'max_withdrawal' => 5000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['PCI DSS', 'SSL 256-bit', 'Visa Secure'],
                'features' => [
                    'Instant deposits',
                    'Worldwide acceptance',
                    'Advanced fraud protection',
                    'Mobile wallet integration',
                    'Contactless payments'
                ],
                'pros' => [
                    'Universally accepted',
                    'Instant deposits',
                    'Strong security features',
                    'Familiar to all users'
                ],
                'cons' => [
                    'Some banks block gambling transactions',
                    'Withdrawal times vary by bank',
                    'May require additional verification'
                ],
                'popularity_score' => 95,
                'trust_rating' => 9.8
            ],
            'mastercard' => [
                'id' => 'mastercard',
                'name' => 'Mastercard',
                'category' => 'credit_debit',
                'logo' => '/images/payments/mastercard.png',
                'description' => 'Globally trusted credit and debit card solution with enhanced security for Canadian players.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => '1-3 business days'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'Free'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 5000,
                    'min_withdrawal' => 20,
                    'max_withdrawal' => 5000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['PCI DSS', 'SSL 256-bit', 'Mastercard SecureCode'],
                'features' => [
                    'Instant deposits',
                    'Global acceptance',
                    'Advanced fraud protection',
                    'Mobile payments',
                    'Contactless technology'
                ],
                'pros' => [
                    'Widely accepted',
                    'Immediate deposits',
                    'Robust security',
                    'Easy to use'
                ],
                'cons' => [
                    'Bank restrictions possible',
                    'Withdrawal processing varies',
                    'Additional verification may be required'
                ],
                'popularity_score' => 92,
                'trust_rating' => 9.7
            ],
            'interac' => [
                'id' => 'interac',
                'name' => 'Interac',
                'category' => 'bank_transfer',
                'logo' => '/images/payments/interac.png',
                'description' => 'Canada\'s most trusted debit payment system, offering secure direct bank account transactions.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => '1-2 business days'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'CAD $1.50'
                ],
                'limits' => [
                    'min_deposit' => 20,
                    'max_deposit' => 3000,
                    'min_withdrawal' => 20,
                    'max_withdrawal' => 3000
                ],
                'canadian_specific' => true,
                'security_certifications' => ['PCI DSS', 'Bank-level security', 'EMV certified'],
                'features' => [
                    'Direct bank account access',
                    'Canadian banking integration',
                    'Instant deposits',
                    'Mobile banking support',
                    'Two-factor authentication'
                ],
                'pros' => [
                    'Canada-specific solution',
                    'Bank-level security',
                    'Instant deposits',
                    'Widely trusted by Canadians'
                ],
                'cons' => [
                    'Only available in Canada',
                    'Daily transaction limits',
                    'Small withdrawal fee'
                ],
                'popularity_score' => 98,
                'trust_rating' => 9.9
            ],
            'paypal' => [
                'id' => 'paypal',
                'name' => 'PayPal',
                'category' => 'e_wallet',
                'logo' => '/images/payments/paypal.png',
                'description' => 'World\'s leading digital wallet with buyer protection and instant transactions.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => '1-2 business days'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'Free'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 10000,
                    'min_withdrawal' => 10,
                    'max_withdrawal' => 10000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['PCI DSS', 'SSL 256-bit', 'PayPal Protection'],
                'features' => [
                    'Buyer protection',
                    'Mobile app integration',
                    'Multiple funding sources',
                    'Instant transfers',
                    'International support'
                ],
                'pros' => [
                    'Enhanced security',
                    'Buyer protection',
                    'Easy to use',
                    'Mobile-friendly'
                ],
                'cons' => [
                    'Limited casino availability',
                    'Account restrictions possible',
                    'Currency conversion fees'
                ],
                'popularity_score' => 88,
                'trust_rating' => 9.5
            ],
            'skrill' => [
                'id' => 'skrill',
                'name' => 'Skrill',
                'category' => 'e_wallet',
                'logo' => '/images/payments/skrill.png',
                'description' => 'Popular e-wallet designed for online gaming with low fees and fast transfers.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => 'Within 24 hours'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => '1.45%'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 20000,
                    'min_withdrawal' => 10,
                    'max_withdrawal' => 20000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['PCI DSS', 'FCA regulated', '2FA authentication'],
                'features' => [
                    'Gaming-focused',
                    'Fast withdrawals',
                    'Multiple currencies',
                    'VIP program',
                    'Mobile app'
                ],
                'pros' => [
                    'Fast transactions',
                    'Gaming-friendly',
                    'Low fees',
                    'VIP benefits'
                ],
                'cons' => [
                    'Withdrawal fees',
                    'Account verification required',
                    'Limited customer support hours'
                ],
                'popularity_score' => 85,
                'trust_rating' => 9.2
            ],
            'neteller' => [
                'id' => 'neteller',
                'name' => 'Neteller',
                'category' => 'e_wallet',
                'logo' => '/images/payments/neteller.png',
                'description' => 'Secure e-wallet service with instant deposits and fast withdrawals for online gaming.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => 'Within 24 hours'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => '1.9%'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 15000,
                    'min_withdrawal' => 10,
                    'max_withdrawal' => 15000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['PCI DSS', 'FCA regulated', 'SSL encryption'],
                'features' => [
                    'Instant transactions',
                    'Prepaid card option',
                    'VIP program',
                    'Mobile compatibility',
                    'Multi-currency support'
                ],
                'pros' => [
                    'Very fast withdrawals',
                    'Prepaid card available',
                    'VIP rewards',
                    'Strong security'
                ],
                'cons' => [
                    'Withdrawal fees',
                    'Account inactivity fees',
                    'Limited to gaming sites'
                ],
                'popularity_score' => 82,
                'trust_rating' => 9.1
            ],
            'ecopayz' => [
                'id' => 'ecopayz',
                'name' => 'ecoPayz',
                'category' => 'e_wallet',
                'logo' => '/images/payments/ecopayz.png',
                'description' => 'Secure e-wallet with global reach and competitive fees for online casino transactions.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => '1-2 business days'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => '1.49%'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 50000,
                    'min_withdrawal' => 10,
                    'max_withdrawal' => 50000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['PCI DSS', 'FCA licensed', 'ISO 27001'],
                'features' => [
                    'Global acceptance',
                    'Multiple funding options',
                    'VIP program',
                    'Mobile app',
                    'Prepaid card'
                ],
                'pros' => [
                    'High transaction limits',
                    'Competitive fees',
                    'Strong security',
                    'Global reach'
                ],
                'cons' => [
                    'Withdrawal fees apply',
                    'Account verification required',
                    'Limited Canadian marketing'
                ],
                'popularity_score' => 78,
                'trust_rating' => 8.9
            ],
            'bank_transfer' => [
                'id' => 'bank_transfer',
                'name' => 'Bank Transfer',
                'category' => 'bank_transfer',
                'logo' => '/images/payments/bank-transfer.png',
                'description' => 'Direct bank-to-bank transfers offering maximum security and high transaction limits.',
                'processing_time' => [
                    'deposit' => '1-3 business days',
                    'withdrawal' => '3-5 business days'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'Free'
                ],
                'limits' => [
                    'min_deposit' => 50,
                    'max_deposit' => 100000,
                    'min_withdrawal' => 50,
                    'max_withdrawal' => 100000
                ],
                'canadian_specific' => true,
                'security_certifications' => ['Bank-level security', 'CDIC protected', 'SSL encryption'],
                'features' => [
                    'Highest security level',
                    'Very high limits',
                    'CDIC protection',
                    'All Canadian banks',
                    'No third-party involvement'
                ],
                'pros' => [
                    'Maximum security',
                    'Very high limits',
                    'No fees',
                    'CDIC protected'
                ],
                'cons' => [
                    'Slower processing',
                    'Requires bank details',
                    'No instant deposits'
                ],
                'popularity_score' => 75,
                'trust_rating' => 9.8
            ],
            'paysafecard' => [
                'id' => 'paysafecard',
                'name' => 'Paysafecard',
                'category' => 'prepaid',
                'logo' => '/images/payments/paysafecard.png',
                'description' => 'Prepaid voucher system for anonymous and secure online payments without bank details.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => 'Not available'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'N/A'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 1000,
                    'min_withdrawal' => 0,
                    'max_withdrawal' => 0
                ],
                'canadian_specific' => false,
                'security_certifications' => ['PCI DSS', 'Anonymous payments', 'SSL secure'],
                'features' => [
                    'Complete anonymity',
                    'No bank details required',
                    'Available at retail stores',
                    'Instant deposits',
                    'No registration needed'
                ],
                'pros' => [
                    'Complete privacy',
                    'No bank details needed',
                    'Instant deposits',
                    'Widely available'
                ],
                'cons' => [
                    'Deposit only',
                    'Lower limits',
                    'Must buy vouchers in advance'
                ],
                'popularity_score' => 70,
                'trust_rating' => 8.7
            ],
            'apple_pay' => [
                'id' => 'apple_pay',
                'name' => 'Apple Pay',
                'category' => 'mobile',
                'logo' => '/images/payments/apple-pay.png',
                'description' => 'Secure mobile payment system using Touch ID or Face ID for quick transactions.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => 'Not available'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'N/A'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 2000,
                    'min_withdrawal' => 0,
                    'max_withdrawal' => 0
                ],
                'canadian_specific' => false,
                'security_certifications' => ['Touch/Face ID', 'Tokenization', 'SSL secure'],
                'features' => [
                    'Biometric security',
                    'Instant payments',
                    'No card details shared',
                    'Mobile optimized',
                    'One-touch payments'
                ],
                'pros' => [
                    'Very secure',
                    'Extremely fast',
                    'Easy to use',
                    'Mobile-first'
                ],
                'cons' => [
                    'iOS devices only',
                    'Deposit only',
                    'Limited casino support'
                ],
                'popularity_score' => 83,
                'trust_rating' => 9.4
            ],
            'google_pay' => [
                'id' => 'google_pay',
                'name' => 'Google Pay',
                'category' => 'mobile',
                'logo' => '/images/payments/google-pay.png',
                'description' => 'Android-based mobile payment solution with fingerprint and PIN security.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => 'Not available'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'N/A'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 2000,
                    'min_withdrawal' => 0,
                    'max_withdrawal' => 0
                ],
                'canadian_specific' => false,
                'security_certifications' => ['Fingerprint auth', 'Tokenization', 'SSL secure'],
                'features' => [
                    'Fingerprint security',
                    'Quick payments',
                    'Android integration',
                    'NFC support',
                    'Multiple card support'
                ],
                'pros' => [
                    'Android compatible',
                    'Fast transactions',
                    'Secure authentication',
                    'Wide device support'
                ],
                'cons' => [
                    'Android only',
                    'Deposit only',
                    'Limited availability'
                ],
                'popularity_score' => 80,
                'trust_rating' => 9.2
            ],
            'bitcoin' => [
                'id' => 'bitcoin',
                'name' => 'Bitcoin',
                'category' => 'crypto',
                'logo' => '/images/payments/bitcoin.png',
                'description' => 'Leading cryptocurrency offering anonymous, fast, and secure transactions.',
                'processing_time' => [
                    'deposit' => '15-30 minutes',
                    'withdrawal' => '30-60 minutes'
                ],
                'fees' => [
                    'deposit' => 'Network fees',
                    'withdrawal' => 'Network fees'
                ],
                'limits' => [
                    'min_deposit' => 20,
                    'max_deposit' => 50000,
                    'min_withdrawal' => 20,
                    'max_withdrawal' => 50000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['Blockchain security', 'Cryptographic protection', 'Decentralized'],
                'features' => [
                    'Complete anonymity',
                    'No bank involvement',
                    'Global availability',
                    'Fast transactions',
                    'High security'
                ],
                'pros' => [
                    'Anonymous payments',
                    'Fast processing',
                    'No banking restrictions',
                    'Global acceptance'
                ],
                'cons' => [
                    'Price volatility',
                    'Technical knowledge required',
                    'Network fees vary'
                ],
                'popularity_score' => 77,
                'trust_rating' => 8.8
            ],
            'ethereum' => [
                'id' => 'ethereum',
                'name' => 'Ethereum',
                'category' => 'crypto',
                'logo' => '/images/payments/ethereum.png',
                'description' => 'Second-largest cryptocurrency with smart contract capabilities and fast transactions.',
                'processing_time' => [
                    'deposit' => '5-15 minutes',
                    'withdrawal' => '15-30 minutes'
                ],
                'fees' => [
                    'deposit' => 'Gas fees',
                    'withdrawal' => 'Gas fees'
                ],
                'limits' => [
                    'min_deposit' => 20,
                    'max_deposit' => 40000,
                    'min_withdrawal' => 20,
                    'max_withdrawal' => 40000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['Blockchain security', 'Smart contracts', 'Cryptographic'],
                'features' => [
                    'Smart contract support',
                    'Faster than Bitcoin',
                    'Anonymous transactions',
                    'DeFi integration',
                    'Lower fees'
                ],
                'pros' => [
                    'Faster than Bitcoin',
                    'Lower fees',
                    'Advanced features',
                    'Growing acceptance'
                ],
                'cons' => [
                    'Price volatility',
                    'Gas fee fluctuations',
                    'Technical complexity'
                ],
                'popularity_score' => 72,
                'trust_rating' => 8.6
            ],
            'litecoin' => [
                'id' => 'litecoin',
                'name' => 'Litecoin',
                'category' => 'crypto',
                'logo' => '/images/payments/litecoin.png',
                'description' => 'Silver to Bitcoin\'s gold, offering faster transactions and lower fees.',
                'processing_time' => [
                    'deposit' => '5-10 minutes',
                    'withdrawal' => '10-20 minutes'
                ],
                'fees' => [
                    'deposit' => 'Very low',
                    'withdrawal' => 'Very low'
                ],
                'limits' => [
                    'min_deposit' => 10,
                    'max_deposit' => 30000,
                    'min_withdrawal' => 10,
                    'max_withdrawal' => 30000
                ],
                'canadian_specific' => false,
                'security_certifications' => ['Blockchain security', 'Scrypt algorithm', 'Decentralized'],
                'features' => [
                    'Very fast transactions',
                    'Low fees',
                    'Stable network',
                    'Wide acceptance',
                    'Easy to use'
                ],
                'pros' => [
                    'Very fast',
                    'Minimal fees',
                    'Reliable network',
                    'Easy to understand'
                ],
                'cons' => [
                    'Less anonymous than others',
                    'Price volatility',
                    'Smaller market cap'
                ],
                'popularity_score' => 68,
                'trust_rating' => 8.4
            ],
            'american_express' => [
                'id' => 'american_express',
                'name' => 'American Express',
                'category' => 'credit_debit',
                'logo' => '/images/payments/amex.png',
                'description' => 'Premium credit card with excellent customer service and fraud protection.',
                'processing_time' => [
                    'deposit' => 'Instant',
                    'withdrawal' => '2-4 business days'
                ],
                'fees' => [
                    'deposit' => 'Free',
                    'withdrawal' => 'Free'
                ],
                'limits' => [
                    'min_deposit' => 25,
                    'max_deposit' => 7500,
                    'min_withdrawal' => 25,
                    'max_withdrawal' => 7500
                ],
                'canadian_specific' => false,
                'security_certifications' => ['PCI DSS', 'SafeKey technology', 'Fraud protection'],
                'features' => [
                    'Premium customer service',
                    'Enhanced fraud protection',
                    'Travel benefits',
                    'Instant deposits',
                    'Global acceptance'
                ],
                'pros' => [
                    'Excellent customer service',
                    'Strong fraud protection',
                    'Premium benefits',
                    'Instant deposits'
                ],
                'cons' => [
                    'Limited casino acceptance',
                    'Higher merchant fees',
                    'Annual fees may apply'
                ],
                'popularity_score' => 65,
                'trust_rating' => 9.3
            ]
        ];
    }

    /**
     * Initialize security features data
     */
    private function initializeSecurityFeatures(): void
    {
        $this->securityFeatures = [
            'ssl_encryption' => [
                'name' => 'SSL 256-bit Encryption',
                'description' => 'Bank-level encryption protecting all transactions',
                'icon' => 'fas fa-shield-alt'
            ],
            'pci_dss' => [
                'name' => 'PCI DSS Compliance',
                'description' => 'Payment Card Industry security standards',
                'icon' => 'fas fa-certificate'
            ],
            'two_factor' => [
                'name' => 'Two-Factor Authentication',
                'description' => 'Additional layer of account security',
                'icon' => 'fas fa-key'
            ],
            'fraud_protection' => [
                'name' => 'Advanced Fraud Protection',
                'description' => 'Real-time transaction monitoring',
                'icon' => 'fas fa-eye'
            ],
            'cdic_protection' => [
                'name' => 'CDIC Protection',
                'description' => 'Canadian Deposit Insurance Corporation coverage',
                'icon' => 'fas fa-maple-leaf'
            ]
        ];
    }

    /**
     * Initialize processing times information
     */
    private function initializeProcessingTimes(): void
    {
        $this->processingTimes = [
            'instant' => [
                'label' => 'Instant',
                'description' => 'Funds available immediately',
                'icon' => 'fas fa-bolt',
                'color' => '#28a745'
            ],
            'fast' => [
                'label' => '1-24 hours',
                'description' => 'Quick processing within a day',
                'icon' => 'fas fa-clock',
                'color' => '#17a2b8'
            ],
            'standard' => [
                'label' => '1-3 business days',
                'description' => 'Standard banking timeframe',
                'icon' => 'fas fa-calendar-alt',
                'color' => '#ffc107'
            ],
            'slow' => [
                'label' => '3-7 business days',
                'description' => 'Traditional banking methods',
                'icon' => 'fas fa-hourglass-half',
                'color' => '#dc3545'
            ]
        ];
    }
}
