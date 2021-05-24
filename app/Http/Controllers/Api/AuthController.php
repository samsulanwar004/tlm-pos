<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:tenants,username',
            'password' => 'required|string'
        ]);

        $guard = 'api_login';

        if(!Auth::guard($guard)->attempt($request->only(['username', 'password']))) return $this->error('Unauthorized',401);
        
        $user = Auth::guard($guard)->user();

        if ($user->status == 0) return $this->error('Inactive');

        if (!empty($user->api_token)) {
            $token = $user->api_token;
        } else {
            $token = Str::random(80);

            $user->api_token = $token;
            $user->update();
        }

        return $this->success(
            'success',
            [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        );
    }
}
