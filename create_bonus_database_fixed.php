<?php

/**
 * Enhanced Bonus Database Schema - Server Version
 * Creates tables for comprehensive bonus management
 */

// Load environment and database
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as DB;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Setup database connection
$capsule = new DB;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'], // Fixed: was DB_DATABASE
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    echo "🔄 Creating enhanced bonus database tables...\n";

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

    // Insert comprehensive bonus data
    $sampleBonuses = [
        // Welcome Bonuses
        [
            'casino_id' => 1, 'bonus_type' => 'welcome',
            'title' => '100% up to $4,000 + 210 Free Spins',
            'description' => 'Welcome bonus for new players on first deposit',
            'bonus_amount' => 4000.00, 'bonus_percentage' => 100, 'free_spins_count' => 210,
            'wagering_requirement' => 35, 'min_deposit' => 1.00, 'max_bonus' => 4000.00,
            'game_restrictions' => 'Slots only', 'time_limit_days' => 7, 'bonus_code' => null,
            'exclusive' => false, 'featured' => true, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://www.jackpotcitycasino.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/jackpot-city',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'casino_id' => 2, 'bonus_type' => 'welcome',
            'title' => '100% up to $1,500 + 150 Free Spins',
            'description' => 'Exclusive welcome package for Canadian players',
            'bonus_amount' => 1500.00, 'bonus_percentage' => 100, 'free_spins_count' => 150,
            'wagering_requirement' => 30, 'min_deposit' => 10.00, 'max_bonus' => 1500.00,
            'game_restrictions' => 'Slots and live games', 'time_limit_days' => 14, 'bonus_code' => 'NOVA150',
            'exclusive' => true, 'featured' => true, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://novajackpot.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/novajackpot',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'casino_id' => 3, 'bonus_type' => 'welcome',
            'title' => '200% up to $2,000 + 100 Free Spins',
            'description' => 'Double your first deposit with this generous welcome bonus',
            'bonus_amount' => 2000.00, 'bonus_percentage' => 200, 'free_spins_count' => 100,
            'wagering_requirement' => 40, 'min_deposit' => 20.00, 'max_bonus' => 2000.00,
            'game_restrictions' => 'All casino games', 'time_limit_days' => 10, 'bonus_code' => 'SPIN200',
            'exclusive' => false, 'featured' => true, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://spinight.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/spinight',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        
        // No Deposit Bonuses
        [
            'casino_id' => 1, 'bonus_type' => 'no_deposit',
            'title' => '$25 No Deposit Bonus',
            'description' => 'Free cash bonus - no deposit required',
            'bonus_amount' => 25.00, 'bonus_percentage' => null, 'free_spins_count' => null,
            'wagering_requirement' => 50, 'min_deposit' => 0.00, 'max_bonus' => 25.00,
            'game_restrictions' => 'Slots only', 'time_limit_days' => 3, 'bonus_code' => 'NODEPOSIT25',
            'exclusive' => true, 'featured' => false, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://www.jackpotcitycasino.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/jackpot-city-nodeposit',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'casino_id' => 2, 'bonus_type' => 'no_deposit',
            'title' => '$30 Free Play - No Deposit',
            'description' => 'Try our casino risk-free with $30 in free play credits',
            'bonus_amount' => 30.00, 'bonus_percentage' => null, 'free_spins_count' => null,
            'wagering_requirement' => 60, 'min_deposit' => 0.00, 'max_bonus' => 30.00,
            'game_restrictions' => 'Slots and table games', 'time_limit_days' => 2, 'bonus_code' => 'FREE30',
            'exclusive' => false, 'featured' => true, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://novajackpot.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/novajackpot-nodeposit',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        
        // Free Spins Bonuses
        [
            'casino_id' => 2, 'bonus_type' => 'free_spins',
            'title' => '50 Free Spins on Starburst',
            'description' => 'No deposit required - claim your free spins now',
            'bonus_amount' => null, 'bonus_percentage' => null, 'free_spins_count' => 50,
            'wagering_requirement' => 35, 'min_deposit' => 0.00, 'max_bonus' => null,
            'game_restrictions' => 'Starburst slot only', 'time_limit_days' => 7, 'bonus_code' => 'FREESPIN50',
            'exclusive' => false, 'featured' => true, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://novajackpot.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/novajackpot-freespins',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'casino_id' => 3, 'bonus_type' => 'free_spins',
            'title' => '100 Free Spins on Book of Dead',
            'description' => 'Embark on an adventure with 100 free spins',
            'bonus_amount' => null, 'bonus_percentage' => null, 'free_spins_count' => 100,
            'wagering_requirement' => 30, 'min_deposit' => 0.00, 'max_bonus' => null,
            'game_restrictions' => 'Book of Dead slot only', 'time_limit_days' => 5, 'bonus_code' => 'BOOK100',
            'exclusive' => true, 'featured' => false, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://spinight.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/spinight-freespins',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        
        // Reload Bonuses
        [
            'casino_id' => 3, 'bonus_type' => 'reload',
            'title' => '50% Reload Bonus up to $500',
            'description' => 'Weekly reload bonus for existing players',
            'bonus_amount' => 500.00, 'bonus_percentage' => 50, 'free_spins_count' => null,
            'wagering_requirement' => 25, 'min_deposit' => 25.00, 'max_bonus' => 500.00,
            'game_restrictions' => 'All games', 'time_limit_days' => 5, 'bonus_code' => 'RELOAD50',
            'exclusive' => false, 'featured' => false, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://spinight.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/spinight-reload',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'casino_id' => 1, 'bonus_type' => 'reload',
            'title' => '25% Monday Reload up to $300',
            'description' => 'Start your week with a bonus every Monday',
            'bonus_amount' => 300.00, 'bonus_percentage' => 25, 'free_spins_count' => null,
            'wagering_requirement' => 30, 'min_deposit' => 50.00, 'max_bonus' => 300.00,
            'game_restrictions' => 'Slots and video poker', 'time_limit_days' => 1, 'bonus_code' => 'MONDAY25',
            'exclusive' => false, 'featured' => false, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://www.jackpotcitycasino.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/jackpot-city-reload',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        
        // Cashback Bonuses
        [
            'casino_id' => 2, 'bonus_type' => 'cashback',
            'title' => '10% Weekly Cashback',
            'description' => 'Get 10% of your losses back every week',
            'bonus_amount' => null, 'bonus_percentage' => 10, 'free_spins_count' => null,
            'wagering_requirement' => 1, 'min_deposit' => null, 'max_bonus' => 1000.00,
            'game_restrictions' => 'All games', 'time_limit_days' => 7, 'bonus_code' => null,
            'exclusive' => false, 'featured' => true, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://novajackpot.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/novajackpot-cashback',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        
        // Additional Welcome Bonuses for variety
        [
            'casino_id' => 4, 'bonus_type' => 'welcome',
            'title' => '100% up to $1,200 + 120 Free Spins',
            'description' => 'Royal treatment for new members',
            'bonus_amount' => 1200.00, 'bonus_percentage' => 100, 'free_spins_count' => 120,
            'wagering_requirement' => 35, 'min_deposit' => 10.00, 'max_bonus' => 1200.00,
            'game_restrictions' => 'Slots and video poker', 'time_limit_days' => 7, 'bonus_code' => null,
            'exclusive' => false, 'featured' => true, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://royalvegas.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/royal-vegas',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'casino_id' => 5, 'bonus_type' => 'welcome',
            'title' => '100% up to $1,000',
            'description' => 'Classic welcome bonus for Canadian players',
            'bonus_amount' => 1000.00, 'bonus_percentage' => 100, 'free_spins_count' => null,
            'wagering_requirement' => 30, 'min_deposit' => 10.00, 'max_bonus' => 1000.00,
            'game_restrictions' => 'All casino games', 'time_limit_days' => 7, 'bonus_code' => null,
            'exclusive' => false, 'featured' => false, 'valid_until' => '2025-12-31',
            'terms_url' => 'https://betway.com/terms',
            'affiliate_link' => 'https://bestcasinoportal.com/go/betway',
            'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ]
    ];

    foreach ($sampleBonuses as $bonus) {
        DB::table('bonuses')->insert($bonus);
    }

    echo "✅ Enhanced bonus database setup complete!\n";
    echo "📊 Created " . count($sampleBonuses) . " comprehensive bonuses\n";
    echo "🎯 Bonus types: " . implode(', ', array_unique(array_column($sampleBonuses, 'bonus_type'))) . "\n";
    echo "💡 Featured bonuses: " . count(array_filter($sampleBonuses, fn($b) => $b['featured'])) . "\n";
    echo "🔥 Exclusive bonuses: " . count(array_filter($sampleBonuses, fn($b) => $b['exclusive'])) . "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
