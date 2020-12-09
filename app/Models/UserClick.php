<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClick extends Model
{
    protected $fillable = [
        'browser', 'os', 'company_id'
    ];
}
