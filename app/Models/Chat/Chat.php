<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    /**
     * All chat's participants
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'chat_participants', 'chat_id', 'user_id');
    }

    /**
     * All chat's messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id', 'id');
    }

    public function getAnotherUser($currentUser = null)
    {
        if (!$currentUser) {
            $currentUser = auth()->user();
        }
        return $this->participants()->where('user_id', '!=', $currentUser->id)->first();
    }



    public function getLastMessageText()
    {
        $message = $this->messages()->orderByDesc('created_at')->first();
        if ($message) {
            return $message->text;
        }
        return 'Новых сообщений нет';
    }
}
