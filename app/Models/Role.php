<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * Users with this role
    */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
