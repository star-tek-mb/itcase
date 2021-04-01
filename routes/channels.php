<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.{id}', function ($user, $id) {
    $chat = \App\Models\Chat\Chat::find($id);
    if (!$chat) {
        return false;
    }
    return $chat->participants()->where('user_id', $user->id)->count() > 0;
});
