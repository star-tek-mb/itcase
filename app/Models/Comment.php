<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $fillable = [
        'for_set', // user
        'who_set', // author
        'comment',
        'assessment',
        'theme'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'for_set');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'id', 'who_set');
    }
}
