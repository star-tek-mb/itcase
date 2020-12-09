<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryItem extends Model
{
    protected $fillable = [
        'title', 'type', 'meta', 'user_id'
    ];

    /**
     * Get History item owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get title for history item
     *
     * @return string
    */
    public function getTitle()
    {
        $type = $this->type;
        parse_str($this->meta, $metaArray);
        switch ($type) {
            case 'company.create': {
                $url = route('admin.companies.edit', $metaArray['id']);
                $name = $metaArray['ru_title'];
                return "Создал(a) компанию <a href='$url' class='link-effect'>$name</a>";
            }
            case 'company.update': {
                $url = route('admin.companies.edit', $metaArray['id']);
                $name = $metaArray['ru_title'];
                return "Изменил(a) компанию <a href='$url' class='link-effect'>$name</a>";
            }
            case 'company.delete': {
                $name = $metaArray['ru_title'];
                return "Удали(а) компанию $name";
            }
            case 'category.create': {
                $url = route('admin.categories.edit', $metaArray['id']);
                $name = $metaArray['ru_title'];
                return "Создал(a) категорию справочника <a href='$url' class='link-effect'>$name</a>";
            }
            case 'category.update': {
                $url = route('admin.categories.edit', $metaArray['id']);
                $name = $metaArray['ru_title'];
                return "Изменил(a) категорию справочника <a href='$url' class='link-effect'>$name</a>";
            }
            case 'category.delete': {
                $name = $metaArray['ru_title'];
                return "Удалил(а) категорию $name";
            }
            default: return 'Undefined';
        }
    }
}
