<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurseController extends Controller
{
    /**
     * Fix banner url redirect
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $accountPage = 'tenders';
        if ($user->hasRole('customer')) {
            return \view('site.pages.account.customer.purse', compact('user', 'accountPage'));
        } elseif ($user->hasRole('contractor')) {
            return \view('site.pages.account.contractor.purse', compact('user', 'accountPage'));
        } else {
            abort(404);
        }
    }

    //Todo Click, Payme,Visa
}
