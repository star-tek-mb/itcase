<?php


namespace App\Repositories;

use App\Models\Service;

interface ServiceRepositoryInterface
{
    /**
     * Get all services
     *
     * @return array
    */
    public function all();

    /**
     * Get service by id
     *
     * @param int $serviceId
     * @return Service
    */
    public function get(int $serviceId);

    /**
     * Create a new service
     *
     * @param \Illuminate\Http\Request $serviceData
     * @return void
    */
    public function create($serviceData);

    /**
     * Update a service
     *
     * @param int $serviceId
     * @param \Illuminate\Http\Request $serviceData
     * @return void
    */
    public function update(int $serviceId, $serviceData);

    /**
     * Delete a service
     *
     * @param int $serviceId
     * @return void
    */
    public function delete(int $serviceId);
}
