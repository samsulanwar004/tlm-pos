<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$data = $request->all();

            $validatedData = $request->validate([
                'username' => 'required|max:255',
                'password' => 'required',
            ]);

    		if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
    			return redirect('dashboard');
    		} else {
                Session::flash('error_message', 'Invalid username or password');
    			return redirect()->back();
    		}
    	}
    	return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        if ($request->isMethod('put')) {
            $request->validate([
                'name' => 'max:255',
                'username' => 'max:255',
                'password' => 'confirmed'
            ]);

            $user->update($request->only(['name', 'username', 'password']));

            return redirect('profile')->with('success', 'Success update profile');
        }

        return view('auth.profile', compact('user'));
    }
}
