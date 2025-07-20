<?php
namespace App\Services;

class LegalStatusService 
{
    public function getLegalStatusData()
    {
        return [
            'legal_overview' => [
                'status' => 'Legal',
                'primary_regulator' => 'iGaming Ontario (iGO)',
                'federal_oversight' => 'Alcohol and Gaming Commission of Ontario (AGCO)',
                'international_licenses' => ['MGA', 'UKGC', 'Curaçao', 'PGCB'],
                'last_updated' => '2025-01-15'
            ],
            'casino_statistics' => [
                'total_casinos' => 200,
                'licensed_operators' => 45,
                'local_casinos' => 106,
                'international_casinos' => 94,
                'min_deposit' => '$1-$10',
                'biggest_bonus' => '100% up to $20,000'
            ],
            'regulatory_authorities' => [
                'igo' => [
                    'name' => 'iGaming Ontario',
                    'established' => 2022,
                    'jurisdiction' => 'Ontario',
                    'license_types' => ['Operator License', 'Supplier License'],
                    'oversight' => 'Direct provincial regulation',
                    'website' => 'https://igamingontario.ca',
                    'description' => 'iGaming Ontario (iGO) is a subsidiary of the Alcohol and Gaming Commission of Ontario (AGCO) and is responsible for conducting and managing Internet gaming in Ontario.',
                    'canadian_relevance' => 'Primary regulator for Ontario online casinos'
                ],
                'agco' => [
                    'name' => 'Alcohol and Gaming Commission of Ontario',
                    'established' => 1998,
                    'jurisdiction' => 'Ontario',
                    'responsibilities' => ['Licensing', 'Compliance', 'Enforcement'],
                    'website' => 'https://agco.ca',
                    'description' => 'AGCO regulates the alcohol, gaming, and horse racing sectors in Ontario to ensure public interest and player protection.',
                    'canadian_relevance' => 'Provincial oversight and compliance authority'
                ],
                'mga' => [
                    'name' => 'Malta Gaming Authority',
                    'jurisdiction' => 'Malta (EU)',
                    'canadian_relevance' => 'International operators serving Canada',
                    'reputation' => 'Gold standard for online gambling regulation',
                    'license_verification' => 'https://www.mga.org.mt',
                    'description' => 'The Malta Gaming Authority is one of the most respected gaming regulators globally, providing comprehensive player protection.',
                    'website' => 'https://www.mga.org.mt'
                ],
                'ukgc' => [
                    'name' => 'UK Gambling Commission',
                    'jurisdiction' => 'United Kingdom',
                    'canadian_relevance' => 'Highest international gaming standard',
                    'reputation' => 'Strictest consumer protection',
                    'license_verification' => 'https://www.gamblingcommission.gov.uk',
                    'description' => 'The UK Gambling Commission sets the global standard for gambling regulation with the strictest consumer protection measures.',
                    'website' => 'https://www.gamblingcommission.gov.uk'
                ],
                'curacao' => [
                    'name' => 'Curaçao eGaming',
                    'jurisdiction' => 'Curaçao',
                    'canadian_relevance' => 'Many international operators serving Canada',
                    'reputation' => 'Established Caribbean jurisdiction',
                    'license_verification' => 'https://www.gaming-curacao.com',
                    'description' => 'Curaçao eGaming provides licensing for online gambling operators with a focus on international markets.',
                    'website' => 'https://www.gaming-curacao.com'
                ]
            ],
            'provincial_breakdown' => [
                'ontario' => [
                    'name' => 'Ontario',
                    'status' => 'Legal (Regulated)',
                    'age_requirement' => 19,
                    'regulator' => 'iGaming Ontario',
                    'local_operators' => 'Yes',
                    'international_access' => 'Yes (licensed only)',
                    'tax_implications' => 'No tax on casual winnings',
                    'population' => '14.8 million',
                    'key_legislation' => 'Gaming Control Act, 1992'
                ],
                'quebec' => [
                    'name' => 'Quebec',
                    'status' => 'Legal (Provincial)',
                    'age_requirement' => 18,
                    'regulator' => 'Loto-Québec',
                    'local_operators' => 'Espacejeux.com',
                    'international_access' => 'Available',
                    'tax_implications' => 'No tax on casual winnings',
                    'population' => '8.6 million',
                    'key_legislation' => 'Act respecting Loto-Québec'
                ],
                'alberta' => [
                    'name' => 'Alberta',
                    'status' => 'Legal',
                    'age_requirement' => 18,
                    'regulator' => 'Alberta Gaming, Liquor and Cannabis',
                    'local_operators' => 'PlayAlberta.ca',
                    'international_access' => 'Available',
                    'tax_implications' => 'No tax on casual winnings',
                    'population' => '4.4 million',
                    'key_legislation' => 'Gaming, Liquor and Cannabis Act'
                ],
                'british_columbia' => [
                    'name' => 'British Columbia',
                    'status' => 'Legal',
                    'age_requirement' => 19,
                    'regulator' => 'British Columbia Lottery Corporation',
                    'local_operators' => 'PlayNow.com',
                    'international_access' => 'Available',
                    'tax_implications' => 'No tax on casual winnings',
                    'population' => '5.2 million',
                    'key_legislation' => 'Gaming Control Act'
                ],
                'manitoba' => [
                    'name' => 'Manitoba',
                    'status' => 'Legal',
                    'age_requirement' => 18,
                    'regulator' => 'Liquor, Gaming and Cannabis Authority of Manitoba',
                    'local_operators' => 'Yes',
                    'international_access' => 'Available',
                    'tax_implications' => 'No tax on casual winnings',
                    'population' => '1.4 million',
                    'key_legislation' => 'Gaming Control Act'
                ]
            ],
            'payment_regulations' => [
                'interac' => [
                    'name' => 'Interac',
                    'status' => 'Fully legal',
                    'processing_time' => '24-48 hours',
                    'limits' => '$0.01 - $10,000',
                    'availability' => 'All Canadian banks',
                    'fees' => 'Usually free',
                    'security' => 'Bank-level encryption'
                ],
                'visa_mastercard' => [
                    'name' => 'Visa/Mastercard',
                    'status' => 'Legal (some restrictions)',
                    'processing_time' => '1-2 days',
                    'limits' => '$10 - $10,000',
                    'notes' => 'Some banks may block gambling transactions',
                    'fees' => 'Varies by bank',
                    'security' => '3D Secure verification'
                ],
                'cryptocurrency' => [
                    'name' => 'Cryptocurrency',
                    'status' => 'Legal',
                    'processing_time' => '1-24 hours',
                    'limits' => 'Varies by casino',
                    'notes' => 'Bitcoin, Ethereum widely accepted',
                    'fees' => 'Network fees apply',
                    'security' => 'Blockchain technology'
                ],
                'muchbetter' => [
                    'name' => 'MuchBetter',
                    'status' => 'Legal',
                    'processing_time' => 'Up to 24 hours',
                    'limits' => '$10 - $7,000',
                    'notes' => 'Digital wallet solution',
                    'fees' => 'Low transaction fees',
                    'security' => 'Touch/Face ID protection'
                ]
            ]
        ];
    }

    public function getGameStatistics()
    {
        return [
            'popular_games' => [
                'Majestic Bison',
                'Gates of Olympus',
                'Sweet Bonanza',
                'Book of Dead',
                'Starburst'
            ],
            'game_categories' => [
                'Slots' => 15000,
                'Live Casino' => 800,
                'Table Games' => 400,
                'Jackpots' => 200
            ],
            'total_games' => 16400
        ];
    }

    public function getProvinceRegulation($provinceCode)
    {
        $provinces = $this->getLegalStatusData()['provincial_breakdown'];
        
        return $provinces[$provinceCode] ?? null;
    }

    public function getLegalSummaryForHomepage()
    {
        return [
            'status' => 'Legal',
            'total_casinos' => 200,
            'authorities' => ['iGaming Ontario', 'MGA', 'Curaçao'],
            'local_casinos' => 106,
            'min_deposit' => '$1-$10',
            'payment_methods' => ['Interac', 'Visa', 'Mastercard', 'Crypto'],
            'popular_games' => ['Majestic Bison', 'Gates of Olympus'],
            'best_casino' => 'BonRush',
            'biggest_bonus' => '100% up to $20,000',
            'gambling_age' => '19+ (18+ in QB/AB/MB)',
            'tax_info' => 'No (unless regular income)'
        ];
    }

    public function getAllAuthorities()
    {
        return $this->getLegalStatusData()['regulatory_authorities'];
    }

    public function getAllProvinces()
    {
        return $this->getLegalStatusData()['provincial_breakdown'];
    }

    public function getPaymentRegulations()
    {
        return $this->getLegalStatusData()['payment_regulations'];
    }
}
