<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use Log;

/**
 * Class ChatMessageController
 * @package App\Http\Controllers
 */
class ChatMessageController extends Controller
{
    /**
     * Create chat message
     */
    public function create(Request $request, Chat $chat)
    {

        $message = $request->body;

        event(
            (new NewMessage($message, $chat))->dontBroadcastToCurrentUser()
        );

        $chat->addMessage($message);

    }
}
