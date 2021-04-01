<?php


namespace App\Repositories;

use App\Models\UserClick;

class UserClickRepository implements UserClickRepositoryInterface
{

    /**
     * Save a user click
     *
     * @param array $clickData
     * @return void
     */
    public function create($clickData)
    {
        UserClick::create($clickData);
    }
}
