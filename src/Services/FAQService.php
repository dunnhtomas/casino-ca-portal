<?php

namespace App\Services;

/**
 * FAQ Service - Comprehensive Q&A Management for Casino Portal
 * 
 * Provides structured FAQ data for Canadian online casino portal,
 * covering legal, safety, bonus, and payment topics.
 * 
 * @package App\Services
 * @version 1.0
 * @since 2025-07-18
 */
class FAQService
{
    /**
     * Get all FAQ data with comprehensive Canadian casino information
     * 
     * @return array Complete FAQ dataset
     */
    public function getAllFAQs(): array
    {
        return [
            // Legal & Regulatory FAQs
            [
                'id' => 1,
                'category' => 'legal',
                'priority' => 1,
                'featured' => true,
                'question' => 'Is online gambling legal in Canada?',
                'answer' => 'Online gambling exists in a legal gray area in Canada. While it\'s not explicitly illegal for Canadians to play at offshore online casinos, each province regulates gambling differently. Most provinces allow residents to play at government-operated online casinos. However, gambling on offshore sites operates in an unregulated space. Always check your provincial laws and gamble responsibly.',
                'tags' => ['legal', 'regulation', 'provincial'],
                'related_sections' => ['legal-status', 'provinces'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 2,
                'category' => 'legal',
                'priority' => 2,
                'featured' => true,
                'question' => 'What is the legal gambling age in Canada?',
                'answer' => 'The legal gambling age varies by province. In Alberta, Manitoba, and Quebec, you must be 18 years old. In all other provinces and territories (British Columbia, Saskatchewan, Ontario, New Brunswick, Nova Scotia, Prince Edward Island, Newfoundland and Labrador, Northwest Territories, Nunavut, and Yukon), the legal age is 19. Always verify your provincial requirements before gambling.',
                'tags' => ['age', 'legal', 'provincial'],
                'related_sections' => ['provinces', 'legal-status'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 3,
                'category' => 'legal',
                'priority' => 3,
                'featured' => false,
                'question' => 'Are offshore casinos legal for Canadians?',
                'answer' => 'Offshore online casinos operate in a regulatory gray area for Canadian players. While there are no federal laws explicitly prohibiting Canadians from playing at international online casinos, these sites are not regulated by Canadian authorities. Players should exercise caution, ensure the casino is licensed by a reputable jurisdiction, and understand that player protections may be limited.',
                'tags' => ['offshore', 'regulation', 'international'],
                'related_sections' => ['legal-status', 'safety'],
                'last_updated' => '2025-07-18'
            ],

            // Safety & Security FAQs
            [
                'id' => 4,
                'category' => 'safety',
                'priority' => 1,
                'featured' => true,
                'question' => 'Are online casinos safe?',
                'answer' => 'Reputable online casinos employ multiple security measures to protect players, including SSL encryption, secure payment processing, and random number generators (RNGs) for fair play. Look for casinos licensed by respected authorities like the Malta Gaming Authority, UK Gambling Commission, or Curacao eGaming. Always check for proper licensing, read reviews, and verify the casino\'s security credentials before playing.',
                'tags' => ['safety', 'security', 'encryption', 'licensing'],
                'related_sections' => ['casino-reviews', 'methodology'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 5,
                'category' => 'safety',
                'priority' => 2,
                'featured' => false,
                'question' => 'How is my personal information protected?',
                'answer' => 'Legitimate online casinos use 128-bit or 256-bit SSL encryption to protect your personal and financial data during transmission. They also implement strict privacy policies, secure data storage systems, and comply with data protection regulations. Look for privacy policy links, SSL certificates (https://), and certifications from security auditing firms like eCOGRA or TST.',
                'tags' => ['privacy', 'data protection', 'ssl', 'encryption'],
                'related_sections' => ['safety', 'methodology'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 6,
                'category' => 'safety',
                'priority' => 3,
                'featured' => false,
                'question' => 'What if a casino doesn\'t pay out?',
                'answer' => 'If you encounter payout issues, first contact the casino\'s customer support with documentation of your issue. If unresolved, you can escalate to the casino\'s licensing authority or dispute resolution service. For casinos licensed by reputable authorities, regulatory bodies can investigate and mediate disputes. This is why choosing licensed casinos is crucial for player protection.',
                'tags' => ['disputes', 'payouts', 'licensing', 'support'],
                'related_sections' => ['problem-gambling', 'legal-status'],
                'last_updated' => '2025-07-18'
            ],

            // Bonuses & Promotions FAQs
            [
                'id' => 7,
                'category' => 'bonuses',
                'priority' => 1,
                'featured' => true,
                'question' => 'How do casino bonuses work?',
                'answer' => 'Casino bonuses are promotional offers that provide extra funds or free spins to players. Common types include welcome bonuses (matching your first deposit), no-deposit bonuses (free money to try the casino), and reload bonuses (for subsequent deposits). All bonuses come with terms and conditions, including wagering requirements that specify how many times you must play through the bonus before withdrawing winnings.',
                'tags' => ['bonuses', 'promotions', 'wagering', 'terms'],
                'related_sections' => ['bonus-database', 'bonus-types'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 8,
                'category' => 'bonuses',
                'priority' => 2,
                'featured' => false,
                'question' => 'What are wagering requirements?',
                'answer' => 'Wagering requirements (also called playthrough requirements) specify how many times you must bet your bonus amount before you can withdraw any winnings. For example, a $100 bonus with 30x wagering requires $3,000 in total bets. Different games contribute differently to wagering - slots usually count 100%, while table games may count 10-20%. Always read the terms before claiming any bonus.',
                'tags' => ['wagering', 'playthrough', 'requirements', 'terms'],
                'related_sections' => ['bonus-types', 'bonus-database'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 9,
                'category' => 'bonuses',
                'priority' => 3,
                'featured' => false,
                'question' => 'Can I withdraw bonus money immediately?',
                'answer' => 'No, you cannot withdraw bonus money immediately. All casino bonuses come with wagering requirements that must be completed before any withdrawal. Additionally, there are usually maximum withdrawal limits on bonus winnings, time limits to complete wagering, and game restrictions. Some bonuses also require you to make a minimum deposit before withdrawal is possible.',
                'tags' => ['withdrawal', 'restrictions', 'wagering', 'limits'],
                'related_sections' => ['bonus-types', 'payment-methods'],
                'last_updated' => '2025-07-18'
            ],

            // Banking & Payments FAQs
            [
                'id' => 10,
                'category' => 'banking',
                'priority' => 1,
                'featured' => false,
                'question' => 'What payment methods are accepted?',
                'answer' => 'Most online casinos accept a variety of payment methods including credit/debit cards (Visa, Mastercard), e-wallets (PayPal, Skrill, Neteller), bank transfers, prepaid cards (Paysafecard), and increasingly cryptocurrency (Bitcoin, Ethereum). Canadian players often have access to Interac e-Transfer, which is widely accepted and convenient for CAD transactions.',
                'tags' => ['payments', 'banking', 'interac', 'methods'],
                'related_sections' => ['payment-methods', 'casino-reviews'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 11,
                'category' => 'banking',
                'priority' => 2,
                'featured' => false,
                'question' => 'How long do withdrawals take?',
                'answer' => 'Withdrawal times vary by casino and payment method. E-wallets are typically fastest (24-48 hours), credit/debit cards take 3-5 business days, and bank transfers can take 3-7 business days. Some casinos offer instant withdrawals for VIP players or specific payment methods. Processing times also include the casino\'s internal review period, which can range from instant to 72 hours.',
                'tags' => ['withdrawals', 'processing', 'timeframes', 'methods'],
                'related_sections' => ['payment-methods', 'casino-reviews'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 12,
                'category' => 'banking',
                'priority' => 3,
                'featured' => false,
                'question' => 'Are there fees for deposits/withdrawals?',
                'answer' => 'Fee structures vary by casino and payment method. Many casinos offer free deposits and withdrawals, especially for e-wallets and cryptocurrency. Credit card deposits may incur cash advance fees from your bank. Some casinos charge withdrawal fees for certain methods or impose fees for multiple withdrawals within a short timeframe. Always check the casino\'s banking page for specific fee information.',
                'tags' => ['fees', 'costs', 'banking', 'charges'],
                'related_sections' => ['payment-methods', 'casino-reviews'],
                'last_updated' => '2025-07-18'
            ],

            // Games & Software FAQs
            [
                'id' => 13,
                'category' => 'games',
                'priority' => 1,
                'featured' => false,
                'question' => 'What games are available at online casinos?',
                'answer' => 'Online casinos offer a vast selection of games including slots (with various themes and features), table games (blackjack, roulette, baccarat, poker), live dealer games (real dealers via video stream), specialty games (scratch cards, bingo, keno), and video poker. Game libraries can range from hundreds to thousands of titles, provided by leading software developers like Microgaming, NetEnt, Playtech, and Evolution Gaming.',
                'tags' => ['games', 'slots', 'table games', 'live dealer'],
                'related_sections' => ['games-section', 'software-providers'],
                'last_updated' => '2025-07-18'
            ],
            [
                'id' => 14,
                'category' => 'games',
                'priority' => 2,
                'featured' => false,
                'question' => 'Can I play for free before betting real money?',
                'answer' => 'Yes, most online casinos offer demo or \'play for fun\' versions of their games (except live dealer games). These free versions let you experience the gameplay, features, and mechanics without risking real money. Demo play is perfect for learning new games, testing strategies, or simply enjoying casino games for entertainment. No registration is usually required for demo play.',
                'tags' => ['demo', 'free play', 'practice', 'no deposit'],
                'related_sections' => ['games-section', 'free-games'],
                'last_updated' => '2025-07-18'
            ],

            // Technical & Support FAQs
            [
                'id' => 15,
                'category' => 'support',
                'priority' => 1,
                'featured' => false,
                'question' => 'How do I contact customer support?',
                'answer' => 'Most online casinos offer multiple support channels including live chat (available 24/7 at top casinos), email support, phone support, and FAQ sections. Live chat is typically the fastest option for immediate assistance. Some casinos also offer support via social media. Look for casinos with responsive, knowledgeable support teams that can assist in your preferred language.',
                'tags' => ['support', 'contact', 'help', 'assistance'],
                'related_sections' => ['casino-reviews', 'methodology'],
                'last_updated' => '2025-07-18'
            ]
        ];
    }

    /**
     * Search FAQs based on query string
     * 
     * @param string $query Search query
     * @return array Matching FAQ results
     */
    public function searchFAQs(string $query): array
    {
        $allFAQs = $this->getAllFAQs();
        $query = strtolower(trim($query));
        
        if (empty($query)) {
            return $allFAQs;
        }

        return array_filter($allFAQs, function($faq) use ($query) {
            $searchableText = strtolower(
                $faq['question'] . ' ' . 
                $faq['answer'] . ' ' . 
                implode(' ', $faq['tags'])
            );
            
            return strpos($searchableText, $query) !== false;
        });
    }

    /**
     * Get FAQs by category
     * 
     * @param string $category Category slug
     * @return array Category-specific FAQs
     */
    public function getFAQsByCategory(string $category): array
    {
        $allFAQs = $this->getAllFAQs();
        
        return array_filter($allFAQs, function($faq) use ($category) {
            return $faq['category'] === $category;
        });
    }

    /**
     * Get FAQ by ID
     * 
     * @param int $id FAQ ID
     * @return array|null FAQ data or null if not found
     */
    public function getFAQById(int $id): ?array
    {
        $allFAQs = $this->getAllFAQs();
        
        foreach ($allFAQs as $faq) {
            if ($faq['id'] === $id) {
                return $faq;
            }
        }
        
        return null;
    }

    /**
     * Get featured FAQs for homepage
     * 
     * @param int $limit Number of featured FAQs to return
     * @return array Featured FAQ data
     */
    public function getFeaturedFAQs(int $limit = 4): array
    {
        $allFAQs = $this->getAllFAQs();
        
        $featured = array_filter($allFAQs, function($faq) {
            return $faq['featured'] === true;
        });
        
        // Sort by priority
        usort($featured, function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });
        
        return array_slice($featured, 0, $limit);
    }

    /**
     * Get related FAQs based on FAQ ID
     * 
     * @param int $faqId FAQ ID to find related questions for
     * @param int $limit Number of related FAQs to return
     * @return array Related FAQ data
     */
    public function getRelatedFAQs(int $faqId, int $limit = 3): array
    {
        $currentFAQ = $this->getFAQById($faqId);
        if (!$currentFAQ) {
            return [];
        }
        
        $allFAQs = $this->getAllFAQs();
        $related = [];
        
        foreach ($allFAQs as $faq) {
            if ($faq['id'] === $faqId) {
                continue; // Skip the current FAQ
            }
            
            // Calculate relevance score based on shared tags and category
            $relevanceScore = 0;
            
            // Same category gets high score
            if ($faq['category'] === $currentFAQ['category']) {
                $relevanceScore += 10;
            }
            
            // Shared tags get score
            $sharedTags = array_intersect($faq['tags'], $currentFAQ['tags']);
            $relevanceScore += count($sharedTags) * 3;
            
            // Shared related sections get score
            if (isset($faq['related_sections']) && isset($currentFAQ['related_sections'])) {
                $sharedSections = array_intersect($faq['related_sections'], $currentFAQ['related_sections']);
                $relevanceScore += count($sharedSections) * 2;
            }
            
            if ($relevanceScore > 0) {
                $faq['relevance_score'] = $relevanceScore;
                $related[] = $faq;
            }
        }
        
        // Sort by relevance score (highest first)
        usort($related, function($a, $b) {
            return $b['relevance_score'] <=> $a['relevance_score'];
        });
        
        return array_slice($related, 0, $limit);
    }

    /**
     * Get FAQ categories with counts
     * 
     * @return array Category data with FAQ counts
     */
    public function getCategories(): array
    {
        $allFAQs = $this->getAllFAQs();
        $categories = [];
        
        foreach ($allFAQs as $faq) {
            $category = $faq['category'];
            if (!isset($categories[$category])) {
                $categories[$category] = [
                    'slug' => $category,
                    'name' => $this->getCategoryName($category),
                    'description' => $this->getCategoryDescription($category),
                    'count' => 0
                ];
            }
            $categories[$category]['count']++;
        }
        
        return array_values($categories);
    }

    /**
     * Get FAQ statistics
     * 
     * @return array FAQ statistics
     */
    public function getStatistics(): array
    {
        $allFAQs = $this->getAllFAQs();
        $categories = $this->getCategories();
        
        return [
            'total_faqs' => count($allFAQs),
            'featured_faqs' => count(array_filter($allFAQs, function($faq) {
                return $faq['featured'] === true;
            })),
            'categories' => count($categories),
            'last_updated' => max(array_column($allFAQs, 'last_updated')),
            'category_breakdown' => $categories
        ];
    }

    /**
     * Get category display name
     * 
     * @param string $slug Category slug
     * @return string Category display name
     */
    private function getCategoryName(string $slug): string
    {
        $names = [
            'legal' => 'Legal & Regulatory',
            'safety' => 'Safety & Security',
            'bonuses' => 'Bonuses & Promotions',
            'banking' => 'Banking & Payments',
            'games' => 'Games & Software',
            'support' => 'Technical & Support'
        ];
        
        return $names[$slug] ?? ucfirst($slug);
    }

    /**
     * Get category description
     * 
     * @param string $slug Category slug
     * @return string Category description
     */
    private function getCategoryDescription(string $slug): string
    {
        $descriptions = [
            'legal' => 'Questions about gambling laws, regulations, and legal compliance in Canada',
            'safety' => 'Information about casino security, player protection, and safe gambling practices',
            'bonuses' => 'Details about casino promotions, bonus terms, and wagering requirements',
            'banking' => 'Payment methods, withdrawal times, fees, and banking procedures',
            'games' => 'Game types, software providers, demo play, and gaming features',
            'support' => 'Customer service, technical assistance, and account management'
        ];
        
        return $descriptions[$slug] ?? 'General questions and information';
    }

    /**
     * Generate FAQ schema markup for SEO
     * 
     * @param array $faqs FAQ data to generate schema for
     * @return array Schema.org FAQ markup
     */
    public function generateFAQSchema(array $faqs): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];
        
        foreach ($faqs as $faq) {
            $schema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer']
                ]
            ];
        }
        
        return $schema;
    }
}
