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
        return $this->belongsTo(User::class, 'for_set', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'who_set', 'id');
    }
}
