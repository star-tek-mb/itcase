<?php


namespace App\Repositories;

use App\Models\Chat\Chat;

/**
 * Interface ChatRepositoryInterface
 * @package App\Repositories
 */
interface ChatRepositoryInterface
{
    /**
     * Create a new chat with participants
     *
     * @param $participantsIds
     * @return Chat
     */
    public function create($participantsIds);

    /**
     * Get a chat by id
     *
     * @param $chatId
     * @return Chat
     */
    public function getById($chatId);

    /**
     * Delete a chat
     *
     * @param $chatId
     * @return mixed
     */
    public function delete($chatId);
}
