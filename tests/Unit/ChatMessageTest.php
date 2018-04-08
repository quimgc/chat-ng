<?php

namespace Tests\Unit;

use App\Chat;
use App\ChatMessage;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ChatMessageTest
 * @package Tests\Unit
 */
class ChatMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_formatted_created_at_date()
    {
        $message = ChatMessage::forceCreate([
            'body' => 'Prova',
            'user_id' => $user = factory(User::class)->create()->id,
            'chat_id' => Chat::forceCreate([ 'name' => 'Chat1'])->id,
            'created_at' => Carbon::parse('2016-12-01 8:00pm')
        ]);
        $this->assertEquals('08:00:00PM 01-12-2016', $message->formatted_created_at_date);
    }

}
