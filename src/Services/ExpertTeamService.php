<?php

namespace App\Services;

/**
 * Expert Team Service
 * 
 * Manages expert profiles, credentials, and casino recommendations
 * Provides comprehensive expert data for trust building and authority
 * 
 * @author Dr. Emily Rodriguez, Casino Expert Team Lead
 */
class ExpertTeamService
{
    private $experts;
    private $expertRecommendations;

    public function __construct()
    {
        $this->initializeExperts();
        $this->initializeExpertRecommendations();
    }

    /**
     * Get all expert profiles
     */
    public function getAllExperts()
    {
        return array_map([$this, 'enrichExpertData'], $this->experts);
    }

    /**
     * Get specific expert by ID
     */
    public function getExpert($expertId)
    {
        foreach ($this->experts as $expert) {
            if ($expert['id'] === $expertId) {
                return $this->enrichExpertData($expert);
            }
        }
        return null;
    }

    /**
     * Get expert recommendations for specific expert
     */
    public function getExpertRecommendations($expertId, $limit = 5)
    {
        $recommendations = isset($this->expertRecommendations[$expertId]) 
            ? $this->expertRecommendations[$expertId] 
            : [];

        return array_slice($recommendations, 0, $limit);
    }

    /**
     * Get all expert recommendations combined
     */
    public function getAllExpertRecommendations()
    {
        $allRecommendations = [];
        
        foreach ($this->expertRecommendations as $expertId => $recommendations) {
            $expert = $this->getExpert($expertId);
            if ($expert) {
                foreach ($recommendations as $recommendation) {
                    $recommendation['expert'] = $expert;
                    $allRecommendations[] = $recommendation;
                }
            }
        }

        return $allRecommendations;
    }

    /**
     * Get expert team section data for homepage
     */
    public function getExpertTeamSection()
    {
        $experts = $this->getAllExperts();
        $featuredRecommendations = [];

        // Get top recommendation from each expert
        foreach ($experts as $expert) {
            $recommendations = $this->getExpertRecommendations($expert['id'], 1);
            if (!empty($recommendations)) {
                $recommendation = $recommendations[0];
                $recommendation['expert'] = $expert;
                $featuredRecommendations[] = $recommendation;
            }
        }

        return [
            'title' => 'Our Casino Experts',
            'subtitle' => 'Meet the professional team evaluating Canada\'s best online casinos',
            'experts' => $experts,
            'featured_recommendations' => $featuredRecommendations,
            'trust_signals' => $this->getTrustSignals(),
            'methodology' => $this->getEvaluationMethodology()
        ];
    }

    /**
     * Get trust signals for credibility
     */
    public function getTrustSignals()
    {
        return [
            [
                'icon' => 'shield-check',
                'title' => '50+ Years Combined Experience',
                'description' => 'Our expert team brings decades of casino industry knowledge'
            ],
            [
                'icon' => 'award',
                'title' => 'Independent Reviews',
                'description' => 'Unbiased evaluations with no casino partnerships affecting ratings'
            ],
            [
                'icon' => 'users',
                'title' => 'Real Canadian Experts',
                'description' => 'Local professionals who understand Canadian gaming regulations'
            ],
            [
                'icon' => 'check-circle',
                'title' => '1000+ Casinos Reviewed',
                'description' => 'Comprehensive analysis of Canada\'s entire online casino market'
            ]
        ];
    }

    /**
     * Get evaluation methodology
     */
    public function getEvaluationMethodology()
    {
        return [
            'title' => 'Our Casino Evaluation Process',
            'steps' => [
                [
                    'step' => 1,
                    'title' => 'Licensing & Security',
                    'description' => 'Verify legitimate licenses and SSL encryption standards'
                ],
                [
                    'step' => 2,
                    'title' => 'Game Selection',
                    'description' => 'Evaluate game variety, software providers, and RTP rates'
                ],
                [
                    'step' => 3,
                    'title' => 'Banking Options',
                    'description' => 'Test deposit/withdrawal methods and processing times'
                ],
                [
                    'step' => 4,
                    'title' => 'Customer Support',
                    'description' => 'Assess response times and support quality across channels'
                ],
                [
                    'step' => 5,
                    'title' => 'Bonus Terms',
                    'description' => 'Analyze wagering requirements and bonus fairness'
                ]
            ]
        ];
    }

    /**
     * Initialize expert database
     */
    private function initializeExperts()
    {
        $this->experts = [
            [
                'id' => 1,
                'name' => 'Dr. Emily Rodriguez',
                'title' => 'Senior Casino Analyst',
                'slug' => 'dr-emily-rodriguez',
                'experience_years' => 12,
                'photo' => '/images/experts/emily-rodriguez.jpg',
                'bio_short' => 'PhD in Statistics with 12+ years analyzing casino algorithms and RTP rates.',
                'bio_long' => 'Dr. Emily Rodriguez holds a PhD in Applied Statistics from University of Toronto and has spent over 12 years analyzing casino gaming algorithms, RTP calculations, and player protection mechanisms. She previously worked as a consultant for the Ontario Gaming Commission and specializes in slot machine mathematics and bonus optimization strategies.',
                'specializations' => [
                    'Slot Machine Analysis',
                    'RTP Calculations', 
                    'Bonus Mathematics',
                    'Player Protection'
                ],
                'credentials' => [
                    'PhD Applied Statistics (University of Toronto)',
                    'Former Ontario Gaming Commission Consultant',
                    'Certified Gambling Risk Assessment Analyst',
                    'Member of Canadian Gaming Research Institute'
                ],
                'articles_count' => 127,
                'reviews_count' => 89,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/emily-rodriguez-casino',
                    'twitter' => 'https://twitter.com/EmilySlotExpert'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Marcus Thompson',
                'title' => 'Table Games Specialist',
                'slug' => 'marcus-thompson',
                'experience_years' => 15,
                'photo' => '/images/experts/marcus-thompson.jpg',
                'bio_short' => 'Former professional blackjack player with 15+ years in casino table game analysis.',
                'bio_long' => 'Marcus Thompson is a former professional blackjack player who transitioned into casino analysis after 8 years of competitive play. He holds certifications in multiple table game variants and has extensive experience evaluating live dealer platforms, game fairness, and dealer quality across Canadian online casinos.',
                'specializations' => [
                    'Table Game Strategy',
                    'Live Dealer Analysis',
                    'Blackjack Optimization',
                    'Game Fairness Testing'
                ],
                'credentials' => [
                    'Professional Blackjack Player (8 years)',
                    'Certified Table Games Dealer',
                    'Live Casino Platform Specialist',
                    'Gaming Mathematics Certification'
                ],
                'articles_count' => 94,
                'reviews_count' => 67,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/marcus-thompson-gaming'
                ]
            ],
            [
                'id' => 3,
                'name' => 'Sarah Chen',
                'title' => 'Mobile Gaming Expert',
                'slug' => 'sarah-chen',
                'experience_years' => 8,
                'photo' => '/images/experts/sarah-chen.jpg',
                'bio_short' => 'Mobile technology specialist focusing on casino app performance and user experience.',
                'bio_long' => 'Sarah Chen is a mobile technology specialist with 8 years of experience evaluating casino mobile platforms. She holds a degree in Computer Science from McGill University and specializes in mobile app performance, user interface design, and cross-platform compatibility for casino applications.',
                'specializations' => [
                    'Mobile App Analysis',
                    'User Experience Design',
                    'Cross-Platform Testing',
                    'Mobile Security'
                ],
                'credentials' => [
                    'Computer Science (McGill University)',
                    'Mobile App Development Certification',
                    'UX/UI Design Specialist',
                    'Mobile Security Expert'
                ],
                'articles_count' => 76,
                'reviews_count' => 52,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/sarah-chen-mobile',
                    'github' => 'https://github.com/sarah-chen-gaming'
                ]
            ],
            [
                'id' => 4,
                'name' => 'Robert MacLeod',
                'title' => 'Banking & Security Analyst',
                'slug' => 'robert-macleod',
                'experience_years' => 20,
                'photo' => '/images/experts/robert-macleod.jpg',
                'bio_short' => 'Former bank security director with 20+ years in financial services and casino banking.',
                'bio_long' => 'Robert MacLeod spent 15 years as a security director at Royal Bank of Canada before transitioning to casino industry analysis. He specializes in payment processing security, cryptocurrency integration, and financial compliance for online gaming platforms across Canada.',
                'specializations' => [
                    'Payment Security',
                    'Cryptocurrency Analysis',
                    'Financial Compliance',
                    'Fraud Prevention'
                ],
                'credentials' => [
                    'Former RBC Security Director (15 years)',
                    'Certified Information Security Manager',
                    'Financial Compliance Specialist',
                    'Cryptocurrency Security Expert'
                ],
                'articles_count' => 103,
                'reviews_count' => 71,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/robert-macleod-security'
                ]
            ],
            [
                'id' => 5,
                'name' => 'Jessica Park',
                'title' => 'Bonus & Promotions Specialist',
                'slug' => 'jessica-park',
                'experience_years' => 9,
                'photo' => '/images/experts/jessica-park.jpg',
                'bio_short' => 'Former casino marketing manager specializing in bonus terms and promotional value analysis.',
                'bio_long' => 'Jessica Park worked for 6 years in casino marketing before becoming an independent analyst. She specializes in bonus mathematics, promotional value calculations, and wagering requirement analysis. Her expertise helps players identify the most valuable casino offers in the Canadian market.',
                'specializations' => [
                    'Bonus Value Analysis',
                    'Promotional Terms',
                    'Wagering Requirements',
                    'Marketing Strategy'
                ],
                'credentials' => [
                    'Former Casino Marketing Manager (6 years)',
                    'Promotional Mathematics Certification',
                    'Digital Marketing Specialist',
                    'Canadian Gaming Regulations Expert'
                ],
                'articles_count' => 88,
                'reviews_count' => 64,
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/jessica-park-bonuses'
                ]
            ]
        ];
    }

    /**
     * Initialize expert recommendations
     */
    private function initializeExpertRecommendations()
    {
        $this->expertRecommendations = [
            1 => [ // Dr. Emily Rodriguez
                [
                    'casino_id' => 2,
                    'casino_name' => 'Royal Vegas',
                    'rating' => 4.8,
                    'reason' => 'Exceptional RTP rates and transparent slot mathematics',
                    'highlight' => 'Best for serious slot players who understand the math'
                ],
                [
                    'casino_id' => 1,
                    'casino_name' => 'Spin Casino',
                    'rating' => 4.6,
                    'reason' => 'Excellent game variety with verified RTP reporting',
                    'highlight' => 'Strong bonus terms with fair wagering requirements'
                ],
                [
                    'casino_id' => 4,
                    'casino_name' => 'Jackpot City',
                    'rating' => 4.5,
                    'reason' => 'Proven track record and reliable payout statistics',
                    'highlight' => 'Consistent performance across all game categories'
                ]
            ],
            2 => [ // Marcus Thompson
                [
                    'casino_id' => 6,
                    'casino_name' => 'FortuneJack',
                    'rating' => 4.9,
                    'reason' => 'Superior live dealer tables with professional dealers',
                    'highlight' => 'Best blackjack variants and table limits'
                ],
                [
                    'casino_id' => 2,
                    'casino_name' => 'Royal Vegas',
                    'rating' => 4.7,
                    'reason' => 'Excellent table game selection and fair dealing',
                    'highlight' => 'Professional live casino environment'
                ],
                [
                    'casino_id' => 8,
                    'casino_name' => 'LeoVegas',
                    'rating' => 4.6,
                    'reason' => 'High-quality live dealer experience',
                    'highlight' => 'Multiple camera angles and interactive features'
                ]
            ],
            3 => [ // Sarah Chen
                [
                    'casino_id' => 8,
                    'casino_name' => 'LeoVegas',
                    'rating' => 4.9,
                    'reason' => 'Award-winning mobile app with flawless performance',
                    'highlight' => 'Industry-leading mobile gaming experience'
                ],
                [
                    'casino_id' => 9,
                    'casino_name' => 'Casumo',
                    'rating' => 4.7,
                    'reason' => 'Innovative mobile interface and gamification',
                    'highlight' => 'Unique adventure-style mobile experience'
                ],
                [
                    'casino_id' => 1,
                    'casino_name' => 'Spin Casino',
                    'rating' => 4.5,
                    'reason' => 'Reliable cross-platform compatibility',
                    'highlight' => 'Consistent experience across all devices'
                ]
            ],
            4 => [ // Robert MacLeod
                [
                    'casino_id' => 10,
                    'casino_name' => 'Cloudbet',
                    'rating' => 4.8,
                    'reason' => 'Leading cryptocurrency security and payment options',
                    'highlight' => 'Bank-level security with crypto flexibility'
                ],
                [
                    'casino_id' => 3,
                    'casino_name' => 'BitStarz',
                    'rating' => 4.7,
                    'reason' => 'Excellent payment processing and security protocols',
                    'highlight' => 'Fast withdrawals with robust security'
                ],
                [
                    'casino_id' => 2,
                    'casino_name' => 'Royal Vegas',
                    'rating' => 4.6,
                    'reason' => 'Trusted banking methods with proven security',
                    'highlight' => 'Traditional banking with modern security'
                ]
            ],
            5 => [ // Jessica Park
                [
                    'casino_id' => 5,
                    'casino_name' => 'PlayOJO',
                    'rating' => 4.9,
                    'reason' => 'No wagering requirements and transparent bonus terms',
                    'highlight' => 'Most player-friendly bonus structure available'
                ],
                [
                    'casino_id' => 2,
                    'casino_name' => 'Royal Vegas',
                    'rating' => 4.6,
                    'reason' => 'Fair bonus terms with reasonable wagering requirements',
                    'highlight' => 'Balanced bonus offers with clear terms'
                ],
                [
                    'casino_id' => 7,
                    'casino_name' => 'Casino Gods',
                    'rating' => 4.5,
                    'reason' => 'Generous free spins with manageable requirements',
                    'highlight' => 'Excellent value on welcome bonus package'
                ]
            ]
        ];
    }

    /**
     * Enrich expert data with additional calculated fields
     */
    private function enrichExpertData($expert)
    {
        $enriched = $expert;
        $enriched['total_content'] = $expert['articles_count'] + $expert['reviews_count'];
        $enriched['profile_url'] = '/experts/' . $expert['slug'];
        $enriched['experience_level'] = $this->calculateExperienceLevel($expert['experience_years']);
        $enriched['recommendation_count'] = isset($this->expertRecommendations[$expert['id']]) 
            ? count($this->expertRecommendations[$expert['id']]) 
            : 0;
        
        return $enriched;
    }

    /**
     * Calculate experience level based on years
     */
    private function calculateExperienceLevel($years)
    {
        if ($years >= 15) return 'Senior Expert';
        if ($years >= 10) return 'Expert';
        if ($years >= 5) return 'Specialist';
        return 'Analyst';
    }
}
