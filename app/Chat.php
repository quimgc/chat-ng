<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Log;

/**
 * Class Chat.
 *
 * @package App
 */
class Chat extends Model
{

    protected $guarded = [];

    /**
     * Get the messages for the chat.
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Add message to chat.
     *
     * @param $message
     * @param null $user
     */
    public function addMessage($message, $user = null)
    {
        if (!$user) $user = Auth::user();
        $ChatMessage = new ChatMessage([
            'body' => $message,
            'user_id' => $user->id,
        ]);
        $this->messages()->save($ChatMessage);
    }

}
