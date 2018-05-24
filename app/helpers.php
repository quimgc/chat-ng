<?php

use Acacha\User\GuestUser;
use App\Chat;
use App\ChatMessage;
use App\Http\Resources\UserResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Mail\Message;

if (!function_exists('randomDate')) {
    /**
     * Method to generate random date between two dates.
     *
     * @param $sStartDate
     * @param $sEndDate
     * @param string $sFormat
     * @return bool|string
     */
    function randomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d H:i:s')
    {
        // Convert the supplied date to timestamp
        $fMin = strtotime($sStartDate);
        $fMax = strtotime($sEndDate);
        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);
        // Convert back to the specified date format
        return date($sFormat, $fVal);
    }
}

if (!function_exists('create_test_database')) {
    function create_test_database()
    {
        $now = Carbon::now();
        foreach (range(1, $now->month) as $month) {
            dump('Month: ' . $month);
            foreach (range(1, rand(50, 1000)) as $user) {
                dump('Creating user number ' , $user);
                dump($randomDate = randomDate(
                    Carbon::createFromDate(null, $month, 1)->startOfMonth(),
                    Carbon::createFromDate(null, $month, 1)->endOfMonth()));
                factory(User::class)->create([
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate
                ]);
            }
        }
    }
}

if (!function_exists('generate_messages_for_chat')) {

    function generate_messages_for_chat() {

        $now = Carbon::now();
        foreach (range(1, $now->month) as $month) {
            dump('Month: ' . $month);
            foreach (range(1, rand(50, 1000)) as $user) {
                dump('Creating chat message ' , $user);
                dump($randomDate = randomDate(
                    Carbon::createFromDate(null, $month, 1)->startOfMonth(),
                    Carbon::createFromDate(null, $month, 1)->endOfMonth()));
                factory(ChatMessage::class)->create([
                    'body' => 'Missatge generat automàticament.',
                    'user_id' => 1,
                    'chat_id' => 1,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate
                ]);
            }
        }
    }
}

if (!function_exists('inititalize_test_database')) {
    function inititalize_test_database() {
        $chat1 = Chat::forceCreate(['name' => 'Chat1' ]);
        Chat::forceCreate(['name' => 'Chat2' ]);
        Chat::forceCreate(['name' => 'Chat3' ]);

        // Add some messages to Chat 1
        $user = factory(User::class)->create();
        $chat1->addMessage('Hello world!',$user);
        $chat1->addMessage('Hello foo!',$user);
        $user2 = factory(User::class)->create();
        $chat1->addMessage('Hello bar!',$user2);
    }
}

if (!function_exists('random_avatar_path')) {
    function random_avatar_path()
    {
        $avatars = [
            '/img/avatar.png',
            '/img/avatar2.png',
            '/img/avatar3.png',
            '/img/avatar04.png',
            '/img/avatar5.png',
            '/img/user1-128x128.jpg',
            '/img/user2-160x160.jpg',
            '/img/user3-128x128.jpg',
            '/img/user4-128x128.jpg',
            '/img/user5-128x128.jpg',
            '/img/user6-128x128.jpg',
            '/img/user7-128x128.jpg',
            '/img/user8-128x128.jpg'
        ];
        return $avatars[array_rand($avatars)];
    }
}



if (!function_exists('formatted_logged_user')) {
    function formatted_logged_user()
    {
        if(!Auth::user()) return new GuestUser();
        return json_encode((new UserResource(Auth::user()))->resolve());
    }
}

if (!function_exists('get_chat_monthly_info')) {

    function get_chat_monthly_info($year = null, $month = null)
    {
        Artisan::call('cache:clear');

        if($year == null && $month == null) {
            $year = Carbon::now()->year;
            $month = Carbon::now()->subMonth()->month;
        }

        DB::table('monthly_statistics')->insert([
            'year' => $year,
            'month' => $month,
            'new_users' =>  DB::table('users')
                ->whereYear('created_at',strval($year))
                ->whereMonth('created_at',str_pad($month, 2, '0', STR_PAD_LEFT))
                ->count(),
            'total_users' => DB::table('users')
                ->whereYear('created_at', strval($year))
                ->whereMonth('created_at','<=',str_pad($month,2,'0',STR_PAD_LEFT))
                ->count(),
            'chat_messages' => DB::table('chat_messages')
                ->whereYear('created_at',strval($year))
                ->whereMonth('created_at',str_pad($month,2,'0',STR_PAD_LEFT))
                ->count(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}

if (!function_exists('create_user')) {
    function create_user()
    {
        factory(User::class)->create([
            'name' => env('TASKS_USER_NAME', 'Quim González Colat'),
            'email' => env('TASKS_USER_EMAIL', 'quimgonzalez@iesebre.com'),
            'password' => bcrypt(env('TASKS_USER_PASSWORD')),
        ]);

        factory(User::class)->create([
            'name' => env('TASKS_USER_NAME_PROF', 'Sergi Tur Badenas'),
            'email' => env('TASKS_USER_EMAIL_PROF', 'sergiturbadenas@gmail.com'),
            'password' => bcrypt(env('TASKS_USER_PASSWORD_PROF')),
        ]);
    }
}

if (!function_exists('generate_monthly_statistics')) {
    function generate_monthly_statistics() {
        for ($i = 1; $i<Carbon::now()->month; $i++) {
            $year = Carbon::now()->year;
            get_chat_monthly_info($year, $i);
        }
    }
}
