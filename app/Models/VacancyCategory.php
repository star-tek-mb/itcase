<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class VacancyCategory extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title'
    ];

    public $translatable = [
        'title'
    ];
}
