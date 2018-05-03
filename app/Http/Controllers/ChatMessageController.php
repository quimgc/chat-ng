<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\newMessage;
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
//        newMessage::dispatch();
        Log::info('send sms');

        $message = $request->body;

        event(
            (new newMessage($message, $chat))->dontBroadcastToCurrentUser()
        );

        $chat->addMessage($message);



        //TODO notifications al web push
    }
}
