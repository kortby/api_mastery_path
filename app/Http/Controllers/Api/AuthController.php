<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{
    use ApiResponses, HasApiTokens;

    public function login(ApiLoginRequest $request)
    {
        $user = User::firstWhere('email', $request->email);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $token = $user->createToken('Api for token ' . $user->email)->plainTextToken;

        return response()->json([
            'message' => 'Authenticated',
            'data' => [
                'token' => $token
            ]
        ], 200);
    }

    public function register(ApiLoginRequest $request)
    {
        return $this->ok('register', 'wew');
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok('Logged out');
    }
}
