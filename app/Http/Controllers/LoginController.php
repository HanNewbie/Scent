<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;


class LoginController extends Controller
{
    public function loginForm(){
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $role = $request->role;
        $email = $request->email;
        $password = $request->password;

        if ($role === 'user') {
            $user = \App\Models\User::where('email', $email)->first();
        } elseif ($role === 'admin') {
            $user = \App\Models\Admin::where('email', $email)->first();
        } else {
            return back()->withErrors(['role' => 'Peran tidak dikenali']);
        }

        if ($user && Hash::check($password, $user->password)) {
            if ($role === 'user') {
                Auth::guard('web')->login($user);
                return redirect()->intended('/user/dashboard');
            } else {
                Auth::guard('admin')->login($user);
                return redirect()->intended('/admin/dashboard');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function registerForm(){
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('landingpage')->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
