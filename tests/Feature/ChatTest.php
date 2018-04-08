<?php

namespace Tests\Feature;

use App\Chat;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use View;

/**
 * Class ChatTest.
 * @package Tests\Feature
 */
class ChatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_user_can_see_chat()
    {
        $user = factory(User::class)->create();
        View::share('user', $user);

        $chat1 = Chat::forceCreate(['name' => 'Chat1' ]);

        // Add some messages to Chat 1
        $user = factory(User::class)->create();
        $chat1->addMessage('Hello world!',$user);
        $chat1->addMessage('Hello foo!',$user);
        $user2 = factory(User::class)->create();
        $chat1->addMessage('Hello bar!',$user2);

        $chat = Chat::findOrFail(1);

        $response = $this->actingAs($user)->get('/chat/' . $chat->id);
        $response->assertSuccessful();
        $response->assertSee('Hello world!');
        $response->assertSee('Hello foo!');
        $response->assertSee('Hello bar!');
        $response->assertSee($user->name);
        $response->assertSee($user2->name);
    }
}
