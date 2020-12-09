<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'text', 'user_id', 'chat_id'
    ];

    /**
     * Message author
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * A chat of the message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function chat()
    {
        return $this->hasOne(Chat::class, 'id', 'chat_id');
    }
}
