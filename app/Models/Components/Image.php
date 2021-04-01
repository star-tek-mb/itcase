<?php


namespace App\Models\Components;

use Illuminate\Support\Facades\Storage;

trait Image
{
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
        $this->image = null;
        $this->save();
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
}
