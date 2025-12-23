<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class ResetController extends Controller
{
    public function showForm($token, Request $request)
    {
        return view('reset', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8|confirmed',
            'token'=>'required'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if(!$reset){
            return back()->withErrors(['email'=>'Token tidak valid']);
        }

        $expiredAt = Carbon::parse($reset->created_at)->addMinutes(60);
        if(Carbon::now()->isAfter($expiredAt)){
            return back()->withErrors(['email'=>'Token sudah kadaluarsa']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('status','Password berhasil direset.');
    }
}
