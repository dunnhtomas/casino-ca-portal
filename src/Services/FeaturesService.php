<?php

namespace App\Services;

class FeaturesService
{
    private array $features;

    public function __construct()
    {
        $this->initializeFeatures();
    }

    /**
     * Get all 5 key features
     */
    public function getFiveKeyFeatures(): array
    {
        return $this->features;
    }

    /**
     * Get specific feature by ID
     */
    public function getFeatureDetails(int $featureId): ?array
    {
        return $this->features[$featureId - 1] ?? null;
    }

    /**
     * Get aggregated statistics for all features
     */
    public function getFeatureStats(): array
    {
        return [
            'total_games' => '21,500+',
            'max_bonus' => '$20,000 CAD',
            'payment_methods' => '6+',
            'mobile_compatibility' => '100%',
            'security_level' => '256-bit SSL'
        ];
    }

    /**
     * Get features formatted for homepage display
     */
    public function getFeaturesForHomepage(): array
    {
        return array_map(function($feature) {
            return [
                'id' => $feature['id'],
                'title' => $feature['title'],
                'description' => $feature['description'],
                'icon_class' => $feature['icon_class'],
                'stat_value' => $feature['stat_value'],
                'stat_label' => $feature['stat_label'],
                'color_scheme' => $feature['color_scheme']
            ];
        }, $this->features);
    }

    /**
     * Get features with Schema.org markup
     */
    public function getFeaturesWithSchema(): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Key Casino Features for Canadian Players',
            'description' => 'Top 5 features that make our casino reviews platform the best choice for Canadian gamblers',
            'itemListElement' => []
        ];

        foreach ($this->features as $index => $feature) {
            $schema['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'Service',
                    'name' => $feature['title'],
                    'description' => $feature['description'],
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'Best Casino Portal',
                        'url' => 'https://bestcasinoportal.com'
                    ]
                ]
            ];
        }

        return $schema;
    }

    /**
     * Initialize the 5 key features data
     */
    private function initializeFeatures(): void
    {
        $this->features = [
            [
                'id' => 1,
                'title' => 'Premium Casino Games from Leading Providers',
                'description' => 'Access 21,500+ games from top developers like NetEnt, Microgaming, and Evolution Gaming. Our featured casinos offer the latest slots, live dealer games, and table classics with the highest RTPs available to Canadian players.',
                'icon_class' => 'fas fa-gamepad',
                'stat_value' => '21,500+',
                'stat_label' => 'Games Available',
                'color_scheme' => 'blue',
                'keywords' => ['casino games', 'slots', 'NetEnt', 'Microgaming', 'Evolution Gaming', 'RTP'],
                'canadian_focus' => 'Games specifically available to Canadian players with no geo-restrictions'
            ],
            [
                'id' => 2,
                'title' => 'Generous Welcome Bonuses in Canadian Dollars',
                'description' => 'No currency conversion fees or exchange rate confusion. Our reviewed casinos offer welcome bonuses up to $20,000 CAD plus free spins, specifically designed for Canadian players with favorable wagering requirements.',
                'icon_class' => 'fas fa-maple-leaf',
                'stat_value' => '$20,000',
                'stat_label' => 'Max Bonus CAD',
                'color_scheme' => 'red',
                'keywords' => ['Canadian dollars', 'welcome bonus', 'free spins', 'wagering requirements', 'CAD'],
                'canadian_focus' => 'All bonuses listed in Canadian dollars with transparent terms'
            ],
            [
                'id' => 3,
                'title' => 'Popular Canadian Payment Options',
                'description' => 'Deposit and withdraw using Interac e-Transfer, Visa, Mastercard, and cryptocurrency. Fast processing times, secure transactions, and methods trusted by millions of Canadians for online gambling.',
                'icon_class' => 'fas fa-credit-card',
                'stat_value' => 'Instant',
                'stat_label' => 'Deposit Times',
                'color_scheme' => 'green',
                'keywords' => ['Interac e-Transfer', 'Visa', 'Mastercard', 'cryptocurrency', 'Canadian banking'],
                'canadian_focus' => 'Payment methods specifically popular and trusted in Canada'
            ],
            [
                'id' => 4,
                'title' => 'Seamless Mobile Gaming Experience',
                'description' => 'Play your favorite casino games anywhere with optimized mobile sites and dedicated apps. Our reviewed casinos offer full game libraries, easy navigation, and touch-optimized interfaces for iOS and Android.',
                'icon_class' => 'fas fa-mobile-alt',
                'stat_value' => '100%',
                'stat_label' => 'Mobile Compatible',
                'color_scheme' => 'purple',
                'keywords' => ['mobile casino', 'iOS', 'Android', 'mobile gaming', 'responsive design'],
                'canadian_focus' => 'Mobile apps and sites optimized for Canadian network speeds and devices'
            ],
            [
                'id' => 5,
                'title' => 'Bank-Like Security with SSL Encryption',
                'description' => 'Your personal and financial information is protected with 256-bit SSL encryption, the same technology used by major Canadian banks. All reviewed casinos are licensed and regulated by respected authorities.',
                'icon_class' => 'fas fa-shield-alt',
                'stat_value' => '256-bit',
                'stat_label' => 'SSL Security',
                'color_scheme' => 'orange',
                'keywords' => ['SSL encryption', 'security', 'licensed casinos', 'regulation', 'Canadian banks'],
                'canadian_focus' => 'Security standards meeting Canadian financial industry requirements'
            ]
        ];
    }

    /**
     * Get feature by title (for internal use)
     */
    public function getFeatureByTitle(string $title): ?array
    {
        foreach ($this->features as $feature) {
            if (stripos($feature['title'], $title) !== false) {
                return $feature;
            }
        }
        return null;
    }

    /**
     * Get features grouped by category
     */
    public function getFeaturesByCategory(): array
    {
        return [
            'content' => [$this->features[0]], // Games
            'financial' => [$this->features[1], $this->features[2]], // Bonuses, Payments
            'technical' => [$this->features[3], $this->features[4]]  // Mobile, Security
        ];
    }

    /**
     * Get Canadian-specific messaging for features
     */
    public function getCanadianFocusPoints(): array
    {
        return array_map(function($feature) {
            return [
                'title' => $feature['title'],
                'canadian_focus' => $feature['canadian_focus']
            ];
        }, $this->features);
    }
}
