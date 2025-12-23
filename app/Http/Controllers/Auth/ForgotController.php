<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotController extends Controller
{
    public function showForm()
    {
        return view('forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar.');
        }

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $link = url('/reset-password/' . $token . '?email=' . $request->email);

        try {
            Mail::send('reset-pw', ['link' => $link], function ($message) use ($request) {
                $message->from(
                    config('mail.from.address'),
                    config('mail.from.name')
                );
                $message->to($request->email);
                $message->subject('Reset Password');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email reset password. Silakan coba lagi.');
        }

        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }

}
