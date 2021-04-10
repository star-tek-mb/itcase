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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'throttle:6,1'])->only('verify', 'resend');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $user = User::create([
            'first_name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Неверный логин или пароль'], 401);
        }
        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    public function resend(Request $request)
    {
        $request->user()->sendPhoneVerificationMessage();
        return response()->json(null);
    }

    public function verify(Request $request)
    {
        if ($request->user()->verifyPhoneCode($request->code)) {
            $request->user()->markPhoneAsVerified();
        } else {
            \response()->json();
            return response()->json(null, 403);
        }
        return response()->json(null, 200);
    }
}
