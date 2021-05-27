<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Components\Image;
use App\Models\Components\Slug;

//use Kalnoy\Nestedset\NodeTrait;

class BlogPost extends Model
{
    use Image;
    use Slug;

    const UPLOAD_DIRECTORY = 'uploads/blogposts/';

    protected $fillable = [
        'ru_short_content', 'uz_short_content', 'en_short_content',
        'meta_title', 'meta_description', 'meta_keywords',
        'ru_content', 'uz_content', 'en_content',
        'ru_title', 'en_title', 'uz_title',
        'ru_slug', 'en_slug', 'uz_slug',
        'category_id'
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

    public function category()
    {
        return $this->hasOne(BlogCategory::class, 'id', 'category_id');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return strip_tags($this->ru_title);
    }

    /**
     * Override delete method to delete image too
     *
     * @return void
     * @throws \Exception
     */
    public function delete()
    {
        $this->removeImage();
        parent::delete();
    }

    public function getShortContent()
    {
        return strip_tags($this->ru_short_content);
    }

    public function getAncestorsSlugs()
    {
        if ($this->category) {
            return $this->category->ru_slug . "/$this->ru_slug";
        } else {
            return $this->ru_slug;
        }
    }

    public function getSlugAttribute()
    {
        $locale = config('app.locale');
        if ($locale == 'uz') {
            return $this->uz_slug;
        } else if ($locale == 'en') {
            return $this->en_slug;
        } else {
            return $this->ru_slug;
        }
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

    public function getContentAttribute()
    {
        $locale = config('app.locale');
        if ($locale == 'uz') {
            return $this->uz_content;
        } else if ($locale == 'en') {
            return $this->en_content;
        } else {
            return $this->ru_content;
        }
    }

    public function getSummaryAttribute()
    {
        $locale = config('app.locale');
        if ($locale == 'uz') {
            return $this->uz_short_content;
        } else if ($locale == 'en') {
            return $this->en_short_content;
        } else {
            return $this->ru_short_content;
        }
    }
}
