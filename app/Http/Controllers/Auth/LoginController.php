<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Socialite;
use Auth;
use Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        Validator::make($request->all(), [
            'username'      => 'required|string',
            'password'      => 'required'
        ], [
            'email.required' => 'Укажите электронную почту',
            'email.email' => 'Неверный формат электронной почты',
            'password.required' => 'Укажите пароль'
        ])->validate();
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('username'))) {
            return [
                'phone_number' => $request->get('username'),
                'password' => $request->get('password')
            ];
        } elseif (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            return [
                'email' => $request->get('username'),
                'password' => $request->get('password')
            ];
        }
        else {
            return  [];
        }
    }

    protected function sendLoginResponse(Request $request)
    {
        if (is_numeric($request->get('username'))) {
            $phone = $request->get('username');
            $user = User::where('phone_number', $phone)->first();
        } elseif (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            $email = $request->get('username');
            $user = User::where('email', $email)->first();
        }
//        $email = $request->get('email');
//        $user = User::where('email', $email)->first();
        if (!$user->completed) {
            return redirect('/account/create');
        }
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
    protected function sendFailedLoginResponse(Request $request)
    {

        throw ValidationException::withMessages([
            'username' => trans('auth.failed'),
        ]);
//        return redirect()->back()->with('success', 'your message,here');
    }
    /**
     * Redirect the user to the google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
    }

    /**
     * Obtain the user information from google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('site.account.index');
            } else {
                $newUser = User::create([
                  'first_name' => $user->name,
                  'email' => $user->email,
                  'google_id'=> $user->id,
                  'password' => ''
                ]);
                Auth::login($newUser);
                return redirect()->route('site.account.index');
            }
        } catch (Exception $e) {
            return redirect()->route('site.catalog.index')->with('error', 'Авторизация через Google в данный момент недоступна.');
        }
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('site.catalog.index')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Cache-Control', 'post-check=0, pre-check=0', false)
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }
}
