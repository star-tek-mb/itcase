<?php
namespace App\Repositories;

use App\Models\MenuItem;

interface MenuRepositoryInterface
{
    /**
     * Get Menu item by id
     *
     * @param int $id
     * @return MenuItem
     */
    public function get(int $id);

    /**
     * Get Menu item by slug
     *
     * @param string $slug
     * @return MenuItem
     */
    public function getBySlug(string $slug);

    /**
     * Create a menu item
     *
     * @param \Illuminate\Http\Request $menuData
     */
    public function create($menuData);

    /**
     * Update a menu item
     *
     * @param int $id
     * @param \Illuminate\Http\Request $menuData
    */
    public function update(int $id, $menuData);

    /**
     * Delete a menu item
     *
     * @param int $id
     * @return int
    */
    public function delete(int $id);
}
