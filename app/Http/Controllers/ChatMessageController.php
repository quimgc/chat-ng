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
        Log::info($chat);
        event(new newMessage($chat, $request->user(), $request->body));

        $chat->addMessage($request->body);


        //TODO notifications al web push
    }
}
