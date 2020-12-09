<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqGroup extends Model
{
    protected $fillable = [
        'ru_title', 'en_title', 'uz_title',
    ];

    public function companies()
    {
        return $this->hasMany(Company::class, 'faq_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(FaqItem::class, 'faq_group_id', 'id');
    }

    public function getTitle()
    {
        return strip_tags($this->ru_title);
    }

    public function delete()
    {
        $this->items()->delete();
        return parent::delete();
    }
}
