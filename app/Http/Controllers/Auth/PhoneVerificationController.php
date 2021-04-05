<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class PhoneVerificationController extends Controller
{

    protected $redirectTo = '/account/create';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function resend(Request $request)
    {
        $request->user()->sendPhoneVerificationMessage();
        return redirect()->back();
    }

    public function verify(Request $request)
    {
        if ($request->user()->verifyPhoneCode($request->code)) {
            $request->user()->markPhoneAsVerified();
        } else {
            throw ValidationException::withMessages([
                'code' => __('auth.code.invalid'),
            ]);
        }
        return redirect($this->redirectTo);
    }

    public function show()
    {
        return view('registration.phone-verify');
    }
}
