<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CguSite extends Model
{
    const GENERATE_FILENAME_LENGTH = 20;
    const UPLOAD_FILE_PATH = 'uploads/cgu_sites_images/';

    protected $fillable = [
        'ru_title', 'en_title', 'uz_title',
        'ru_slug', 'en_slug', 'uz_slug',
        'ru_description', 'en_description', 'uz_description',
        'link', 'category_id', 'active'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentCategory()
    {
        return $this->hasOne(CguCategory::class, 'id', 'category_id');
    }

    /**
     * @return bool
     */
    public function hasParentCategory()
    {
        return ($this->parentCategory != null) ? true : false;
    }

    /**
     * @return string
     */
    public function getParentCategoryTitle()
    {
        return ($this->hasParentCategory()) ? $this->parentCategory->ru_title : 'Нет';
    }

    public function getActiveRender()
    {
        if ($this->active) {
            return "<i class='text-success'>Активный</i>";
        } else {
            return "<i class='text-danger'>Не активный</i>";
        }
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return '/' . self::UPLOAD_FILE_PATH . $this->image;
    }

    /**
     * @param $image
     */
    public function uploadImage($image)
    {
        if ($image == null) {
            return;
        }

        $this->removeImage();
        $filename = $this->generateFilename($image->extension());
        $image->storeAs(self::UPLOAD_FILE_PATH, $filename);
        $this->saveImage($filename);
    }

    /**
     * @param $extension
     * @return string
     */
    public function generateFilename($extension)
    {
        return str_random(self::GENERATE_FILENAME_LENGTH) . $extension;
    }

    /**
     * @param $filename
     */
    public function saveImage($filename)
    {
        $this->image = $filename;
        $this->save();
    }

    /**
     *
     */
    public function removeImage()
    {
        if ($this->image != null) {
            Storage::delete(self::UPLOAD_FILE_PATH, $this->image);
            $this->saveImage('');
        }
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return strip_tags($this->ru_title);
    }
}
