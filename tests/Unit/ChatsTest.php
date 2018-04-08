<?php

namespace Tests\Unit;

use App\Chat;
use App\ChatMessage;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ChatsTest
 * @package Tests\Unit
 */
class ChatsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_messages_to_chat()
    {
        $chat = Chat::forceCreate(['name' => 'Chat1' ]);
        $this->assertCount(0, $chat->messages);
        $chat->addMessage('Hello world!',factory(User::class)->create());
        $chat = $chat->fresh();
        $this->assertCount(1, $chat->messages);
        $this->assertEquals('Hello world!', $chat->messages[0]->body);
    }
}
