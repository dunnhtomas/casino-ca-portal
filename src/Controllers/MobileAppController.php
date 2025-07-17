<?php

namespace App\Controllers;

use App\Services\MobileAppService;

/**
 * Mobile App Controller
 * Handles mobile casino app display and API endpoints
 * 
 * PRD #13: Mobile App Section
 * Manages homepage integration and dedicated mobile app pages
 */
class MobileAppController
{
    private MobileAppService $mobileAppService;

    public function __construct()
    {
        $this->mobileAppService = new MobileAppService();
    }

    /**
     * Display mobile apps page
     */
    public function index(): string
    {
        $mobileData = $this->mobileAppService->getMobileApps();
        
        return $this->renderMobileAppsPage($mobileData);
    }

    /**
     * Get mobile apps data for API consumption
     */
    public function getApiData(): string
    {
        header('Content-Type: application/json');
        
        $mobileData = $this->mobileAppService->getMobileApps();
        
        return json_encode($mobileData, JSON_PRETTY_PRINT);
    }

    /**
     * Get mobile apps filtered by platform
     */
    public function getAppsByPlatform(string $platform): string
    {
        header('Content-Type: application/json');
        
        $platformData = $this->mobileAppService->getAppsByPlatform($platform);
        
        return json_encode($platformData, JSON_PRETTY_PRINT);
    }

    /**
     * Show individual mobile app details
     */
    public function showAppDetails(string $appId): string
    {
        $appDetails = $this->mobileAppService->getAppDetails($appId);
        
        if (!$appDetails) {
            http_response_code(404);
            return 'Mobile app not found';
        }
        
        return $this->renderAppDetailsPage($appDetails);
    }

    /**
     * Track app download (for analytics)
     */
    public function downloadApp(string $appId, string $platform): string
    {
        $appDetails = $this->mobileAppService->getAppDetails($appId);
        
        if (!$appDetails || !isset($appDetails['app_store_links'][$platform])) {
            http_response_code(404);
            return json_encode(['error' => 'App or platform not found']);
        }

        // Track download for analytics (implement your tracking logic here)
        $this->trackDownload($appId, $platform);
        
        // Return download URL
        return json_encode([
            'success' => true,
            'download_url' => $appDetails['app_store_links'][$platform],
            'app_name' => $appDetails['name'],
            'platform' => $platform
        ]);
    }

    /**
     * Get mobile app data for homepage integration
     */
    public function getHomepageData(): array
    {
        return $this->mobileAppService->getMobileApps();
    }

    /**
     * Track download for analytics
     */
    private function trackDownload(string $appId, string $platform): void
    {
        // Implement your analytics tracking here
        // For example: log to database, send to Google Analytics, etc.
        error_log("Mobile app download tracked: {$appId} on {$platform}");
    }

    /**
     * Render full mobile apps page
     */
    private function renderMobileAppsPage(array $mobileData): string
    {
        $apps = $mobileData['apps'];
        $statistics = $mobileData['statistics'];
        $platforms = $mobileData['platforms'];
        $advantages = $mobileData['mobile_advantages'];
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mobile Casino Apps - Best Casino Portal</title>
            <meta name="description" content="Download the best mobile casino apps for Canadian players. Featuring exclusive mobile bonuses, instant play, and award-winning mobile gaming experiences.">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <link rel="stylesheet" href="/css/mobile-app.css">
        </head>
        <body>
            <div class="container">
                <header class="mobile-app-header">
                    <h1>📱 Mobile Casino Apps</h1>
                    <p class="mobile-app-subtitle">
                        Download award-winning mobile casino apps designed for Canadian players. 
                        Enjoy exclusive mobile bonuses, instant play, and premium gaming on the go.
                    </p>
                    
                    <div class="mobile-app-stats">
                        <div class="mobile-stat-item">
                            <span class="mobile-stat-number"><?= $statistics['total_apps'] ?></span>
                            <span class="mobile-stat-label">Mobile Apps</span>
                        </div>
                        <div class="mobile-stat-item">
                            <span class="mobile-stat-number"><?= number_format($statistics['total_downloads']) ?></span>
                            <span class="mobile-stat-label">Total Downloads</span>
                        </div>
                        <div class="mobile-stat-item">
                            <span class="mobile-stat-number"><?= $statistics['average_rating'] ?></span>
                            <span class="mobile-stat-label">Avg Rating</span>
                        </div>
                        <div class="mobile-stat-item">
                            <span class="mobile-stat-number"><?= $statistics['bonus_apps'] ?></span>
                            <span class="mobile-stat-label">Bonus Apps</span>
                        </div>
                    </div>
                </header>

                <div class="platform-tabs">
                    <button class="platform-tab active" data-platform="all">All Platforms</button>
                    <button class="platform-tab" data-platform="ios">iOS Apps</button>
                    <button class="platform-tab" data-platform="android">Android Apps</button>
                    <button class="platform-tab" data-platform="pwa">Web Apps</button>
                </div>

                <div class="mobile-apps-grid">
                    <?php foreach ($apps as $app): ?>
                        <div class="mobile-app-card" data-platforms="<?= implode(',', $app['platforms']) ?>">
                            <div class="mobile-app-header">
                                <div class="app-icon">
                                    <img src="<?= $app['icon'] ?>" alt="<?= $app['name'] ?>" loading="lazy">
                                </div>
                                <div class="app-title-section">
                                    <h3 class="app-name"><?= $app['name'] ?></h3>
                                    <p class="app-company"><?= $app['company'] ?></p>
                                    <div class="app-rating">
                                        <div class="rating-stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?= $i <= floor($app['ratings']['average']) ? 'active' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="rating-score"><?= $app['ratings']['average'] ?></span>
                                        <span class="rating-count">(<?= number_format($app['reviews']['total']) ?>)</span>
                                    </div>
                                </div>
                                <div class="platform-badges">
                                    <?php foreach ($app['platforms'] as $platform): ?>
                                        <span class="platform-badge platform-<?= $platform ?>"><?= ucfirst($platform) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <div class="mobile-app-info">
                                <p class="app-description"><?= $app['description'] ?></p>
                                
                                <div class="app-details">
                                    <div class="detail-row">
                                        <span class="detail-label">Downloads:</span>
                                        <span class="detail-value"><?= number_format($app['downloads']) ?>+</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Size:</span>
                                        <span class="detail-value"><?= $app['file_size']['ios'] ?? $app['file_size']['android'] ?? 'Varies' ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Updated:</span>
                                        <span class="detail-value"><?= date('M d, Y', strtotime($app['last_updated'])) ?></span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Support:</span>
                                        <span class="detail-value rating-score"><?= $app['support_rating'] ?>/5</span>
                                    </div>
                                </div>
                                
                                <?php if (!empty($app['mobile_bonus'])): ?>
                                    <div class="mobile-bonus-highlight">
                                        <h4>📱 Mobile Exclusive Bonus</h4>
                                        <div class="bonus-amount"><?= $app['mobile_bonus']['amount'] ?></div>
                                        <div class="bonus-description"><?= $app['mobile_bonus']['description'] ?></div>
                                        <div class="bonus-code">Code: <?= $app['mobile_bonus']['code'] ?></div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="app-features">
                                    <h4>Key Features</h4>
                                    <ul class="features-list">
                                        <?php foreach (array_slice($app['features'], 0, 4) as $feature): ?>
                                            <li><i class="fas fa-check"></i> <?= $feature ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                
                                <div class="download-section">
                                    <div class="qr-codes">
                                        <?php foreach ($app['platforms'] as $platform): ?>
                                            <?php if (isset($app['qr_codes'][$platform])): ?>
                                                <div class="qr-code" data-platform="<?= $platform ?>">
                                                    <img src="<?= $app['qr_codes'][$platform] ?>" alt="<?= ucfirst($platform) ?> QR Code">
                                                    <span><?= ucfirst($platform) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <div class="download-buttons">
                                        <?php foreach ($app['platforms'] as $platform): ?>
                                            <a href="<?= $app['app_store_links'][$platform] ?>" 
                                               class="download-btn platform-<?= $platform ?>"
                                               onclick="trackDownload('<?= $app['id'] ?>', '<?= $platform ?>')">
                                                <i class="fab fa-<?= $platform === 'ios' ? 'apple' : ($platform === 'android' ? 'google-play' : 'chrome') ?>"></i>
                                                Download for <?= ucfirst($platform) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mobile-advantages-section">
                    <h2>Why Choose Mobile Casino Apps?</h2>
                    <div class="advantages-grid">
                        <?php foreach ($advantages as $advantage): ?>
                            <div class="advantage-item">
                                <div class="advantage-icon">
                                    <i class="<?= $advantage['icon'] ?>"></i>
                                </div>
                                <h3><?= $advantage['title'] ?></h3>
                                <p><?= $advantage['description'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <script>
                // Platform filtering functionality
                document.querySelectorAll('.platform-tab').forEach(tab => {
                    tab.addEventListener('click', function() {
                        const platform = this.dataset.platform;
                        
                        // Update active tab
                        document.querySelectorAll('.platform-tab').forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        
                        // Filter mobile apps
                        document.querySelectorAll('.mobile-app-card').forEach(card => {
                            const cardPlatforms = card.dataset.platforms.split(',');
                            if (platform === 'all' || cardPlatforms.includes(platform)) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });

                function trackDownload(appId, platform) {
                    // Send download tracking to analytics
                    fetch(`/api/mobile-apps/${appId}/download/${platform}`, {
                        method: 'POST'
                    }).catch(e => console.log('Analytics tracking failed:', e));
                }
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }

    /**
     * Render individual mobile app details page
     */
    private function renderAppDetailsPage(array $app): string
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= $app['name'] ?> Mobile App - Best Casino Portal</title>
            <meta name="description" content="Download <?= $app['name'] ?> mobile casino app. <?= $app['description'] ?> Available for iOS and Android.">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <link rel="stylesheet" href="/css/mobile-app.css">
        </head>
        <body>
            <div class="container">
                <div class="app-detail-page">
                    <header class="app-detail-header">
                        <div class="app-icon-large">
                            <img src="<?= $app['icon'] ?>" alt="<?= $app['name'] ?>">
                        </div>
                        <div class="app-title-section">
                            <h1><?= $app['name'] ?> Mobile App</h1>
                            <p class="app-description"><?= $app['description'] ?></p>
                            <div class="app-meta">
                                <span class="app-company"><?= $app['company'] ?></span>
                                <span class="app-license"><?= $app['license'] ?></span>
                            </div>
                        </div>
                        <div class="app-rating-large">
                            <div class="rating-score-large"><?= $app['ratings']['average'] ?></div>
                            <div class="rating-label">App Rating</div>
                            <div class="rating-reviews"><?= number_format($app['reviews']['total']) ?> reviews</div>
                        </div>
                    </header>

                    <div class="app-details-grid">
                        <div class="detail-section">
                            <h2>Screenshots</h2>
                            <div class="screenshots-gallery">
                                <?php foreach ($app['screenshots'] as $screenshot): ?>
                                    <img src="<?= $screenshot ?>" alt="<?= $app['name'] ?> Screenshot" loading="lazy">
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="detail-section">
                            <h2>Features & Benefits</h2>
                            <ul class="features-detailed">
                                <?php foreach ($app['features'] as $feature): ?>
                                    <li><?= $feature ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <?php if (!empty($app['mobile_bonus'])): ?>
                            <div class="detail-section">
                                <h2>Exclusive Mobile Bonus</h2>
                                <div class="bonus-details">
                                    <div class="bonus-amount"><?= $app['mobile_bonus']['amount'] ?></div>
                                    <div class="bonus-description"><?= $app['mobile_bonus']['description'] ?></div>
                                    <div class="bonus-terms">Wagering: <?= $app['mobile_bonus']['wagering'] ?></div>
                                    <div class="bonus-code">Bonus Code: <?= $app['mobile_bonus']['code'] ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}
