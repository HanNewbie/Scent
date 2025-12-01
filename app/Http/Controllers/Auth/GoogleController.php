<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(24)),
                ]
            );

            // Pastikan pakai guard yang sama
            Auth::guard('web')->login($user);
            
            // Regenerate session untuk keamanan
            request()->session()->regenerate();

            return redirect()->route('user.dashboard');

        } catch (\Exception $e) {
            \Log::error('Google login error: '.$e->getMessage());
            return redirect('/login')->with('error', 'Gagal login dengan Google');
        }
    }


    // public function handleGoogleCallback()
    // {
    //     $user = User::firstOrCreate(
    //         ['email' => 'dev@local.test'],
    //         ['name' => 'Dev User', 'username' => 'devuser', 'password' => bcrypt('password')]
    //     );

    //     Auth::login($user); // login paksa

    //     return redirect()->route('user.dashboard');
    // }

    // private function generateUsername($name)
    // {
    //     $baseUsername = Str::slug($name, '');
    //     $username = $baseUsername;
    //     $counter = 1;

    //     while (User::where('username', $username)->exists()) {
    //         $username = $baseUsername . $counter;
    //         $counter++;
    //     }

    //     return $username;
    // }


}
