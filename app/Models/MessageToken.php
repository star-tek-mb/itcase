<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\String\b;

class MessageToken extends Model
{
    protected $fillable = [
        'token',
        'user_id'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
