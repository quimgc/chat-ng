<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\NewMessage;
use App\Notifications\ChatMessage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;
use Notification;

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
        $user = $request->user;

        event(
            (new NewMessage($message, $chat))->dontBroadcastToCurrentUser()
        );

//        Notification::send(User::all(), new ChatMessage($user['name'], $message, Carbon::now()));

        $chat->addMessage($message);

    }
}
