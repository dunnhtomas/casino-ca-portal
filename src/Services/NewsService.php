<?php

namespace App\Services;

/**
 * News Service
 * Manages casino industry news, updates, and editorial content
 * 
 * PRD #14: News & Updates Section
 * Provides latest casino news, game releases, regulatory updates, and promotional announcements
 */
class NewsService
{
    private array $newsArticles;
    private array $newsCategories;
    private array $newsStatistics;

    public function __construct()
    {
        $this->initializeNewsContent();
        $this->initializeCategories();
        $this->initializeStatistics();
    }

    /**
     * Get featured news articles for homepage display
     */
    public function getFeaturedNews(): array
    {
        $featuredArticles = array_filter(
            $this->newsArticles,
            fn($article) => $article['priority'] === 'high' && $article['status'] === 'published'
        );

        // Sort by publication date and return top 6
        usort($featuredArticles, fn($a, $b) => strtotime($b['publication_date']) - strtotime($a['publication_date']));
        
        return array_slice($featuredArticles, 0, 6);
    }

    /**
     * Get news articles by category
     */
    public function getNewsByCategory(string $category): array
    {
        return array_filter(
            $this->newsArticles,
            fn($article) => $article['category'] === $category && $article['status'] === 'published'
        );
    }

    /**
     * Get latest updates across all categories
     */
    public function getLatestUpdates(): array
    {
        $publishedArticles = array_filter(
            $this->newsArticles,
            fn($article) => $article['status'] === 'published'
        );

        usort($publishedArticles, fn($a, $b) => strtotime($b['publication_date']) - strtotime($a['publication_date']));
        
        return array_slice($publishedArticles, 0, 12);
    }

    /**
     * Get promotional news and bonus announcements
     */
    public function getPromotionalNews(): array
    {
        return $this->getNewsByCategory('bonuses');
    }

    /**
     * Get game release announcements
     */
    public function getGameReleaseNews(): array
    {
        return $this->getNewsByCategory('game-releases');
    }

    /**
     * Get regulatory updates for Canadian market
     */
    public function getRegulatoryUpdates(): array
    {
        return $this->getNewsByCategory('regulations');
    }

    /**
     * Get news categories with article counts
     */
    public function getNewsCategories(): array
    {
        $categories = [];
        
        foreach ($this->newsCategories as $categoryId => $category) {
            $articleCount = count($this->getNewsByCategory($categoryId));
            $categories[] = [
                'id' => $categoryId,
                'name' => $category['name'],
                'icon' => $category['icon'],
                'description' => $category['description'],
                'article_count' => $articleCount
            ];
        }

        return $categories;
    }

    /**
     * Get news section statistics
     */
    public function getNewsStatistics(): array
    {
        return $this->newsStatistics;
    }

    /**
     * Search news articles by query
     */
    public function searchNews(string $query): array
    {
        $query = strtolower($query);
        
        return array_filter($this->newsArticles, function($article) use ($query) {
            return strpos(strtolower($article['title']), $query) !== false ||
                   strpos(strtolower($article['excerpt']), $query) !== false ||
                   in_array($query, array_map('strtolower', $article['tags']));
        });
    }

    /**
     * Get breaking news (urgent updates)
     */
    public function getBreakingNews(): array
    {
        return array_filter(
            $this->newsArticles,
            fn($article) => $article['priority'] === 'urgent' && $article['status'] === 'published'
        );
    }

    /**
     * Get trending articles based on engagement
     */
    public function getTrendingNews(): array
    {
        $publishedArticles = array_filter(
            $this->newsArticles,
            fn($article) => $article['status'] === 'published'
        );

        // Sort by engagement score (views + shares * 3 + comments * 5)
        usort($publishedArticles, function($a, $b) {
            $scoreA = $a['engagement']['views'] + ($a['engagement']['shares'] * 3) + ($a['engagement']['comments_count'] * 5);
            $scoreB = $b['engagement']['views'] + ($b['engagement']['shares'] * 3) + ($b['engagement']['comments_count'] * 5);
            return $scoreB - $scoreA;
        });

        return array_slice($publishedArticles, 0, 8);
    }

    /**
     * Get related articles for a specific article
     */
    public function getRelatedArticles(string $articleId, int $limit = 4): array
    {
        $currentArticle = $this->getArticleById($articleId);
        if (!$currentArticle) {
            return [];
        }

        $relatedArticles = array_filter($this->newsArticles, function($article) use ($currentArticle, $articleId) {
            if ($article['id'] === $articleId || $article['status'] !== 'published') {
                return false;
            }

            // Check for same category or shared tags
            return $article['category'] === $currentArticle['category'] ||
                   !empty(array_intersect($article['tags'], $currentArticle['tags']));
        });

        return array_slice($relatedArticles, 0, $limit);
    }

    /**
     * Get article by ID
     */
    public function getArticleById(string $articleId): ?array
    {
        foreach ($this->newsArticles as $article) {
            if ($article['id'] === $articleId) {
                return $article;
            }
        }
        return null;
    }

    /**
     * Get article by slug
     */
    public function getArticleBySlug(string $slug): ?array
    {
        foreach ($this->newsArticles as $article) {
            if ($article['slug'] === $slug) {
                return $article;
            }
        }
        return null;
    }

    /**
     * Initialize news content with comprehensive Canadian casino industry articles
     */
    private function initializeNewsContent(): void
    {
        $this->newsArticles = [
            [
                'id' => 'evolution-gaming-lightning-roulette-launch',
                'slug' => 'evolution-gaming-lightning-roulette-live-dealers-canada',
                'title' => 'Evolution Gaming Launches Lightning Roulette with Enhanced Live Dealers for Canadian Players',
                'excerpt' => 'Experience the electrifying new Lightning Roulette variant with multipliers up to 500x, now available at top Canadian online casinos with French and English speaking dealers.',
                'content' => 'Evolution Gaming has announced the launch of their revolutionary Lightning Roulette variant specifically tailored for the Canadian market...',
                'category' => 'game-releases',
                'featured_image' => '/images/news/lightning-roulette-canada.jpg',
                'author' => [
                    'name' => 'Sarah Mitchell',
                    'bio' => 'Live casino specialist with 8+ years covering Evolution Gaming releases',
                    'avatar' => '/images/authors/sarah-mitchell.jpg'
                ],
                'publication_date' => '2025-07-17',
                'last_updated' => '2025-07-17',
                'tags' => ['evolution gaming', 'live roulette', 'lightning roulette', 'canadian casinos'],
                'reading_time' => '4 min read',
                'related_casinos' => ['spin-casino', 'jackpot-city', 'royal-vegas'],
                'seo' => [
                    'meta_title' => 'Lightning Roulette Canada 2025 | Evolution Gaming Live Dealers',
                    'meta_description' => 'New Lightning Roulette with 500x multipliers now live at Canadian casinos. French & English dealers, exclusive bonuses for Canadian players.',
                    'keywords' => ['lightning roulette canada', 'evolution gaming', 'live casino', 'canadian dealers']
                ],
                'engagement' => [
                    'views' => 2847,
                    'shares' => 67,
                    'comments_count' => 23
                ],
                'priority' => 'high',
                'status' => 'published'
            ],
            [
                'id' => 'ontario-igaming-revenue-q2-2025',
                'slug' => 'ontario-igaming-revenue-reaches-record-q2-2025',
                'title' => 'Ontario iGaming Revenue Reaches Record $1.2 Billion in Q2 2025',
                'excerpt' => 'iGaming Ontario reports unprecedented growth with $1.2B in Q2 revenue, driven by increased mobile gaming adoption and new operator launches.',
                'content' => 'iGaming Ontario (iGO) has released their Q2 2025 financial results showing record-breaking revenue of $1.2 billion...',
                'category' => 'regulations',
                'featured_image' => '/images/news/ontario-igaming-revenue-q2.jpg',
                'author' => [
                    'name' => 'Michael Chen',
                    'bio' => 'Gaming industry analyst specializing in Canadian regulatory developments',
                    'avatar' => '/images/authors/michael-chen.jpg'
                ],
                'publication_date' => '2025-07-16',
                'last_updated' => '2025-07-17',
                'tags' => ['ontario', 'igaming', 'revenue', 'regulations', 'mobile gaming'],
                'reading_time' => '6 min read',
                'related_casinos' => ['betmgm-ontario', 'pointsbet-canada', 'bet365-ontario'],
                'seo' => [
                    'meta_title' => 'Ontario iGaming Revenue $1.2B Q2 2025 | Record Growth Report',
                    'meta_description' => 'Ontario breaks iGaming revenue records with $1.2B in Q2 2025. Analysis of mobile gaming growth and new operator performance.',
                    'keywords' => ['ontario igaming revenue', 'canada gambling statistics', 'igaming ontario report']
                ],
                'engagement' => [
                    'views' => 4321,
                    'shares' => 89,
                    'comments_count' => 34
                ],
                'priority' => 'high',
                'status' => 'published'
            ],
            [
                'id' => 'pragmatic-play-mega-wheel-exclusive-bonus',
                'slug' => 'pragmatic-play-mega-wheel-exclusive-canadian-bonus',
                'title' => 'Pragmatic Play Mega Wheel Launches with Exclusive 200% Canadian Welcome Bonus',
                'excerpt' => 'The exciting new Mega Wheel live game show from Pragmatic Play is now available with an exclusive 200% bonus up to $2,000 CAD for Canadian players.',
                'content' => 'Pragmatic Play has launched their latest live game show, Mega Wheel, featuring massive multipliers and interactive gameplay...',
                'category' => 'bonuses',
                'featured_image' => '/images/news/mega-wheel-bonus-canada.jpg',
                'author' => [
                    'name' => 'Emma Thompson',
                    'bio' => 'Bonus specialist tracking exclusive Canadian casino promotions',
                    'avatar' => '/images/authors/emma-thompson.jpg'
                ],
                'publication_date' => '2025-07-15',
                'last_updated' => '2025-07-16',
                'tags' => ['pragmatic play', 'mega wheel', 'live casino', 'bonus', 'canadian exclusive'],
                'reading_time' => '3 min read',
                'related_casinos' => ['spin-casino', 'casumo-canada', 'leoVegas-ontario'],
                'seo' => [
                    'meta_title' => 'Mega Wheel Canada Bonus 200% | Pragmatic Play Exclusive 2025',
                    'meta_description' => 'Get exclusive 200% bonus up to $2,000 CAD on new Mega Wheel live casino game. Available only at licensed Canadian casinos.',
                    'keywords' => ['mega wheel bonus canada', 'pragmatic play exclusive', 'live casino bonus']
                ],
                'engagement' => [
                    'views' => 1893,
                    'shares' => 45,
                    'comments_count' => 18
                ],
                'priority' => 'high',
                'status' => 'published'
            ],
            [
                'id' => 'microgaming-progressive-jackpot-network-update',
                'slug' => 'microgaming-progressive-jackpot-network-major-update-2025',
                'title' => 'Microgaming Unveils Major Progressive Jackpot Network Update with Enhanced Canadian Integration',
                'excerpt' => 'Microgaming announces significant upgrades to their progressive jackpot network, featuring improved CAD currency support and faster payouts for Canadian winners.',
                'content' => 'Microgaming has revealed comprehensive updates to their progressive jackpot network, specifically designed to enhance the experience for Canadian players...',
                'category' => 'industry',
                'featured_image' => '/images/news/microgaming-jackpot-network-2025.jpg',
                'author' => [
                    'name' => 'David Rodriguez',
                    'bio' => 'Gaming technology expert covering software provider innovations',
                    'avatar' => '/images/authors/david-rodriguez.jpg'
                ],
                'publication_date' => '2025-07-14',
                'last_updated' => '2025-07-15',
                'tags' => ['microgaming', 'progressive jackpots', 'network update', 'canadian integration'],
                'reading_time' => '5 min read',
                'related_casinos' => ['jackpot-city', 'spin-palace', 'ruby-fortune'],
                'seo' => [
                    'meta_title' => 'Microgaming Jackpot Network Update 2025 | Canadian CAD Support',
                    'meta_description' => 'Microgaming enhances progressive jackpot network with improved CAD support and faster Canadian payouts. Major update for 2025.',
                    'keywords' => ['microgaming jackpot update', 'progressive jackpots canada', 'cad currency casino']
                ],
                'engagement' => [
                    'views' => 2156,
                    'shares' => 52,
                    'comments_count' => 19
                ],
                'priority' => 'medium',
                'status' => 'published'
            ],
            [
                'id' => 'netent-gonzo-quest-megaways-mobile-optimization',
                'slug' => 'netent-gonzo-quest-megaways-mobile-optimization-canada',
                'title' => 'NetEnt Optimizes Gonzo\'s Quest Megaways for Mobile Gaming Across Canada',
                'excerpt' => 'NetEnt releases enhanced mobile version of popular Gonzo\'s Quest Megaways with improved touch controls and Canadian-specific features.',
                'content' => 'NetEnt has launched a significantly improved mobile version of their hit slot Gonzo\'s Quest Megaways, specifically optimized for Canadian mobile players...',
                'category' => 'game-releases',
                'featured_image' => '/images/news/gonzo-quest-mobile-canada.jpg',
                'author' => [
                    'name' => 'Lisa Wang',
                    'bio' => 'Mobile gaming specialist focusing on slot game innovations',
                    'avatar' => '/images/authors/lisa-wang.jpg'
                ],
                'publication_date' => '2025-07-13',
                'last_updated' => '2025-07-14',
                'tags' => ['netent', 'gonzo quest megaways', 'mobile optimization', 'canadian casinos'],
                'reading_time' => '4 min read',
                'related_casinos' => ['casumo-canada', 'mrgreen-ontario', 'betsson-canada'],
                'seo' => [
                    'meta_title' => 'Gonzo Quest Megaways Mobile Canada 2025 | NetEnt Optimization',
                    'meta_description' => 'Play optimized Gonzo Quest Megaways on mobile in Canada. Enhanced touch controls and Canadian-specific features from NetEnt.',
                    'keywords' => ['gonzo quest mobile canada', 'netent mobile slots', 'megaways mobile']
                ],
                'engagement' => [
                    'views' => 1678,
                    'shares' => 31,
                    'comments_count' => 12
                ],
                'priority' => 'medium',
                'status' => 'published'
            ],
            [
                'id' => 'crypto-gambling-regulations-canada-2025',
                'slug' => 'cryptocurrency-gambling-regulations-canada-update-2025',
                'title' => 'Canada Introduces New Cryptocurrency Gambling Regulations for Enhanced Player Protection',
                'excerpt' => 'Canadian government announces comprehensive cryptocurrency gambling regulations focusing on player safety, transaction transparency, and responsible gaming measures.',
                'content' => 'The Canadian government has unveiled new regulations governing cryptocurrency use in online gambling, marking a significant step toward comprehensive digital asset oversight...',
                'category' => 'regulations',
                'featured_image' => '/images/news/crypto-gambling-regulations-canada.jpg',
                'author' => [
                    'name' => 'Robert Kim',
                    'bio' => 'Cryptocurrency and gaming law expert covering Canadian regulatory developments',
                    'avatar' => '/images/authors/robert-kim.jpg'
                ],
                'publication_date' => '2025-07-12',
                'last_updated' => '2025-07-13',
                'tags' => ['cryptocurrency', 'regulations', 'canada', 'player protection', 'bitcoin gambling'],
                'reading_time' => '7 min read',
                'related_casinos' => ['bitcasino-canada', 'cloudbet-ontario', 'stake-canada'],
                'seo' => [
                    'meta_title' => 'Canada Crypto Gambling Regulations 2025 | New Player Protection Laws',
                    'meta_description' => 'New Canadian cryptocurrency gambling regulations enhance player protection and transaction transparency. Complete 2025 regulatory update.',
                    'keywords' => ['crypto gambling canada regulations', 'bitcoin casino laws canada', 'cryptocurrency gambling rules']
                ],
                'engagement' => [
                    'views' => 3456,
                    'shares' => 78,
                    'comments_count' => 45
                ],
                'priority' => 'high',
                'status' => 'published'
            ]
        ];
    }

    /**
     * Initialize news categories
     */
    private function initializeCategories(): void
    {
        $this->newsCategories = [
            'game-releases' => [
                'name' => 'Game Releases',
                'icon' => 'fas fa-gamepad',
                'description' => 'Latest slot games, live casino additions, and new game launches'
            ],
            'bonuses' => [
                'name' => 'Bonuses & Promotions',
                'icon' => 'fas fa-gift',
                'description' => 'Exclusive bonuses, tournament announcements, and promotional offers'
            ],
            'regulations' => [
                'name' => 'Regulatory Updates',
                'icon' => 'fas fa-gavel',
                'description' => 'Canadian gaming law changes, licensing updates, and compliance news'
            ],
            'industry' => [
                'name' => 'Industry News',
                'icon' => 'fas fa-chart-line',
                'description' => 'Market trends, casino acquisitions, technology innovations, and analysis'
            ]
        ];
    }

    /**
     * Initialize news statistics
     */
    private function initializeStatistics(): void
    {
        $this->newsStatistics = [
            [
                'number' => '50+',
                'label' => 'Weekly Articles'
            ],
            [
                'number' => '24/7',
                'label' => 'News Coverage'
            ],
            [
                'number' => '1M+',
                'label' => 'Monthly Readers'
            ],
            [
                'number' => '4',
                'label' => 'Expert Writers'
            ]
        ];
    }
}
