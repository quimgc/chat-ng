<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

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
        $chat->addMessage($request->body);
    }
}
