<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Kalnoy\Nestedset\NodeTrait;

class CguCategory extends Model
{
    use NodeTrait;

    protected $fillable = [
        'ru_title', 'en_title', 'uz_title',
        'ru_slug', 'en_slug', 'uz_slug',
        'parent_id'
    ];

    const UPLOAD_IMAGE_DIRECTORY = 'uploads/cgu_categories_image/';

    /**
     * Возвращает дочерние объекты категории
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('position', 'asc');
    }

    /**
     * Get files
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(CguCatalog::class, 'category_id', 'id')->orderBy('position', 'asc');
    }

    /**
     * Check for files
     *
     * @return bool
     */
    public function hasFiles()
    {
        return (isset($this->files[0])) ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites()
    {
        return $this->hasMany(CguSite::class, 'category_id', 'id')->orderBy('position', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'id', 'id', 'parent_id');
    }

    /**
     * Проверяет есть ли дочерние категории или нет
     *
     * @return bool
     */
    public function hasCategories()
    {
        return (isset($this->categories[0])) ? true : false;
    }

    public function hasSites()
    {
        return (isset($this->sites[0])) ? true : false;
    }

    /**
     * @return bool
     */
    public function hasParentCategory()
    {
        return ($this->parentCategory != null) ? true : false;
    }

    /**
     * Загружает изображение на сервер и сохраняет в базе
     *
     * @param $image
     */
    public function uploadImage($image)
    {
        if ($image == null) {
            return;
        }

        $this->removeImage();
        $filename = $this->generateFileName($image->extension());
        $image->storeAs(self::UPLOAD_IMAGE_DIRECTORY, $filename);
        $this->saveImageName($filename);
    }



    public function getImage()
    {
        return '/' . self::UPLOAD_IMAGE_DIRECTORY . $this->image;
    }

    /**
     * Создаёт название файла
     *
     * @param $ext
     * @return string
     */
    public function generateFileName($ext)
    {
        return str_random(20) . '.' . $ext;
    }

    /**
     *Удаляет изображение
     */
    public function removeImage()
    {
        if ($this->image != null) {
            Storage::delete(self::UPLOAD_IMAGE_DIRECTORY . $this->image);
            $this->image = null;
            $this->save();
        }
    }

    /**
     * Сохраняет имя файла в базу
     *
     * @param $name
     */
    public function saveImageName($name)
    {
        $this->image = $name;
        $this->save();
    }

    /**
     * Удаляем картину и сам объект
     *
     * @throws \Exception
     */
    public function remove()
    {
        $this->removeImage();
        $this->delete();
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

    /**
     * Создает слаг для русского языка если не ввели слаг
     *
     * @param $title
     */
    public function createRuSlug($title)
    {
        $this->ru_slug = SlugService::createSlug(CguCategory::class, 'ru_slug', $title);
    }

    /**
     * Создает слаг для английского языка если не ввели слаг
     *
     * @param $title
     */
    public function createEnSlug($title)
    {
        $this->en_slug = SlugService::createSlug(CguCategory::class, 'en_slug', $title);
    }

    /**
     * Создает слаг для узбекского языка если не ввели слаг
     *
     * @param $title
     */
    public function createUzSlug($title)
    {
        $this->uz_slug = SlugService::createSlug(CguCategory::class, 'uz_slug', $title);
    }

    /**
     * @param $title
     */
    public function saveRuSlug($title)
    {
        $this->ru_slug = $title;
        $this->save();
    }

    /**
     * @param $title
     */
    public function saveEnSlug($title)
    {
        $this->en_slug = $title;
        $this->save();
    }

    /**
     * @param $title
     */
    public function saveUzSlug($title)
    {
        $this->uz_slug= $title;
        $this->save();
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
