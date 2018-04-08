<?php

namespace Tests\Feature;

use App\Chat;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use View;

/**
 * Class ChatMessagesControllerTest
 * @package Tests\Feature
 */
class ChatMessagesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_user_can_add_message_to_chat()
    {
        $logged_user = factory(User::class)->create();
        View::share('user', $logged_user);

        $chat1 = Chat::forceCreate(['name' => 'Chat1' ]);

        // Add some messages to Chat 1
        $user = factory(User::class)->create();
        $chat1->addMessage('Hello world!',$user);
        $chat1->addMessage('Hello foo!',$user);
        $user2 = factory(User::class)->create();
        $chat1->addMessage('Hello bar!',$user2);

        $chat = Chat::findOrFail(1);

        $this->assertCount(3,$chat->messages);

        $response = $this->actingAs($logged_user)->post('/chat/' . $chat->id . '/message', [
            'body' => 'Catalonia is not spain!'
        ]);

        $response->assertSuccessful();
        $chat = $chat->fresh();
        $this->assertCount(4, $chat->messages);
        $this->assertEquals('Catalonia is not spain!', $chat->messages[3]->body);
    }
}
