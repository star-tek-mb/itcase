<?php


namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all users
     *
     * @return mixed
    */
    public function all();

    /**
     * Get user by search
     *
     * @param request $search
     * @return Users
    */
    public function searchContractors(Request $search);

    /**
     * Get user by it's id
     *
     * @param int $userId
     * @return User
    */


    public function get($userId);

    /**
     * Create an User
     *
     * @param \Illuminate\Http\Request $userData
     * @param int $userRoleId
     * @return void
    */
    public function create($userData, $userRoleId);

    /**
     * Update an user
     *
     * @param int $userId
     * @param \Illuminate\Http\Request $userData
     * @return void
    */
    public function update($userId, $userData);

    /**
     * Delete user
     *
     * @param int $userId
     * @return void
    */
    public function delete($userId);

    /**
     * Get all users with role 'admin'
     *
     * @return mixed
    */
    public function getAdmins();

    /**
     * Get all users with role 'customer'
     *
     * @return mixed
    */
    public function getCustomers();

    /**
     * Get all roles
     *
     * @return array
    */
    public function allRoles();

    /**
     * Get all digital agencies
     *
     * @return Collection
     */
    public function getContractors();

    /**
     * Get contractor company by slug
     *
     * @param string $slug
     * @return User
     */
    public function getContractorBySlug(string $slug);

    /**
     * Create an account for user
     *
     * @param \Illuminate\Http\Request $data
     * @return mixed
     */
    public function createAccount($data);

    /**
     * Register new user via Telegram
     *
     * @param \Illuminate\Http\Request $data
     * @return mixed
     */
    public function createUserViaTelegram($data);

    /**
     * Get user by Telegram ID
     *
     * @param int $telegramId
     * @return User
     */
    public function getUserByTelegramId(int $telegramId);
}
