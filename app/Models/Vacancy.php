<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Vacancy extends Model
{

    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'vacancy_category_id',
        'city'
    ];

    public $translatable = [
        'title',
        'description'
    ];
}
