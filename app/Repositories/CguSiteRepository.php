<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 20.08.2019
 * Time: 20:34
 */

namespace App\Repositories;

use App\Models\CguCategory;
use App\Models\CguSite;

class CguSiteRepository implements CguSiteRepositoryInterface
{


    /**
     * @param $site_id
     * @return mixed
     */
    public function get($site_id)
    {
        return CguSite::find($site_id);
    }

    /**
     * Get's all categories.
     *
     * @return mixed
     */
    public function all()
    {
        return CguSite::orderBy('position', 'asc')->get();
    }

    /**
     * Deletes a site.
     *
     * @param int
     */
    public function delete($site_id)
    {
        $site = $this->get($site_id);
        $site->remove();
    }


    /**
     * @param $site_id
     * @param object $site_data
     * @return mixed
     */
    public function update($site_id, object $site_data)
    {
        $site = $this->get($site_id);
        $site->update($site_data->all());
        $site->uploadImage($site_data->file('image'));

        return $site;
    }

    /**
     * Store a category
     *
     * @param object $site_data
     * @return mixed
     */
    public function store(object $site_data)
    {
        $site = CguSite::create($site_data->all());
        $site->uploadImage($site_data->file('image'));

        return $site;
    }

    /**
     * @return mixed
     */
    public function getCategoriesTree()
    {
        return CguCategory::all()->toTree();
    }
}
