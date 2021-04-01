<?php


namespace App\Repositories;

use App\Models\FaqGroup;
use Illuminate\Database\Eloquent\Collection;

interface FaqRepositoryInterface
{
    /**
     * Get all FAQ
     * @return Collection
     */
    public function all();

    /**
     * Get FAQ by id
     * @param int $faqId
     * @return FaqGroup
     */
    public function get(int $faqId);

    /**
     * Create a new FAQ
     * @param $faqData
     * @return FaqGroup
     */
    public function create($faqData);

    /**
     * Edit FAQ
     * @param int $faqId
     * @param $faqData
     * @return FaqGroup
     */
    public function update(int $faqId, $faqData);

    /**
     * Delete FAQ
     * @param int $faqId
     * @return void
     */
    public function delete(int $faqId);
}
