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
        'city',
        'budget',
        'address'
    ];

    public $translatable = [
        'title',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(VacancyCategory::class, 'vacancy_category_id');
    }
}
