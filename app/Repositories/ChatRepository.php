<?php


namespace App\Repositories;

use App\Models\Chat\Chat;

class ChatRepository implements ChatRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function create($participantsIds)
    {
        $chat = Chat::create();
        $chat->participants()->attach($participantsIds);
        return $chat;
    }

    /**
     * @inheritDoc
     */
    public function getById($chatId)
    {
        return Chat::findOrFail($chatId);
    }

    /**
     * @inheritDoc
     */
    public function delete($chatId)
    {
        Chat::destroy($chatId);
    }
}
