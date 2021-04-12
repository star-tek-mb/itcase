<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Components\Image;

class PopularServices extends Model
{
    use Image;

    const UPLOAD_DIRECTORY = 'uploads/popular-services/';

    protected $fillable = [
        'ru_content', 'uz_content', 'en_content',
        'ru_title', 'en_title', 'uz_title',
        'image', 'url', 'image_text'
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
     * @return string
     */
    public function getTitle()
    {
        return strip_tags($this->ru_title);
    }

    public function getImg(){
        if (stripos($this->image, 'https://')===0){
            return $this->image;
        }
        else 
            return $this->getImage();
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

    public function getContent()
    {
        return strip_tags($this->ru_content);
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
}
