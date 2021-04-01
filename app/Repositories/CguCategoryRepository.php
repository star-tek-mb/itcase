<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 19.08.2019
 * Time: 21:57
 */

namespace App\Repositories;

use App\Models\CguCategory;

class CguCategoryRepository implements CguCategoryRepositoryInterface
{


    /**
     * @param $category_id
     * @return mixed
     */
    public function get($category_id)
    {
        return CguCategory::find($category_id);
    }

    /**
     * Get's all posts.
     *
     * @return mixed
     */
    public function all()
    {
        return CguCategory::orderBy('position', 'asc')->where('parent_id', null)->get();
    }


    /**
     * @param $category_id
     */
    public function delete($category_id)
    {
        $category = $this->get($category_id);

        $parent = null;
        if ($category->parent_id != null) {
            $parent = $category->parent_id;
        }

        $category->remove();

        return $parent;
    }


    /**
     * @param $category_id
     * @param object $category_data
     */
    public function update($category_id, object $category_data)
    {
        $category = CguCategory::find($category_id);
        $category->update($category_data->all());
        $category->uploadImage($category_data->file('image'));

        if ($category_data->get('parent_id') != 0) {
            $parent = CguCategory::find($category_data->get('parent_id'));
            $category->appendToNode($parent)->save();
        }

//        if($category_data->get('ru_slug') == null)
//            $category->createRuSlug($category_data->get('ru_title'));
//        else
//            $category->saveEnSlug($category_data->get('ru_title'));
//
//        if($category_data->get('en_slug') == null)
//            $category->createEnSlug($category_data->get('en_title'));
//        else
//            $category->saveEnSlug($category_data->get('en_title'));
//
//        if($category_data->get('uz_slug') == null)
//            $category->createUzSlug($category_data->get('uz_title'));
//        else
//            $category->saveUzSlug($category_data->get('uz_title'));

        return $category;
    }

    /**
     * @param object $category_data
     * @return mixed
     */
    public function store(object $category_data)
    {
        $category = CguCategory::create($category_data->all());
        $category->uploadImage($category_data->file('image'));

        if ($category_data->get('parent_id') != 0) {
            $parent = CguCategory::find($category_data->get('parent_id'));
            $category->appendToNode($parent)->save();
        }

//        if($category_data->get('ru_slug') == null)
//            $category->createRuSlug($category_data->get('ru_title'));
//        else
//            $category->saveEnSlug($category_data->get('ru_title'));
//
//        if($category_data->get('en_slug') == null)
//            $category->createEnSlug($category_data->get('en_title'));
//        else
//            $category->saveEnSlug($category_data->get('en_title'));
//
//        if($category_data->get('uz_slug') == null)
//            $category->createUzSlug($category_data->get('uz_title'));
//        else
//            $category->saveUzSlug($category_data->get('uz_title'));

        return $category;
    }

    /**
     * Возвращает всё дерево категориев цгу
     *
     * @return mixed
     */
    public function getTree()
    {
        return CguCategory::all()->toTree();
    }
}
