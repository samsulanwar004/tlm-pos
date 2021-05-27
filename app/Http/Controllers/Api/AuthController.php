<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Xplayer;

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

        $xplayer = Xplayer::where('user_id', $user->id)->first();

        if ($xplayer) {

            if ($xplayer->player_id != $request->input('player_id') && !empty($request->input('player_id'))) {
                $xplayer->player_id = $request->input('player_id');
                $xplayer->update();
            }    
        } else {
            if (!empty($request->input('player_id'))) {
                Xplayer::create([
                    'user_id' => $user->id,
                    'player_id' => $request->input('player_id')
                ]);
            }
        }

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
