<?php

namespace App\Services;

class ExtendedCasinoService
{
    private $casinos;

    public function __construct()
    {
        $this->initializeExtendedCasinos();
    }

    private function initializeExtendedCasinos()
    {
        $this->casinos = [
            [
                'id' => 1,
                'name' => 'Jackpot City Casino',
                'logo_url' => '/images/casinos/jackpot-city-logo.svg',
                'rating' => 4.8,
                'established_year' => 1998,
                'avg_rtp' => 97.8,
                'payout_speed' => '1-2 days',
                'game_count' => 1200,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1600',
                    'percentage' => 100,
                    'details' => 'Up to $1600 + 200 Free Spins'
                ],
                'security_certifications' => ['eCOGRA', 'Malta Gaming Authority', 'SSL Encryption'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'PayPal'],
                'software_providers' => ['Microgaming', 'NetEnt', 'Evolution Gaming'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 98,
                'canadian_friendly' => true
            ],
            [
                'id' => 2,
                'name' => 'Spin Casino',
                'logo_url' => '/images/casinos/spin-casino-logo.svg',
                'rating' => 4.7,
                'established_year' => 2001,
                'avg_rtp' => 97.5,
                'payout_speed' => '1-3 days',
                'game_count' => 950,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1000',
                    'percentage' => 100,
                    'details' => 'Up to $1000 + 150 Free Spins'
                ],
                'security_certifications' => ['eCOGRA', 'Kahnawake Gaming Commission', 'TST Certified'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Skrill', 'ecoPayz'],
                'software_providers' => ['Microgaming', 'Play\'n GO', 'Pragmatic Play'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 96,
                'canadian_friendly' => true
            ],
            [
                'id' => 3,
                'name' => 'Ruby Fortune',
                'logo_url' => '/images/casinos/ruby-fortune-logo.svg',
                'rating' => 4.6,
                'established_year' => 2003,
                'avg_rtp' => 97.2,
                'payout_speed' => '2-3 days',
                'game_count' => 800,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$750',
                    'percentage' => 100,
                    'details' => 'Up to $750 + 100 Free Spins'
                ],
                'security_certifications' => ['eCOGRA', 'Malta Gaming Authority', 'Advanced SSL'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'Paysafecard'],
                'software_providers' => ['Microgaming', 'NetEnt', 'Red Tiger'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 95,
                'canadian_friendly' => true
            ],
            [
                'id' => 4,
                'name' => 'Royal Vegas Casino',
                'logo_url' => '/images/casinos/royal-vegas-logo.svg',
                'rating' => 4.5,
                'established_year' => 2000,
                'avg_rtp' => 97.0,
                'payout_speed' => '2-4 days',
                'game_count' => 700,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1200',
                    'percentage' => 100,
                    'details' => 'Up to $1200 Welcome Package'
                ],
                'security_certifications' => ['eCOGRA', 'Malta Gaming Authority', 'Secure Sockets'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Skrill', 'Neteller'],
                'software_providers' => ['Microgaming', 'Evolution Gaming', 'Big Time Gaming'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 94,
                'canadian_friendly' => true
            ],
            [
                'id' => 5,
                'name' => 'Betway Casino',
                'logo_url' => '/images/casinos/betway-logo.svg',
                'rating' => 4.7,
                'established_year' => 2006,
                'avg_rtp' => 97.3,
                'payout_speed' => '1-2 days',
                'game_count' => 1100,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1000',
                    'percentage' => 100,
                    'details' => 'Up to $1000 + 200 Free Spins'
                ],
                'security_certifications' => ['eCOGRA', 'UK Gambling Commission', 'Malta Gaming Authority'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'PayPal', 'Neteller'],
                'software_providers' => ['Microgaming', 'NetEnt', 'Playtech', 'Evolution Gaming'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 97,
                'canadian_friendly' => true
            ],
            [
                'id' => 6,
                'name' => '888 Casino',
                'logo_url' => '/images/casinos/888-casino-logo.svg',
                'rating' => 4.6,
                'established_year' => 1997,
                'avg_rtp' => 96.8,
                'payout_speed' => '2-5 days',
                'game_count' => 850,
                'welcome_bonus' => [
                    'type' => 'No Deposit + Match',
                    'amount' => '$88 + $1500',
                    'percentage' => 100,
                    'details' => '$88 Free + Up to $1500 Bonus'
                ],
                'security_certifications' => ['Gibraltar Gaming Commission', 'UK Gambling Commission', 'Random Testing'],
                'payment_methods' => ['Visa', 'Mastercard', 'PayPal', 'Neteller', 'Paysafecard'],
                'software_providers' => ['NetEnt', 'Playtech', 'IGT', 'Random Logic'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 95,
                'canadian_friendly' => true
            ],
            [
                'id' => 7,
                'name' => 'LeoVegas Casino',
                'logo_url' => '/images/casinos/leovegas-logo.svg',
                'rating' => 4.8,
                'established_year' => 2012,
                'avg_rtp' => 97.6,
                'payout_speed' => '1-2 days',
                'game_count' => 1500,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1000',
                    'percentage' => 100,
                    'details' => 'Up to $1000 + 200 Free Spins'
                ],
                'security_certifications' => ['Malta Gaming Authority', 'UK Gambling Commission', 'Swedish Gambling Authority'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'Skrill'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Play\'n GO', 'Evolution Gaming'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 98,
                'canadian_friendly' => true
            ],
            [
                'id' => 8,
                'name' => 'Casumo Casino',
                'logo_url' => '/images/casinos/casumo-logo.svg',
                'rating' => 4.5,
                'established_year' => 2012,
                'avg_rtp' => 97.1,
                'payout_speed' => '1-3 days',
                'game_count' => 1200,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1200',
                    'percentage' => 100,
                    'details' => 'Up to $1200 + 200 Free Spins'
                ],
                'security_certifications' => ['Malta Gaming Authority', 'UK Gambling Commission', 'SSL Encryption'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'ecoPayz'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Play\'n GO', 'Yggdrasil'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 96,
                'canadian_friendly' => true
            ],
            [
                'id' => 9,
                'name' => 'PlayOJO Casino',
                'logo_url' => '/images/casinos/playojo-logo.svg',
                'rating' => 4.4,
                'established_year' => 2017,
                'avg_rtp' => 96.9,
                'payout_speed' => '2-4 days',
                'game_count' => 900,
                'welcome_bonus' => [
                    'type' => 'No Wagering Spins',
                    'amount' => '80 Free Spins',
                    'percentage' => 0,
                    'details' => '80 No Wagering Free Spins'
                ],
                'security_certifications' => ['UK Gambling Commission', 'Malta Gaming Authority', 'Fair Play Certified'],
                'payment_methods' => ['Visa', 'Mastercard', 'PayPal', 'Neteller', 'Paysafecard'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Play\'n GO', 'Pragmatic Play'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 93,
                'canadian_friendly' => true
            ],
            [
                'id' => 10,
                'name' => 'Videoslots Casino',
                'logo_url' => '/images/casinos/videoslots-logo.svg',
                'rating' => 4.3,
                'established_year' => 2011,
                'avg_rtp' => 96.7,
                'payout_speed' => '2-5 days',
                'game_count' => 4000,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$200',
                    'percentage' => 100,
                    'details' => 'Up to $200 + 11 Free Spins'
                ],
                'security_certifications' => ['Malta Gaming Authority', 'UK Gambling Commission', 'Swedish Gambling Authority'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'Skrill'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Play\'n GO', 'Pragmatic Play'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 92,
                'canadian_friendly' => true
            ],
            [
                'id' => 11,
                'name' => 'Mr Green Casino',
                'logo_url' => '/images/casinos/mr-green-logo.svg',
                'rating' => 4.5,
                'established_year' => 2008,
                'avg_rtp' => 97.0,
                'payout_speed' => '1-3 days',
                'game_count' => 1100,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1200',
                    'percentage' => 100,
                    'details' => 'Up to $1200 + 200 Free Spins'
                ],
                'security_certifications' => ['Malta Gaming Authority', 'UK Gambling Commission', 'Danish Gambling Authority'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'Skrill'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Evolution Gaming', 'Yggdrasil'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 95,
                'canadian_friendly' => true
            ],
            [
                'id' => 12,
                'name' => 'Rizk Casino',
                'logo_url' => '/images/casinos/rizk-logo.svg',
                'rating' => 4.4,
                'established_year' => 2016,
                'avg_rtp' => 96.8,
                'payout_speed' => '2-4 days',
                'game_count' => 800,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$600',
                    'percentage' => 100,
                    'details' => 'Up to $600 + 200 Free Spins'
                ],
                'security_certifications' => ['Malta Gaming Authority', 'UK Gambling Commission', 'SSL Security'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'ecoPayz'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Play\'n GO', 'Thunderkick'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 94,
                'canadian_friendly' => true
            ],
            [
                'id' => 13,
                'name' => 'Genesis Casino',
                'logo_url' => '/images/casinos/genesis-logo.svg',
                'rating' => 4.6,
                'established_year' => 2018,
                'avg_rtp' => 97.2,
                'payout_speed' => '1-2 days',
                'game_count' => 1300,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1000',
                    'percentage' => 100,
                    'details' => 'Up to $1000 + 300 Free Spins'
                ],
                'security_certifications' => ['Malta Gaming Authority', 'UK Gambling Commission', 'Curacao eGaming'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'Skrill'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Play\'n GO', 'Evolution Gaming'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 96,
                'canadian_friendly' => true
            ],
            [
                'id' => 14,
                'name' => 'PlayAmo Casino',
                'logo_url' => '/images/casinos/playamo-logo.svg',
                'rating' => 4.3,
                'established_year' => 2016,
                'avg_rtp' => 96.9,
                'payout_speed' => '2-3 days',
                'game_count' => 1500,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$1500',
                    'percentage' => 100,
                    'details' => 'Up to $1500 + 150 Free Spins'
                ],
                'security_certifications' => ['Curacao eGaming', 'SSL Encryption', 'Fair Gaming Certified'],
                'payment_methods' => ['Visa', 'Mastercard', 'Bitcoin', 'Neteller', 'Skrill'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Betsoft', 'Amatic'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 93,
                'canadian_friendly' => true
            ],
            [
                'id' => 15,
                'name' => 'Wildz Casino',
                'logo_url' => '/images/casinos/wildz-logo.svg',
                'rating' => 4.7,
                'established_year' => 2019,
                'avg_rtp' => 97.4,
                'payout_speed' => '1-2 days',
                'game_count' => 1200,
                'welcome_bonus' => [
                    'type' => 'Match Bonus',
                    'amount' => '$500',
                    'percentage' => 100,
                    'details' => 'Up to $500 + 200 Free Spins'
                ],
                'security_certifications' => ['Malta Gaming Authority', 'UK Gambling Commission', 'Advanced SSL'],
                'payment_methods' => ['Visa', 'Mastercard', 'Interac', 'Neteller', 'ecoPayz'],
                'software_providers' => ['NetEnt', 'Microgaming', 'Play\'n GO', 'Pragmatic Play'],
                'mobile_compatibility' => true,
                'live_chat_support' => true,
                'trust_score' => 97,
                'canadian_friendly' => true
            ]
        ];
    }

    public function getExtendedTopCasinos($limit = 15)
    {
        return array_slice($this->casinos, 0, $limit);
    }

    public function getCasinoById($id)
    {
        foreach ($this->casinos as $casino) {
            if ($casino['id'] == $id) {
                return $casino;
            }
        }
        return null;
    }

    public function getFilteredCasinos($filters = [])
    {
        $filtered = $this->casinos;

        if (isset($filters['min_rating'])) {
            $filtered = array_filter($filtered, function($casino) use ($filters) {
                return $casino['rating'] >= $filters['min_rating'];
            });
        }

        if (isset($filters['min_games'])) {
            $filtered = array_filter($filtered, function($casino) use ($filters) {
                return $casino['game_count'] >= $filters['min_games'];
            });
        }

        if (isset($filters['fast_payout'])) {
            $filtered = array_filter($filtered, function($casino) {
                return strpos($casino['payout_speed'], '1-') === 0 || strpos($casino['payout_speed'], '2-') === 0;
            });
        }

        return array_values($filtered);
    }

    public function getCasinoStatistics()
    {
        return [
            'total_casinos' => count($this->casinos),
            'average_rating' => round(array_sum(array_column($this->casinos, 'rating')) / count($this->casinos), 1),
            'average_games' => round(array_sum(array_column($this->casinos, 'game_count')) / count($this->casinos)),
            'average_rtp' => round(array_sum(array_column($this->casinos, 'avg_rtp')) / count($this->casinos), 1),
            'established_range' => [
                'oldest' => min(array_column($this->casinos, 'established_year')),
                'newest' => max(array_column($this->casinos, 'established_year'))
            ]
        ];
    }
}
