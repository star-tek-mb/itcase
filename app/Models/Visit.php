<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public function Views()
    {
        return $this->belongsTo(Tender::class);
    }

    public static function createVisitLog($tender)
    {
        $tenderViews= new Visit();
        $tenderViews->listing_id = $tender->id;
        $tenderViews->slug = $tender->slug;
        $tenderViews->url = \Request::url();
        $tenderViews->session_id = \Request::getSession()->getId();
        $tenderViews->user_id = (\Auth::check())?\Auth::id():null;
        $tenderViews->ip = \Request::getClientIp();
        $tenderViews->agent = \Request::header('User-Agent');
        $tenderViews->save();
    }
}
