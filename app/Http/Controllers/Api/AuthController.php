<?php
/**
 * Created by PhpStorm.
 * User: Php
 * Date: 10.12.2020
 * Time: 15:06
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.min' => 'Пароль должен быть не меньше :min',
            'password.required' => 'Укажите пароль',
            'password.confirmed' => 'Пароли должны совпадать',
            'email.required' => 'Укажите электронную почту',
            'email.email' => 'Электронная почта должна быть в формате example@example.com',
            'email.unique' => 'Такая электроннная почта уже зарегистрирована',
        ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 401);
    }

    
    $input = $request->all();
        $user = User::create([
        'name' => '',
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
    ]);

    
    $token = $user->createToken($request->device_name)->plainTextToken;

    
    return response()->json(['token' => $token], 200);
}

}