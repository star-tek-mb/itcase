<?php


namespace App\Repositories;

use App\Models\MenuItem;

class MenuRepository implements MenuRepositoryInterface
{

    /**
     * Get Menu item by id
     *
     * @param int $id
     * @return MenuItem
     */
    public function get(int $id)
    {
        return MenuItem::findOrFail($id);
    }

    /**
     * Get Menu item by slug
     *
     * @param string $slug
     * @return MenuItem
     */
    public function getBySlug(string $slug)
    {
        return MenuItem::where('ru_slug', $slug)->first();
    }

    /**
     * Create a menu item
     *
     * @param \Illuminate\Http\Request $menuData
     */
    public function create($menuData)
    {
        $newMenuItem = MenuItem::create($menuData->all());
        $newMenuItem->uploadImage($menuData->file('image'));
        $categoriesIds = $menuData->get('categories');
        $newMenuItem->categories()->attach($categoriesIds);
        $metaWords = ['Тендеры по', 'Заказы по', 'Работа по'];
        $newMenuItem->tender_meta_title_prefix = $metaWords[array_rand($metaWords)];
        $newMenuItem->save();
        if (empty($menuData->get('ru_slug'))) {
            $newMenuItem->generateSlug();
        }
    }

    /**
     * Update a menu item
     *
     * @param int $id
     * @param \Illuminate\Http\Request $menuData
     */
    public function update(int $id, $menuData)
    {
        $menuItem = $this->get($id);
        $menuItem->update($menuData->all());
        $menuItem->uploadImage($menuData->file('image'));
        $menuItem->categories()->detach();
        $menuItem->categories()->attach($menuData->get('categories'));
        if (empty($menuData->get('ru_slug'))) {
            $menuItem->generateSlug();
        }
    }

    /**
     * Delete a menu item
     *
     * @param int $id
     * @throws \Exception
     * @return int
     */
    public function delete(int $id)
    {
        $menuItem = $this->get($id);
        $needId = $menuItem->need_id;
        $menuItem->delete();
        return $needId;
    }
}
