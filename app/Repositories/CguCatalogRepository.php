<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 22.08.2019
 * Time: 10:40
 */

namespace App\Repositories;

use App\Models\CguCatalog;
use App\Models\CguCategory;

class CguCatalogRepository implements CguCatalogRepositoryInterface
{

    /**
     * @param $catalog_id
     * @return mixed
     */
    public function get($catalog_id)
    {
        return CguCatalog::find($catalog_id);
    }

    public function removeFile($id)
    {
        $catalog = $this->get($id);
        $catalog->removeFile();
    }

    /**
     * Get's all catalogs.
     *
     * @return mixed
     */
    public function all()
    {
        return CguCatalog::orderBy('id', 'desc')->get();
    }

    /**
     * Deletes a catalog.
     *
     * @param int
     */
    public function delete($catalog_data)
    {
        $catalog = $this->get($catalog_data);
        $catalog->remove();
    }


    /**
     * @param $catalog_id
     * @param object $catalog_data
     * @return mixed
     */
    public function update($catalog_id, object $catalog_data)
    {
        $catalog = $this->get($catalog_id);
        $catalog->update($catalog_data->all());
        $catalog->uploadFile($catalog_data->file('file'));

        return $catalog;
    }

    /**
     * Store a catalog
     *
     * @param object $catalog_data
     * @return mixed
     */
    public function store(object $catalog_data)
    {
        $catalog = CguCatalog::create($catalog_data->all());
        $catalog->uploadFile($catalog_data->file('file'));

        return $catalog;
    }

    public function getTree()
    {
        return CguCategory::all()->toTree();
    }
}
