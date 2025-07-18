<?php

namespace App\Services;

class LegalStatusService
{
    private $legalData;
    private $summary;

    public function __construct()
    {
        $this->initializeLegalData();
        $this->initializeSummary();
    }

    private function initializeLegalData()
    {
        $this->legalData = [
            'legal_framework' => [
                'status' => 'Legal',
                'last_updated' => '2025-07-01',
                'regulatory_bodies' => [
                    'federal' => 'Criminal Code of Canada',
                    'provincial' => 'Individual Provincial Gaming Commissions'
                ]
            ],
            'provinces' => [
                'alberta' => [
                    'name' => 'Alberta',
                    'status' => 'Legal',
                    'regulator' => 'Alberta Gaming, Liquor and Cannabis Commission (AGLC)',
                    'min_age' => 18,
                    'local_casinos' => 2,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'british_columbia' => [
                    'name' => 'British Columbia',
                    'status' => 'Legal',
                    'regulator' => 'British Columbia Lottery Corporation (BCLC)',
                    'min_age' => 19,
                    'local_casinos' => 3,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'manitoba' => [
                    'name' => 'Manitoba',
                    'status' => 'Legal',
                    'regulator' => 'Liquor, Gaming and Cannabis Authority of Manitoba',
                    'min_age' => 18,
                    'local_casinos' => 1,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'new_brunswick' => [
                    'name' => 'New Brunswick',
                    'status' => 'Legal',
                    'regulator' => 'New Brunswick Lotteries and Gaming Corporation',
                    'min_age' => 19,
                    'local_casinos' => 1,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'newfoundland_labrador' => [
                    'name' => 'Newfoundland and Labrador',
                    'status' => 'Legal',
                    'regulator' => 'Atlantic Lottery Corporation',
                    'min_age' => 19,
                    'local_casinos' => 0,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'northwest_territories' => [
                    'name' => 'Northwest Territories',
                    'status' => 'Legal',
                    'regulator' => 'Northwest Territories Lotteries',
                    'min_age' => 19,
                    'local_casinos' => 0,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'nova_scotia' => [
                    'name' => 'Nova Scotia',
                    'status' => 'Legal',
                    'regulator' => 'Atlantic Lottery Corporation',
                    'min_age' => 19,
                    'local_casinos' => 2,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'nunavut' => [
                    'name' => 'Nunavut',
                    'status' => 'Legal',
                    'regulator' => 'Nunavut Liquor and Cannabis Commission',
                    'min_age' => 19,
                    'local_casinos' => 0,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'ontario' => [
                    'name' => 'Ontario',
                    'status' => 'Legal',
                    'regulator' => 'iGaming Ontario (iGO)',
                    'min_age' => 19,
                    'local_casinos' => 12,
                    'online_gambling' => 'Fully Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'prince_edward_island' => [
                    'name' => 'Prince Edward Island',
                    'status' => 'Legal',
                    'regulator' => 'Atlantic Lottery Corporation',
                    'min_age' => 19,
                    'local_casinos' => 0,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'quebec' => [
                    'name' => 'Quebec',
                    'status' => 'Legal',
                    'regulator' => 'Loto-Québec',
                    'min_age' => 18,
                    'local_casinos' => 4,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'saskatchewan' => [
                    'name' => 'Saskatchewan',
                    'status' => 'Legal',
                    'regulator' => 'Saskatchewan Liquor and Gaming Authority (SLGA)',
                    'min_age' => 19,
                    'local_casinos' => 2,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ],
                'yukon' => [
                    'name' => 'Yukon',
                    'status' => 'Legal',
                    'regulator' => 'Yukon Liquor Corporation',
                    'min_age' => 19,
                    'local_casinos' => 0,
                    'online_gambling' => 'Regulated',
                    'taxes' => 'Winnings over $1,200 subject to tax withholding'
                ]
            ]
        ];
    }

    private function initializeSummary()
    {
        $this->summary = [
            'status' => 'Legal',
            'total_casinos' => 27,
            'local_casinos' => 27,
            'gambling_age' => '18+ (AB, QC) / 19+ (All Others)',
            'authorities' => [
                'iGaming Ontario (iGO)',
                'British Columbia Lottery Corporation',
                'Loto-Québec',
                'Atlantic Lottery Corporation'
            ],
            'min_deposit' => '$10',
            'payment_methods' => ['Interac', 'Credit Cards', 'PayPal', 'Bank Transfer'],
            'popular_games' => ['Slots', 'Blackjack', 'Roulette', 'Baccarat'],
            'best_casino' => 'Jackpot City Casino',
            'biggest_bonus' => 'Up to $1,600 + 200 Free Spins',
            'tax_info' => 'Winnings over $1,200 subject to withholding'
        ];
    }

    public function getLegalStatusData()
    {
        return $this->legalData;
    }

    public function getLegalSummary()
    {
        return $this->summary;
    }

    public function getProvinceRegulations($province = null)
    {
        if ($province && isset($this->legalData['provinces'][$province])) {
            return $this->legalData['provinces'][$province];
        }
        
        return $this->legalData['provinces'];
    }

    public function getRegulatedCasinosCount()
    {
        return array_sum(array_column($this->legalData['provinces'], 'local_casinos'));
    }

    public function getMinimumAges()
    {
        $ages = array_column($this->legalData['provinces'], 'min_age');
        return [
            'minimum' => min($ages),
            'maximum' => max($ages),
            'provinces_18' => ['Alberta', 'Quebec'],
            'provinces_19' => array_filter(array_column($this->legalData['provinces'], 'name'), function($province) {
                return !in_array($province, ['Alberta', 'Quebec']);
            })
        ];
    }
}
