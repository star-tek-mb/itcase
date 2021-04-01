<?php


namespace App\Repositories;

use App\Models\Service;

class ServiceRepository implements ServiceRepositoryInterface
{

    /**
     * Get all services
     *
     * @return array
     */
    public function all()
    {
        return Service::all();
    }

    /**
     * Get service by id
     *
     * @param int $serviceId
     * @return Service
     */
    public function get(int $serviceId)
    {
        return Service::findOrFail($serviceId);
    }

    /**
     * Create a new service
     *
     * @param \Illuminate\Http\Request $serviceData
     * @return void
     */
    public function create($serviceData)
    {
        Service::create($serviceData->all());
    }

    /**
     * Update a service
     *
     * @param int $serviceId
     * @param \Illuminate\Http\Request $serviceData
     * @return void
     */
    public function update(int $serviceId, $serviceData)
    {
        $this->get($serviceId)->update($serviceData->all());
    }

    /**
     * Delete a service
     *
     * @param int $serviceId
     * @return void
     */
    public function delete(int $serviceId)
    {
        Service::destroy($serviceId);
    }
}
