<?php

namespace Tests\Feature;

use App\Chat;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use View;

/**
 * Class ChatsTest.
 *
 * @package Tests\Feature
 */
class ChatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_user_can_see_chats()
    {
        $user = factory(User::class)->create();

        Chat::forceCreate(['name' => 'Chat1' ]);
        Chat::forceCreate(['name' => 'Chat2' ]);
        Chat::forceCreate(['name' => 'Chat3' ]);

        View::share('user', $user);
        $response = $this->actingAs($user)->get('/chats');
        $response->assertSuccessful();
        $response->assertSeeText('Chat1');
        $response->assertSeeText('Chat2');
        $response->assertSeeText('Chat3');
    }

    /** @test */
    public function logged_user_can_join_to_specific_chat()
    {
        $user = factory(User::class)->create();
        View::share('user', $user);

        $chat = Chat::forceCreate(['name' => 'Chat1' ]);

        $response = $this->actingAs($user)->get('/chat/' . $chat->id);
        $response->assertSuccessful();

    }
}
