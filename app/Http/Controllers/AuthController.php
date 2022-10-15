<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Validation Error', 500);    
        }
        if (!$token = auth()->attempt($credentials)) {
            return ResponseFormatter::error(null, 'Unauthorized', 500);
        }
        return ResponseFormatter::success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ], 'Authenticated');
    }

    public function logout()
    {
        auth()->logout();
        return ResponseFormatter::success(null, 'Logged out');
    }

    public function refresh()
    {
        return ResponseFormatter::success([
            'access_token' => auth()->refresh(),
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ], 'Resfreshed');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return ResponseFormatter::error(['errors' => $validator->errors()], 'Validation Error');
        }
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if ($user) {
            return ResponseFormatter::success(['user' => $user], 'User Registered');
        }
    }
}
