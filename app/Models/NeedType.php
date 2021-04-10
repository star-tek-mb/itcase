<?php

namespace App\Models;

use App\Models\Components\Slug;
use Illuminate\Database\Eloquent\Model;

class NeedType extends Model
{
    use Slug;

    protected $fillable = [
        'ru_title', 'uz_title', 'en_title',
        'meta_title', 'meta_description', 'meta_keywords',
        'ru_slug', 'en_slug', 'uz_slug', 'url',
        'meta_title', 'meta_description', 'meta_keywords'
    ];

    /**
     * Get all companies for this need type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany(Company::class, 'need_id', 'id');
    }

    /**
     * Menu Items for this type of
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'need_id', 'id');
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

    public function getTitleAttribute()
    {
        $locale = config('app.locale');
        if ($locale == 'uz') {
            return $this->uz_title;
        } else if ($locale == 'en') {
            return $this->en_title;
        } else {
            return $this->ru_title;
        }
    }

}
