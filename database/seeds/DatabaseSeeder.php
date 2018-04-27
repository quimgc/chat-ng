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
        inititalize_test_database();

        MonthlyStatistic::forceCreate([
            'year' => 2018,
            'month' => 1,
            'new_users' => 30,
            'total_users' => 30,
            'chat_messages' => 20
        ]);
        MonthlyStatistic::forceCreate([
            'year' => 2018,
            'month' => 2,
            'new_users' => 30,
            'total_users' => 50,
            'chat_messages' => 50
        ]);
        MonthlyStatistic::forceCreate([
            'year' => 2018,
            'month' => 3,
            'new_users' => 10,
            'total_users' => 60,
            'chat_messages' => 10
        ]);
        MonthlyStatistic::forceCreate([
            'year' => 2018,
            'month' => 4,
            'new_users' => 5,
            'total_users' => 65,
            'chat_messages' => 20
        ]);


    }
}
