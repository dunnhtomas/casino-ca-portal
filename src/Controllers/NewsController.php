<?php

namespace App\Controllers;

use App\Services\NewsService;

/**
 * News Controller
 * Handles news articles, updates, and editorial content display
 * 
 * PRD #14: News & Updates Section
 */
class NewsController
{
    private NewsService $newsService;

    public function __construct()
    {
        $this->newsService = new NewsService();
    }

    /**
     * Display all news articles
     */
    public function index(): string
    {
        $featuredNews = $this->newsService->getFeaturedNews();
        $latestUpdates = $this->newsService->getLatestUpdates();
        $newsCategories = $this->newsService->getNewsCategories();
        $breakingNews = $this->newsService->getBreakingNews();
        $trendingNews = $this->newsService->getTrendingNews();
        $newsStatistics = $this->newsService->getNewsStatistics();

        return $this->renderNewsIndex($featuredNews, $latestUpdates, $newsCategories, $breakingNews, $trendingNews, $newsStatistics);
    }

    /**
     * Display news by category
     */
    public function category(string $category): string
    {
        $categoryNews = $this->newsService->getNewsByCategory($category);
        $newsCategories = $this->newsService->getNewsCategories();

        return $this->renderCategoryNews($category, $categoryNews, $newsCategories);
    }

    /**
     * Display single news article
     */
    public function article(string $slug): string
    {
        $article = $this->newsService->getArticleBySlug($slug);
        
        if (!$article) {
            http_response_code(404);
            return $this->render404();
        }

        $relatedArticles = $this->newsService->getRelatedArticles($article['id'], 4);
        
        return $this->renderSingleArticle($article, $relatedArticles);
    }

    /**
     * Search news articles
     */
    public function search(): string
    {
        $query = $_GET['q'] ?? '';
        
        if (empty($query)) {
            return $this->renderSearchForm();
        }

        $searchResults = $this->newsService->searchNews($query);
        
        return $this->renderSearchResults($query, $searchResults);
    }

    /**
     * API endpoint for featured news (for homepage integration)
     */
    public function apiFeaturedNews(): void
    {
        header('Content-Type: application/json');
        
        $featuredNews = $this->newsService->getFeaturedNews();
        
        echo json_encode([
            'success' => true,
            'data' => $featuredNews,
            'count' => count($featuredNews)
        ]);
    }

    /**
     * API endpoint for latest updates
     */
    public function apiLatestUpdates(): void
    {
        header('Content-Type: application/json');
        
        $latestUpdates = $this->newsService->getLatestUpdates();
        
        echo json_encode([
            'success' => true,
            'data' => $latestUpdates,
            'count' => count($latestUpdates)
        ]);
    }

    /**
     * API endpoint for breaking news
     */
    public function apiBreakingNews(): void
    {
        header('Content-Type: application/json');
        
        $breakingNews = $this->newsService->getBreakingNews();
        
        echo json_encode([
            'success' => true,
            'data' => $breakingNews,
            'count' => count($breakingNews)
        ]);
    }

    /**
     * API endpoint for trending news
     */
    public function apiTrendingNews(): void
    {
        header('Content-Type: application/json');
        
        $trendingNews = $this->newsService->getTrendingNews();
        
        echo json_encode([
            'success' => true,
            'data' => $trendingNews,
            'count' => count($trendingNews)
        ]);
    }

    /**
     * Render news index page
     */
    private function renderNewsIndex(array $featuredNews, array $latestUpdates, array $newsCategories, array $breakingNews, array $trendingNews, array $newsStatistics): string
    {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Casino News & Updates | Best Casino Portal Canada</title>
            <meta name="description" content="Stay updated with the latest Canadian casino news, game releases, bonuses, and industry updates. Your trusted source for casino information.">
            <link rel="stylesheet" href="/css/news-updates.css">
            <link rel="stylesheet" href="/css/main.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <header class="header">
                <nav class="nav">
                    <div class="nav-container">
                        <a href="/" class="nav-logo">Best Casino Portal</a>
                        <ul class="nav-menu">
                            <li><a href="/">Home</a></li>
                            <li><a href="/casinos">Casinos</a></li>
                            <li><a href="/bonuses">Bonuses</a></li>
                            <li><a href="/games">Games</a></li>
                            <li><a href="/news" class="active">News</a></li>
                            <li><a href="/reviews">Reviews</a></li>
                        </ul>
                    </div>
                </nav>
            </header>

            <main class="main-content">
                ' . $this->renderBreakingNews($breakingNews) . '
                ' . $this->renderNewsHero($newsStatistics) . '
                ' . $this->renderFeaturedNewsSection($featuredNews) . '
                ' . $this->renderNewsCategoriesSection($newsCategories) . '
                ' . $this->renderTrendingNewsSection($trendingNews) . '
                ' . $this->renderLatestUpdatesSection($latestUpdates) . '
            </main>

            <footer class="footer">
                <div class="footer-content">
                    <p>&copy; 2025 Best Casino Portal. All rights reserved.</p>
                </div>
            </footer>
        </body>
        </html>';
    }

    /**
     * Render breaking news banner
     */
    private function renderBreakingNews(array $breakingNews): string
    {
        if (empty($breakingNews)) {
            return '';
        }

        $html = '<div class="breaking-news-banner">';
        $html .= '<div class="breaking-news-container">';
        $html .= '<span class="breaking-news-label"><i class="fas fa-exclamation-circle"></i> BREAKING</span>';
        $html .= '<div class="breaking-news-ticker">';
        
        foreach ($breakingNews as $news) {
            $html .= '<a href="/news/' . htmlspecialchars($news['slug']) . '" class="breaking-news-item">';
            $html .= htmlspecialchars($news['title']);
            $html .= '</a>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Render news hero section
     */
    private function renderNewsHero(array $newsStatistics): string
    {
        $html = '<section class="news-hero">';
        $html .= '<div class="container">';
        $html .= '<div class="news-hero-content">';
        $html .= '<h1>Canadian Casino News & Updates</h1>';
        $html .= '<p>Stay informed with the latest developments in the Canadian online casino industry. From new game releases to regulatory updates, we cover everything that matters to Canadian players.</p>';
        
        $html .= '<div class="news-statistics">';
        foreach ($newsStatistics as $stat) {
            $html .= '<div class="stat-item">';
            $html .= '<span class="stat-number">' . htmlspecialchars($stat['number']) . '</span>';
            $html .= '<span class="stat-label">' . htmlspecialchars($stat['label']) . '</span>';
            $html .= '</div>';
        }
        $html .= '</div>';
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</section>';

        return $html;
    }

    /**
     * Render featured news section
     */
    private function renderFeaturedNewsSection(array $featuredNews): string
    {
        $html = '<section class="featured-news-section">';
        $html .= '<div class="container">';
        $html .= '<div class="section-header">';
        $html .= '<h2>Featured Stories</h2>';
        $html .= '<p>Top stories handpicked by our editorial team</p>';
        $html .= '</div>';
        
        $html .= '<div class="featured-news-grid">';
        
        foreach ($featuredNews as $index => $article) {
            $isMajor = $index === 0;
            $cardClass = $isMajor ? 'featured-news-card major' : 'featured-news-card';
            
            $html .= '<article class="' . $cardClass . '">';
            $html .= '<div class="news-image">';
            $html .= '<img src="' . htmlspecialchars($article['featured_image']) . '" alt="' . htmlspecialchars($article['title']) . '">';
            $html .= '<span class="news-category">' . htmlspecialchars(ucwords(str_replace('-', ' ', $article['category']))) . '</span>';
            $html .= '</div>';
            
            $html .= '<div class="news-content">';
            $html .= '<h3><a href="/news/' . htmlspecialchars($article['slug']) . '">' . htmlspecialchars($article['title']) . '</a></h3>';
            $html .= '<p class="news-excerpt">' . htmlspecialchars($article['excerpt']) . '</p>';
            
            $html .= '<div class="news-meta">';
            $html .= '<div class="author-info">';
            $html .= '<img src="' . htmlspecialchars($article['author']['avatar']) . '" alt="' . htmlspecialchars($article['author']['name']) . '">';
            $html .= '<span>' . htmlspecialchars($article['author']['name']) . '</span>';
            $html .= '</div>';
            $html .= '<span class="news-date">' . date('M j, Y', strtotime($article['publication_date'])) . '</span>';
            $html .= '<span class="reading-time">' . htmlspecialchars($article['reading_time']) . '</span>';
            $html .= '</div>';
            
            $html .= '</div>';
            $html .= '</article>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</section>';

        return $html;
    }

    /**
     * Render news categories section
     */
    private function renderNewsCategoriesSection(array $newsCategories): string
    {
        $html = '<section class="news-categories-section">';
        $html .= '<div class="container">';
        $html .= '<div class="section-header">';
        $html .= '<h2>Browse by Category</h2>';
        $html .= '<p>Explore news articles organized by topic</p>';
        $html .= '</div>';
        
        $html .= '<div class="news-categories-grid">';
        
        foreach ($newsCategories as $category) {
            $html .= '<a href="/news/category/' . htmlspecialchars($category['id']) . '" class="news-category-card">';
            $html .= '<div class="category-icon">';
            $html .= '<i class="' . htmlspecialchars($category['icon']) . '"></i>';
            $html .= '</div>';
            $html .= '<h3>' . htmlspecialchars($category['name']) . '</h3>';
            $html .= '<p>' . htmlspecialchars($category['description']) . '</p>';
            $html .= '<span class="article-count">' . $category['article_count'] . ' articles</span>';
            $html .= '</a>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</section>';

        return $html;
    }

    /**
     * Render trending news section
     */
    private function renderTrendingNewsSection(array $trendingNews): string
    {
        $html = '<section class="trending-news-section">';
        $html .= '<div class="container">';
        $html .= '<div class="section-header">';
        $html .= '<h2><i class="fas fa-fire"></i> Trending Now</h2>';
        $html .= '<p>Most popular articles this week</p>';
        $html .= '</div>';
        
        $html .= '<div class="trending-news-grid">';
        
        foreach (array_slice($trendingNews, 0, 4) as $index => $article) {
            $html .= '<article class="trending-news-card">';
            $html .= '<div class="trending-rank">#' . ($index + 1) . '</div>';
            $html .= '<div class="news-image">';
            $html .= '<img src="' . htmlspecialchars($article['featured_image']) . '" alt="' . htmlspecialchars($article['title']) . '">';
            $html .= '</div>';
            $html .= '<div class="news-content">';
            $html .= '<h4><a href="/news/' . htmlspecialchars($article['slug']) . '">' . htmlspecialchars($article['title']) . '</a></h4>';
            $html .= '<div class="engagement-stats">';
            $html .= '<span><i class="fas fa-eye"></i> ' . number_format($article['engagement']['views']) . '</span>';
            $html .= '<span><i class="fas fa-share"></i> ' . $article['engagement']['shares'] . '</span>';
            $html .= '<span><i class="fas fa-comments"></i> ' . $article['engagement']['comments_count'] . '</span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</article>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</section>';

        return $html;
    }

    /**
     * Render latest updates section
     */
    private function renderLatestUpdatesSection(array $latestUpdates): string
    {
        $html = '<section class="latest-updates-section">';
        $html .= '<div class="container">';
        $html .= '<div class="section-header">';
        $html .= '<h2>Latest Updates</h2>';
        $html .= '<p>Stay current with our most recent articles</p>';
        $html .= '</div>';
        
        $html .= '<div class="latest-updates-grid">';
        
        foreach (array_slice($latestUpdates, 0, 8) as $article) {
            $html .= '<article class="update-card">';
            $html .= '<div class="news-image">';
            $html .= '<img src="' . htmlspecialchars($article['featured_image']) . '" alt="' . htmlspecialchars($article['title']) . '">';
            $html .= '<span class="news-category">' . htmlspecialchars(ucwords(str_replace('-', ' ', $article['category']))) . '</span>';
            $html .= '</div>';
            $html .= '<div class="news-content">';
            $html .= '<h4><a href="/news/' . htmlspecialchars($article['slug']) . '">' . htmlspecialchars($article['title']) . '</a></h4>';
            $html .= '<p class="news-excerpt">' . htmlspecialchars(substr($article['excerpt'], 0, 120)) . '...</p>';
            $html .= '<div class="news-meta">';
            $html .= '<span class="news-date">' . date('M j', strtotime($article['publication_date'])) . '</span>';
            $html .= '<span class="reading-time">' . htmlspecialchars($article['reading_time']) . '</span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</article>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</section>';

        return $html;
    }

    /**
     * Render single article page
     */
    private function renderSingleArticle(array $article, array $relatedArticles): string
    {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . htmlspecialchars($article['seo']['meta_title']) . '</title>
            <meta name="description" content="' . htmlspecialchars($article['seo']['meta_description']) . '">
            <link rel="stylesheet" href="/css/news-updates.css">
            <link rel="stylesheet" href="/css/main.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <header class="header">
                <nav class="nav">
                    <div class="nav-container">
                        <a href="/" class="nav-logo">Best Casino Portal</a>
                        <ul class="nav-menu">
                            <li><a href="/">Home</a></li>
                            <li><a href="/casinos">Casinos</a></li>
                            <li><a href="/bonuses">Bonuses</a></li>
                            <li><a href="/games">Games</a></li>
                            <li><a href="/news" class="active">News</a></li>
                            <li><a href="/reviews">Reviews</a></li>
                        </ul>
                    </div>
                </nav>
            </header>

            <main class="main-content">
                ' . $this->renderArticleContent($article) . '
                ' . $this->renderRelatedArticles($relatedArticles) . '
            </main>

            <footer class="footer">
                <div class="footer-content">
                    <p>&copy; 2025 Best Casino Portal. All rights reserved.</p>
                </div>
            </footer>
        </body>
        </html>';
    }

    /**
     * Render article content
     */
    private function renderArticleContent(array $article): string
    {
        $html = '<article class="single-article">';
        $html .= '<div class="container">';
        
        $html .= '<div class="article-header">';
        $html .= '<div class="breadcrumb">';
        $html .= '<a href="/">Home</a> > <a href="/news">News</a> > <span>' . htmlspecialchars($article['title']) . '</span>';
        $html .= '</div>';
        
        $html .= '<span class="article-category">' . htmlspecialchars(ucwords(str_replace('-', ' ', $article['category']))) . '</span>';
        $html .= '<h1>' . htmlspecialchars($article['title']) . '</h1>';
        
        $html .= '<div class="article-meta">';
        $html .= '<div class="author-info">';
        $html .= '<img src="' . htmlspecialchars($article['author']['avatar']) . '" alt="' . htmlspecialchars($article['author']['name']) . '">';
        $html .= '<div>';
        $html .= '<span class="author-name">' . htmlspecialchars($article['author']['name']) . '</span>';
        $html .= '<span class="author-bio">' . htmlspecialchars($article['author']['bio']) . '</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="article-details">';
        $html .= '<span class="publish-date">' . date('F j, Y', strtotime($article['publication_date'])) . '</span>';
        $html .= '<span class="reading-time">' . htmlspecialchars($article['reading_time']) . '</span>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div>';
        
        $html .= '<div class="article-image">';
        $html .= '<img src="' . htmlspecialchars($article['featured_image']) . '" alt="' . htmlspecialchars($article['title']) . '">';
        $html .= '</div>';
        
        $html .= '<div class="article-content">';
        $html .= '<p class="article-excerpt">' . htmlspecialchars($article['excerpt']) . '</p>';
        $html .= '<div class="article-body">' . nl2br(htmlspecialchars($article['content'])) . '</div>';
        $html .= '</div>';
        
        if (!empty($article['tags'])) {
            $html .= '<div class="article-tags">';
            $html .= '<span class="tags-label">Tags:</span>';
            foreach ($article['tags'] as $tag) {
                $html .= '<span class="tag">' . htmlspecialchars($tag) . '</span>';
            }
            $html .= '</div>';
        }
        
        $html .= '</div>';
        $html .= '</article>';

        return $html;
    }

    /**
     * Render related articles
     */
    private function renderRelatedArticles(array $relatedArticles): string
    {
        if (empty($relatedArticles)) {
            return '';
        }

        $html = '<section class="related-articles-section">';
        $html .= '<div class="container">';
        $html .= '<h3>Related Articles</h3>';
        $html .= '<div class="related-articles-grid">';
        
        foreach ($relatedArticles as $article) {
            $html .= '<article class="related-article-card">';
            $html .= '<div class="news-image">';
            $html .= '<img src="' . htmlspecialchars($article['featured_image']) . '" alt="' . htmlspecialchars($article['title']) . '">';
            $html .= '</div>';
            $html .= '<div class="news-content">';
            $html .= '<h4><a href="/news/' . htmlspecialchars($article['slug']) . '">' . htmlspecialchars($article['title']) . '</a></h4>';
            $html .= '<span class="news-date">' . date('M j, Y', strtotime($article['publication_date'])) . '</span>';
            $html .= '</div>';
            $html .= '</article>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</section>';

        return $html;
    }

    /**
     * Render category news page
     */
    private function renderCategoryNews(string $category, array $categoryNews, array $newsCategories): string
    {
        $categoryName = ucwords(str_replace('-', ' ', $category));
        
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . htmlspecialchars($categoryName) . ' News | Best Casino Portal Canada</title>
            <meta name="description" content="Latest ' . htmlspecialchars($categoryName) . ' news and updates from the Canadian casino industry.">
            <link rel="stylesheet" href="/css/news-updates.css">
            <link rel="stylesheet" href="/css/main.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <header class="header">
                <nav class="nav">
                    <div class="nav-container">
                        <a href="/" class="nav-logo">Best Casino Portal</a>
                        <ul class="nav-menu">
                            <li><a href="/">Home</a></li>
                            <li><a href="/casinos">Casinos</a></li>
                            <li><a href="/bonuses">Bonuses</a></li>
                            <li><a href="/games">Games</a></li>
                            <li><a href="/news" class="active">News</a></li>
                            <li><a href="/reviews">Reviews</a></li>
                        </ul>
                    </div>
                </nav>
            </header>

            <main class="main-content">
                <section class="category-news-section">
                    <div class="container">
                        <div class="breadcrumb">
                            <a href="/">Home</a> > <a href="/news">News</a> > <span>' . htmlspecialchars($categoryName) . '</span>
                        </div>
                        
                        <div class="category-header">
                            <h1>' . htmlspecialchars($categoryName) . ' News</h1>
                            <p>Latest updates and articles in ' . htmlspecialchars($categoryName) . '</p>
                        </div>
                        
                        ' . $this->renderNewsCategoriesNavigation($newsCategories, $category) . '
                        
                        <div class="category-articles-grid">
                            ' . $this->renderCategoryArticles($categoryNews) . '
                        </div>
                    </div>
                </section>
            </main>

            <footer class="footer">
                <div class="footer-content">
                    <p>&copy; 2025 Best Casino Portal. All rights reserved.</p>
                </div>
            </footer>
        </body>
        </html>';
    }

    /**
     * Render category navigation
     */
    private function renderNewsCategoriesNavigation(array $newsCategories, string $activeCategory): string
    {
        $html = '<div class="category-navigation">';
        $html .= '<a href="/news" class="category-nav-item">All News</a>';
        
        foreach ($newsCategories as $category) {
            $isActive = $category['id'] === $activeCategory ? ' active' : '';
            $html .= '<a href="/news/category/' . htmlspecialchars($category['id']) . '" class="category-nav-item' . $isActive . '">';
            $html .= '<i class="' . htmlspecialchars($category['icon']) . '"></i> ';
            $html .= htmlspecialchars($category['name']);
            $html .= '</a>';
        }
        
        $html .= '</div>';
        return $html;
    }

    /**
     * Render category articles
     */
    private function renderCategoryArticles(array $articles): string
    {
        if (empty($articles)) {
            return '<p class="no-articles">No articles found in this category.</p>';
        }

        $html = '';
        foreach ($articles as $article) {
            $html .= '<article class="category-article-card">';
            $html .= '<div class="news-image">';
            $html .= '<img src="' . htmlspecialchars($article['featured_image']) . '" alt="' . htmlspecialchars($article['title']) . '">';
            $html .= '</div>';
            $html .= '<div class="news-content">';
            $html .= '<h3><a href="/news/' . htmlspecialchars($article['slug']) . '">' . htmlspecialchars($article['title']) . '</a></h3>';
            $html .= '<p class="news-excerpt">' . htmlspecialchars($article['excerpt']) . '</p>';
            $html .= '<div class="news-meta">';
            $html .= '<div class="author-info">';
            $html .= '<img src="' . htmlspecialchars($article['author']['avatar']) . '" alt="' . htmlspecialchars($article['author']['name']) . '">';
            $html .= '<span>' . htmlspecialchars($article['author']['name']) . '</span>';
            $html .= '</div>';
            $html .= '<span class="news-date">' . date('M j, Y', strtotime($article['publication_date'])) . '</span>';
            $html .= '<span class="reading-time">' . htmlspecialchars($article['reading_time']) . '</span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</article>';
        }
        
        return $html;
    }

    /**
     * Render 404 error page
     */
    private function render404(): string
    {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Article Not Found | Best Casino Portal</title>
            <link rel="stylesheet" href="/css/main.css">
        </head>
        <body>
            <div class="error-page">
                <h1>404 - Article Not Found</h1>
                <p>The article you\'re looking for doesn\'t exist.</p>
                <a href="/news" class="btn">Back to News</a>
            </div>
        </body>
        </html>';
    }

    /**
     * Render search form
     */
    private function renderSearchForm(): string
    {
        return '
        <div class="search-form">
            <h2>Search News Articles</h2>
            <form method="GET">
                <input type="text" name="q" placeholder="Enter search terms..." required>
                <button type="submit">Search</button>
            </form>
        </div>';
    }

    /**
     * Render search results
     */
    private function renderSearchResults(string $query, array $results): string
    {
        $html = '<div class="search-results">';
        $html .= '<h2>Search Results for "' . htmlspecialchars($query) . '"</h2>';
        $html .= '<p>' . count($results) . ' articles found</p>';
        
        if (!empty($results)) {
            $html .= '<div class="search-results-grid">';
            foreach ($results as $article) {
                $html .= '<article class="search-result-card">';
                $html .= '<h3><a href="/news/' . htmlspecialchars($article['slug']) . '">' . htmlspecialchars($article['title']) . '</a></h3>';
                $html .= '<p>' . htmlspecialchars($article['excerpt']) . '</p>';
                $html .= '<span class="news-date">' . date('M j, Y', strtotime($article['publication_date'])) . '</span>';
                $html .= '</article>';
            }
            $html .= '</div>';
        } else {
            $html .= '<p>No articles found matching your search.</p>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}
