<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Components\Image;

class Howto extends Model
{
    use HasTranslations;

    use Image;

    const UPLOAD_DIRECTORY = 'uploads/howtos/';

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

    protected $fillable = [
        'title',
        'content',
        'url_label',
        'url'
    ];

    public $translatable = [
        'title',
        'content',
        'url_label'
    ];
}
