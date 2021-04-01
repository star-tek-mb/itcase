<?php


namespace App\Repositories;

interface UserClickRepositoryInterface
{
    /**
     * Save a user click
     *
     * @param array $clickData
     * @return void
    */
    public function create($clickData);
}
