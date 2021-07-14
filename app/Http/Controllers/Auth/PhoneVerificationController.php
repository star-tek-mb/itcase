<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class PhoneVerificationController extends Controller
{

    public function resend(Request $request)
    {
        $request->user()->sendPhoneVerificationMessage();
        return redirect()->back();
    }
 // redirect to payment
    public function verify(Request $request)
    {
        if ($request->user()->verifyPhoneCode($request->code)) {
            $request->user()->markPhoneAsVerified();
        } else {
            throw ValidationException::withMessages([
                'code' => __('auth.code.invalid'),
            ]);
        }
        return redirect()->route('site.account.payment')->with('account.success', __('Номер подтвержден'));
    }

    public function show()
    {
        return view('registration.phone-verify');
    }
}
