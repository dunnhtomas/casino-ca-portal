<?php

namespace App\Services;

class ProvinceService
{
    public function getAllProvinces()
    {
        return [
            'AB' => [
                'name' => 'Alberta',
                'gambling_age' => 18,
                'legal_status' => 'Legal',
                'local_casinos' => 25,
                'population' => '4.4M',
                'regulatory_body' => 'Alberta Gaming, Liquor and Cannabis',
                'description' => 'Alberta allows online casino gaming with the lowest gambling age in Canada. The province has a strong gaming industry with multiple tribal casinos and regulated online options.',
                'recommended_casinos' => ['jackpot-city', 'spin-palace', 'royal-vegas'],
                'key_facts' => [
                    'Lowest gambling age in Canada (18+)',
                    'Strong provincial lottery corporation',
                    'Multiple tribal casinos',
                    'Calgary Stampede Casino events'
                ],
                'flag_url' => '/images/flags/ab.svg'
            ],
            'BC' => [
                'name' => 'British Columbia',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 18,
                'population' => '5.2M',
                'regulatory_body' => 'British Columbia Lottery Corporation',
                'description' => 'BC has a regulated online casino market through PlayNow.com and multiple land-based casino destinations throughout the province.',
                'recommended_casinos' => ['leovegas', 'betway', 'jackpot-city'],
                'key_facts' => [
                    'PlayNow.com is the official online platform',
                    'Strict responsible gambling measures',
                    'Beautiful casino destinations like Vancouver',
                    'Strong First Nations gaming presence'
                ],
                'flag_url' => '/images/flags/bc.svg'
            ],
            'MB' => [
                'name' => 'Manitoba',
                'gambling_age' => 18,
                'legal_status' => 'Legal',
                'local_casinos' => 8,
                'population' => '1.4M',
                'regulatory_body' => 'Manitoba Liquor & Lotteries',
                'description' => 'Manitoba offers regulated gambling through Manitoba Liquor & Lotteries with both online and land-based casino options.',
                'recommended_casinos' => ['spin-casino', 'ruby-fortune', 'zodiac-casino'],
                'key_facts' => [
                    'Low gambling age (18+)',
                    'Club Regent Casino in Winnipeg',
                    'Strong charitable gaming sector',
                    'PlayNow.com partnership'
                ],
                'flag_url' => '/images/flags/mb.svg'
            ],
            'NB' => [
                'name' => 'New Brunswick',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 3,
                'population' => '789K',
                'regulatory_body' => 'Atlantic Lottery Corporation',
                'description' => 'New Brunswick participates in the Atlantic Lottery Corporation with regulated online gaming and local casino options.',
                'recommended_casinos' => ['jackpot-city', 'spin-palace', 'royal-vegas'],
                'key_facts' => [
                    'Part of Atlantic Canada gaming region',
                    'Casino New Brunswick in Moncton',
                    'Regulated online lottery gaming',
                    'Charitable gaming permitted'
                ],
                'flag_url' => '/images/flags/nb.svg'
            ],
            'NL' => [
                'name' => 'Newfoundland and Labrador',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 1,
                'population' => '521K',
                'regulatory_body' => 'Atlantic Lottery Corporation',
                'description' => 'Newfoundland and Labrador offers regulated gambling through the Atlantic Lottery Corporation with limited local casino options.',
                'recommended_casinos' => ['leovegas', 'betway', 'jackpot-city'],
                'key_facts' => [
                    'Atlantic Canada gaming participant',
                    'Limited land-based casino options',
                    'Strong lottery tradition',
                    'Online gaming through ALC'
                ],
                'flag_url' => '/images/flags/nl.svg'
            ],
            'NS' => [
                'name' => 'Nova Scotia',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 2,
                'population' => '992K',
                'regulatory_body' => 'Atlantic Lottery Corporation',
                'description' => 'Nova Scotia offers regulated gambling through the Atlantic Lottery Corporation with Halifax Casino and Sydney Casino.',
                'recommended_casinos' => ['spin-casino', 'ruby-fortune', 'zodiac-casino'],
                'key_facts' => [
                    'Halifax Casino Nova Scotia',
                    'Sydney Casino Nova Scotia',
                    'Atlantic Canada gaming hub',
                    'Strong responsible gambling programs'
                ],
                'flag_url' => '/images/flags/ns.svg'
            ],
            'ON' => [
                'name' => 'Ontario',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 26,
                'population' => '15.0M',
                'regulatory_body' => 'Alcohol and Gaming Commission of Ontario',
                'description' => 'Ontario has the largest regulated online casino market in Canada with numerous licensed operators and extensive land-based casino options.',
                'recommended_casinos' => ['jackpot-city', 'leovegas', 'betway'],
                'key_facts' => [
                    'Largest casino market in Canada',
                    'iGaming Ontario regulatory framework',
                    'Fallsview Casino Resort',
                    'Casino Rama and Woodbine Casino'
                ],
                'flag_url' => '/images/flags/on.svg'
            ],
            'PE' => [
                'name' => 'Prince Edward Island',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 0,
                'population' => '164K',
                'regulatory_body' => 'Atlantic Lottery Corporation',
                'description' => 'Prince Edward Island participates in Atlantic Lottery Corporation gaming with no land-based casinos but regulated online options.',
                'recommended_casinos' => ['spin-palace', 'royal-vegas', 'jackpot-city'],
                'key_facts' => [
                    'No land-based casinos',
                    'Atlantic Lottery Corporation member',
                    'Online gaming available',
                    'Charitable gaming permitted'
                ],
                'flag_url' => '/images/flags/pe.svg'
            ],
            'QC' => [
                'name' => 'Quebec',
                'gambling_age' => 18,
                'legal_status' => 'Legal',
                'local_casinos' => 12,
                'population' => '8.6M',
                'regulatory_body' => 'Loto-Québec',
                'description' => 'Quebec has a unique regulated gaming market through Loto-Québec with Espacejeux online platform and multiple land-based casinos.',
                'recommended_casinos' => ['ruby-fortune', 'zodiac-casino', 'spin-casino'],
                'key_facts' => [
                    'Espacejeux.com official platform',
                    'Casino de Montréal',
                    'French-language gaming focus',
                    'Strict in-province regulations'
                ],
                'flag_url' => '/images/flags/qc.svg'
            ],
            'SK' => [
                'name' => 'Saskatchewan',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 7,
                'population' => '1.2M',
                'regulatory_body' => 'Saskatchewan Liquor and Gaming Authority',
                'description' => 'Saskatchewan offers regulated gambling through SLGA with multiple casino destinations and online gaming options.',
                'recommended_casinos' => ['leovegas', 'betway', 'jackpot-city'],
                'key_facts' => [
                    'Casino Regina flagship destination',
                    'First Nations gaming partnerships',
                    'Strong charitable gaming sector',
                    'Rural casino locations'
                ],
                'flag_url' => '/images/flags/sk.svg'
            ],
            'NT' => [
                'name' => 'Northwest Territories',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 1,
                'population' => '45K',
                'regulatory_body' => 'Northwest Territories Liquor and Cannabis Commission',
                'description' => 'Northwest Territories has limited gambling options with one casino and participation in national lottery systems.',
                'recommended_casinos' => ['spin-palace', 'royal-vegas', 'jackpot-city'],
                'key_facts' => [
                    'Diamond Tooth Gerties Casino',
                    'Limited gambling infrastructure',
                    'Tourism-focused gaming',
                    'Northern gaming regulations'
                ],
                'flag_url' => '/images/flags/nt.svg'
            ],
            'NU' => [
                'name' => 'Nunavut',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 0,
                'population' => '39K',
                'regulatory_body' => 'Nunavut Liquor and Cannabis Commission',
                'description' => 'Nunavut has very limited gambling infrastructure with no casinos but participates in national lottery systems.',
                'recommended_casinos' => ['ruby-fortune', 'zodiac-casino', 'spin-casino'],
                'key_facts' => [
                    'No land-based casinos',
                    'National lottery participation',
                    'Limited gaming infrastructure',
                    'Cultural considerations for gaming'
                ],
                'flag_url' => '/images/flags/nu.svg'
            ],
            'YT' => [
                'name' => 'Yukon',
                'gambling_age' => 19,
                'legal_status' => 'Legal',
                'local_casinos' => 2,
                'population' => '42K',
                'regulatory_body' => 'Yukon Liquor Corporation',
                'description' => 'Yukon offers limited gambling options with two casinos and participation in national lottery systems.',
                'recommended_casinos' => ['leovegas', 'betway', 'jackpot-city'],
                'key_facts' => [
                    'Diamond Tooth Gerties (seasonal)',
                    'Klondike Kate\'s Casino',
                    'Tourism-focused gaming',
                    'Historic gold rush gaming tradition'
                ],
                'flag_url' => '/images/flags/yt.svg'
            ]
        ];
    }

    public function getProvince($code)
    {
        $provinces = $this->getAllProvinces();
        return $provinces[strtoupper($code)] ?? null;
    }

    public function getProvincesByRegion()
    {
        $provinces = $this->getAllProvinces();
        
        return [
            'Western Canada' => [
                'BC' => $provinces['BC'],
                'AB' => $provinces['AB'],
                'SK' => $provinces['SK'],
                'MB' => $provinces['MB']
            ],
            'Central Canada' => [
                'ON' => $provinces['ON'],
                'QC' => $provinces['QC']
            ],
            'Atlantic Canada' => [
                'NB' => $provinces['NB'],
                'NS' => $provinces['NS'],
                'PE' => $provinces['PE'],
                'NL' => $provinces['NL']
            ],
            'Northern Territories' => [
                'NT' => $provinces['NT'],
                'NU' => $provinces['NU'],
                'YT' => $provinces['YT']
            ]
        ];
    }
}
