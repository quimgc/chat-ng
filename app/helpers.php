<?php

use Acacha\User\GuestUser;
use App\Chat;
use App\Http\Resources\UserResource;
use App\User;

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
