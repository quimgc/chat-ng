<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatMessage.
 *
 * @package App
 */
class ChatMessage extends Model
{
    protected $guarded = [];

    protected $appends = ['formatted_created_at_date'];

    /**
     * Get the user that owns the chat message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * formatted_created_at_date attribute.
     *
     * @return mixed
     */
    public function getFormattedCreatedAtDateAttribute()
    {
        return $this->created_at->format('h:i:sA d-m-Y');
    }
}
