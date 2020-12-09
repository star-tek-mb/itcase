<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderRequest extends Model
{
    protected $fillable = [
        'user_id', 'budget_from', 'budget_to',
        'period_from', 'period_to', 'comment', 'tender_id',
        'invited'
    ];

    public function tender()
    {
        return $this->hasOne(Tender::class, 'id', 'tender_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
