<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqItem extends Model
{
    protected $fillable = [
        'ru_question', 'en_question', 'uz_question',
        'ru_content', 'en_content', 'uz_content'
    ];

    public function faqGroup()
    {
        return $this->hasOne(FaqGroup::class, 'id', 'faq_group_id');
    }
}
