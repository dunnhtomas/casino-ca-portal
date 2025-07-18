<?php
namespace App\Services;

class CasinoGridService {
    
    /**
     * Get comprehensive casino database with 90+ casinos
     */
    public function getAllCasinos(): array {
        return [
            // Top Tier Casinos (Ratings 4.5+)
            [
                'id' => 1,
                'name' => 'Jackpot City Casino',
                'slug' => 'jackpot-city',
                'logo' => 'JC',
                'rating' => 4.8,
                'established' => 1998,
                'rtp' => '97.39%',
                'games' => '1,350+',
                'bonus' => '100% up to $4,000',
                'payout' => '1-3 days',
                'categories' => ['top-rated', 'live-casino', 'mobile'],
                'featured' => true,
                'license' => 'MGA'
            ],
            [
                'id' => 2,
                'name' => 'Spin Palace',
                'slug' => 'spin-palace',
                'logo' => 'SP',
                'rating' => 4.7,
                'established' => 2001,
                'rtp' => '97.45%',
                'games' => '1,000+',
                'bonus' => '100% up to $1,000',
                'payout' => '1-3 days',
                'categories' => ['top-rated', 'slots', 'mobile'],
                'featured' => true,
                'license' => 'MGA'
            ],
            [
                'id' => 3,
                'name' => 'Lucky Ones',
                'slug' => 'lucky-ones',
                'logo' => 'LO',
                'rating' => 4.6,
                'established' => 2023,
                'rtp' => '98.27%',
                'games' => '8,000+',
                'bonus' => '100% up to $20,000',
                'payout' => '0-2 days',
                'categories' => ['new', 'crypto', 'high-roller'],
                'featured' => true,
                'license' => 'Curacao'
            ],
            [
                'id' => 4,
                'name' => 'Pistolo',
                'slug' => 'pistolo',
                'logo' => 'PI',
                'rating' => 4.6,
                'established' => 2025,
                'rtp' => '97.21%',
                'games' => '11,000+',
                'bonus' => '100% up to $750',
                'payout' => '1-3 days',
                'categories' => ['new', 'payment-variety', 'mobile'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 5,
                'name' => 'Magius',
                'slug' => 'magius',
                'logo' => 'MG',
                'rating' => 4.6,
                'established' => 2024,
                'rtp' => '98.13%',
                'games' => '7,400+',
                'bonus' => '100% up to $2,500',
                'payout' => '1-2 days',
                'categories' => ['live-casino', 'crypto', 'vip'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 6,
                'name' => 'BetVictor',
                'slug' => 'betvictor',
                'logo' => 'BV',
                'rating' => 4.5,
                'established' => 1946,
                'rtp' => '96.85%',
                'games' => '1,500+',
                'bonus' => '100% up to $3,000',
                'payout' => '0-2 days',
                'categories' => ['established', 'sports', 'mobile'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 7,
                'name' => 'Vegas Hero',
                'slug' => 'vegas-hero',
                'logo' => 'VH',
                'rating' => 4.5,
                'established' => 2017,
                'rtp' => '96.92%',
                'games' => '2,400+',
                'bonus' => '100% up to $750',
                'payout' => '1-2 days',
                'categories' => ['slots', 'live-casino', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            
            // High Quality Casinos (Ratings 4.0-4.4)
            [
                'id' => 8,
                'name' => 'Spinbara',
                'slug' => 'spinbara',
                'logo' => 'SB',
                'rating' => 4.4,
                'established' => 2025,
                'rtp' => '97.23%',
                'games' => '5,200+',
                'bonus' => '300% up to $5,000',
                'payout' => '1-3 days',
                'categories' => ['new', 'high-roller', 'mobile'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 9,
                'name' => 'Mafia Casino',
                'slug' => 'mafia-casino',
                'logo' => 'MC',
                'rating' => 4.3,
                'established' => 2025,
                'rtp' => '96.89%',
                'games' => '4,800+',
                'bonus' => '100% up to $750',
                'payout' => '0-1 days',
                'categories' => ['new', 'fast-payout', 'crypto'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 10,
                'name' => 'Tooniebet',
                'slug' => 'tooniebet',
                'logo' => 'TB',
                'rating' => 4.3,
                'established' => 2024,
                'rtp' => '96.78%',
                'games' => '3,000+',
                'bonus' => 'Up to $3,500',
                'payout' => '1-3 days',
                'categories' => ['canadian', 'mobile', 'sports'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 11,
                'name' => 'Casinova',
                'slug' => 'casinova',
                'logo' => 'CN',
                'rating' => 4.2,
                'established' => 2024,
                'rtp' => '96.74%',
                'games' => '3,200+',
                'bonus' => '100% up to $3,000',
                'payout' => '1-2 days',
                'categories' => ['slots', 'mobile', 'crypto'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 12,
                'name' => 'Royal Vegas',
                'slug' => 'royal-vegas',
                'logo' => 'RV',
                'rating' => 4.1,
                'established' => 2000,
                'rtp' => '96.58%',
                'games' => '850+',
                'bonus' => '100% up to $1,200',
                'payout' => '2-4 days',
                'categories' => ['established', 'vip', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 13,
                'name' => 'Ruby Fortune',
                'slug' => 'ruby-fortune',
                'logo' => 'RF',
                'rating' => 4.0,
                'established' => 2003,
                'rtp' => '96.45%',
                'games' => '680+',
                'bonus' => '100% up to $750',
                'payout' => '2-5 days',
                'categories' => ['established', 'mobile', 'vip'],
                'featured' => false,
                'license' => 'MGA'
            ],
            
            // Good Quality Casinos (Ratings 3.5-3.9)
            [
                'id' => 14,
                'name' => 'Captain Cooks',
                'slug' => 'captain-cooks',
                'logo' => 'CC',
                'rating' => 3.9,
                'established' => 1999,
                'rtp' => '96.22%',
                'games' => '550+',
                'bonus' => '100 chances for $5',
                'payout' => '3-7 days',
                'categories' => ['established', 'low-deposit', 'mobile'],
                'featured' => false,
                'license' => 'Kahnawake'
            ],
            [
                'id' => 15,
                'name' => 'Gaming Club',
                'slug' => 'gaming-club',
                'logo' => 'GC',
                'rating' => 3.8,
                'established' => 1994,
                'rtp' => '96.18%',
                'games' => '450+',
                'bonus' => '100% up to $350',
                'payout' => '3-7 days',
                'categories' => ['established', 'classic', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            
            // Additional 75+ Casinos for comprehensive coverage
            [
                'id' => 16,
                'name' => 'LeoVegas',
                'slug' => 'leovegas',
                'logo' => 'LV',
                'rating' => 4.4,
                'established' => 2012,
                'rtp' => '97.12%',
                'games' => '2,500+',
                'bonus' => '100% up to $1,000',
                'payout' => '1-3 days',
                'categories' => ['mobile', 'live-casino', 'sports'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 17,
                'name' => 'Betway',
                'slug' => 'betway',
                'logo' => 'BW',
                'rating' => 4.3,
                'established' => 2006,
                'rtp' => '96.89%',
                'games' => '1,800+',
                'bonus' => '100% up to $1,000',
                'payout' => '1-5 days',
                'categories' => ['sports', 'live-casino', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 18,
                'name' => 'PlayOJO',
                'slug' => 'playojo',
                'logo' => 'PO',
                'rating' => 4.2,
                'established' => 2017,
                'rtp' => '96.95%',
                'games' => '3,000+',
                'bonus' => 'No wagering spins',
                'payout' => '1-3 days',
                'categories' => ['no-wagering', 'slots', 'mobile'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 19,
                'name' => 'Rizk Casino',
                'slug' => 'rizk',
                'logo' => 'RZ',
                'rating' => 4.1,
                'established' => 2016,
                'rtp' => '96.78%',
                'games' => '1,500+',
                'bonus' => '100% up to $200',
                'payout' => '1-3 days',
                'categories' => ['innovation', 'mobile', 'crypto'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 20,
                'name' => 'Mr Green',
                'slug' => 'mr-green',
                'logo' => 'MR',
                'rating' => 4.0,
                'established' => 2008,
                'rtp' => '96.65%',
                'games' => '2,200+',
                'bonus' => '100% up to $350',
                'payout' => '1-5 days',
                'categories' => ['established', 'responsible', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            
            // Continue with more casinos to reach 90+...
            // (Adding more casinos for demonstration - in production, this would be a full database)
            
            [
                'id' => 21,
                'name' => 'Videoslots',
                'slug' => 'videoslots',
                'logo' => 'VS',
                'rating' => 4.3,
                'established' => 2011,
                'rtp' => '97.05%',
                'games' => '5,000+',
                'bonus' => '100% up to $500',
                'payout' => '1-3 days',
                'categories' => ['slots', 'tournaments', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 22,
                'name' => 'Casino Heroes',
                'slug' => 'casino-heroes',
                'logo' => 'CH',
                'rating' => 4.1,
                'established' => 2014,
                'rtp' => '96.88%',
                'games' => '1,800+',
                'bonus' => '100% up to $100',
                'payout' => '1-3 days',
                'categories' => ['adventure', 'mobile', 'loyalty'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 23,
                'name' => 'NetBet',
                'slug' => 'netbet',
                'logo' => 'NB',
                'rating' => 4.0,
                'established' => 2001,
                'rtp' => '96.72%',
                'games' => '2,500+',
                'bonus' => '100% up to $200',
                'payout' => '1-5 days',
                'categories' => ['sports', 'live-casino', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 24,
                'name' => 'Unibet',
                'slug' => 'unibet',
                'logo' => 'UN',
                'rating' => 4.2,
                'established' => 1997,
                'rtp' => '96.85%',
                'games' => '1,200+',
                'bonus' => '100% up to $500',
                'payout' => '1-3 days',
                'categories' => ['established', 'sports', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            
            // Additional 75+ Casinos for comprehensive coverage
            [
                'id' => 16,
                'name' => 'LeoVegas',
                'slug' => 'leovegas',
                'logo' => 'LV',
                'rating' => 4.4,
                'established' => 2012,
                'rtp' => '97.12%',
                'games' => '2,500+',
                'bonus' => '100% up to $1,000',
                'payout' => '1-3 days',
                'categories' => ['mobile', 'live-casino', 'sports'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 17,
                'name' => 'Betway',
                'slug' => 'betway',
                'logo' => 'BW',
                'rating' => 4.3,
                'established' => 2006,
                'rtp' => '96.89%',
                'games' => '1,800+',
                'bonus' => '100% up to $1,000',
                'payout' => '1-5 days',
                'categories' => ['sports', 'live-casino', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 18,
                'name' => 'PlayOJO',
                'slug' => 'playojo',
                'logo' => 'PO',
                'rating' => 4.2,
                'established' => 2017,
                'rtp' => '96.95%',
                'games' => '3,000+',
                'bonus' => 'No wagering spins',
                'payout' => '1-3 days',
                'categories' => ['no-wagering', 'slots', 'mobile'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 19,
                'name' => 'Rizk Casino',
                'slug' => 'rizk',
                'logo' => 'RZ',
                'rating' => 4.1,
                'established' => 2016,
                'rtp' => '96.78%',
                'games' => '1,500+',
                'bonus' => '100% up to $200',
                'payout' => '1-3 days',
                'categories' => ['innovation', 'mobile', 'crypto'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 20,
                'name' => 'Mr Green',
                'slug' => 'mr-green',
                'logo' => 'MR',
                'rating' => 4.0,
                'established' => 2008,
                'rtp' => '96.65%',
                'games' => '2,200+',
                'bonus' => '100% up to $350',
                'payout' => '1-5 days',
                'categories' => ['established', 'responsible', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 21,
                'name' => 'Videoslots',
                'slug' => 'videoslots',
                'logo' => 'VS',
                'rating' => 4.3,
                'established' => 2011,
                'rtp' => '97.05%',
                'games' => '5,000+',
                'bonus' => '100% up to $500',
                'payout' => '1-3 days',
                'categories' => ['slots', 'tournaments', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 22,
                'name' => 'Casino Heroes',
                'slug' => 'casino-heroes',
                'logo' => 'CH',
                'rating' => 4.1,
                'established' => 2014,
                'rtp' => '96.88%',
                'games' => '1,800+',
                'bonus' => '100% up to $100',
                'payout' => '1-3 days',
                'categories' => ['adventure', 'mobile', 'loyalty'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 23,
                'name' => 'NetBet',
                'slug' => 'netbet',
                'logo' => 'NB',
                'rating' => 4.0,
                'established' => 2001,
                'rtp' => '96.72%',
                'games' => '2,500+',
                'bonus' => '100% up to $200',
                'payout' => '1-5 days',
                'categories' => ['sports', 'live-casino', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 24,
                'name' => 'Unibet',
                'slug' => 'unibet',
                'logo' => 'UN',
                'rating' => 4.2,
                'established' => 1997,
                'rtp' => '96.85%',
                'games' => '1,200+',
                'bonus' => '100% up to $500',
                'payout' => '1-3 days',
                'categories' => ['established', 'sports', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 25,
                'name' => 'Betsafe',
                'slug' => 'betsafe',
                'logo' => 'BS',
                'rating' => 4.1,
                'established' => 2006,
                'rtp' => '96.77%',
                'games' => '1,600+',
                'bonus' => '100% up to $300',
                'payout' => '1-3 days',
                'categories' => ['sports', 'safe', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 26,
                'name' => 'CasinoEuro',
                'slug' => 'casinoeuro',
                'logo' => 'CE',
                'rating' => 4.0,
                'established' => 2002,
                'rtp' => '96.58%',
                'games' => '1,400+',
                'bonus' => '100% up to $150',
                'payout' => '2-5 days',
                'categories' => ['established', 'european', 'mobile'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 27,
                'name' => 'Casumo',
                'slug' => 'casumo',
                'logo' => 'CA',
                'rating' => 4.3,
                'established' => 2012,
                'rtp' => '97.15%',
                'games' => '2,800+',
                'bonus' => '100% up to $300',
                'payout' => '1-3 days',
                'categories' => ['innovation', 'mobile', 'adventure'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 28,
                'name' => 'Genesis Casino',
                'slug' => 'genesis-casino',
                'logo' => 'GE',
                'rating' => 4.2,
                'established' => 2018,
                'rtp' => '96.92%',
                'games' => '3,500+',
                'bonus' => '100% up to $1,000',
                'payout' => '1-3 days',
                'categories' => ['new', 'mobile', 'vip'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 29,
                'name' => 'bet365',
                'slug' => 'bet365',
                'logo' => 'B3',
                'rating' => 4.4,
                'established' => 2000,
                'rtp' => '96.89%',
                'games' => '1,000+',
                'bonus' => '100% up to $300',
                'payout' => '1-5 days',
                'categories' => ['established', 'sports', 'live-casino'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 30,
                'name' => 'William Hill',
                'slug' => 'william-hill',
                'logo' => 'WH',
                'rating' => 4.1,
                'established' => 1934,
                'rtp' => '96.45%',
                'games' => '800+',
                'bonus' => '100% up to $250',
                'payout' => '2-5 days',
                'categories' => ['established', 'sports', 'classic'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 31,
                'name' => 'Paddy Power',
                'slug' => 'paddy-power',
                'logo' => 'PP',
                'rating' => 4.0,
                'established' => 1988,
                'rtp' => '96.32%',
                'games' => '600+',
                'bonus' => '100% up to $200',
                'payout' => '2-5 days',
                'categories' => ['established', 'sports', 'irish'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 32,
                'name' => 'Casino.com',
                'slug' => 'casino-com',
                'logo' => 'CO',
                'rating' => 3.9,
                'established' => 2008,
                'rtp' => '96.28%',
                'games' => '400+',
                'bonus' => '100% up to $400',
                'payout' => '3-7 days',
                'categories' => ['classic', 'mobile', 'established'],
                'featured' => false,
                'license' => 'Gibraltar'
            ],
            [
                'id' => 33,
                'name' => '888 Casino',
                'slug' => '888-casino',
                'logo' => '88',
                'rating' => 4.1,
                'established' => 1997,
                'rtp' => '96.55%',
                'games' => '500+',
                'bonus' => '100% up to $200',
                'payout' => '2-5 days',
                'categories' => ['established', 'classic', 'mobile'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 34,
                'name' => '32Red',
                'slug' => '32red',
                'logo' => '32',
                'rating' => 3.8,
                'established' => 2002,
                'rtp' => '96.18%',
                'games' => '350+',
                'bonus' => '100% up to $160',
                'payout' => '3-7 days',
                'categories' => ['established', 'classic', 'mobile'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 35,
                'name' => 'All British Casino',
                'slug' => 'all-british',
                'logo' => 'AB',
                'rating' => 3.9,
                'established' => 2013,
                'rtp' => '96.35%',
                'games' => '650+',
                'bonus' => '100% up to $100',
                'payout' => '2-5 days',
                'categories' => ['british', 'mobile', 'classic'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 36,
                'name' => 'Mansion Casino',
                'slug' => 'mansion-casino',
                'logo' => 'MA',
                'rating' => 3.7,
                'established' => 2003,
                'rtp' => '96.12%',
                'games' => '300+',
                'bonus' => '100% up to $500',
                'payout' => '3-7 days',
                'categories' => ['established', 'vip', 'classic'],
                'featured' => false,
                'license' => 'Gibraltar'
            ],
            [
                'id' => 37,
                'name' => 'Betfair Casino',
                'slug' => 'betfair-casino',
                'logo' => 'BF',
                'rating' => 4.0,
                'established' => 1999,
                'rtp' => '96.62%',
                'games' => '800+',
                'bonus' => '100% up to $300',
                'payout' => '2-5 days',
                'categories' => ['established', 'sports', 'exchange'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 38,
                'name' => 'Grosvenor Casino',
                'slug' => 'grosvenor-casino',
                'logo' => 'GR',
                'rating' => 3.8,
                'established' => 1970,
                'rtp' => '96.25%',
                'games' => '500+',
                'bonus' => '100% up to $200',
                'payout' => '3-7 days',
                'categories' => ['established', 'land-based', 'classic'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 39,
                'name' => 'Party Casino',
                'slug' => 'party-casino',
                'logo' => 'PC',
                'rating' => 3.9,
                'established' => 2006,
                'rtp' => '96.38%',
                'games' => '700+',
                'bonus' => '100% up to $500',
                'payout' => '2-5 days',
                'categories' => ['established', 'party', 'mobile'],
                'featured' => false,
                'license' => 'Gibraltar'
            ],
            [
                'id' => 40,
                'name' => 'Coral Casino',
                'slug' => 'coral-casino',
                'logo' => 'CR',
                'rating' => 3.8,
                'established' => 1926,
                'rtp' => '96.15%',
                'games' => '400+',
                'bonus' => '100% up to $300',
                'payout' => '3-7 days',
                'categories' => ['established', 'sports', 'british'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 41,
                'name' => 'Sky Vegas',
                'slug' => 'sky-vegas',
                'logo' => 'SV',
                'rating' => 3.9,
                'established' => 2013,
                'rtp' => '96.42%',
                'games' => '600+',
                'bonus' => '100% up to $250',
                'payout' => '2-5 days',
                'categories' => ['british', 'mobile', 'sky'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 42,
                'name' => 'Virgin Casino',
                'slug' => 'virgin-casino',
                'logo' => 'VI',
                'rating' => 3.7,
                'established' => 2014,
                'rtp' => '96.08%',
                'games' => '350+',
                'bonus' => '100% up to $200',
                'payout' => '3-7 days',
                'categories' => ['british', 'virgin', 'mobile'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 43,
                'name' => 'Ladbrokes Casino',
                'slug' => 'ladbrokes-casino',
                'logo' => 'LA',
                'rating' => 3.8,
                'established' => 1886,
                'rtp' => '96.22%',
                'games' => '450+',
                'bonus' => '100% up to $250',
                'payout' => '3-7 days',
                'categories' => ['established', 'sports', 'british'],
                'featured' => false,
                'license' => 'UKGC'
            ],
            [
                'id' => 44,
                'name' => 'LeoVegas Sport',
                'slug' => 'leovegas-sport',
                'logo' => 'LS',
                'rating' => 4.2,
                'established' => 2012,
                'rtp' => '96.95%',
                'games' => '1,800+',
                'bonus' => '100% up to $800',
                'payout' => '1-3 days',
                'categories' => ['mobile', 'sports', 'live-casino'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 45,
                'name' => 'Sloty Casino',
                'slug' => 'sloty-casino',
                'logo' => 'SL',
                'rating' => 4.0,
                'established' => 2017,
                'rtp' => '96.75%',
                'games' => '1,500+',
                'bonus' => '100% up to $300',
                'payout' => '1-3 days',
                'categories' => ['slots', 'mobile', 'new'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 46,
                'name' => 'Yako Casino',
                'slug' => 'yako-casino',
                'logo' => 'YA',
                'rating' => 3.9,
                'established' => 2015,
                'rtp' => '96.48%',
                'games' => '1,200+',
                'bonus' => '100% up to $333',
                'payout' => '2-5 days',
                'categories' => ['quirky', 'mobile', 'slots'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 47,
                'name' => 'Dunder Casino',
                'slug' => 'dunder-casino',
                'logo' => 'DU',
                'rating' => 4.1,
                'established' => 2016,
                'rtp' => '96.82%',
                'games' => '1,600+',
                'bonus' => '100% up to $200',
                'payout' => '1-3 days',
                'categories' => ['simple', 'mobile', 'slots'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 48,
                'name' => 'Thrills Casino',
                'slug' => 'thrills-casino',
                'logo' => 'TH',
                'rating' => 4.0,
                'established' => 2013,
                'rtp' => '96.68%',
                'games' => '1,300+',
                'bonus' => '100% up to $100',
                'payout' => '1-3 days',
                'categories' => ['thrills', 'mobile', 'adventure'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 49,
                'name' => 'Spinit Casino',
                'slug' => 'spinit-casino',
                'logo' => 'SI',
                'rating' => 3.8,
                'established' => 2016,
                'rtp' => '96.35%',
                'games' => '1,100+',
                'bonus' => '100% up to $1,000',
                'payout' => '2-5 days',
                'categories' => ['slots', 'mobile', 'spin'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 50,
                'name' => 'Frank Casino',
                'slug' => 'frank-casino',
                'logo' => 'FR',
                'rating' => 3.9,
                'established' => 2014,
                'rtp' => '96.52%',
                'games' => '900+',
                'bonus' => '100% up to $300',
                'payout' => '2-5 days',
                'categories' => ['frank', 'mobile', 'honest'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 51,
                'name' => 'Wishmaker Casino',
                'slug' => 'wishmaker-casino',
                'logo' => 'WI',
                'rating' => 4.0,
                'established' => 2019,
                'rtp' => '96.75%',
                'games' => '2,000+',
                'bonus' => '100% up to $500',
                'payout' => '1-3 days',
                'categories' => ['wishes', 'mobile', 'new'],
                'featured' => false,
                'license' => 'MGA'
            ],
            [
                'id' => 52,
                'name' => 'Playamo Casino',
                'slug' => 'playamo-casino',
                'logo' => 'PL',
                'rating' => 4.2,
                'established' => 2016,
                'rtp' => '97.08%',
                'games' => '4,000+',
                'bonus' => '100% up to $300',
                'payout' => '1-2 days',
                'categories' => ['crypto', 'mobile', 'fast-payout'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 53,
                'name' => 'BitStarz Casino',
                'slug' => 'bitstarz-casino',
                'logo' => 'BI',
                'rating' => 4.4,
                'established' => 2014,
                'rtp' => '97.25%',
                'games' => '3,500+',
                'bonus' => '100% up to $500',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'fast-payout', 'mobile'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 54,
                'name' => 'mBit Casino',
                'slug' => 'mbit-casino',
                'logo' => 'MB',
                'rating' => 4.1,
                'established' => 2014,
                'rtp' => '96.95%',
                'games' => '2,500+',
                'bonus' => '110% up to 1 BTC',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'bitcoin', 'fast-payout'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 55,
                'name' => 'FortuneJack',
                'slug' => 'fortunejack',
                'logo' => 'FJ',
                'rating' => 4.0,
                'established' => 2014,
                'rtp' => '96.82%',
                'games' => '3,000+',
                'bonus' => '110% up to 1.5 BTC',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'bitcoin', 'live-casino'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 56,
                'name' => 'CloudBet',
                'slug' => 'cloudbet',
                'logo' => 'CB',
                'rating' => 3.9,
                'established' => 2013,
                'rtp' => '96.65%',
                'games' => '1,800+',
                'bonus' => '100% up to 1 BTC',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'sports', 'bitcoin'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 57,
                'name' => 'Stake Casino',
                'slug' => 'stake-casino',
                'logo' => 'ST',
                'rating' => 4.3,
                'established' => 2017,
                'rtp' => '97.12%',
                'games' => '5,000+',
                'bonus' => 'Rakeback Program',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'rakeback', 'streaming'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 58,
                'name' => 'BC.Game',
                'slug' => 'bc-game',
                'logo' => 'BC',
                'rating' => 4.1,
                'established' => 2017,
                'rtp' => '96.88%',
                'games' => '8,000+',
                'bonus' => '180% up to $20,000',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'sports', 'lottery'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 59,
                'name' => 'Roobet',
                'slug' => 'roobet',
                'logo' => 'RO',
                'rating' => 4.0,
                'established' => 2019,
                'rtp' => '96.75%',
                'games' => '4,500+',
                'bonus' => 'Daily Rewards',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'streaming', 'social'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 60,
                'name' => 'Duelbits',
                'slug' => 'duelbits',
                'logo' => 'DB',
                'rating' => 3.9,
                'established' => 2020,
                'rtp' => '96.58%',
                'games' => '3,500+',
                'bonus' => '100% up to $500',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'duel', 'sports'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 61,
                'name' => 'Betfury',
                'slug' => 'betfury',
                'logo' => 'BU',
                'rating' => 4.0,
                'established' => 2019,
                'rtp' => '96.72%',
                'games' => '6,000+',
                'bonus' => 'BFG Tokens',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'token', 'staking'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 62,
                'name' => 'Wild Casino',
                'slug' => 'wild-casino',
                'logo' => 'WC',
                'rating' => 4.1,
                'established' => 2018,
                'rtp' => '96.85%',
                'games' => '350+',
                'bonus' => '250% up to $5,000',
                'payout' => '1-3 days',
                'categories' => ['usa', 'crypto', 'high-roller'],
                'featured' => false,
                'license' => 'Panama'
            ],
            [
                'id' => 63,
                'name' => 'Bovada Casino',
                'slug' => 'bovada-casino',
                'logo' => 'BO',
                'rating' => 4.0,
                'established' => 2011,
                'rtp' => '96.62%',
                'games' => '200+',
                'bonus' => '100% up to $3,000',
                'payout' => '1-5 days',
                'categories' => ['usa', 'sports', 'poker'],
                'featured' => false,
                'license' => 'Kahnawake'
            ],
            [
                'id' => 64,
                'name' => 'Ignition Casino',
                'slug' => 'ignition-casino',
                'logo' => 'IG',
                'rating' => 4.2,
                'established' => 2016,
                'rtp' => '96.95%',
                'games' => '300+',
                'bonus' => '150% up to $1,500',
                'payout' => '1-3 days',
                'categories' => ['usa', 'poker', 'crypto'],
                'featured' => false,
                'license' => 'Kahnawake'
            ],
            [
                'id' => 65,
                'name' => 'Slots.lv',
                'slug' => 'slots-lv',
                'logo' => 'SLV',
                'rating' => 3.9,
                'established' => 2013,
                'rtp' => '96.45%',
                'games' => '400+',
                'bonus' => '200% up to $5,000',
                'payout' => '2-5 days',
                'categories' => ['usa', 'slots', 'crypto'],
                'featured' => false,
                'license' => 'Kahnawake'
            ],
            [
                'id' => 66,
                'name' => 'Red Dog Casino',
                'slug' => 'red-dog-casino',
                'logo' => 'RD',
                'rating' => 3.8,
                'established' => 2019,
                'rtp' => '96.28%',
                'games' => '150+',
                'bonus' => '225% up to $12,250',
                'payout' => '1-5 days',
                'categories' => ['usa', 'rtg', 'crypto'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 67,
                'name' => 'Super Slots',
                'slug' => 'super-slots',
                'logo' => 'SS',
                'rating' => 4.0,
                'established' => 2020,
                'rtp' => '96.58%',
                'games' => '280+',
                'bonus' => '250% up to $6,000',
                'payout' => '1-3 days',
                'categories' => ['usa', 'slots', 'new'],
                'featured' => false,
                'license' => 'Panama'
            ],
            [
                'id' => 68,
                'name' => 'Las Atlantis',
                'slug' => 'las-atlantis',
                'logo' => 'LAT',
                'rating' => 3.9,
                'established' => 2020,
                'rtp' => '96.42%',
                'games' => '200+',
                'bonus' => '280% up to $14,000',
                'payout' => '2-5 days',
                'categories' => ['usa', 'atlantis', 'rtg'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 69,
                'name' => 'Planet 7 Casino',
                'slug' => 'planet-7-casino',
                'logo' => 'P7',
                'rating' => 3.7,
                'established' => 2008,
                'rtp' => '96.15%',
                'games' => '130+',
                'bonus' => '300% up to $3,000',
                'payout' => '3-7 days',
                'categories' => ['usa', 'rtg', 'planet'],
                'featured' => false,
                'license' => 'Costa Rica'
            ],
            [
                'id' => 70,
                'name' => 'Slotocash Casino',
                'slug' => 'slotocash-casino',
                'logo' => 'SC',
                'rating' => 3.8,
                'established' => 2007,
                'rtp' => '96.22%',
                'games' => '180+',
                'bonus' => '200% up to $1,500',
                'payout' => '3-7 days',
                'categories' => ['usa', 'rtg', 'cash'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 71,
                'name' => 'Uptown Aces',
                'slug' => 'uptown-aces',
                'logo' => 'UA',
                'rating' => 3.6,
                'established' => 2014,
                'rtp' => '96.08%',
                'games' => '150+',
                'bonus' => '250% up to $2,500',
                'payout' => '3-7 days',
                'categories' => ['usa', 'uptown', 'rtg'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 72,
                'name' => 'Roaring 21',
                'slug' => 'roaring-21',
                'logo' => 'R21',
                'rating' => 3.7,
                'established' => 2018,
                'rtp' => '96.18%',
                'games' => '120+',
                'bonus' => '200% up to $10,000',
                'payout' => '2-5 days',
                'categories' => ['usa', 'roaring', 'twenties'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 73,
                'name' => 'Slots Empire',
                'slug' => 'slots-empire',
                'logo' => 'SE',
                'rating' => 3.8,
                'established' => 2017,
                'rtp' => '96.25%',
                'games' => '200+',
                'bonus' => '220% up to $12,000',
                'payout' => '2-5 days',
                'categories' => ['usa', 'empire', 'slots'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 74,
                'name' => 'Fair Go Casino',
                'slug' => 'fair-go-casino',
                'logo' => 'FG',
                'rating' => 3.9,
                'established' => 2017,
                'rtp' => '96.35%',
                'games' => '350+',
                'bonus' => '200% up to $1,000',
                'payout' => '2-5 days',
                'categories' => ['australia', 'fair', 'rtg'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 75,
                'name' => 'Kahuna Casino',
                'slug' => 'kahuna-casino',
                'logo' => 'KA',
                'rating' => 3.8,
                'established' => 2020,
                'rtp' => '96.42%',
                'games' => '500+',
                'bonus' => '100% up to $300',
                'payout' => '1-3 days',
                'categories' => ['australia', 'kahuna', 'tropical'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 76,
                'name' => 'Joe Fortune',
                'slug' => 'joe-fortune',
                'logo' => 'JF',
                'rating' => 4.0,
                'established' => 2018,
                'rtp' => '96.65%',
                'games' => '250+',
                'bonus' => '200% up to $1,000',
                'payout' => '1-3 days',
                'categories' => ['australia', 'joe', 'fortune'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 77,
                'name' => 'Rich Casino',
                'slug' => 'rich-casino',
                'logo' => 'RI',
                'rating' => 3.7,
                'established' => 2018,
                'rtp' => '96.12%',
                'games' => '600+',
                'bonus' => '300% up to $3,000',
                'payout' => '2-5 days',
                'categories' => ['australia', 'rich', 'luxury'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 78,
                'name' => 'Mucho Vegas',
                'slug' => 'mucho-vegas',
                'logo' => 'MV',
                'rating' => 3.8,
                'established' => 2017,
                'rtp' => '96.28%',
                'games' => '400+',
                'bonus' => '150% up to $1,500',
                'payout' => '2-5 days',
                'categories' => ['vegas', 'mucho', 'spanish'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 79,
                'name' => 'Miami Club Casino',
                'slug' => 'miami-club-casino',
                'logo' => 'MC',
                'rating' => 3.6,
                'established' => 2012,
                'rtp' => '96.05%',
                'games' => '100+',
                'bonus' => '400% up to $800',
                'payout' => '3-7 days',
                'categories' => ['usa', 'miami', 'club'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 80,
                'name' => 'Drake Casino',
                'slug' => 'drake-casino',
                'logo' => 'DR',
                'rating' => 3.7,
                'established' => 2012,
                'rtp' => '96.18%',
                'games' => '180+',
                'bonus' => '300% up to $6,000',
                'payout' => '3-7 days',
                'categories' => ['usa', 'drake', 'urban'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 81,
                'name' => 'Treasure Mile',
                'slug' => 'treasure-mile',
                'logo' => 'TM',
                'rating' => 3.5,
                'established' => 2014,
                'rtp' => '95.95%',
                'games' => '120+',
                'bonus' => '350% up to $3,500',
                'payout' => '3-7 days',
                'categories' => ['usa', 'treasure', 'mile'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 82,
                'name' => 'Silver Oak Casino',
                'slug' => 'silver-oak-casino',
                'logo' => 'SO',
                'rating' => 3.6,
                'established' => 2009,
                'rtp' => '96.02%',
                'games' => '130+',
                'bonus' => '200% up to $12,000',
                'payout' => '3-7 days',
                'categories' => ['usa', 'silver', 'oak'],
                'featured' => false,
                'license' => 'Costa Rica'
            ],
            [
                'id' => 83,
                'name' => 'Grande Vegas',
                'slug' => 'grande-vegas',
                'logo' => 'GV',
                'rating' => 3.7,
                'established' => 2006,
                'rtp' => '96.15%',
                'games' => '140+',
                'bonus' => '200% up to $600',
                'payout' => '3-7 days',
                'categories' => ['usa', 'grande', 'vegas'],
                'featured' => false,
                'license' => 'Costa Rica'
            ],
            [
                'id' => 84,
                'name' => 'Cherry Jackpot',
                'slug' => 'cherry-jackpot',
                'logo' => 'CJ',
                'rating' => 3.8,
                'established' => 2017,
                'rtp' => '96.25%',
                'games' => '150+',
                'bonus' => '200% up to $20,000',
                'payout' => '2-5 days',
                'categories' => ['usa', 'cherry', 'jackpot'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 85,
                'name' => 'Spinfinity Casino',
                'slug' => 'spinfinity-casino',
                'logo' => 'SF',
                'rating' => 3.9,
                'established' => 2019,
                'rtp' => '96.48%',
                'games' => '800+',
                'bonus' => '100% up to $250',
                'payout' => '1-3 days',
                'categories' => ['new', 'infinity', 'spin'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 86,
                'name' => 'Pokie Spins',
                'slug' => 'pokie-spins',
                'logo' => 'PS',
                'rating' => 3.8,
                'established' => 2017,
                'rtp' => '96.32%',
                'games' => '600+',
                'bonus' => '100% up to $500',
                'payout' => '1-3 days',
                'categories' => ['australia', 'pokie', 'spins'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 87,
                'name' => 'True Blue Casino',
                'slug' => 'true-blue-casino',
                'logo' => 'TB',
                'rating' => 3.7,
                'established' => 2017,
                'rtp' => '96.18%',
                'games' => '300+',
                'bonus' => '200% up to $2,000',
                'payout' => '2-5 days',
                'categories' => ['australia', 'true', 'blue'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 88,
                'name' => 'House of Pokies',
                'slug' => 'house-of-pokies',
                'logo' => 'HP',
                'rating' => 3.6,
                'established' => 2020,
                'rtp' => '96.08%',
                'games' => '400+',
                'bonus' => '100% up to $1,000',
                'payout' => '2-5 days',
                'categories' => ['australia', 'house', 'pokies'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 89,
                'name' => 'Aussie Play Casino',
                'slug' => 'aussie-play-casino',
                'logo' => 'AP',
                'rating' => 3.8,
                'established' => 2018,
                'rtp' => '96.25%',
                'games' => '350+',
                'bonus' => '200% up to $1,500',
                'payout' => '2-5 days',
                'categories' => ['australia', 'aussie', 'play'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 90,
                'name' => 'Oshi Casino',
                'slug' => 'oshi-casino',
                'logo' => 'OS',
                'rating' => 4.0,
                'established' => 2020,
                'rtp' => '96.72%',
                'games' => '3,000+',
                'bonus' => '100% up to $500',
                'payout' => '1-3 days',
                'categories' => ['crypto', 'anime', 'new'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 91,
                'name' => 'BitCasino.io',
                'slug' => 'bitcasino-io',
                'logo' => 'BCI',
                'rating' => 4.1,
                'established' => 2014,
                'rtp' => '96.85%',
                'games' => '2,200+',
                'bonus' => 'mBTC Bonus',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'bitcoin', 'instant'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 92,
                'name' => 'CryptoWild',
                'slug' => 'cryptowild',
                'logo' => 'CW',
                'rating' => 3.9,
                'established' => 2017,
                'rtp' => '96.58%',
                'games' => '1,500+',
                'bonus' => '100% up to 1 BTC',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'wild', 'bitcoin'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 93,
                'name' => '1xBit Casino',
                'slug' => '1xbit-casino',
                'logo' => '1X',
                'rating' => 3.8,
                'established' => 2016,
                'rtp' => '96.42%',
                'games' => '4,000+',
                'bonus' => '100% up to 1 BTC',
                'payout' => '0-1 days',
                'categories' => ['crypto', 'sports', 'multi'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 94,
                'name' => 'King Billy Casino',
                'slug' => 'king-billy-casino',
                'logo' => 'KB',
                'rating' => 4.2,
                'established' => 2017,
                'rtp' => '96.95%',
                'games' => '3,500+',
                'bonus' => '100% up to $1,000',
                'payout' => '1-3 days',
                'categories' => ['king', 'royal', 'mobile'],
                'featured' => false,
                'license' => 'Curacao'
            ],
            [
                'id' => 95,
                'name' => 'Wazamba Casino',
                'slug' => 'wazamba-casino',
                'logo' => 'WZ',
                'rating' => 4.0,
                'established' => 2019,
                'rtp' => '96.68%',
                'games' => '4,000+',
                'bonus' => '100% up to $500',
                'payout' => '1-3 days',
                'categories' => ['tribal', 'adventure', 'new'],
                'featured' => false,
                'license' => 'Curacao'
            ]
            
            // Note: This completes our 95-casino database for comprehensive market coverage
        ];
    }
    
    /**
     * Get casino categories for filtering
     */
    public function getCategories(): array {
        return [
            'all' => 'All Casinos',
            'top-rated' => 'Top Rated',
            'new' => 'New Casinos',
            'live-casino' => 'Live Dealer',
            'mobile' => 'Mobile Optimized',
            'crypto' => 'Crypto Friendly',
            'slots' => 'Best for Slots',
            'high-roller' => 'High Roller',
            'fast-payout' => 'Fast Payout',
            'no-wagering' => 'No Wagering',
            'established' => 'Established',
            'canadian' => 'Canadian Friendly',
            'vip' => 'VIP Programs',
            'sports' => 'Sports Betting',
            'low-deposit' => 'Low Deposit'
        ];
    }
    
    public function filterCasinos($filters = [])
    {
        $casinos = $this->getAllCasinos();
        
        foreach ($filters as $filter_type => $filter_value) {
            $casinos = array_filter($casinos, function($casino) use ($filter_type, $filter_value) {
                switch ($filter_type) {
                    case 'min_rating':
                        return $casino['rating'] >= floatval($filter_value);
                    case 'max_rating':
                        return $casino['rating'] <= floatval($filter_value);
                    case 'category':
                        return in_array($filter_value, $casino['categories']);
                    case 'min_games':
                        $games_num = intval(str_replace(['+', ','], '', $casino['games']));
                        return $games_num >= intval($filter_value);
                    case 'license':
                        return $casino['license'] === $filter_value;
                    case 'established_range':
                        return $this->matchesEstablishedRange($casino['established'], $filter_value);
                    case 'featured':
                        return $casino['featured'] === ($filter_value === 'true');
                    default:
                        return true;
                }
            });
        }
        
        return $casinos;
    }
    
    public function getFilterOptions()
    {
        return [
            'rating' => [
                'min' => 1.0,
                'max' => 5.0,
                'step' => 0.1,
                'default_min' => 3.5
            ],
            'established' => [
                'ranges' => ['1990-2000', '2001-2010', '2011-2020', '2021-2025']
            ],
            'games_count' => [
                'ranges' => ['100-500', '501-1000', '1001-2000', '2001-5000', '5000+']
            ],
            'licenses' => [
                'options' => ['MGA', 'UKGC', 'Curacao', 'Gibraltar', 'Kahnawake', 'eCOGRA']
            ],
            'categories' => $this->getCategories()
        ];
    }
    
    private function matchesEstablishedRange($established, $range)
    {
        switch ($range) {
            case '1990-2000':
                return $established >= 1990 && $established <= 2000;
            case '2001-2010':
                return $established >= 2001 && $established <= 2010;
            case '2011-2020':
                return $established >= 2011 && $established <= 2020;
            case '2021-2025':
                return $established >= 2021 && $established <= 2025;
            default:
                return true;
        }
    }
    
    public function getCasinoById($id)
    {
        $casinos = $this->getAllCasinos();
        foreach ($casinos as $casino) {
            if ($casino['id'] == $id || $casino['slug'] === $id) {
                return $casino;
            }
        }
        return null;
    }
    
    public function getCasinosByIds($ids)
    {
        $casinos = $this->getAllCasinos();
        $result = [];
        
        foreach ($ids as $id) {
            foreach ($casinos as $casino) {
                if ($casino['id'] == $id || $casino['slug'] === $id) {
                    $result[] = $casino;
                    break;
                }
            }
        }
        
        return $result;
    }
    
    public function getStatistics()
    {
        $casinos = $this->getAllCasinos();
        
        return [
            'total_casinos' => count($casinos),
            'average_rating' => round(array_sum(array_column($casinos, 'rating')) / count($casinos), 1),
            'featured_casinos' => count(array_filter($casinos, function($casino) {
                return $casino['featured'];
            })),
            'new_casinos' => count(array_filter($casinos, function($casino) {
                return in_array('new', $casino['categories']);
            })),
            'crypto_casinos' => count(array_filter($casinos, function($casino) {
                return in_array('crypto', $casino['categories']);
            })),
            'mobile_casinos' => count(array_filter($casinos, function($casino) {
                return in_array('mobile', $casino['categories']);
            }))
        ];
    }
    
    /**
     * Sort casinos by specified field
     */
    public function sortCasinos(array $casinos, string $sortBy, string $direction = 'desc'): array {
        usort($casinos, function($a, $b) use ($sortBy, $direction) {
            $aValue = $a[$sortBy] ?? 0;
            $bValue = $b[$sortBy] ?? 0;
            
            // Handle different data types
            if ($sortBy === 'rating') {
                $comparison = $aValue <=> $bValue;
            } elseif ($sortBy === 'established') {
                $comparison = $aValue <=> $bValue;
            } elseif ($sortBy === 'name') {
                $comparison = strcmp($aValue, $bValue);
            } else {
                $comparison = $aValue <=> $bValue;
            }
            
            return $direction === 'desc' ? -$comparison : $comparison;
        });
        
        return $casinos;
    }
    
    /**
     * Get paginated casino results
     */
    public function paginateCasinos(array $casinos, int $page = 1, int $perPage = 20): array {
        $total = count($casinos);
        $offset = ($page - 1) * $perPage;
        $items = array_slice($casinos, $offset, $perPage);
        
        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage),
            'hasMore' => $page * $perPage < $total
        ];
    }
}
