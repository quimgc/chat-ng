<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Chat.
 *
 * @package App
 */
class Chat extends Model
{
    /**
     * Get the messages for the chat.
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
