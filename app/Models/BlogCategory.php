<?php

namespace App\Models;

use App\Models\Components\Slug;
use Illuminate\Database\Eloquent\Model;
use function foo\func;

class BlogCategory extends Model
{
    use Slug;

    protected $fillable = [
        'ru_title', 'en_title', 'uz_title',
        'ru_slug', 'en_slug', 'uz_slug',
        'meta_title', 'meta_description', 'meta_keywords'
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

    /**
     * Возвращаем очищенный заголовок
     *
     * @return string
     */
    public function getTitle()
    {
        return strip_tags($this->ru_title);
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id', 'id');
    }

    /**
     * @return array
     */
    public function sluggable()
    {
        return [
            'ru_slug' => [
                'source' => 'ru_title'
            ],
            'en_slug' => [
                'source' => 'en_title'
            ],
            'uz_slug' => [
                'source' => 'uz_title'
            ],
        ];
    }
}
