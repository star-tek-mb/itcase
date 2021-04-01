<?php

namespace App\Repositories;

//use Your Model

/**
 * Class BlogCategoryRepositoryInterface.
 */
interface BlogCategoryRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function get($blogcategory_id);

    /**
     * Get blog category by slug
     *
     * @param string $slug
     * @return \App\Models\BlogCategory
     */
    public function getBySlug(string $slug);

    public function all();

    public function delete($blogcategory_id);

    public function update($blogcategory_id, $blogcategory_data);

    public function store($blogcategory_data);
}
