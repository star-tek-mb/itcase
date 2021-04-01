<?php

namespace App\Repositories;

use App\Models\BlogCategory;

//use Your Model

/**
 * Class BlogCategoryRepository.
 */
class BlogCategoryRepository implements BlogCategoryRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    /**
     * @param $blogcategory_id
     * @return mixed
     */
    public function get($blogcategory_id)
    {
        return BlogCategory::findOrFail($blogcategory_id);
    }
    /**
     * Get's all posts.
     *
     * @return mixed
     */
    public function all()
    {
        return BlogCategory::all();
    }


    /**
     * @param $blogcategory_id
     */
    public function delete($blogcategory_id)
    {
        BlogCategory::destroy($blogcategory_id);
    }

    /**
     * @param $blogcategory_id
     * @param $blogcategory_data
     * @return
     */
    public function update($blogcategory_id, $blogcategory_data)
    {
        $category = BlogCategory::findOrFail($blogcategory_id);
        $category->update($blogcategory_data->all());

        return $category;
    }

    /**
     * @param object $blogcategory_data
     * @return mixed
     */
    public function store($blogcategory_data)
    {
        $category = BlogCategory::create($blogcategory_data->all());
        $category->generateSlug();

        return $category;
    }

    /**
     * @inheritDoc
     */
    public function getBySlug(string $slug)
    {
        return BlogCategory::where('ru_slug', $slug)->first();
    }
}
