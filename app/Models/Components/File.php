<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 23.08.2019
 * Time: 10:18
 */

namespace App\Models\Components;

trait File
{
    public function getRenderedFile()
    {
        switch ($this->getFileType()) {
            case 'image/jpeg':
                return $this->getImageRender();
            case 'application/pdf':
                return $this->getPDFRender();
            default:
                return '';
        }
    }

    public function getImageRender()
    {
        $html = "<img style='width: 200px;' src='" . $this->getFileUrl() ."'>";

        return $html;
    }

    public function getPDFRender()
    {
        $html = "<ul>";
        $html .= "<li>Тип файла: " . $this->getFileType() . "</li>";
        $html .= "<li>Размер файла: " . $this->getFileSize() . "</li>";
        $html .= "<li>Ссылка на файл: <a href='" . $this->getFileUrl() . "'>файл</a></li>";
        $html .= "</ul>";

        return $html;
    }
}
