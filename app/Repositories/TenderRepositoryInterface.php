<?php


namespace App\Repositories;

use App\Models\TenderRequest;

interface TenderRepositoryInterface
{
    /**
     * Get all tenders with no order
     * @return mixed
     */
    public function all();

    /**
     * Get all tenders ordered by created at field
     * @param bool $withoutContractors
     * @return mixed
     */
    public function allOrderedByCreatedAt($withoutContractors = false);

    // Search tender
    // @param Request $search
    // return mixed
    public function TenderSearch(Request $search);

    /**
     * Create a new tender
     *
     * @param \Illuminate\Http\Request $data
     * @return \App\Models\Tender
     */
    public function create($data);


    /**
     * Update a tender
     *
     * @param int $id
     * @param \Illuminate\Http\Request $data
     * @return void
     */
    public function update($id, $data);

    /**
     * Delete a tender
     *
     * @param int $id
     * @return void
     */
    public function delete($id);

    /**
     * Get a tender by id
     *
     * @param $id
     * @return \App\Models\Tender
     */
    public function get($id);

    /**
     * Get a tender by slug
     *
     * @param $slug
     * @return \App\Models\Tender
     */
    public function getBySlug(string $slug);

    /**
     * Create a request for tender
     *
     * @param \Illuminate\Http\Request $data
     * @return TenderRequest
     */
    public function createRequest($data);

    /**
     * Cancel the request
     *
     * @param $requestId
     * @return mixed
     */
    public function cancelRequest($requestId);

    /**
     * Accept request for tender
     *
     * @param $tenderId
     * @param $requestId
     * @return boolean
     */
    public function acceptRequest($tenderId, $requestId);

    /**
     * Set the owner to the tender
     *
     * @param $tenderId
     * @param $userId
     * @return mixed
     */
    public function setOwnerToTender($tenderId, $userId);

    /**
     * Manually add contractor to tender
     *
     * @param $tenderId
     * @param $contractorId
     * @return \App\Models\TenderRequest
     */
    public function addContractor($tenderId, $contractorId);

    /**
     * Publish the tender
     *
     * @param $tenderId
     * @return \App\Models\Tender
     */
    public function publishTender($tenderId);
}
