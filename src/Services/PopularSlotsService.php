<?php

namespace App\Services;

/**
 * Popular Slots Service
 * 
 * Manages popular slot games data, filtering, and recommendations
 * Provides comprehensive slot game information and casino integration
 * 
 * @author Sarah Chen, Mobile Gaming Expert & Slot Specialist
 */
class PopularSlotsService
{
    private $slots;
    private $providers;
    private $categories;

    public function __construct()
    {
        $this->initializeSlots();
        $this->initializeProviders();
        $this->initializeCategories();
    }

    /**
     * Get all popular slots with filtering options
     */
    public function getPopularSlots($filters = [], $limit = null)
    {
        $slots = $this->slots;

        // Apply filters
        if (!empty($filters)) {
            $slots = $this->applyFilters($slots, $filters);
        }

        // Sort by popularity by default
        usort($slots, function($a, $b) {
            return $b['popularity_score'] <=> $a['popularity_score'];
        });

        // Enrich with additional data
        $slots = array_map([$this, 'enrichSlotData'], $slots);

        return $limit ? array_slice($slots, 0, $limit) : $slots;
    }

    /**
     * Get specific slot by slug
     */
    public function getSlot($slug)
    {
        foreach ($this->slots as $slot) {
            if ($slot['slug'] === $slug) {
                return $this->enrichSlotData($slot);
            }
        }
        return null;
    }

    /**
     * Get slots by provider
     */
    public function getSlotsByProvider($providerId, $limit = 10)
    {
        $slots = array_filter($this->slots, function($slot) use ($providerId) {
            return $slot['provider_id'] === $providerId;
        });

        return array_slice(array_map([$this, 'enrichSlotData'], $slots), 0, $limit);
    }

    /**
     * Get slots by category
     */
    public function getSlotsByCategory($categoryId, $limit = 10)
    {
        $slots = array_filter($this->slots, function($slot) use ($categoryId) {
            return in_array($categoryId, $slot['category_ids']);
        });

        return array_slice(array_map([$this, 'enrichSlotData'], $slots), 0, $limit);
    }

    /**
     * Search slots by name or keywords
     */
    public function searchSlots($query, $limit = 20)
    {
        $query = strtolower($query);
        $slots = array_filter($this->slots, function($slot) use ($query) {
            return strpos(strtolower($slot['name']), $query) !== false ||
                   strpos(strtolower($slot['theme']), $query) !== false ||
                   strpos(strtolower($slot['description']), $query) !== false;
        });

        return array_slice(array_map([$this, 'enrichSlotData'], $slots), 0, $limit);
    }

    /**
     * Get popular slots section data for homepage
     */
    public function getPopularSlotsSection($limit = 24)
    {
        $popularSlots = $this->getPopularSlots([], $limit);
        $topProviders = $this->getTopProviders(6);
        
        return [
            'title' => 'Popular Casino Slots',
            'subtitle' => 'Discover the most exciting slot games from top providers',
            'slots' => $popularSlots,
            'providers' => $topProviders,
            'stats' => $this->getSlotsStats(),
            'categories' => $this->categories,
            'filters' => $this->getFilterOptions()
        ];
    }

    /**
     * Get top providers by slot count and popularity
     */
    public function getTopProviders($limit = 10)
    {
        $providerStats = [];
        
        foreach ($this->providers as $provider) {
            $slotCount = count(array_filter($this->slots, function($slot) use ($provider) {
                return $slot['provider_id'] === $provider['id'];
            }));
            
            $avgRating = $this->calculateProviderAvgRating($provider['id']);
            
            $providerStats[] = array_merge($provider, [
                'slot_count' => $slotCount,
                'avg_rating' => $avgRating,
                'popularity_score' => $slotCount * $avgRating
            ]);
        }

        usort($providerStats, function($a, $b) {
            return $b['popularity_score'] <=> $a['popularity_score'];
        });

        return array_slice($providerStats, 0, $limit);
    }

    /**
     * Get filter options for slot filtering
     */
    public function getFilterOptions()
    {
        return [
            'providers' => array_map(function($provider) {
                return [
                    'id' => $provider['id'],
                    'name' => $provider['name'],
                    'slot_count' => count(array_filter($this->slots, function($slot) use ($provider) {
                        return $slot['provider_id'] === $provider['id'];
                    }))
                ];
            }, $this->providers),
            'volatility' => [
                ['value' => 'low', 'label' => 'Low Volatility'],
                ['value' => 'medium', 'label' => 'Medium Volatility'],
                ['value' => 'high', 'label' => 'High Volatility']
            ],
            'rtp_ranges' => [
                ['value' => '95-96', 'label' => '95% - 96%'],
                ['value' => '96-97', 'label' => '96% - 97%'],
                ['value' => '97-98', 'label' => '97% - 98%'],
                ['value' => '98+', 'label' => '98%+']
            ],
            'max_win_ranges' => [
                ['value' => '1000-5000', 'label' => '1,000x - 5,000x'],
                ['value' => '5000-10000', 'label' => '5,000x - 10,000x'],
                ['value' => '10000-25000', 'label' => '10,000x - 25,000x'],
                ['value' => '25000+', 'label' => '25,000x+']
            ],
            'categories' => $this->categories
        ];
    }

    /**
     * Get slots statistics
     */
    public function getSlotsStats()
    {
        $totalSlots = count($this->slots);
        $avgRtp = round(array_sum(array_column($this->slots, 'rtp')) / $totalSlots, 2);
        $maxWinSlot = max(array_column($this->slots, 'max_win_multiplier'));
        
        return [
            'total_slots' => $totalSlots,
            'avg_rtp' => $avgRtp,
            'max_win_available' => $maxWinSlot,
            'provider_count' => count($this->providers),
            'category_count' => count($this->categories)
        ];
    }

    /**
     * Initialize slots database
     */
    private function initializeSlots()
    {
        $this->slots = [
            [
                'id' => 1,
                'name' => 'Gates of Olympus',
                'slug' => 'gates-of-olympus',
                'provider_id' => 1, // Pragmatic Play
                'theme' => 'Greek Mythology',
                'reels' => 6,
                'rows' => 5,
                'paylines' => 'Cluster Pays',
                'ways_to_win' => null,
                'rtp' => 96.50,
                'volatility' => 'high',
                'min_bet' => 0.20,
                'max_bet' => 125.00,
                'max_win_multiplier' => 5000,
                'features' => ['Multiplier Symbols', 'Free Spins', 'Tumble Feature', 'Ante Bet'],
                'description' => 'Journey to Mount Olympus in this high-volatility slot featuring Zeus and cascading reels.',
                'image' => '/images/slots/gates-of-olympus.jpg',
                'category_ids' => [1, 3], // Mythology, High Volatility
                'popularity_score' => 95,
                'release_date' => '2021-02-13',
                'mobile_optimized' => true
            ],
            [
                'id' => 2,
                'name' => 'Sweet Bonanza',
                'slug' => 'sweet-bonanza',
                'provider_id' => 1, // Pragmatic Play
                'theme' => 'Candy/Fruit',
                'reels' => 6,
                'rows' => 5,
                'paylines' => 'Cluster Pays',
                'ways_to_win' => null,
                'rtp' => 96.51,
                'volatility' => 'high',
                'min_bet' => 0.20,
                'max_bet' => 125.00,
                'max_win_multiplier' => 21100,
                'features' => ['Tumble Feature', 'Free Spins', 'Multiplier Bombs', 'Ante Bet'],
                'description' => 'Indulge in this candy-themed slot with massive win potential and multiplier features.',
                'image' => '/images/slots/sweet-bonanza.jpg',
                'category_ids' => [2, 3], // Fruit/Candy, High Volatility
                'popularity_score' => 92,
                'release_date' => '2019-06-27',
                'mobile_optimized' => true
            ],
            [
                'id' => 3,
                'name' => 'Book of Dead',
                'slug' => 'book-of-dead',
                'provider_id' => 2, // Play\'n GO
                'theme' => 'Ancient Egypt',
                'reels' => 5,
                'rows' => 3,
                'paylines' => 10,
                'ways_to_win' => null,
                'rtp' => 96.21,
                'volatility' => 'high',
                'min_bet' => 0.01,
                'max_bet' => 100.00,
                'max_win_multiplier' => 5000,
                'features' => ['Free Spins', 'Expanding Symbols', 'Gamble Feature'],
                'description' => 'Join Rich Wilde on an Egyptian adventure in this classic high-volatility slot.',
                'image' => '/images/slots/book-of-dead.jpg',
                'category_ids' => [4, 3], // Ancient Egypt, High Volatility
                'popularity_score' => 89,
                'release_date' => '2016-01-15',
                'mobile_optimized' => true
            ],
            [
                'id' => 4,
                'name' => 'Starburst',
                'slug' => 'starburst',
                'provider_id' => 3, // NetEnt
                'theme' => 'Space/Gems',
                'reels' => 5,
                'rows' => 3,
                'paylines' => 10,
                'ways_to_win' => null,
                'rtp' => 96.09,
                'volatility' => 'low',
                'min_bet' => 0.10,
                'max_bet' => 100.00,
                'max_win_multiplier' => 500,
                'features' => ['Expanding Wilds', 'Re-spins', 'Both Ways Pays'],
                'description' => 'Classic gem-themed slot with expanding wilds and frequent wins.',
                'image' => '/images/slots/starburst.jpg',
                'category_ids' => [5, 6], // Space/Gems, Low Volatility
                'popularity_score' => 87,
                'release_date' => '2012-11-01',
                'mobile_optimized' => true
            ],
            [
                'id' => 5,
                'name' => 'Gonzo\'s Quest',
                'slug' => 'gonzos-quest',
                'provider_id' => 3, // NetEnt
                'theme' => 'Adventure',
                'reels' => 5,
                'rows' => 3,
                'paylines' => 20,
                'ways_to_win' => null,
                'rtp' => 95.97,
                'volatility' => 'medium',
                'min_bet' => 0.20,
                'max_bet' => 50.00,
                'max_win_multiplier' => 2500,
                'features' => ['Avalanche Feature', 'Multiplier Trail', 'Free Falls'],
                'description' => 'Join Gonzo on his quest for gold with cascading reels and multipliers.',
                'image' => '/images/slots/gonzos-quest.jpg',
                'category_ids' => [7, 8], // Adventure, Medium Volatility
                'popularity_score' => 85,
                'release_date' => '2010-05-01',
                'mobile_optimized' => true
            ],
            [
                'id' => 6,
                'name' => 'The Dog House',
                'slug' => 'the-dog-house',
                'provider_id' => 1, // Pragmatic Play
                'theme' => 'Animals',
                'reels' => 5,
                'rows' => 3,
                'paylines' => 20,
                'ways_to_win' => null,
                'rtp' => 96.51,
                'volatility' => 'high',
                'min_bet' => 0.20,
                'max_bet' => 125.00,
                'max_win_multiplier' => 6750,
                'features' => ['Sticky Wilds', 'Free Spins', 'Wild Multipliers'],
                'description' => 'Cute dogs and big wins await in this charming high-volatility slot.',
                'image' => '/images/slots/the-dog-house.jpg',
                'category_ids' => [9, 3], // Animals, High Volatility
                'popularity_score' => 83,
                'release_date' => '2019-04-25',
                'mobile_optimized' => true
            ],
            [
                'id' => 7,
                'name' => 'Reactoonz',
                'slug' => 'reactoonz',
                'provider_id' => 2, // Play\'n GO
                'theme' => 'Aliens/Space',
                'reels' => 7,
                'rows' => 7,
                'paylines' => 'Cluster Pays',
                'ways_to_win' => null,
                'rtp' => 96.51,
                'volatility' => 'high',
                'min_bet' => 0.20,
                'max_bet' => 100.00,
                'max_win_multiplier' => 4570,
                'features' => ['Quantum Features', 'Instability', 'Gargantoon'],
                'description' => 'Alien creatures create explosive wins in this unique cluster-pays slot.',
                'image' => '/images/slots/reactoonz.jpg',
                'category_ids' => [5, 3], // Space/Aliens, High Volatility
                'popularity_score' => 81,
                'release_date' => '2017-10-01',
                'mobile_optimized' => true
            ],
            [
                'id' => 8,
                'name' => 'Mega Moolah',
                'slug' => 'mega-moolah',
                'provider_id' => 4, // Microgaming
                'theme' => 'African Safari',
                'reels' => 5,
                'rows' => 3,
                'paylines' => 25,
                'ways_to_win' => null,
                'rtp' => 88.12,
                'volatility' => 'medium',
                'min_bet' => 0.25,
                'max_bet' => 6.25,
                'max_win_multiplier' => 'Progressive',
                'features' => ['Progressive Jackpot', 'Free Spins', 'Multipliers'],
                'description' => 'The legendary progressive jackpot slot that has made millionaires.',
                'image' => '/images/slots/mega-moolah.jpg',
                'category_ids' => [10, 11], // Safari, Progressive Jackpot
                'popularity_score' => 79,
                'release_date' => '2006-11-01',
                'mobile_optimized' => true
            ],
            [
                'id' => 9,
                'name' => 'Dead or Alive 2',
                'slug' => 'dead-or-alive-2',
                'provider_id' => 3, // NetEnt
                'theme' => 'Western',
                'reels' => 5,
                'rows' => 3,
                'paylines' => 9,
                'ways_to_win' => null,
                'rtp' => 96.82,
                'volatility' => 'high',
                'min_bet' => 0.09,
                'max_bet' => 18.00,
                'max_win_multiplier' => 100000,
                'features' => ['Free Spins Variants', 'Sticky Wilds', 'High Volatility'],
                'description' => 'Extreme volatility Western slot with massive win potential.',
                'image' => '/images/slots/dead-or-alive-2.jpg',
                'category_ids' => [12, 3], // Western, High Volatility
                'popularity_score' => 77,
                'release_date' => '2019-05-22',
                'mobile_optimized' => true
            ],
            [
                'id' => 10,
                'name' => 'Wolf Gold',
                'slug' => 'wolf-gold',
                'provider_id' => 1, // Pragmatic Play
                'theme' => 'Wildlife',
                'reels' => 5,
                'rows' => 3,
                'paylines' => 25,
                'ways_to_win' => null,
                'rtp' => 96.01,
                'volatility' => 'medium',
                'min_bet' => 0.25,
                'max_bet' => 125.00,
                'max_win_multiplier' => 1000,
                'features' => ['Money Respin', 'Free Spins', 'Giant Symbols'],
                'description' => 'Majestic wolves and desert landscapes in this money respin slot.',
                'image' => '/images/slots/wolf-gold.jpg',
                'category_ids' => [9, 8], // Animals, Medium Volatility
                'popularity_score' => 75,
                'release_date' => '2017-04-01',
                'mobile_optimized' => true
            ]
        ];
    }

    /**
     * Initialize providers database
     */
    private function initializeProviders()
    {
        $this->providers = [
            [
                'id' => 1,
                'name' => 'Pragmatic Play',
                'slug' => 'pragmatic-play',
                'logo' => '/images/providers/pragmatic-play.png',
                'founded' => 2015,
                'description' => 'Leading multi-product provider with innovative slots and live casino games.',
                'website' => 'https://www.pragmaticplay.com',
                'licenses' => ['MGA', 'UKGC', 'SGA'],
                'specialties' => ['Video Slots', 'Live Casino', 'Mobile Gaming']
            ],
            [
                'id' => 2,
                'name' => 'Play\'n GO',
                'slug' => 'play-n-go',
                'logo' => '/images/providers/play-n-go.png',
                'founded' => 2005,
                'description' => 'Swedish developer known for high-quality slots and mobile optimization.',
                'website' => 'https://www.playngo.com',
                'licenses' => ['MGA', 'UKGC', 'DGA'],
                'specialties' => ['Video Slots', 'Mobile Games', 'Book Series']
            ],
            [
                'id' => 3,
                'name' => 'NetEnt',
                'slug' => 'netent',
                'logo' => '/images/providers/netent.png',
                'founded' => 1996,
                'description' => 'Pioneer in online casino gaming with premium slot games.',
                'website' => 'https://www.netent.com',
                'licenses' => ['MGA', 'UKGC', 'SGA'],
                'specialties' => ['Premium Slots', 'Live Casino', 'Branded Games']
            ],
            [
                'id' => 4,
                'name' => 'Microgaming',
                'slug' => 'microgaming',
                'logo' => '/images/providers/microgaming.png',
                'founded' => 1994,
                'description' => 'Industry veteran known for progressive jackpots and diverse game portfolio.',
                'website' => 'https://www.microgaming.co.uk',
                'licenses' => ['MGA', 'UKGC', 'KGC'],
                'specialties' => ['Progressive Jackpots', 'Classic Slots', 'Mega Series']
            ]
        ];
    }

    /**
     * Initialize categories database
     */
    private function initializeCategories()
    {
        $this->categories = [
            ['id' => 1, 'name' => 'Mythology', 'slug' => 'mythology'],
            ['id' => 2, 'name' => 'Fruit/Candy', 'slug' => 'fruit-candy'],
            ['id' => 3, 'name' => 'High Volatility', 'slug' => 'high-volatility'],
            ['id' => 4, 'name' => 'Ancient Egypt', 'slug' => 'ancient-egypt'],
            ['id' => 5, 'name' => 'Space/Aliens', 'slug' => 'space-aliens'],
            ['id' => 6, 'name' => 'Low Volatility', 'slug' => 'low-volatility'],
            ['id' => 7, 'name' => 'Adventure', 'slug' => 'adventure'],
            ['id' => 8, 'name' => 'Medium Volatility', 'slug' => 'medium-volatility'],
            ['id' => 9, 'name' => 'Animals', 'slug' => 'animals'],
            ['id' => 10, 'name' => 'Safari', 'slug' => 'safari'],
            ['id' => 11, 'name' => 'Progressive Jackpot', 'slug' => 'progressive-jackpot'],
            ['id' => 12, 'name' => 'Western', 'slug' => 'western']
        ];
    }

    /**
     * Apply filters to slots array
     */
    private function applyFilters($slots, $filters)
    {
        foreach ($filters as $filterType => $filterValue) {
            switch ($filterType) {
                case 'provider':
                    $slots = array_filter($slots, function($slot) use ($filterValue) {
                        return $slot['provider_id'] == $filterValue;
                    });
                    break;
                case 'volatility':
                    $slots = array_filter($slots, function($slot) use ($filterValue) {
                        return $slot['volatility'] === $filterValue;
                    });
                    break;
                case 'rtp_min':
                    $slots = array_filter($slots, function($slot) use ($filterValue) {
                        return $slot['rtp'] >= $filterValue;
                    });
                    break;
                case 'rtp_max':
                    $slots = array_filter($slots, function($slot) use ($filterValue) {
                        return $slot['rtp'] <= $filterValue;
                    });
                    break;
                case 'category':
                    $slots = array_filter($slots, function($slot) use ($filterValue) {
                        return in_array($filterValue, $slot['category_ids']);
                    });
                    break;
            }
        }
        
        return $slots;
    }

    /**
     * Enrich slot data with calculated values
     */
    private function enrichSlotData($slot)
    {
        $enriched = $slot;
        $enriched['provider'] = $this->getProviderById($slot['provider_id']);
        $enriched['categories'] = $this->getCategoriesByIds($slot['category_ids']);
        $enriched['volatility_label'] = ucfirst($slot['volatility']) . ' Volatility';
        $enriched['max_win_formatted'] = $this->formatMaxWin($slot['max_win_multiplier']);
        $enriched['rtp_formatted'] = $slot['rtp'] . '%';
        $enriched['rating'] = $this->calculateSlotRating($slot);
        
        return $enriched;
    }

    /**
     * Get provider by ID
     */
    private function getProviderById($providerId)
    {
        foreach ($this->providers as $provider) {
            if ($provider['id'] === $providerId) {
                return $provider;
            }
        }
        return null;
    }

    /**
     * Get categories by IDs
     */
    private function getCategoriesByIds($categoryIds)
    {
        return array_filter($this->categories, function($category) use ($categoryIds) {
            return in_array($category['id'], $categoryIds);
        });
    }

    /**
     * Format max win display
     */
    private function formatMaxWin($maxWin)
    {
        if ($maxWin === 'Progressive') {
            return 'Progressive Jackpot';
        }
        
        if ($maxWin >= 1000) {
            return number_format($maxWin / 1000, 0) . 'K';
        }
        
        return number_format($maxWin) . 'x';
    }

    /**
     * Calculate slot rating based on various factors
     */
    private function calculateSlotRating($slot)
    {
        $rating = 3.0; // Base rating
        
        // RTP bonus
        if ($slot['rtp'] >= 97) $rating += 1.0;
        elseif ($slot['rtp'] >= 96) $rating += 0.5;
        
        // Popularity bonus
        if ($slot['popularity_score'] >= 90) $rating += 1.0;
        elseif ($slot['popularity_score'] >= 80) $rating += 0.5;
        
        // Feature bonus
        if (count($slot['features']) >= 4) $rating += 0.5;
        
        return min(5.0, round($rating, 1));
    }

    /**
     * Calculate provider average rating
     */
    private function calculateProviderAvgRating($providerId)
    {
        $providerSlots = array_filter($this->slots, function($slot) use ($providerId) {
            return $slot['provider_id'] === $providerId;
        });
        
        if (empty($providerSlots)) return 0;
        
        $totalRating = array_sum(array_map([$this, 'calculateSlotRating'], $providerSlots));
        return round($totalRating / count($providerSlots), 1);
    }
}
