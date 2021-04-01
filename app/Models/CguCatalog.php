<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Components\File as FileTrait;

class CguCatalog extends Model
{
    use FileTrait;

    /**
     * Constant of file name length
     */
    const UPLOAD_FILE_LENGTH = 20;

    /**
     * Constant of file path
     */
    const UPLOAD_FILE_DIRECTORY = 'uploads/cgu_catalogs_files/';

    protected $fillable = [
        'ru_title', 'en_title', 'uz_title',
        'ru_slug', 'en_slug', 'uz_slug',
        'ru_description', 'en_description', 'uz_description',
        'link', 'active', 'category_id', 'video', 'handbook_category_id'
    ];


    /**
     * Get related category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(CguCategory::class, 'id', 'id', 'category_id');
    }

    /**
     * Check for existing related category
     *
     * @return bool
     */
    public function hasParentCategory()
    {
        return ($this->parentCategory != null) ? true : false;
    }

    /**
     * Get related handbook category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function handbookCategory()
    {
        return $this->hasOne(HandbookCategory::class, 'id', 'handbook_category_id');
    }

    /**
     * Get clear title without tags
     *
     * @return string
     */
    public function getTitle()
    {
        return strip_tags($this->ru_title);
    }

    /**
     * Upload file by removing old
     *
     * @param $file
     */
    public function uploadFile($file)
    {
        if ($file == null) {
            return;
        }

        $this->removeFile();
        $filename = $this->generateFilename($file->extension());
        $file->storeAs(self::UPLOAD_FILE_DIRECTORY, $filename);
        $this->saveFileName($filename);
    }

    /**
     * Get clear parent category title
     *
     * @return string
     */
    public function getParentCategoryTitle()
    {
        return ($this->hasParentCategory()) ? $this->parentCategory->ru_title : 'Нет';
    }

    /**
     * Generate file name by using constant of file name length
     *
     * @param $ext
     * @return string
     */
    public function generateFilename($ext)
    {
        return str_random(self::UPLOAD_FILE_LENGTH) . '.' . $ext;
    }

    /**
     * Save file name to the base
     *
     * @param $filemame
     */
    public function saveFileName($filemame)
    {
        $this->file = $filemame;
        $this->save();
    }

    /**
     * Remove existing file and remove name from base
     */
    public function removeFile()
    {
        if ($this->file != null) {
            Storage::delete(self::UPLOAD_FILE_DIRECTORY . $this->file);
            $this->saveFileName('');
        }
    }

    public function remove()
    {
        $this->removeFile();
        $this->delete();
    }

    /**
     * Get file type of uploaded file
     *
     * @return null
     */
    public function getFileType()
    {
        if ($this->file != null) {
            if (File::exists(public_path() . '/' . self::UPLOAD_FILE_DIRECTORY . $this->file)) {
                return File::mimeType(public_path() . '/' . self::UPLOAD_FILE_DIRECTORY . $this->file);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Get file size of uploaded file
     *
     * @return false|null|string
     */
    public function getFileSize()
    {
        if ($this->file != null) {
            if (File::exists(public_path() . '/' . self::UPLOAD_FILE_DIRECTORY . $this->file)) {
                return File::size(public_path() . '/' . self::UPLOAD_FILE_DIRECTORY . $this->file);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Get uri to file
     *
     * @return null|string
     */
    public function getFileUrl()
    {
        if ($this->file != null) {
            return '/' . self::UPLOAD_FILE_DIRECTORY . $this->file;
        } else {
            return null;
        }
    }

    /**
     * Show active html tags
     *
     * @return string
     */
    public function getActiveRender()
    {
        if ($this->active) {
            return "<i class='text-success'>Active</i>";
        } else {
            return "<i class='text-danger'>Not active</i>";
        }
    }
}
