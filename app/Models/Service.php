<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    protected $fillable = [
        'ru_title', 'en_title', 'uz_title', 'category_id'
    ];

    const UPLOAD_DIRECTORY = "uploads/services_image/";

    /**
     * Get all companies
    */
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    /**
     * Category for service
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function category()
    {
        return $this->hasOne(HandbookCategory::class, 'id', 'category_id');
    }

    /**
     * Upload an image and save it in file storage
     *
     * @param $image
     */
    public function uploadImage($image)
    {
        if (!$image) {
            return;
        }

        $this->removeImage();
        $filename = $this->generateFileName($image->extension());
        $image->storeAs(self::UPLOAD_DIRECTORY, $filename);
        $this->saveImageName($filename);
    }

    /**
     * Generate filename for image
     *
     * @param string $imageName
     * @return string
     */
    private function generateFileName(string $imageName)
    {
        return str_random(20) . '.' . $imageName;
    }

    /**
     * Get image filename
     *
     * @return string
     */
    public function getImage()
    {
        if ($this->image) {
            return '/' . self::UPLOAD_DIRECTORY . $this->image;
        } else {
            return '';
        }
    }

    /**
     * Remove an image
     *
     * @return void
     */
    public function removeImage()
    {
        if ($this->image) {
            Storage::delete(self::UPLOAD_DIRECTORY . $this->image);
        }
    }

    /**
     * Save an image name to the database
     *
     * @param string $imageName
     * @return void
     */
    private function saveImageName(string $imageName)
    {
        $this->image = $imageName;
        $this->save();
    }

    public function delete()
    {
        $this->removeImage();
        parent::delete();
    }
}
