<?php

namespace App\Http\Controllers;

use App\Chat;

/**
 * Class ChatController.
 *
 * @package App\Http\Controllers
 */
class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chats',['chats' => Chat::all()]);
    }

    /**
     * Show chat
     *
     * @param Chat $chat
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Chat $chat)
    {
        return view('chat',['chat' => $chat]);
    }

}
