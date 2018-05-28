<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\NewMessage;
use App\Notifications\ChatMessage;
use App\User;
use Auth;
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
        $date = Carbon::now();
        $participants = $request->participants;
        unset($participants[array_search($user['name'], $participants)]);

        event(
            (new NewMessage($message, $chat, $user))->dontBroadcastToCurrentUser()
        );

        foreach($participants as $participant) {
            $userNotify = User::findOrFail($participant['id']);
            Notification::send($userNotify, new ChatMessage($user, $chat, $message, $date));
        }

        $chat->addMessage($message);

    }
}
