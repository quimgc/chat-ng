<?php

use App\MonthlyStatistic;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        create_user();
        inititalize_test_database();
        create_test_database();
        generate_messages_for_chat();
        generate_monthly_statistics();

    }
}
