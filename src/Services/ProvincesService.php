<?php

namespace App\Services;

use PDO;
use Exception;

class ProvincesService
{
    private $db;

    public function __construct(?PDO $database = null)
    {
        $this->db = $database;
    }

    /**
     * Get all Canadian provinces and territories
     * @return array
     */
    public function getAllProvinces(): array
    {
        // Static data for Canadian provinces and territories
        return [
            [
                'id' => 1,
                'name' => 'Ontario',
                'code' => 'ON',
                'type' => 'province',
                'gambling_age' => 19,
                'population' => 15000000,
                'casino_count' => 45,
                'legal_status' => 'Fully regulated through iGaming Ontario (iGO)',
                'top_casino' => 'Jackpot City',
                'top_casino_rating' => 4.7,
                'capital' => 'Toronto',
                'region' => 'Central Canada'
            ],
            [
                'id' => 2,
                'name' => 'Quebec',
                'code' => 'QC',
                'type' => 'province',
                'gambling_age' => 18,
                'population' => 8600000,
                'casino_count' => 32,
                'legal_status' => 'Regulated by Loto-Quebec',
                'top_casino' => 'Spin Palace',
                'top_casino_rating' => 4.6,
                'capital' => 'Quebec City',
                'region' => 'Central Canada'
            ],
            [
                'id' => 3,
                'name' => 'British Columbia',
                'code' => 'BC',
                'type' => 'province',
                'gambling_age' => 19,
                'population' => 5200000,
                'casino_count' => 28,
                'legal_status' => 'Regulated by British Columbia Lottery Corporation',
                'top_casino' => 'Ruby Fortune',
                'top_casino_rating' => 4.5,
                'capital' => 'Victoria',
                'region' => 'Western Canada'
            ],
            [
                'id' => 4,
                'name' => 'Alberta',
                'code' => 'AB',
                'type' => 'province',
                'gambling_age' => 18,
                'population' => 4500000,
                'casino_count' => 24,
                'legal_status' => 'Regulated by Alberta Gaming, Liquor and Cannabis',
                'top_casino' => 'Betway Casino',
                'top_casino_rating' => 4.4,
                'capital' => 'Edmonton',
                'region' => 'Western Canada'
            ],
            [
                'id' => 5,
                'name' => 'Manitoba',
                'code' => 'MB',
                'type' => 'province',
                'gambling_age' => 18,
                'population' => 1400000,
                'casino_count' => 18,
                'legal_status' => 'Regulated by Manitoba Liquor & Lotteries',
                'top_casino' => 'LeoVegas',
                'top_casino_rating' => 4.3,
                'capital' => 'Winnipeg',
                'region' => 'Central Canada'
            ],
            [
                'id' => 6,
                'name' => 'Saskatchewan',
                'code' => 'SK',
                'type' => 'province',
                'gambling_age' => 19,
                'population' => 1200000,
                'casino_count' => 15,
                'legal_status' => 'Regulated by Saskatchewan Liquor and Gaming Authority',
                'top_casino' => 'Royal Vegas',
                'top_casino_rating' => 4.2,
                'capital' => 'Regina',
                'region' => 'Central Canada'
            ],
            [
                'id' => 7,
                'name' => 'Nova Scotia',
                'code' => 'NS',
                'type' => 'province',
                'gambling_age' => 19,
                'population' => 1000000,
                'casino_count' => 12,
                'legal_status' => 'Regulated by Nova Scotia Provincial Lotteries and Casino Corporation',
                'top_casino' => 'Captain Cooks',
                'top_casino_rating' => 4.1,
                'capital' => 'Halifax',
                'region' => 'Atlantic Canada'
            ],
            [
                'id' => 8,
                'name' => 'New Brunswick',
                'code' => 'NB',
                'type' => 'province',
                'gambling_age' => 19,
                'population' => 800000,
                'casino_count' => 10,
                'legal_status' => 'Regulated by New Brunswick Lotteries and Gaming Corporation',
                'top_casino' => 'All Slots',
                'top_casino_rating' => 4.0,
                'capital' => 'Fredericton',
                'region' => 'Atlantic Canada'
            ],
            [
                'id' => 9,
                'name' => 'Newfoundland and Labrador',
                'code' => 'NL',
                'type' => 'province',
                'gambling_age' => 19,
                'population' => 520000,
                'casino_count' => 8,
                'legal_status' => 'Regulated by Atlantic Lottery Corporation',
                'top_casino' => 'Gaming Club',
                'top_casino_rating' => 3.9,
                'capital' => 'St. Johns',
                'region' => 'Atlantic Canada'
            ],
            [
                'id' => 10,
                'name' => 'Prince Edward Island',
                'code' => 'PE',
                'type' => 'province',
                'gambling_age' => 19,
                'population' => 170000,
                'casino_count' => 6,
                'legal_status' => 'Regulated by Atlantic Lottery Corporation',
                'top_casino' => 'Luxury Casino',
                'top_casino_rating' => 3.8,
                'capital' => 'Charlottetown',
                'region' => 'Atlantic Canada'
            ],
            [
                'id' => 11,
                'name' => 'Northwest Territories',
                'code' => 'NT',
                'type' => 'territory',
                'gambling_age' => 19,
                'population' => 45000,
                'casino_count' => 3,
                'legal_status' => 'Regulated by Government of Northwest Territories',
                'top_casino' => 'Zodiac Casino',
                'top_casino_rating' => 3.7,
                'capital' => 'Yellowknife',
                'region' => 'Northern Canada'
            ],
            [
                'id' => 12,
                'name' => 'Yukon',
                'code' => 'YT',
                'type' => 'territory',
                'gambling_age' => 19,
                'population' => 42000,
                'casino_count' => 2,
                'legal_status' => 'Regulated by Yukon Liquor Corporation',
                'top_casino' => 'Grand Mondial',
                'top_casino_rating' => 3.6,
                'capital' => 'Whitehorse',
                'region' => 'Northern Canada'
            ],
            [
                'id' => 13,
                'name' => 'Nunavut',
                'code' => 'NU',
                'type' => 'territory',
                'gambling_age' => 19,
                'population' => 40000,
                'casino_count' => 1,
                'legal_status' => 'Limited gambling regulation',
                'top_casino' => 'Golden Tiger',
                'top_casino_rating' => 3.5,
                'capital' => 'Iqaluit',
                'region' => 'Northern Canada'
            ]
        ];
    }

    /**
     * Get province by code
     * @param string $code
     * @return array|null
     */
    public function getProvinceByCode(string $code): ?array
    {
        $provinces = $this->getAllProvinces();
        foreach ($provinces as $province) {
            if (strtoupper($province['code']) === strtoupper($code)) {
                return $province;
            }
        }
        return null;
    }

    /**
     * Get provinces by type (province/territory)
     * @param string $type
     * @return array
     */
    public function getProvincesByType(string $type): array
    {
        $provinces = $this->getAllProvinces();
        return array_filter($provinces, function($province) use ($type) {
            return $province['type'] === $type;
        });
    }

    /**
     * Get provinces by region
     * @param string $region
     * @return array
     */
    public function getProvincesByRegion(string $region): array
    {
        $provinces = $this->getAllProvinces();
        return array_filter($provinces, function($province) use ($region) {
            return $province['region'] === $region;
        });
    }

    /**
     * Get province statistics summary
     * @return array
     */
    public function getProvinceStatistics(): array
    {
        $provinces = $this->getAllProvinces();
        
        $stats = [
            'total_provinces' => count(array_filter($provinces, fn($p) => $p['type'] === 'province')),
            'total_territories' => count(array_filter($provinces, fn($p) => $p['type'] === 'territory')),
            'total_population' => array_sum(array_column($provinces, 'population')),
            'total_casinos' => array_sum(array_column($provinces, 'casino_count')),
            'avg_gambling_age' => round(array_sum(array_column($provinces, 'gambling_age')) / count($provinces), 1),
            'regions' => array_unique(array_column($provinces, 'region'))
        ];

        return $stats;
    }

    /**
     * Get top provinces by casino count
     * @param int $limit
     * @return array
     */
    public function getTopProvincesByCasinoCount(int $limit = 5): array
    {
        $provinces = $this->getAllProvinces();
        usort($provinces, function($a, $b) {
            return $b['casino_count'] - $a['casino_count'];
        });
        
        return array_slice($provinces, 0, $limit);
    }

    /**
     * Get province regulations (simulated data)
     * @param int $provinceId
     * @return array
     */
    public function getProvinceRegulations(int $provinceId): array
    {
        $regulationsMap = [
            1 => [ // Ontario
                [
                    'type' => 'Licensing',
                    'description' => 'iGaming Ontario (iGO) licensing required for all operators',
                    'effective_date' => '2022-04-04',
                    'source_url' => 'https://igamingontario.ca/'
                ],
                [
                    'type' => 'Player Protection',
                    'description' => 'Mandatory responsible gambling measures and self-exclusion programs',
                    'effective_date' => '2022-04-04',
                    'source_url' => 'https://igamingontario.ca/responsible-gambling'
                ]
            ],
            2 => [ // Quebec
                [
                    'type' => 'Monopoly System',
                    'description' => 'Loto-Quebec has exclusive rights to online gambling in Quebec',
                    'effective_date' => '2010-12-10',
                    'source_url' => 'https://lotoquebec.com/'
                ]
            ]
        ];

        return $regulationsMap[$provinceId] ?? [];
    }

    /**
     * Get recommended casinos for a province
     * @param int $provinceId
     * @return array
     */
    public function getProvinceRecommendedCasinos(int $provinceId): array
    {
        // This would normally query the database
        // For now, returning sample data based on province
        $province = $this->getProvinceById($provinceId);
        if (!$province) {
            return [];
        }

        return [
            [
                'name' => $province['top_casino'],
                'rating' => $province['top_casino_rating'],
                'bonus' => '$1,600 Welcome Bonus',
                'games' => '500+',
                'license' => 'Malta Gaming Authority',
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'PayPal']
            ],
            [
                'name' => 'Secondary Casino',
                'rating' => $province['top_casino_rating'] - 0.2,
                'bonus' => '$1,000 Welcome Package',
                'games' => '400+',
                'license' => 'UK Gambling Commission',
                'payment_methods' => ['Visa', 'Mastercard', 'Neteller', 'Skrill']
            ]
        ];
    }

    /**
     * Get province by ID
     * @param int $id
     * @return array|null
     */
    private function getProvinceById(int $id): ?array
    {
        $provinces = $this->getAllProvinces();
        foreach ($provinces as $province) {
            if ($province['id'] === $id) {
                return $province;
            }
        }
        return null;
    }

    /**
     * Search provinces by name
     * @param string $query
     * @return array
     */
    public function searchProvinces(string $query): array
    {
        $provinces = $this->getAllProvinces();
        $query = strtolower($query);
        
        return array_filter($provinces, function($province) use ($query) {
            return strpos(strtolower($province['name']), $query) !== false ||
                   strpos(strtolower($province['code']), $query) !== false ||
                   strpos(strtolower($province['capital']), $query) !== false;
        });
    }

    /**
     * Get province legal information
     * @param int $provinceId
     * @return array
     */
    public function getProvinceLegalInfo(int $provinceId): array
    {
        $province = $this->getProvinceById($provinceId);
        if (!$province) {
            return [];
        }

        return [
            'gambling_age' => $province['gambling_age'],
            'legal_status' => $province['legal_status'],
            'regulatory_body' => $this->getRegulatoryBody($province['code']),
            'online_gambling_legal' => true,
            'sports_betting_legal' => true,
            'responsible_gambling_resources' => [
                'ConnexOntario' => 'https://www.connexontario.ca/',
                'Problem Gambling Helpline' => '1-888-230-3505',
                'Responsible Gambling Council' => 'https://www.responsiblegambling.org/'
            ]
        ];
    }

    /**
     * Get regulatory body for province
     * @param string $provinceCode
     * @return string
     */
    private function getRegulatoryBody(string $provinceCode): string
    {
        $regulatoryBodies = [
            'ON' => 'iGaming Ontario (iGO)',
            'QC' => 'Loto-Quebec',
            'BC' => 'British Columbia Lottery Corporation (BCLC)',
            'AB' => 'Alberta Gaming, Liquor and Cannabis (AGLC)',
            'MB' => 'Manitoba Liquor & Lotteries',
            'SK' => 'Saskatchewan Liquor and Gaming Authority (SLGA)',
            'NS' => 'Nova Scotia Provincial Lotteries and Casino Corporation',
            'NB' => 'New Brunswick Lotteries and Gaming Corporation',
            'NL' => 'Atlantic Lottery Corporation',
            'PE' => 'Atlantic Lottery Corporation',
            'NT' => 'Government of Northwest Territories',
            'YT' => 'Yukon Liquor Corporation',
            'NU' => 'Government of Nunavut'
        ];

        return $regulatoryBodies[strtoupper($provinceCode)] ?? 'Provincial Gaming Authority';
    }
}
