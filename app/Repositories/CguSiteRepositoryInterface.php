<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 20.08.2019
 * Time: 20:34
 */

namespace App\Repositories;

interface CguSiteRepositoryInterface
{
    /**
     * Get's a site by it's ID
     *
     * @param int
     */
    public function get($site_id);

    /**
     * Get's all categories.
     *
     * @return mixed
     */
    public function all();

    /**
     * Deletes a category.
     *
     * @param int
     */
    public function delete($site_id);

    /**
     * Updates a category.
     *
     * @param int
    $site_data     */
    public function update($site_id, object $site_data);


    /**
     * Store a category
     *
     * @param object $site_data
     * @return mixed
     */
    public function store(object $site_data);
}
