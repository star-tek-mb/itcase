<?php

namespace App\Models;

use App\Models\Components\Image;
use App\Models\Components\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MenuItem extends Model
{
    use Image;
    use Slug;

    protected $fillable = [
        'ru_title', 'en_title', 'uz_title', 'need_id',
        'ru_description', 'uz_description', 'en_description',
        'ru_slug', 'en_slug', 'uz_slug',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            event('model.changed');
        });

        static::updated(function ($item) {
            event('model.changed');
        });

        static::deleted(function ($item) {
            event('model.changed');
        });
    }

    const UPLOAD_DIRECTORY = 'uploads/menu_items_images/';

    /**
     * Type of need
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function needType()
    {
        return $this->hasOne(NeedType::class, 'id', 'need_id');
    }

    /**
     * Categories for this menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->belongsToMany(HandbookCategory::class, 'categories_menus', 'menu_id', 'category_id');
    }

    /**
     * Get array of attached categories ids
     *
     * @return array
     */
    public function getCategoriesIdsAsArray()
    {
        return $this->categories()->pluck('handbook_categories.id')->toArray();
    }

    public function delete()
    {
        $this->removeImage();
        return parent::delete();
    }

    /**
     * Get cleand title
     *
     * @return string
     */
    public function getTitle()
    {
        return strip_tags($this->ru_title);
    }

    /**
     * @return Collection Companies from all menu item's categories
     */
    public function getCompanyFromCategories()
    {
        $companies = collect();
        foreach ($this->categories as $category) {
            $categoryCompanies = $category->getAllCompaniesFromDescendingCategories();
            $companies = $companies->merge($categoryCompanies);
        }
        return $companies;
    }
}
