<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $cridentials = $request->only(['email', 'password']);

        if (Auth::attempt($cridentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        }


        return redirect()->route('login.index')->withErrors(['email' => 'Email atau password salah.'])->withInput($request->only('email'));
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login.index');
    }


    public function register()
    {
        return view('auth.register');
    }

    public function postregister(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'role' => '0',
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        return redirect()->route('login.index');
    }
}
