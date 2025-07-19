<?php

/**
 * Enhanced Bonus Database Schema
 * Creates tables for comprehensive bonus management
 */

// Database connection
require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

try {
    // Enhanced bonuses table
    DB::schema()->dropIfExists('bonuses');
    DB::schema()->create('bonuses', function ($table) {
        $table->id();
        $table->unsignedBigInteger('casino_id');
        $table->enum('bonus_type', ['welcome', 'no_deposit', 'free_spins', 'reload', 'cashback', 'loyalty']);
        $table->string('title');
        $table->text('description')->nullable();
        $table->decimal('bonus_amount', 10, 2)->nullable();
        $table->integer('bonus_percentage')->nullable();
        $table->integer('free_spins_count')->nullable();
        $table->integer('wagering_requirement')->nullable();
        $table->decimal('min_deposit', 10, 2)->nullable();
        $table->decimal('max_bonus', 10, 2)->nullable();
        $table->text('game_restrictions')->nullable();
        $table->integer('time_limit_days')->nullable();
        $table->string('bonus_code', 50)->nullable();
        $table->boolean('exclusive')->default(false);
        $table->boolean('featured')->default(false);
        $table->date('valid_until')->nullable();
        $table->string('terms_url', 500)->nullable();
        $table->string('affiliate_link', 500)->nullable();
        $table->timestamps();
        
        // Indexes for performance
        $table->index(['casino_id', 'bonus_type']);
        $table->index('wagering_requirement');
        $table->index(['featured', 'bonus_type']);
    });

    // Bonus comparison tracking
    DB::schema()->dropIfExists('bonus_comparisons');
    DB::schema()->create('bonus_comparisons', function ($table) {
        $table->id();
        $table->string('session_id');
        $table->json('bonus_ids');
        $table->timestamps();
    });

    echo "✅ Bonus database tables created successfully!\n";

    // Insert sample bonus data
    $sampleBonuses = [
        [
            'casino_id' => 1, // Jackpot City
            'bonus_type' => 'welcome',
            'title' => '100% up to $4,000 + 210 Free Spins',
            'description' => 'Welcome bonus for new players on first deposit',
            'bonus_amount' => 4000.00,
            'bonus_percentage' => 100,
            'free_spins_count' => 210,
            'wagering_requirement' => 35,
            'min_deposit' => 1.00,
            'max_bonus' => 4000.00,
            'game_restrictions' => 'Slots only',
            'time_limit_days' => 7,
            'bonus_code' => null,
            'exclusive' => false,
            'featured' => true,
            'valid_until' => '2025-12-31',
            'terms_url' => 'https://www.jackpotcitycasino.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/jackpot-city'
        ],
        [
            'casino_id' => 2, // NOVAJACKPOT
            'bonus_type' => 'welcome',
            'title' => '100% up to $1,500 + 150 Free Spins',
            'description' => 'Exclusive welcome package for Canadian players',
            'bonus_amount' => 1500.00,
            'bonus_percentage' => 100,
            'free_spins_count' => 150,
            'wagering_requirement' => 30,
            'min_deposit' => 10.00,
            'max_bonus' => 1500.00,
            'game_restrictions' => 'Slots and live games',
            'time_limit_days' => 14,
            'bonus_code' => 'NOVA150',
            'exclusive' => true,
            'featured' => true,
            'valid_until' => '2025-12-31',
            'terms_url' => 'https://novajackpot.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/novajackpot'
        ],
        [
            'casino_id' => 3, // SPINIGHT
            'bonus_type' => 'welcome',
            'title' => '200% up to $2,000 + 100 Free Spins',
            'description' => 'Double your first deposit with this generous welcome bonus',
            'bonus_amount' => 2000.00,
            'bonus_percentage' => 200,
            'free_spins_count' => 100,
            'wagering_requirement' => 40,
            'min_deposit' => 20.00,
            'max_bonus' => 2000.00,
            'game_restrictions' => 'All casino games',
            'time_limit_days' => 10,
            'bonus_code' => 'SPIN200',
            'exclusive' => false,
            'featured' => true,
            'valid_until' => '2025-12-31',
            'terms_url' => 'https://spinight.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/spinight'
        ],
        [
            'casino_id' => 1, // Jackpot City - No Deposit
            'bonus_type' => 'no_deposit',
            'title' => '$25 No Deposit Bonus',
            'description' => 'Free cash bonus - no deposit required',
            'bonus_amount' => 25.00,
            'bonus_percentage' => null,
            'free_spins_count' => null,
            'wagering_requirement' => 50,
            'min_deposit' => 0.00,
            'max_bonus' => 25.00,
            'game_restrictions' => 'Slots only',
            'time_limit_days' => 3,
            'bonus_code' => 'NODEPOSIT25',
            'exclusive' => true,
            'featured' => false,
            'valid_until' => '2025-12-31',
            'terms_url' => 'https://www.jackpotcitycasino.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/jackpot-city-nodeposit'
        ],
        [
            'casino_id' => 2, // NOVAJACKPOT - Free Spins
            'bonus_type' => 'free_spins',
            'title' => '50 Free Spins on Starburst',
            'description' => 'No deposit required - claim your free spins now',
            'bonus_amount' => null,
            'bonus_percentage' => null,
            'free_spins_count' => 50,
            'wagering_requirement' => 35,
            'min_deposit' => 0.00,
            'max_bonus' => null,
            'game_restrictions' => 'Starburst slot only',
            'time_limit_days' => 7,
            'bonus_code' => 'FREESPIN50',
            'exclusive' => false,
            'featured' => true,
            'valid_until' => '2025-12-31',
            'terms_url' => 'https://novajackpot.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/novajackpot-freespins'
        ],
        [
            'casino_id' => 3, // SPINIGHT - Reload
            'bonus_type' => 'reload',
            'title' => '50% Reload Bonus up to $500',
            'description' => 'Weekly reload bonus for existing players',
            'bonus_amount' => 500.00,
            'bonus_percentage' => 50,
            'free_spins_count' => null,
            'wagering_requirement' => 25,
            'min_deposit' => 25.00,
            'max_bonus' => 500.00,
            'game_restrictions' => 'All games',
            'time_limit_days' => 5,
            'bonus_code' => 'RELOAD50',
            'exclusive' => false,
            'featured' => false,
            'valid_until' => '2025-12-31',
            'terms_url' => 'https://spinight.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/spinight-reload'
        ]
    ];

    foreach ($sampleBonuses as $bonus) {
        DB::table('bonuses')->insert($bonus);
    }

    echo "✅ Sample bonus data inserted successfully!\n";
    echo "📊 Created " . count($sampleBonuses) . " sample bonuses\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
