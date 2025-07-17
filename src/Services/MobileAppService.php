<?php

namespace App\Services;

/**
 * Mobile App Service
 * Manages mobile casino application data for Canadian players
 * 
 * PRD #13: Mobile App Section
 * Provides detailed information about mobile casino apps, ratings, and features
 */
class MobileAppService
{
    private array $mobileApps;
    private array $appStatistics;
    private array $mobileAdvantages;

    public function __construct()
    {
        $this->initializeMobileApps();
        $this->initializeAppStatistics();
        $this->initializeMobileAdvantages();
    }

    /**
     * Get all mobile apps for homepage display
     */
    public function getMobileApps(): array
    {
        return [
            'statistics' => $this->appStatistics,
            'apps' => $this->mobileApps,
            'platforms' => $this->getPlatforms(),
            'mobile_advantages' => $this->mobileAdvantages,
            'total_downloads' => $this->getTotalDownloads()
        ];
    }

    /**
     * Get mobile apps filtered by platform
     */
    public function getAppsByPlatform(string $platform = null): array
    {
        if (!$platform) {
            return $this->getMobileApps();
        }

        $filteredApps = array_filter(
            $this->mobileApps,
            fn($app) => in_array($platform, $app['platforms'])
        );

        return [
            'platform' => $platform,
            'apps' => $filteredApps,
            'count' => count($filteredApps)
        ];
    }

    /**
     * Get detailed information for a specific mobile app
     */
    public function getAppDetails(string $appId): array
    {
        return $this->mobileApps[$appId] ?? null;
    }

    /**
     * Get app store ratings and statistics
     */
    public function getAppStoreRatings(): array
    {
        $ratings = [];
        foreach ($this->mobileApps as $app) {
            $ratings[$app['id']] = [
                'ios_rating' => $app['ratings']['ios'],
                'android_rating' => $app['ratings']['android'],
                'total_reviews' => $app['reviews']['total'],
                'average_rating' => $app['ratings']['average']
            ];
        }
        return $ratings;
    }

    /**
     * Get mobile-exclusive bonuses
     */
    public function getMobileBonuses(): array
    {
        $mobileBonuses = [];
        foreach ($this->mobileApps as $app) {
            if (!empty($app['mobile_bonus'])) {
                $mobileBonuses[$app['id']] = $app['mobile_bonus'];
            }
        }
        return $mobileBonuses;
    }

    /**
     * Get device compatibility information
     */
    public function getDeviceCompatibility(): array
    {
        return [
            'ios' => [
                'minimum_version' => 'iOS 12.0',
                'supported_devices' => ['iPhone 6s+', 'iPad Air 2+', 'iPod Touch 7th gen+'],
                'features' => ['Face ID', 'Touch ID', 'Apple Pay', 'Siri Shortcuts']
            ],
            'android' => [
                'minimum_version' => 'Android 8.0 (API 26)',
                'supported_devices' => ['Most Android phones and tablets'],
                'features' => ['Fingerprint', 'Google Pay', 'Android Auto', 'Widgets']
            ],
            'pwa' => [
                'browser_support' => ['Chrome 67+', 'Firefox 67+', 'Safari 13+'],
                'features' => ['Offline play', 'Push notifications', 'Add to home screen']
            ]
        ];
    }

    /**
     * Get supported platforms
     */
    private function getPlatforms(): array
    {
        return [
            'ios' => 'iOS App Store',
            'android' => 'Google Play Store',
            'pwa' => 'Progressive Web App'
        ];
    }

    /**
     * Calculate total downloads across all apps
     */
    private function getTotalDownloads(): int
    {
        return array_sum(array_column($this->mobileApps, 'downloads'));
    }

    /**
     * Initialize comprehensive mobile app data
     */
    private function initializeMobileApps(): void
    {
        $this->mobileApps = [
            'spin_casino' => [
                'id' => 'spin_casino',
                'name' => 'Spin Casino',
                'casino_name' => 'Spin Casino',
                'description' => 'Premium mobile casino experience with 600+ games and live dealers',
                'icon' => '/images/apps/spin-casino-icon.png',
                'screenshots' => [
                    '/images/apps/spin-casino-screen1.jpg',
                    '/images/apps/spin-casino-screen2.jpg',
                    '/images/apps/spin-casino-screen3.jpg'
                ],
                'platforms' => ['ios', 'android', 'pwa'],
                'downloads' => 125000,
                'ratings' => [
                    'ios' => 4.6,
                    'android' => 4.4,
                    'average' => 4.5
                ],
                'reviews' => [
                    'total' => 8920,
                    'ios_count' => 4200,
                    'android_count' => 4720
                ],
                'features' => [
                    '600+ Casino Games',
                    'Live Dealer Tables',
                    'Progressive Jackpots',
                    'Touch ID Security',
                    'Instant Deposits',
                    'Mobile-Exclusive Bonuses'
                ],
                'mobile_bonus' => [
                    'type' => 'Welcome Bonus',
                    'amount' => '$1000',
                    'description' => 'Mobile-exclusive 100% match bonus up to $1000',
                    'wagering' => '35x',
                    'code' => 'MOBILE100'
                ],
                'app_store_links' => [
                    'ios' => 'https://apps.apple.com/app/spin-casino',
                    'android' => 'https://play.google.com/store/apps/details?id=com.spincasino',
                    'pwa' => 'https://m.spincasino.com/'
                ],
                'qr_codes' => [
                    'ios' => '/images/qr/spin-casino-ios-qr.png',
                    'android' => '/images/qr/spin-casino-android-qr.png'
                ],
                'file_size' => [
                    'ios' => '89.2 MB',
                    'android' => '76.8 MB'
                ],
                'last_updated' => '2025-07-10',
                'version' => [
                    'ios' => '3.2.1',
                    'android' => '3.2.0'
                ],
                'company' => 'Bayton Ltd',
                'license' => 'Malta Gaming Authority',
                'support_rating' => 4.7,
                'popularity_score' => 95
            ],
            'jackpot_city' => [
                'id' => 'jackpot_city',
                'name' => 'Jackpot City',
                'casino_name' => 'Jackpot City Casino',
                'description' => 'Award-winning mobile casino with massive progressive jackpots',
                'icon' => '/images/apps/jackpot-city-icon.png',
                'screenshots' => [
                    '/images/apps/jackpot-city-screen1.jpg',
                    '/images/apps/jackpot-city-screen2.jpg',
                    '/images/apps/jackpot-city-screen3.jpg'
                ],
                'platforms' => ['ios', 'android', 'pwa'],
                'downloads' => 98000,
                'ratings' => [
                    'ios' => 4.5,
                    'android' => 4.3,
                    'average' => 4.4
                ],
                'reviews' => [
                    'total' => 7650,
                    'ios_count' => 3800,
                    'android_count' => 3850
                ],
                'features' => [
                    'Progressive Jackpots',
                    '500+ Mobile Games',
                    'Microgaming Powered',
                    'Live Chat Support',
                    'Fast Withdrawals',
                    'VIP Program'
                ],
                'mobile_bonus' => [
                    'type' => 'Free Spins',
                    'amount' => '100 Free Spins',
                    'description' => 'Mobile app download bonus - 100 free spins',
                    'wagering' => '30x',
                    'code' => 'MOBILE100'
                ],
                'app_store_links' => [
                    'ios' => 'https://apps.apple.com/app/jackpot-city',
                    'android' => 'https://play.google.com/store/apps/details?id=com.jackpotcity',
                    'pwa' => 'https://m.jackpotcitycasino.com/'
                ],
                'qr_codes' => [
                    'ios' => '/images/qr/jackpot-city-ios-qr.png',
                    'android' => '/images/qr/jackpot-city-android-qr.png'
                ],
                'file_size' => [
                    'ios' => '102.5 MB',
                    'android' => '85.3 MB'
                ],
                'last_updated' => '2025-07-08',
                'version' => [
                    'ios' => '2.8.9',
                    'android' => '2.8.7'
                ],
                'company' => 'Digimedia Ltd',
                'license' => 'Malta Gaming Authority',
                'support_rating' => 4.6,
                'popularity_score' => 92
            ],
            'ruby_fortune' => [
                'id' => 'ruby_fortune',
                'name' => 'Ruby Fortune',
                'casino_name' => 'Ruby Fortune Casino',
                'description' => 'Elegant mobile casino with premium gaming experience',
                'icon' => '/images/apps/ruby-fortune-icon.png',
                'screenshots' => [
                    '/images/apps/ruby-fortune-screen1.jpg',
                    '/images/apps/ruby-fortune-screen2.jpg',
                    '/images/apps/ruby-fortune-screen3.jpg'
                ],
                'platforms' => ['ios', 'android'],
                'downloads' => 76000,
                'ratings' => [
                    'ios' => 4.4,
                    'android' => 4.2,
                    'average' => 4.3
                ],
                'reviews' => [
                    'total' => 5890,
                    'ios_count' => 3100,
                    'android_count' => 2790
                ],
                'features' => [
                    'Premium Gaming',
                    '450+ Mobile Games',
                    'Ruby Rewards Program',
                    'Secure Banking',
                    'Professional Support',
                    'High Roller Bonuses'
                ],
                'mobile_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$750',
                    'description' => 'Mobile welcome package up to $750',
                    'wagering' => '40x',
                    'code' => 'RUBY750'
                ],
                'app_store_links' => [
                    'ios' => 'https://apps.apple.com/app/ruby-fortune',
                    'android' => 'https://play.google.com/store/apps/details?id=com.rubyfortune'
                ],
                'qr_codes' => [
                    'ios' => '/images/qr/ruby-fortune-ios-qr.png',
                    'android' => '/images/qr/ruby-fortune-android-qr.png'
                ],
                'file_size' => [
                    'ios' => '78.9 MB',
                    'android' => '69.2 MB'
                ],
                'last_updated' => '2025-07-05',
                'version' => [
                    'ios' => '1.9.4',
                    'android' => '1.9.2'
                ],
                'company' => 'Palace Group',
                'license' => 'Malta Gaming Authority',
                'support_rating' => 4.4,
                'popularity_score' => 88
            ],
            'royal_vegas' => [
                'id' => 'royal_vegas',
                'name' => 'Royal Vegas',
                'casino_name' => 'Royal Vegas Casino',
                'description' => 'Royal treatment with exclusive mobile gaming experience',
                'icon' => '/images/apps/royal-vegas-icon.png',
                'screenshots' => [
                    '/images/apps/royal-vegas-screen1.jpg',
                    '/images/apps/royal-vegas-screen2.jpg',
                    '/images/apps/royal-vegas-screen3.jpg'
                ],
                'platforms' => ['ios', 'android'],
                'downloads' => 69000,
                'ratings' => [
                    'ios' => 4.3,
                    'android' => 4.1,
                    'average' => 4.2
                ],
                'reviews' => [
                    'total' => 4920,
                    'ios_count' => 2560,
                    'android_count' => 2360
                ],
                'features' => [
                    'Royal Treatment',
                    '400+ Casino Games',
                    'VIP Mobile Program',
                    'Loyalty Points',
                    'Fast Payouts',
                    'Premium Support'
                ],
                'mobile_bonus' => [
                    'type' => 'Package Bonus',
                    'amount' => '$1200',
                    'description' => 'Royal mobile welcome package up to $1200',
                    'wagering' => '35x',
                    'code' => 'ROYAL1200'
                ],
                'app_store_links' => [
                    'ios' => 'https://apps.apple.com/app/royal-vegas',
                    'android' => 'https://play.google.com/store/apps/details?id=com.royalvegas'
                ],
                'qr_codes' => [
                    'ios' => '/images/qr/royal-vegas-ios-qr.png',
                    'android' => '/images/qr/royal-vegas-android-qr.png'
                ],
                'file_size' => [
                    'ios' => '94.1 MB',
                    'android' => '81.7 MB'
                ],
                'last_updated' => '2025-07-03',
                'version' => [
                    'ios' => '2.1.8',
                    'android' => '2.1.6'
                ],
                'company' => 'Digimedia Ltd',
                'license' => 'Malta Gaming Authority',
                'support_rating' => 4.3,
                'popularity_score' => 85
            ],
            'betway_casino' => [
                'id' => 'betway_casino',
                'name' => 'Betway Casino',
                'casino_name' => 'Betway Casino',
                'description' => 'World-class mobile casino with sports betting integration',
                'icon' => '/images/apps/betway-icon.png',
                'screenshots' => [
                    '/images/apps/betway-screen1.jpg',
                    '/images/apps/betway-screen2.jpg',
                    '/images/apps/betway-screen3.jpg'
                ],
                'platforms' => ['ios', 'android', 'pwa'],
                'downloads' => 145000,
                'ratings' => [
                    'ios' => 4.7,
                    'android' => 4.5,
                    'average' => 4.6
                ],
                'reviews' => [
                    'total' => 12890,
                    'ios_count' => 6200,
                    'android_count' => 6690
                ],
                'features' => [
                    'Casino & Sports Betting',
                    '800+ Games',
                    'Live Streaming',
                    'In-Play Betting',
                    'eCOGRA Certified',
                    'Award-Winning App'
                ],
                'mobile_bonus' => [
                    'type' => 'Welcome Bonus',
                    'amount' => '$1000',
                    'description' => 'Mobile casino welcome bonus up to $1000',
                    'wagering' => '30x',
                    'code' => 'BETWAY1000'
                ],
                'app_store_links' => [
                    'ios' => 'https://apps.apple.com/app/betway-casino',
                    'android' => 'https://play.google.com/store/apps/details?id=com.betway',
                    'pwa' => 'https://mobile.betway.com/'
                ],
                'qr_codes' => [
                    'ios' => '/images/qr/betway-ios-qr.png',
                    'android' => '/images/qr/betway-android-qr.png'
                ],
                'file_size' => [
                    'ios' => '124.6 MB',
                    'android' => '98.4 MB'
                ],
                'last_updated' => '2025-07-15',
                'version' => [
                    'ios' => '4.1.2',
                    'android' => '4.1.0'
                ],
                'company' => 'Betway Limited',
                'license' => 'Malta Gaming Authority',
                'support_rating' => 4.8,
                'popularity_score' => 97
            ],
            'leovegas' => [
                'id' => 'leovegas',
                'name' => 'LeoVegas',
                'casino_name' => 'LeoVegas Casino',
                'description' => 'King of mobile casino with award-winning mobile experience',
                'icon' => '/images/apps/leovegas-icon.png',
                'screenshots' => [
                    '/images/apps/leovegas-screen1.jpg',
                    '/images/apps/leovegas-screen2.jpg',
                    '/images/apps/leovegas-screen3.jpg'
                ],
                'platforms' => ['ios', 'android', 'pwa'],
                'downloads' => 167000,
                'ratings' => [
                    'ios' => 4.8,
                    'android' => 4.6,
                    'average' => 4.7
                ],
                'reviews' => [
                    'total' => 15670,
                    'ios_count' => 7890,
                    'android_count' => 7780
                ],
                'features' => [
                    'King of Mobile Casino',
                    '1000+ Games',
                    'Award-Winning Design',
                    'Live Casino Studio',
                    'Instant Play',
                    'VIP Leo Program'
                ],
                'mobile_bonus' => [
                    'type' => 'Welcome Package',
                    'amount' => '$1000 + 200 Spins',
                    'description' => 'Mobile welcome package with bonus and free spins',
                    'wagering' => '35x',
                    'code' => 'LEO1000'
                ],
                'app_store_links' => [
                    'ios' => 'https://apps.apple.com/app/leovegas',
                    'android' => 'https://play.google.com/store/apps/details?id=com.leovegas',
                    'pwa' => 'https://m.leovegas.com/'
                ],
                'qr_codes' => [
                    'ios' => '/images/qr/leovegas-ios-qr.png',
                    'android' => '/images/qr/leovegas-android-qr.png'
                ],
                'file_size' => [
                    'ios' => '134.8 MB',
                    'android' => '112.3 MB'
                ],
                'last_updated' => '2025-07-12',
                'version' => [
                    'ios' => '5.2.1',
                    'android' => '5.2.0'
                ],
                'company' => 'LeoVegas Gaming Ltd',
                'license' => 'Malta Gaming Authority',
                'support_rating' => 4.9,
                'popularity_score' => 98
            ],
            'casumo' => [
                'id' => 'casumo',
                'name' => 'Casumo',
                'casino_name' => 'Casumo Casino',
                'description' => 'Gamified mobile casino with adventure-based rewards',
                'icon' => '/images/apps/casumo-icon.png',
                'screenshots' => [
                    '/images/apps/casumo-screen1.jpg',
                    '/images/apps/casumo-screen2.jpg',
                    '/images/apps/casumo-screen3.jpg'
                ],
                'platforms' => ['ios', 'android'],
                'downloads' => 89000,
                'ratings' => [
                    'ios' => 4.5,
                    'android' => 4.3,
                    'average' => 4.4
                ],
                'reviews' => [
                    'total' => 6780,
                    'ios_count' => 3490,
                    'android_count' => 3290
                ],
                'features' => [
                    'Gamified Experience',
                    '700+ Games',
                    'Adventure Rewards',
                    'Trophies & Badges',
                    'Social Features',
                    'Unique Mobile UI'
                ],
                'mobile_bonus' => [
                    'type' => 'Adventure Bonus',
                    'amount' => '$500 + 100 Spins',
                    'description' => 'Mobile adventure bonus with rewards',
                    'wagering' => '30x',
                    'code' => 'ADVENTURE500'
                ],
                'app_store_links' => [
                    'ios' => 'https://apps.apple.com/app/casumo',
                    'android' => 'https://play.google.com/store/apps/details?id=com.casumo'
                ],
                'qr_codes' => [
                    'ios' => '/images/qr/casumo-ios-qr.png',
                    'android' => '/images/qr/casumo-android-qr.png'
                ],
                'file_size' => [
                    'ios' => '97.2 MB',
                    'android' => '84.6 MB'
                ],
                'last_updated' => '2025-07-01',
                'version' => [
                    'ios' => '3.7.4',
                    'android' => '3.7.2'
                ],
                'company' => 'Casumo Services Limited',
                'license' => 'Malta Gaming Authority',
                'support_rating' => 4.5,
                'popularity_score' => 91
            ],
            'playojo' => [
                'id' => 'playojo',
                'name' => 'PlayOJO',
                'casino_name' => 'PlayOJO Casino',
                'description' => 'Fair play mobile casino with no wagering requirements',
                'icon' => '/images/apps/playojo-icon.png',
                'screenshots' => [
                    '/images/apps/playojo-screen1.jpg',
                    '/images/apps/playojo-screen2.jpg',
                    '/images/apps/playojo-screen3.jpg'
                ],
                'platforms' => ['pwa'],
                'downloads' => 54000,
                'ratings' => [
                    'pwa' => 4.6,
                    'average' => 4.6
                ],
                'reviews' => [
                    'total' => 3240,
                    'pwa_count' => 3240
                ],
                'features' => [
                    'No Wagering Requirements',
                    '600+ Fair Games',
                    'OJOplus Rewards',
                    'Money Back Guarantee',
                    'Transparent Gaming',
                    'Progressive Web App'
                ],
                'mobile_bonus' => [
                    'type' => 'Money Back',
                    'amount' => 'Up to $200',
                    'description' => 'Money back on losses - no wagering required',
                    'wagering' => 'None',
                    'code' => 'FAIR200'
                ],
                'app_store_links' => [
                    'pwa' => 'https://m.playojo.com/'
                ],
                'file_size' => [
                    'pwa' => 'Browser-based'
                ],
                'last_updated' => '2025-07-06',
                'version' => [
                    'pwa' => '2.4.1'
                ],
                'company' => 'SkillOnNet Ltd',
                'license' => 'Malta Gaming Authority',
                'support_rating' => 4.7,
                'popularity_score' => 89
            ]
        ];
    }

    /**
     * Initialize app statistics
     */
    private function initializeAppStatistics(): void
    {
        $this->appStatistics = [
            'total_apps' => count($this->mobileApps),
            'total_downloads' => $this->getTotalDownloads(),
            'average_rating' => $this->calculateAverageRating(),
            'ios_apps' => count(array_filter($this->mobileApps, fn($app) => in_array('ios', $app['platforms']))),
            'android_apps' => count(array_filter($this->mobileApps, fn($app) => in_array('android', $app['platforms']))),
            'pwa_apps' => count(array_filter($this->mobileApps, fn($app) => in_array('pwa', $app['platforms']))),
            'bonus_apps' => count(array_filter($this->mobileApps, fn($app) => !empty($app['mobile_bonus'])))
        ];
    }

    /**
     * Get featured mobile apps for homepage display
     */
    public function getFeaturedMobileApps(): array
    {
        $allAppsData = $this->getMobileApps();
        $allApps = $allAppsData['apps'] ?? [];
        
        // Return top 6 featured apps
        return array_slice($allApps, 0, 6);
    }

    /**
     * Get mobile casino advantages
     */
    public function getMobileAdvantages(): array
    {
        return [
            [
                'icon' => 'fas fa-mobile-alt',
                'title' => 'Play Anywhere',
                'description' => 'Access your favorite casino games from anywhere in Canada with instant mobile connectivity.'
            ],
            [
                'icon' => 'fas fa-bolt',
                'title' => 'Instant Access',
                'description' => 'No downloads required for web apps. Start playing immediately with our optimized mobile experience.'
            ],
            [
                'icon' => 'fas fa-gift',
                'title' => 'Mobile-Only Bonuses',
                'description' => 'Exclusive bonuses and promotions available only to mobile players with special mobile codes.'
            ],
            [
                'icon' => 'fas fa-bell',
                'title' => 'Push Notifications',
                'description' => 'Never miss a bonus opportunity with real-time notifications for promotions and game updates.'
            ],
            [
                'icon' => 'fas fa-shield-alt',
                'title' => 'Enhanced Security',
                'description' => 'Biometric authentication and advanced mobile security features for safe gaming on the go.'
            ],
            [
                'icon' => 'fas fa-sync-alt',
                'title' => 'Seamless Sync',
                'description' => 'Your progress, bonuses, and preferences sync automatically across all your devices.'
            ]
        ];
    }

    /**
     * Get mobile statistics for homepage display
     */
    public function getMobileStats(): array
    {
        return [
            [
                'number' => '95%',
                'label' => 'Mobile Players'
            ],
            [
                'number' => '2.5s',
                'label' => 'Load Time'
            ],
            [
                'number' => '24/7',
                'label' => 'Mobile Support'
            ],
            [
                'number' => '50+',
                'label' => 'Mobile Bonuses'
            ]
        ];
    }

    /**
     * Calculate average rating across all apps
     */
    private function calculateAverageRating(): float
    {
        $totalRating = array_sum(array_column($this->mobileApps, 'ratings.average'));
        return round($totalRating / count($this->mobileApps), 1);
    }

    /**
     * Initialize mobile gaming advantages
     */
    private function initializeMobileAdvantages(): void
    {
        $this->mobileAdvantages = [
            'convenience' => [
                'title' => 'Play Anywhere, Anytime',
                'description' => 'Casino games in your pocket - play during commute, breaks, or anywhere you go',
                'icon' => 'fas fa-mobile-alt'
            ],
            'exclusive_bonuses' => [
                'title' => 'Mobile-Exclusive Bonuses',
                'description' => 'Special bonuses and promotions available only to mobile app users',
                'icon' => 'fas fa-gift'
            ],
            'push_notifications' => [
                'title' => 'Instant Notifications',
                'description' => 'Get alerts for new bonuses, jackpot wins, and game releases',
                'icon' => 'fas fa-bell'
            ],
            'touch_controls' => [
                'title' => 'Intuitive Touch Controls',
                'description' => 'Optimized for touch screens with swipe gestures and haptic feedback',
                'icon' => 'fas fa-hand-pointer'
            ],
            'faster_loading' => [
                'title' => 'Lightning Fast Loading',
                'description' => 'Native apps load faster than browser versions for seamless gaming',
                'icon' => 'fas fa-bolt'
            ],
            'offline_features' => [
                'title' => 'Offline Capabilities',
                'description' => 'Some features work offline including account management and game previews',
                'icon' => 'fas fa-wifi'
            ]
        ];
    }
}
