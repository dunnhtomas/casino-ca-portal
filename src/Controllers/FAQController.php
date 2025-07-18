<?php

namespace App\Controllers;

use App\Services\FAQService;

/**
 * FAQ Controller - FAQ Section & API Management
 * 
 * Handles FAQ section rendering, full FAQ page, search functionality,
 * and API endpoints for the comprehensive Q&A system.
 * 
 * @package App\Controllers
 * @version 1.0
 * @since 2025-07-18
 */
class FAQController
{
    private FAQService $faqService;

    public function __construct()
    {
        $this->faqService = new FAQService();
    }

    /**
     * Render FAQ section for homepage integration
     * 
     * @return string Rendered FAQ section HTML
     */
    public function section(): string
    {
        try {
            $featuredFAQs = $this->faqService->getFeaturedFAQs(4);
            $statistics = $this->faqService->getStatistics();
            
            ob_start();
            include __DIR__ . '/../Views/faq/section.php';
            return ob_get_clean();
        } catch (\Exception $e) {
            error_log("FAQ Section Error: " . $e->getMessage());
            return '<div class="faq-section-error">FAQ section temporarily unavailable</div>';
        }
    }

    /**
     * Render complete FAQ homepage section
     * 
     * @return string Rendered homepage FAQ section HTML
     */
    public function renderFAQSection(): string
    {
        return $this->section();
    }

    /**
     * Render full FAQ page with all questions and search functionality
     * 
     * @return string Complete FAQ page HTML
     */
    public function page(): string
    {
        try {
            $allFAQs = $this->faqService->getAllFAQs();
            $categories = $this->faqService->getCategories();
            $statistics = $this->faqService->getStatistics();
            $featuredFAQs = $this->faqService->getFeaturedFAQs();
            
            // Generate FAQ schema for SEO
            $faqSchema = $this->faqService->generateFAQSchema($featuredFAQs);
            
            ob_start();
            include __DIR__ . '/../Views/faq/page.php';
            return ob_get_clean();
        } catch (\Exception $e) {
            error_log("FAQ Page Error: " . $e->getMessage());
            return '<div class="error-message">FAQ page temporarily unavailable. Please try again later.</div>';
        }
    }

    /**
     * API endpoint for FAQ search functionality
     * 
     * @return void JSON response with search results
     */
    public function search(): void
    {
        header('Content-Type: application/json');
        
        try {
            $query = $_GET['q'] ?? '';
            $category = $_GET['category'] ?? '';
            
            if (!empty($category)) {
                $results = $this->faqService->getFAQsByCategory($category);
            } else {
                $results = $this->faqService->searchFAQs($query);
            }
            
            // Sort results by priority and featured status
            usort($results, function($a, $b) {
                // Featured FAQs first
                if ($a['featured'] && !$b['featured']) return -1;
                if (!$a['featured'] && $b['featured']) return 1;
                
                // Then by priority
                return $a['priority'] <=> $b['priority'];
            });
            
            $response = [
                'success' => true,
                'query' => $query,
                'category' => $category,
                'results' => $results,
                'total' => count($results),
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Search functionality temporarily unavailable',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * API endpoint for category filtering
     * 
     * @param string $category Category slug
     * @return void JSON response with category FAQs
     */
    public function category(): void
    {
        header('Content-Type: application/json');
        
        try {
            $pathParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
            $category = end($pathParts);
            
            $faqs = $this->faqService->getFAQsByCategory($category);
            $categories = $this->faqService->getCategories();
            
            // Find category info
            $categoryInfo = null;
            foreach ($categories as $cat) {
                if ($cat['slug'] === $category) {
                    $categoryInfo = $cat;
                    break;
                }
            }
            
            $response = [
                'success' => true,
                'category' => $categoryInfo,
                'faqs' => $faqs,
                'total' => count($faqs),
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Category data temporarily unavailable',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * API endpoint for related FAQs
     * 
     * @return void JSON response with related FAQs
     */
    public function related(): void
    {
        header('Content-Type: application/json');
        
        try {
            $pathParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
            $faqId = (int) $pathParts[array_search('faq', $pathParts) + 1] ?? 0;
            
            if ($faqId <= 0) {
                throw new \InvalidArgumentException('Invalid FAQ ID');
            }
            
            $currentFAQ = $this->faqService->getFAQById($faqId);
            $relatedFAQs = $this->faqService->getRelatedFAQs($faqId, 3);
            
            $response = [
                'success' => true,
                'faq_id' => $faqId,
                'current_faq' => $currentFAQ,
                'related_faqs' => $relatedFAQs,
                'total' => count($relatedFAQs),
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Invalid request or FAQ not found',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * API endpoint for FAQ categories
     * 
     * @return void JSON response with all categories
     */
    public function categories(): void
    {
        header('Content-Type: application/json');
        
        try {
            $categories = $this->faqService->getCategories();
            $statistics = $this->faqService->getStatistics();
            
            $response = [
                'success' => true,
                'categories' => $categories,
                'statistics' => $statistics,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Categories data temporarily unavailable',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * API endpoint for FAQ statistics and analytics
     * 
     * @return void JSON response with FAQ stats
     */
    public function stats(): void
    {
        header('Content-Type: application/json');
        
        try {
            $statistics = $this->faqService->getStatistics();
            $featuredFAQs = $this->faqService->getFeaturedFAQs();
            
            $response = [
                'success' => true,
                'statistics' => $statistics,
                'featured_count' => count($featuredFAQs),
                'featured_faqs' => array_map(function($faq) {
                    return [
                        'id' => $faq['id'],
                        'question' => $faq['question'],
                        'category' => $faq['category'],
                        'priority' => $faq['priority']
                    ];
                }, $featuredFAQs),
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Statistics temporarily unavailable',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Get FAQ by ID endpoint
     * 
     * @return void JSON response with specific FAQ
     */
    public function getFAQ(): void
    {
        header('Content-Type: application/json');
        
        try {
            $pathParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
            $faqId = (int) end($pathParts);
            
            if ($faqId <= 0) {
                throw new \InvalidArgumentException('Invalid FAQ ID');
            }
            
            $faq = $this->faqService->getFAQById($faqId);
            
            if (!$faq) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'error' => 'FAQ not found',
                    'faq_id' => $faqId,
                    'timestamp' => date('Y-m-d H:i:s')
                ]);
                return;
            }
            
            $relatedFAQs = $this->faqService->getRelatedFAQs($faqId, 3);
            
            $response = [
                'success' => true,
                'faq' => $faq,
                'related_faqs' => $relatedFAQs,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Invalid FAQ ID or request',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Generate FAQ schema markup for a specific set of FAQs
     * 
     * @param array $faqs Optional FAQ array, defaults to featured FAQs
     * @return string JSON-LD schema markup
     */
    public function generateSchemaMarkup(?array $faqs = null): string
    {
        try {
            if ($faqs === null) {
                $faqs = $this->faqService->getFeaturedFAQs();
            }
            
            $schema = $this->faqService->generateFAQSchema($faqs);
            
            return '<script type="application/ld+json">' . 
                   json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . 
                   '</script>';
        } catch (\Exception $e) {
            error_log("FAQ Schema Error: " . $e->getMessage());
            return '';
        }
    }
}
