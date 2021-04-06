<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/account/create';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => [
                'required',
                'string',
                'max:100',
                'unique:users,email',
                'unique:users,phone_number'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
        ], [
            'password.min' => 'Пароль должен быть не меньше :min',
            'password.required' => 'Укажите пароль',
            'password.confirmed' => 'Пароли должны совпадать',
            'validation.unique' => 'Такой пользователь уже существует',
            'email.email' => 'Электронная почта должна быть в формате example@example.com',
            'email.unique' => 'Такая электроннная почта уже зарегистрирована',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if (is_numeric($data['username'])) {
            $user = User::create([
                'first_name' => '',
                'phone_number' => $data['username'],
                'password' => Hash::make($data['password']),
            ]);
        } elseif (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            $user = User::create([
                'first_name' => '',
                'email' => $data['username'],
                'password' => Hash::make($data['password']),
            ]);
        }

        return $user;
    }
}
