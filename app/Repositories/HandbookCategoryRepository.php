<?php


namespace App\Repositories;

use App\Models\HandbookCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use mysql_xdevapi\Table;

class HandbookCategoryRepository implements HandbookCategoryRepositoryInterface
{
    /**
     * Get's a handbook category by it'id
     *
     * @param int $id
     * @return \App\Models\HandbookCategory
     */
    public function get($id)
    {
        return HandbookCategory::find($id);
    }

    /**
     * Gets all handbook categories
     *
     * @return mixed
     */
    public function all()
    {
        return HandbookCategory::where('parent_id', null)->orderBy('position', 'asc')->get();
    }


    public function categoryForTender($language)
    {
        switch ($language) {
            case 1:
                return HandbookCategory::select('id', 'uz_title as lang')->where('parent_id', null)->get();
            case 2:
                return HandbookCategory::select('id', 'ru_title as lang')->where('parent_id', null)->get();
            case 3:
                return HandbookCategory::select('id', 'en_title as lang')->where('parent_id', null)->get();
            default:
                return HandbookCategory::select('id', 'ru_title as lang')->where('parent_id', null)->get();
        }
    }
    public function subCategoryForTender($language, $id)
    {
        switch ($language) {
            case 1:
                return HandbookCategory::select('id', 'uz_title as lang')->where('parent_id', $id)->get();
            case 2:
                return HandbookCategory::select('id', 'ru_title as lang')->where('parent_id', $id)->get();
            case 3:
                return HandbookCategory::select('id', 'en_title as lang')->where('parent_id', $id)->get();
            default:
                return HandbookCategory::select('id', 'ru_title as lang')->where('parent_id', $id)->get();
        }
    }

    /**
     * Get all categories without tree
     *
     * @return array
     */
    public function allWithoutTree()
    {
        return HandbookCategory::all();
    }

    /**
     * Delete a handbook category
     *
     * @param int $id
     * @return int
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $category = $this->get($id);
        $parentId = $category->getParentId();
        $category->delete();
        return $parentId;
    }

    /**
     * Update a handbook category
     *
     * @param int $categoryId
     * @param \Illuminate\Http\Request $categoryData
     * @return \App\Models\HandbookCategory
     */
    public function update(int $categoryId, $categoryData)
    {
        $category = $this->get($categoryId);
        $category->update($categoryData->all());
        if (empty($categoryData->get('ru_slug'))) {
            $category->generateSlug();
        }
        if ($categoryData->has('favorite')) {
            $category->favorite = true;
        } else {
            $category->favorite = false;
        }
        $category->save();
        $category->uploadImage($categoryData->file('image'));

        $template = $categoryData->get('template');
        self::setTemplate($category, $template);

        return $category;
    }

    /**
     * Store a handbook category
     *
     * @param \Illuminate\Http\Request $categoryData
     * @return \App\Models\HandbookCategory
     */
    public function store($categoryData)
    {
        $category = HandbookCategory::create($categoryData->all());
        if ($categoryData->has('favorite')) {
            $category->favorite = true;
        } else {
            $category->favorite = false;
        }
        $category->save();
        if (empty($categoryData->get('ru_slug'))) {
            $category->generateSlug();
        }
        $category->uploadImage($categoryData->file('image'));

        $parentId = $categoryData->get('parent_id');

        if ($parentId != 0) {
            $parent = $this->get($parentId);
            $category->appendToNode($parent)->save();
        }

        $metaWords = ['Тендеры по', 'Заказы по', 'Работа по'];
        $category->tender_meta_title_prefix = $metaWords[array_rand($metaWords)];
        $category->save();

        $template = $categoryData->get('template');
        self::setTemplate($category, $template);

        return $category;
    }

    /**
     * Get tree of handbook categories
     *
     * @return object
     */
    public function getTree()
    {
        return HandbookCategory::all()->toTree();
    }
    /**
     *
     * array $categoryIds
     */
    public  function  getNumberOfCategories($categoryIds){
        return HandbookCategory::whereIn('id', $categoryIds)->count();
    }
    /**
     * Set position for category
     *
     * @param int $categoryId
     * @param int $position
     * @return bool
     */
    public function setPosition(int $categoryId, int $position)
    {
        $category = $this->get($categoryId);
        $category->position = $position;
        return $category->save();
    }

    /**
     * Get favorites categories
     *
     * @return array
     */
    public function getFavoriteCategories()
    {
        return HandbookCategory::where('favorite', true)->orderBy('position', 'asc')->get();
    }

    /**
     * Seacrh categories
     *
     * @param string $query
     * @param boolean $findOne
     * @return mixed
     */
    public function search(string $query, $findOne = false)
    {
        if ($findOne) {
            return HandbookCategory::where('ru_title', $query)->first();
        } else {
            return HandbookCategory::where('ru_title', 'like', "%$query%")->get();
        }
    }

    /**
     * Get category by slug
     *
     * @param string $slug
     * @return \App\Models\HandbookCategory
     */
    public function getBySlug(string $slug)
    {
        $category = HandbookCategory::where('ru_slug', $slug)->first();
        return $category;
    }

    private static function setTemplate(HandbookCategory $category, string $template)
    {
        if (!Storage::disk('catalog_templates')->exists($template . '.blade.php')) {
            $template = 'default';
        }
        $category->template = $template;
        $category->save();
        foreach ($category->descendants as $descendant) {
            $descendant->template = $template;
            $descendant->save();
        }
    }
}
