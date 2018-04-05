<?php

use App\Chat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        Chat::forceCreate(['name' => 'Chat1' ]);
        Chat::forceCreate(['name' => 'Chat2' ]);
        Chat::forceCreate(['name' => 'Chat3' ]);
    }
}
